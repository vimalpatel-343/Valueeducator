<?php

if (!function_exists('captureTrackingData')) {

    function captureTrackingData($userId = null)
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();

        /**
         * -------------------------------------------------------
         * Prevent duplicate tracking per session
         * -------------------------------------------------------
         */
        if ($session->get('tracking_captured')) {
            return $session->get('tracking_data');
        }

        /**
         * -------------------------------------------------------
         * Basic Info
         * -------------------------------------------------------
         */
        $sessionId  = session_id();
        $ipAddress  = $request->getIPAddress();
        $referrer   = $request->getServer('HTTP_REFERER') ?? null;
        $landingPage = current_url();

        /**
         * -------------------------------------------------------
         * UTM Parameters (if present)
         * -------------------------------------------------------
         */
        $utmSource   = $request->getGet('utm_source');
        $utmMedium   = $request->getGet('utm_medium');
        $utmCampaign = $request->getGet('utm_campaign');
        $utmContent  = $request->getGet('utm_content');
        $utmTerm     = $request->getGet('utm_term');

        /**
         * -------------------------------------------------------
         * Detect Source & Medium (GA-style)
         * -------------------------------------------------------
         */
        $source = 'direct';
        $medium = 'direct';

        if (!empty($referrer)) {
            $host = parse_url($referrer, PHP_URL_HOST);

            if (str_contains($host, 'google')) {
                $source = 'google';
                $medium = 'organic';
            } elseif (str_contains($host, 'bing')) {
                $source = 'bing';
                $medium = 'organic';
            } elseif (str_contains($host, 'facebook') || str_contains($host, 'fb.')) {
                $source = 'facebook';
                $medium = 'referral';
            } elseif (str_contains($host, 'instagram')) {
                $source = 'instagram';
                $medium = 'referral';
            } elseif (str_contains($host, 'twitter') || str_contains($host, 't.co')) {
                $source = 'twitter';
                $medium = 'referral';
            } elseif (str_contains($host, 'linkedin')) {
                $source = 'linkedin';
                $medium = 'referral';
            } else {
                $source = $host;
                $medium = 'referral';
            }
        }

        /**
         * -------------------------------------------------------
         * Override with UTM (if exists)
         * -------------------------------------------------------
         */
        if (!empty($utmSource)) {
            $source = $utmSource;
        }
        if (!empty($utmMedium)) {
            $medium = $utmMedium;
        }

        /**
         * -------------------------------------------------------
         * Device & Browser (CI4 compatible)
         * -------------------------------------------------------
         */
        $agent = $request->getUserAgent();

        if ($agent->isRobot()) {
            $device = 'Robot';
        } elseif ($agent->isMobile()) {
            $device = 'Mobile';
        } else {
            $device = 'Desktop';
        }

        $browser = $agent->getBrowser();

        /**
         * -------------------------------------------------------
         * Prepare Data
         * -------------------------------------------------------
         */
        $data = [
            'user_id'          => $userId,
            'session_id'       => $sessionId,
            'referrer_url'     => $referrer,
            'source'           => $source,
            'medium'           => $medium,
            'utm_source'       => $utmSource,
            'utm_medium'       => $utmMedium,
            'utm_campaign'     => $utmCampaign,
            'utm_content'      => $utmContent,
            'utm_term'         => $utmTerm,
            'landing_page'     => $landingPage,
            'ip_address'       => $ipAddress,
            'device'           => $device,
            'browser'          => $browser,
            'first_visit_time' => date('Y-m-d H:i:s'),
            'last_visit_time'  => date('Y-m-d H:i:s'),
            'is_converted'     => 0
        ];

        /**
         * -------------------------------------------------------
         * Store in DB
         * -------------------------------------------------------
         */
        $trackingModel = new \App\Models\TrackingModel();
        $trackingModel->storeTrackingData($data);

        /**
         * -------------------------------------------------------
         * Store in Session
         * -------------------------------------------------------
         */
        $session->set('tracking_data', $data);
        $session->set('tracking_captured', true);

        return $data;
    }
}

if (!function_exists('updateTrackingConversion')) {
    function updateTrackingConversion($userId)
    {
        $trackingModel = new \App\Models\TrackingModel();
        return $trackingModel->markConversion($userId);
    }
}

if (!function_exists('appendUTMToURL')) {
    function appendUTMToURL($url, $source = null, $medium = null, $campaign = null, $content = null, $term = null)
    {
        $session = \Config\Services::session();
        $trackingData = $session->get('tracking_data');
        
        if (!$trackingData && (!$source && !$medium && !$campaign)) {
            return $url;
        }
        
        $params = [];
        
        // Use provided parameters or get from session
        if ($source) {
            $params['utm_source'] = $source;
        } elseif (isset($trackingData['utm_source'])) {
            $params['utm_source'] = $trackingData['utm_source'];
        }
        
        if ($medium) {
            $params['utm_medium'] = $medium;
        } elseif (isset($trackingData['utm_medium'])) {
            $params['utm_medium'] = $trackingData['utm_medium'];
        }
        
        if ($campaign) {
            $params['utm_campaign'] = $campaign;
        } elseif (isset($trackingData['utm_campaign'])) {
            $params['utm_campaign'] = $trackingData['utm_campaign'];
        }
        
        if ($content) {
            $params['utm_content'] = $content;
        } elseif (isset($trackingData['utm_content'])) {
            $params['utm_content'] = $trackingData['utm_content'];
        }
        
        if ($term) {
            $params['utm_term'] = $term;
        } elseif (isset($trackingData['utm_term'])) {
            $params['utm_term'] = $trackingData['utm_term'];
        }
        
        if (empty($params)) {
            return $url;
        }
        
        // Parse URL and add parameters
        $parsedUrl = parse_url($url);
        $query = [];
        
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
        }
        
        // Merge with UTM parameters
        $query = array_merge($query, $params);
        
        // Rebuild URL
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';
        
        $url = $scheme . $host . $port . $path;
        
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        
        return $url . $fragment;
    }
}