<?php

namespace App\Controllers;

class Pdf extends BaseController
{
    /**
     * Generate a temporary access token for PDF viewing
     */
    public function generateToken($type, $filename)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Authentication required',
                'error_type' => 'auth_required'
            ]);
        }
        
        // Validate filename
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Invalid filename',
                'error_type' => 'invalid_file'
            ]);
        }
        
        // Get user ID
        $userId = session()->get('userId');
        
        // Check if user has access to this PDF
        $accessResult = $this->checkPdfAccess($userId, $type, $filename);
        
        if (!$accessResult['has_access']) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => $accessResult['message'],
                'error_type' => $accessResult['error_type'],
                'debug_info' => $accessResult['debug_info'] ?? null
            ]);
        }
        
        // Check if there's already a valid token for this file
        $existingToken = $this->getExistingToken($userId, $type, $filename);
        
        if ($existingToken) {
            return $this->response->setJSON([
                'success' => true, 
                'token' => $existingToken,
                'expires' => 300
            ]);
        }
        
        // Generate a new token
        $tokenData = [
            'user_id' => $userId,
            'type' => $type,
            'filename' => $filename,
            'expires' => time() + 300,
            'ip' => $this->request->getIPAddress(),
            'created_at' => time()
        ];
        
        $token = bin2hex(random_bytes(16));
        $tokenValue = base64_encode(json_encode($tokenData));
        
        // Store token in session
        session()->set('pdf_token_' . $token, $tokenValue);
        
        // Also store a reference to find existing tokens
        session()->set('pdf_token_ref_' . $userId . '_' . $type . '_' . $filename, $token);
        
        return $this->response->setJSON([
            'success' => true, 
            'token' => $token,
            'expires' => 300
        ]);
    }
    
    /**
     * Get existing valid token for a file
     */
    private function getExistingToken($userId, $type, $filename)
    {
        $tokenRef = session()->get('pdf_token_ref_' . $userId . '_' . $type . '_' . $filename);
        
        if ($tokenRef) {
            $tokenValue = session()->get('pdf_token_' . $tokenRef);
            
            if ($tokenValue) {
                try {
                    $tokenData = json_decode(base64_decode($tokenValue), true);
                    
                    // Check if token is still valid (not expired)
                    if (time() <= $tokenData['expires']) {
                        // Check IP address (optional but recommended)
                        if ($tokenData['ip'] === $this->request->getIPAddress()) {
                            return $tokenRef;
                        }
                    } else {
                        // Token expired, clean it up
                        session()->remove('pdf_token_' . $tokenRef);
                        session()->remove('pdf_token_ref_' . $userId . '_' . $type . '_' . $filename);
                    }
                } catch (\Exception $e) {
                    // Invalid token data, clean it up
                    session()->remove('pdf_token_' . $tokenRef);
                    session()->remove('pdf_token_ref_' . $userId . '_' . $type . '_' . $filename);
                }
            }
        }
        
        return null;
    }
    
    /**
     * View PDF with token validation
     */
    public function viewWithToken($token)
    {
        // Get token from session
        $tokenValue = session()->get('pdf_token_' . $token);
        
        if (!$tokenValue) {
            return $this->serveAccessDeniedPdf('Invalid or expired token');
        }
        
        // Decode token data
        try {
            $tokenData = json_decode(base64_decode($tokenValue), true);
            
            // Check if token is expired
            if (time() > $tokenData['expires']) {
                // Remove expired token and its reference
                session()->remove('pdf_token_' . $token);
                session()->remove('pdf_token_ref_' . $tokenData['user_id'] . '_' . $tokenData['type'] . '_' . $tokenData['filename']);
                return $this->serveAccessDeniedPdf('Token expired');
            }
            
            // Check IP address (optional but recommended)
            if ($tokenData['ip'] !== $this->request->getIPAddress()) {
                return $this->serveAccessDeniedPdf('Invalid token');
            }
            
            // Extract data from token
            $type = $tokenData['type'];
            $filename = $tokenData['filename'];
            $userId = $tokenData['user_id'];
            
            // Check access again for security
            $accessResult = $this->checkPdfAccess($userId, $type, $filename);
            
            if (!$accessResult['has_access']) {
                return $this->serveAccessDeniedPdf($accessResult['message']);
            }

            // Log PDF access
            $pdfAccessModel = new \App\Models\PdfAccessModel();
            $pdfAccessModel->logAccess($tokenData['user_id'], $type, $filename);
            
            // Continue with PDF serving
            return $this->servePdf($type, $filename);
            
        } catch (\Exception $e) {
            return $this->serveAccessDeniedPdf('Invalid token');
        }
    }
    
    /**
     * Serve the access denied PDF
     */
    private function serveAccessDeniedPdf($customMessage = null)
    {
        $accessDeniedPath = WRITEPATH . '../public/uploads/access_denied.pdf';
        
        // Check if the access denied PDF exists
        if (file_exists($accessDeniedPath)) {
            $fileSize = filesize($accessDeniedPath);
            
            $this->response
                ->setStatusCode(403)
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Length', $fileSize)
                ->setHeader('Accept-Ranges', 'bytes')
                ->setHeader('Content-Disposition', 'inline; filename="access_denied.pdf"');
            
            // Handle range requests for PDF streaming
            $range = $this->request->getHeaderLine('Range');
            if ($range) {
                [$unit, $range] = explode('=', $range, 2);
                [$start, $end] = explode('-', $range);
                
                $start = intval($start);
                $end = $end ? intval($end) : $fileSize - 1;
                
                $this->response->setStatusCode(206);
                $this->response->setHeader(
                    'Content-Range',
                    "bytes $start-$end/$fileSize"
                );
                
                $length = $end - $start + 1;
                $this->response->setHeader('Content-Length', $length);
                
                $fp = fopen($accessDeniedPath, 'rb');
                fseek($fp, $start);
                echo fread($fp, $length);
                fclose($fp);
                exit;
            }
            
            // Serve the entire file
            readfile($accessDeniedPath);
            exit;
        } else {
            // Fallback to HTML if PDF doesn't exist
            return $this->serveErrorHtml($customMessage ?: 'Access denied', 'access_denied');
        }
    }
    
    /**
     * Check if user has access to a specific PDF (COMPLETELY REWRITTEN)
     */
    private function checkPdfAccess($userId, $type, $filename)
    {
        // Load necessary models
        $userSubscriptionModel = new \App\Models\UserSubscriptionModel();
        $stockModel = new \App\Models\StockModel();
        
        // Get user's active subscriptions (only those that are not expired)
        $activeSubscriptions = $userSubscriptionModel->getUserActiveSubscriptions($userId);
        
        if (empty($activeSubscriptions)) {
            return [
                'has_access' => false,
                'message' => 'You need an active subscription to access this report. Please subscribe to one of our products to continue.',
                'error_type' => 'no_subscription',
                'debug_info' => [
                    'user_id' => $userId,
                    'current_date' => date('Y-m-d'),
                    'active_subscriptions' => []
                ]
            ];
        }
        
        // Extract product IDs from active subscriptions for easier checking
        $userProductIds = [];
        foreach ($activeSubscriptions as $subscription) {
            $userProductIds[] = $subscription['product_id'];
        }
        
        // For stock reports, check if the stock belongs to a product the user has access to
        if ($type === 'stock') {
            // Try to find the stock associated with this report
            $stock = $stockModel->extractStockFromFilename($filename);
            
            if ($stock && !empty($stock['fld_product_id'])) {
                // Check if user has subscription for this product
                if (in_array($stock['fld_product_id'], $userProductIds)) {
                    return [
                        'has_access' => true,
                        'debug_info' => [
                            'stock' => $stock,
                            'stock_product_id' => $stock['fld_product_id'],
                            'user_product_ids' => $userProductIds,
                            'has_access' => true
                        ]
                    ];
                } else {
                    return [
                        'has_access' => false,
                        'message' => 'This report is part of a specific product subscription. Please subscribe to the appropriate product to access this report.',
                        'error_type' => 'product_access_denied',
                        'debug_info' => [
                            'stock' => $stock,
                            'stock_product_id' => $stock['fld_product_id'],
                            'user_product_ids' => $userProductIds,
                            'has_access' => false
                        ]
                    ];
                }
            } else {
                // If we can't determine the stock, check if user has any active subscription
                return [
                    'has_access' => true,
                    'debug_info' => [
                        'filename' => $filename,
                        'stock_found' => false,
                        'user_product_ids' => $userProductIds,
                        'fallback_access' => true
                    ]
                ];
            }
        }
        
        // For rebalance factsheets, check if user has access to any product
        if ($type === 'rebalance') {
            // Extract product ID from filename or check if it's a general factsheet
            $productId = $this->extractProductId($filename);
            
            if ($productId) {
                // Check if user has subscription for this specific product
                if (in_array($productId, $userProductIds)) {
                    return [
                        'has_access' => true,
                        'debug_info' => [
                            'required_product_id' => $productId,
                            'user_product_ids' => $userProductIds,
                            'has_access' => true
                        ]
                    ];
                } else {
                    return [
                        'has_access' => false,
                        'message' => 'This factsheet is part of a specific product subscription. Please subscribe to the appropriate product to access this factsheet.',
                        'error_type' => 'product_access_denied',
                        'debug_info' => [
                            'required_product_id' => $productId,
                            'user_product_ids' => $userProductIds,
                            'has_access' => false
                        ]
                    ];
                }
            } else {
                // General factsheet - check if user has any active subscription
                return [
                    'has_access' => true,
                    'debug_info' => [
                        'filename' => $filename,
                        'product_id_found' => false,
                        'user_product_ids' => $userProductIds,
                        'fallback_access' => true
                    ]
                ];
            }
        }
        
        // Default: allow access if user has any active subscription
        return [
            'has_access' => true,
            'debug_info' => [
                'type' => $type,
                'user_product_ids' => $userProductIds,
                'fallback_access' => true
            ]
        ];
    }
    
    /**
     * Serve PDF file
     */
    private function servePdf($type, $filename)
    {
        // 🔐 Folder whitelist
        $basePaths = [
            'stock'     => 'uploads/stocks/reports/',
            'rebalance' => 'uploads/rebalance/factsheets/',
        ];

        if (!isset($basePaths[$type])) {
            return $this->serveAccessDeniedPdf('Invalid file type');
        }

        $filePath = $basePaths[$type] . $filename;

        if (!file_exists($filePath)) {
            return $this->serveAccessDeniedPdf('PDF file not found');
        }

        $fileSize = filesize($filePath);
        $start = 0;
        $end = $fileSize - 1;

        $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Accept-Ranges', 'bytes')
            ->setHeader('Content-Disposition', 'inline')
            ->setHeader('Cache-Control', 'private, max-age=300');

        $range = $this->request->getHeaderLine('Range');
        if ($range) {
            [$unit, $range] = explode('=', $range, 2);
            [$start, $end] = explode('-', $range);

            $start = intval($start);
            $end = $end ? intval($end) : $end;

            $this->response->setStatusCode(206);
            $this->response->setHeader(
                'Content-Range',
                "bytes $start-$end/$fileSize"
            );
        }

        $length = $end - $start + 1;
        $this->response->setHeader('Content-Length', $length);

        $fp = fopen($filePath, 'rb');
        fseek($fp, $start);
        echo fread($fp, $length);
        fclose($fp);
        exit;
    }
    
    /**
     * Extract product ID from filename
     */
    private function extractProductId($filename)
    {
        // Try to extract from filename pattern
        // Example: "product1_factsheet.pdf" or "emerging_titans_rebalance.pdf"
        
        if (preg_match('/(emerging_titans|tiny_titans)/i', $filename, $matches)) {
            $productSlug = strtolower($matches[1]);
            $productModel = new \App\Models\ProductModel();
            $product = $productModel->getBySlug($productSlug);
            
            if ($product) {
                return $product['id'];
            }
        }
        
        // Try to extract numeric ID if pattern like "product1_factsheet.pdf"
        if (preg_match('/product(\d+)_.*\.pdf$/i', $filename, $matches)) {
            return (int)$matches[1];
        }
        
        return null;
    }
}