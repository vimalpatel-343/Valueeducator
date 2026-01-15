<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Services\LoggerService;
use CodeIgniter\I18n\Time;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Auth extends BaseController
{
    protected $userModel;
    protected $productModel;
    protected LoggerService $authLogger;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->authLogger = service('authLogger');
    }
    
    // Send OTP for signup
    public function sendSignupOTP()
    {
        $requestId = uniqid('auth_', true);
        $startTime = microtime(true);
        
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Invalid request method');
            }
            
            $email = $this->request->getPost('email');
            $ipAddress = $this->request->getIPAddress();
            
            // Log the attempt
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'send_signup_otp',
                'email' => $email,
                'ip' => $ipAddress,
                'session_id' => session_id()
            ]);
            
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Please enter a valid email address');
            }
            
            // Check if email already exists
            $existingUser = $this->userModel->where('fld_email', $email)->first();
            if ($existingUser) {
                throw new \Exception('Email already registered. Please login instead.');
            }
            
            // Check rate limit
            $rateLimitCheck = $this->checkRateLimit($email);
            if (!$rateLimitCheck['allowed']) {
                throw new \Exception($rateLimitCheck['message']);
            }
            
            // Generate OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = Time::now()->addMinutes(OTP_EXPIRY_MINUTES); // OTP expires in 15 minutes
            
            // Save OTP to database
            $otpData = [
                'fld_email' => $email,
                'fld_otp' => $otp,
                'fld_type' => 'signup',
                'fld_expires_at' => $expiresAt
            ];
            
            $db = \Config\Database::connect();
            $db->table('ve_otps')->insert($otpData);
            
            // Record this OTP attempt with IP
            $db->table('ve_otp_attempts')->insert([
                'email' => $email,
                'ip_address' => $ipAddress,
                'request_time' => date('Y-m-d H:i:s')
            ]);
            
            // Send OTP email
            $emailSent = $this->sendOTPEmail($email, $otp);
            
            if (!$emailSent) {
                throw new \Exception('Failed to send OTP email. Please try again.');
            }
            
            // Clean up old records for this email
            $this->cleanupOldOtpAttempts($email);
            
            // Store email in session for next steps
            session()->set('signup_email', $email);
            
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'send_signup_otp_success',
                'email' => $email,
                'execution_time' => $executionTime
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'OTP sent to your email address',
                'request_id' => $requestId
            ]);
            
        } catch (\Exception $e) {
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logError('sendSignupOTP failed', [
                'request_id' => $requestId,
                'email' => $email ?? 'not_provided',
                'execution_time' => $executionTime
            ], $e);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'request_id' => $requestId
            ]);
        }
    }
    
    // Check rate limit for OTP requests (10 per hour per email/IP)
    private function checkRateLimit($email)
    {
        $db = \Config\Database::connect();
        $ipAddress = $this->request->getIPAddress();
        $maxRequestsPerHour = MAX_REQUESTS_PER_HOUR;
        
        // Get current time and 1 hour ago
        $oneHourAgo = date('Y-m-d H:i:s', strtotime('-60 minutes'));
        
        // Check requests by email in the last hour
        $emailAttempts = $db->table('ve_otp_attempts')
            ->where('email', $email)
            ->where('request_time >', $oneHourAgo)
            ->countAllResults();
        
        // Check requests by IP in the last hour
        $ipAttempts = $db->table('ve_otp_attempts')
            ->where('ip_address', $ipAddress)
            ->where('request_time >', $oneHourAgo)
            ->countAllResults();
        
        // If either email or IP exceeds the limit
        if ($emailAttempts >= $maxRequestsPerHour || $ipAttempts >= $maxRequestsPerHour) {
            return [
                'allowed' => false,
                'message' => "You have reached the maximum number of OTP requests. Please try again after 1 hour."
            ];
        }
        
        return ['allowed' => true];
    }

    // Clean up old OTP attempts (call when successful)
    private function cleanupOldOtpAttempts($email)
    {
        $db = \Config\Database::connect();
        $oneHourAgo = date('Y-m-d H:i:s', strtotime('-1 hour'));
        
        // Delete records older than 1 hour for this email
        $db->table('ve_otp_attempts')
            ->where('email', $email)
            ->where('request_time <', $oneHourAgo)
            ->delete();
    }

    // Verify OTP for signup
    public function verifySignupOTP()
    {
        $requestId = uniqid('auth_', true);
        $startTime = microtime(true);
        
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Invalid request method');
            }
            
            $otp = $this->request->getPost('otp');
            $email = session()->get('signup_email');
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'verify_signup_otp',
                'email' => $email,
                'otp_provided' => !empty($otp),
                'session_id' => session_id()
            ]);
            
            if (empty($email)) {
                throw new \Exception('Session expired. Please try again.');
            }
            
            // Check OTP in database
            $db = \Config\Database::connect();
            $otpRecord = $db->table('ve_otps')
                ->where('fld_email', $email)
                ->where('fld_otp', $otp)
                ->where('fld_type', 'signup')
                ->where('fld_expires_at >=', Time::now())
                ->get()
                ->getRowArray();
            
            if (!$otpRecord) {
                throw new \Exception('Invalid OTP. Please try again.');
            }
            
            // Mark OTP as used
            $db->table('ve_otps')->where('id', $otpRecord['id'])->delete();
            
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'verify_signup_otp_success',
                'email' => $email,
                'execution_time' => $executionTime
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'OTP verified successfully',
                'request_id' => $requestId
            ]);
            
        } catch (\Exception $e) {
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logError('verifySignupOTP failed', [
                'request_id' => $requestId,
                'email' => $email ?? 'not_in_session',
                'execution_time' => $executionTime
            ], $e);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'request_id' => $requestId
            ]);
        }
    }
    
    // Save user profile
    public function saveProfile()
    {
        $requestId = uniqid('auth_', true);
        $startTime = microtime(true);
        
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Invalid request method');
            }
            
            $firstName = $this->request->getPost('first_name');
            $lastName = $this->request->getPost('last_name');
            $mobile = $this->request->getPost('mobile');
            $email = session()->get('signup_email');
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'save_profile',
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'mobile' => $mobile,
                'session_id' => session_id()
            ]);
            
            if (empty($email)) {
                throw new \Exception('Session expired. Please try again.');
            }
            
            // Validate inputs
            if (empty($firstName) || empty($lastName) || empty($mobile)) {
                throw new \Exception('All fields are required');
            }
            
            // Create user
            $userData = [
                'fld_email' => $email,
                'fld_mobile' => $mobile,
                'fld_full_name' => $firstName . ' ' . $lastName,
                'fld_status' => 1,
                'fld_role' => 'user'
            ];
            
            $userId = $this->userModel->insert($userData);
            
            if (!$userId) {
                throw new \Exception('Failed to create user account');
            }
            
            // Generate a unique token for this signup
            $token = bin2hex(random_bytes(32));
            $expiresAt = Time::now()->addHours(1); // Token expires in 1 hour
            
            // Store token in database
            $db = \Config\Database::connect();
            $db->table('ve_signup_tokens')->insert([
                'token' => $token,
                'user_id' => $userId,
                'expires_at' => $expiresAt
            ]);
            
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'save_profile_success',
                'user_id' => $userId,
                'email' => $email,
                'execution_time' => $executionTime
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profile saved successfully',
                'token' => $token,
                'request_id' => $requestId
            ]);
            
        } catch (\Exception $e) {
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logError('saveProfile failed', [
                'request_id' => $requestId,
                'email' => session()->get('signup_email') ?? 'not_in_session',
                'execution_time' => $executionTime
            ], $e);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'request_id' => $requestId
            ]);
        }
    }
    
    // Upload profile picture (FIXED VERSION with Query Builder)
    public function uploadProfilePicture()
    {
        $requestId = uniqid('auth_', true);
        $startTime = microtime(true);
        
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Invalid request method');
            }
            
            $token = $this->request->getPost('token');
            
            if (empty($token)) {
                throw new \Exception('Invalid request');
            }
            
            // Get user ID from token
            $db = \Config\Database::connect();
            $tokenRecord = $db->table('ve_signup_tokens')
                ->where('token', $token)
                ->where('expires_at >=', Time::now())
                ->get()
                ->getRowArray();
            
            if (!$tokenRecord) {
                throw new \Exception('Invalid or expired token');
            }
            
            $userId = $tokenRecord['user_id'];
            
            $file = $this->request->getFile('profile_picture');
            
            // Check if file was uploaded
            if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
                throw new \Exception('No file uploaded or upload error occurred');
            }
            
            // Validate file
            if (!$file->isValid()) {
                throw new \Exception('Invalid file uploaded');
            }
            
            // Check file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                throw new \Exception('Only JPG, PNG, GIF, and WEBP images are allowed');
            }
            
            // Check file size (5MB max)
            if ($file->getSize() > 5 * 1024 * 1024) {
                throw new \Exception('File size must be less than 5MB');
            }
            
            // Generate new file name
            $newName = $file->getName();
            
            // Move file to uploads directory
            if (!$file->move(ROOTPATH . 'public/uploads/profile_pictures', $newName)) {
                throw new \Exception('Failed to move uploaded file');
            }
            
            // Prepare update data
            $updateData = [
                'fld_profile_image' => 'uploads/profile_pictures/' . $newName
            ];
            
            // Use Query Builder to update the record
            $builder = $db->table('ve_users');
            $builder->where('id', $userId);
            $result = $builder->update($updateData);
            
            if (!$result) {
                // Delete the uploaded file if update failed
                @unlink(ROOTPATH . 'public/uploads/profile_pictures/' . $newName);
                
                throw new \Exception('Failed to update user record');
            }
            
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'upload_profile_picture_success',
                'user_id' => $userId,
                'file_name' => $newName,
                'execution_time' => $executionTime
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profile picture uploaded successfully',
                'image_path' => base_url('uploads/profile_pictures/' . $newName),
                'token' => $token,
                'request_id' => $requestId
            ]);
            
        } catch (\Exception $e) {
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logError('uploadProfilePicture failed', [
                'request_id' => $requestId,
                'token' => $token ?? 'not_provided',
                'execution_time' => $executionTime
            ], $e);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'request_id' => $requestId
            ]);
        }
    }
    
    // Complete signup process
    public function completeSignup()
    {
        $requestId = uniqid('auth_', true);
        $startTime = microtime(true);
        
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Invalid request method');
            }
            
            $token = $this->request->getPost('token');
            
            if (empty($token)) {
                throw new \Exception('Invalid request');
            }
            
            // Get user ID from token
            $db = \Config\Database::connect();
            $tokenRecord = $db->table('ve_signup_tokens')
                ->where('token', $token)
                ->where('expires_at >=', Time::now())
                ->get()
                ->getRowArray();
            
            if (!$tokenRecord) {
                throw new \Exception('Invalid or expired token');
            }
            
            $userId = $tokenRecord['user_id'];
            
            // Get user details
            $user = $this->userModel->find($userId);
            
            if (!$user) {
                throw new \Exception('User not found');
            }
            
            // Send welcome email
            $this->sendWelcomeEmail($user['fld_email'], $user['fld_full_name']);
            
            // Set user session
            $sessionData = [
                'userId' => $user['id'],
                'userEmail' => $user['fld_email'],
                'userMobile' => $user['fld_mobile'],
                'userName' => $user['fld_full_name'],
                'userRole' => $user['fld_role'],
                'userProfileImage' => $user['fld_profile_image'],
                'kycStatus' => $user['fld_kyc_status'],
                'isLoggedIn' => TRUE
            ];
            
            session()->set($sessionData);
            
            // Record login information
            $this->recordUserLogin($userId);
            
            // Delete the token
            //$db->table('ve_signup_tokens')->where('id', $tokenRecord['id'])->delete();
            
            // Clear signup session
            session()->remove(['signup_email']);
            
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'complete_signup_success',
                'user_id' => $userId,
                'email' => $user['fld_email'],
                'execution_time' => $executionTime
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Signup completed successfully',
                'redirect' => base_url(),
                'request_id' => $requestId
            ]);
            
        } catch (\Exception $e) {
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logError('completeSignup failed', [
                'request_id' => $requestId,
                'token' => $token ?? 'not_provided',
                'execution_time' => $executionTime
            ], $e);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'request_id' => $requestId
            ]);
        }
    }
    
    // Send OTP for login
    public function sendLoginOTP()
    {
        $requestId = uniqid('auth_', true);
        $startTime = microtime(true);
        
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Invalid request method');
            }
            
            $email = $this->request->getPost('email');
            $ipAddress = $this->request->getIPAddress();
            $userAgent = $this->request->getUserAgent();
            
            // Log the attempt
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'send_login_otp',
                'email' => $email,
                'ip' => $ipAddress,
                'user_agent' => [
                    'browser' => $userAgent->getBrowser(),
                    'version' => $userAgent->getVersion(),
                    'platform' => $userAgent->getPlatform(),
                    'mobile' => $userAgent->isMobile(),
                    'robot' => $userAgent->isRobot()
                ],
                'session_id' => session_id(),
                'server_info' => [
                    'php_version' => PHP_VERSION,
                    'ci_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
                    'memory_usage' => memory_get_usage(true),
                    'time' => time()
                ]
            ]);
            
            // Validate email
            if (empty($email)) {
                throw new \Exception('Email is required');
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Please enter a valid email address');
            }
            
            // Check if user exists
            $user = $this->userModel->where('fld_email', $email)->first();
            if (!$user) {
                throw new \Exception('Email not registered. Please signup first.');
            }
            
            // Check rate limit
            $rateLimitCheck = $this->checkRateLimit($email);
            if (!$rateLimitCheck['allowed']) {
                throw new \Exception($rateLimitCheck['message']);
            }
            
            // Generate OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = Time::now()->addMinutes(OTP_EXPIRY_MINUTES); // OTP expires in 15 minutes
            
            // Database operation with logging
            $db = \Config\Database::connect();
            $dbStart = microtime(true);
            
            try {
                $db->transStart();
                
                // Save OTP to database
                $otpData = [
                    'fld_email' => $email,
                    'fld_otp' => $otp,
                    'fld_type' => 'login',
                    'fld_expires_at' => $expiresAt
                ];
                
                $db->table('ve_otps')->insert($otpData);
                
                // Record this OTP attempt with IP
                $db->table('ve_otp_attempts')->insert([
                    'email' => $email,
                    'ip_address' => $ipAddress,
                    'request_time' => date('Y-m-d H:i:s')
                ]);
                
                $db->transComplete();
                
                if ($db->transStatus() === false) {
                    throw new \Exception('Database transaction failed');
                }
                
                $this->authLogger->logDatabaseQuery(
                    'Insert OTP and attempt record',
                    $otpData,
                    microtime(true) - $dbStart
                );
                
            } catch (\Exception $e) {
                $this->authLogger->logError('Database error in sendLoginOTP', [
                    'email' => $email,
                    'request_id' => $requestId
                ], $e);
                throw new \Exception('Database error. Please try again.');
            }
            
            // Send OTP email
            $emailStart = microtime(true);
            $emailSent = $this->sendOTPEmail($email, $otp);
            
            $this->authLogger->logEmailAttempt(
                $email,
                'Verify Your Email Address',
                $emailSent,
                $emailSent ? null : 'Email sending failed'
            );
            
            if (!$emailSent) {
                throw new \Exception('Failed to send OTP email. Please try again.');
            }
            
            // Clean up old records for this email
            $this->cleanupOldOtpAttempts($email);
            
            // Store email in session for next steps
            session()->set('login_email', $email);
            session()->set('login_request_id', $requestId);
            
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'send_login_otp_success',
                'email' => $email,
                'execution_time' => $executionTime,
                'otp_expires_at' => $expiresAt->toDateTimeString()
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'OTP sent to your email address',
                'request_id' => $requestId,
                'debug' => ENVIRONMENT === 'development' ? [
                    'execution_time' => $executionTime,
                    'otp_length' => strlen($otp)
                ] : null
            ]);
            
        } catch (\Exception $e) {
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logError('sendLoginOTP failed', [
                'request_id' => $requestId,
                'email' => $email ?? 'not_provided',
                'execution_time' => $executionTime,
                'post_data' => $this->request->getPost(),
                'session_data' => [
                    'id' => session_id(),
                    'has_login_email' => session()->has('login_email')
                ]
            ], $e);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'request_id' => $requestId,
                'debug' => ENVIRONMENT === 'development' ? [
                    'error_code' => $e->getCode(),
                    'execution_time' => $executionTime
                ] : null
            ]);
        }
    }
    
    // Verify OTP for login
    public function verifyLoginOTP()
    {
        $requestId = uniqid('auth_', true);
        $startTime = microtime(true);
        
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Invalid request method');
            }
            
            $otp = $this->request->getPost('otp');
            $email = session()->get('login_email');
            $loginRequestId = session()->get('login_request_id');
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'verify_login_otp',
                'email' => $email,
                'otp_provided' => !empty($otp),
                'login_request_id' => $loginRequestId,
                'session_id' => session_id()
            ]);
            
            if (empty($email)) {
                throw new \Exception('Session expired. Please try again.');
            }
            
            if (empty($otp)) {
                throw new \Exception('OTP is required');
            }
            
            // Database operation
            $db = \Config\Database::connect();
            $dbStart = microtime(true);
            
            try {
                // Check OTP in database
                $otpRecord = $db->table('ve_otps')
                    ->where('fld_email', $email)
                    ->where('fld_otp', $otp)
                    ->where('fld_type', 'login')
                    ->where('fld_expires_at >=', Time::now())
                    ->get()
                    ->getRowArray();
                
                $this->authLogger->logDatabaseQuery(
                    'Select OTP record',
                    ['email' => $email, 'otp' => '***'],
                    microtime(true) - $dbStart
                );
                
                if (!$otpRecord) {
                    throw new \Exception('Invalid OTP. Please try again.');
                }
                
                // Mark OTP as used
                $db->table('ve_otps')->where('id', $otpRecord['id'])->delete();
                
            } catch (\Exception $e) {
                $this->authLogger->logError('Database error in verifyLoginOTP', [
                    'email' => $email,
                    'request_id' => $requestId
                ], $e);
                throw new \Exception('Database error. Please try again.');
            }
            
            // Get user details
            $user = $this->userModel->where('fld_email', $email)->first();
            
            if (!$user) {
                throw new \Exception('User not found');
            }
            
            // Set user session
            $sessionData = [
                'userId' => $user['id'],
                'userEmail' => $user['fld_email'],
                'userMobile' => $user['fld_mobile'],
                'userName' => $user['fld_full_name'],
                'userRole' => $user['fld_role'],
                'userProfileImage' => $user['fld_profile_image'],
                'isLoggedIn' => TRUE,
                'loginTime' => time()
            ];
            
            session()->set($sessionData);
            
            // Record login information
            $this->recordUserLogin($user['id']);
            
            // Clear login session
            session()->remove(['login_email', 'login_request_id']);
            
            // Check user subscriptions to determine redirect
            $redirectUrl = $this->getUserRedirectUrl($user['id']);
            
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logAuthAttempt([
                'request_id' => $requestId,
                'action' => 'verify_login_otp_success',
                'user_id' => $user['id'],
                'email' => $email,
                'redirect' => $redirectUrl,
                'execution_time' => $executionTime
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => $redirectUrl,
                'request_id' => $requestId
            ]);
            
        } catch (\Exception $e) {
            $executionTime = microtime(true) - $startTime;
            
            $this->authLogger->logError('verifyLoginOTP failed', [
                'request_id' => $requestId,
                'email' => $email ?? 'not_in_session',
                'execution_time' => $executionTime,
                'post_data' => $this->request->getPost(),
                'session_data' => [
                    'id' => session_id(),
                    'has_login_email' => session()->has('login_email')
                ]
            ], $e);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'request_id' => $requestId
            ]);
        }
    }
    
    // Logout
    public function logout()
    {
        $userId = session()->get('userId');
        
        $this->authLogger->logAuthAttempt([
            'action' => 'logout',
            'user_id' => $userId,
            'session_id' => session_id()
        ]);
        
        session()->destroy();
        return redirect()->to(base_url());
    }
    
    // Helper function to send OTP email using PHPMailer
    private function sendOTPEmail($email, $otp)
    {
        $startTime = microtime(true);
        
        try {
            require_once ROOTPATH . 'vendor/autoload.php';
            
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@valueeducator.com';
            $mail->Password = 'Value@100kk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->Timeout = 30; // 30 seconds timeout
            
            // Enable debug in development
            if (ENVIRONMENT === 'development') {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->Debugoutput = function($str, $level) {
                    $this->authLogger->logAuthAttempt([
                        'type' => 'smtp_debug',
                        'level' => $level,
                        'message' => $str
                    ]);
                };
            }
            
            // Recipients
            $mail->setFrom('noreply@valueeducator.com', 'Value Educator');
            $mail->addAddress($email);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email Address';
            
            $message = "Hi,<br><br>
                Thank you for signing/login up with Value Educator! To complete your Login/Signup and verify your email address, please use the code below:<br><br>
                Your Verification Code: <strong>$otp</strong><br><br/>
                This code is valid for 30 minutes<br/>
                Please enter this code on the verification page to confirm your email.<br><br>
                If you did not request this code, please ignore this email or contact us at value.educator@gmail.com.<br><br>
                Thank you for choosing Value Educator!<br><br>
                Best regards,<br>
                Admin Team at Value Educator";
            
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);
            
            $sendTime = microtime(true);
            $result = $mail->send();
            $totalTime = microtime(true) - $startTime;
            
            $this->authLogger->logAuthAttempt([
                'type' => 'email_sent',
                'to' => $email,
                'success' => $result,
                'send_time' => microtime(true) - $sendTime,
                'total_time' => $totalTime,
                'smtp_info' => [
                    'host' => $mail->Host,
                    'port' => $mail->Port,
                    'secure' => $mail->SMTPSecure
                ]
            ]);
            
            return $result;
            
        } catch (\Exception $e) {
            $this->authLogger->logError('Email sending failed', [
                'to' => $email,
                'execution_time' => microtime(true) - $startTime
            ], $e);
            
            return false;
        }
    }
    
    // Helper function to send welcome email
    private function sendWelcomeEmail($email, $name)
    {
        try {
            require_once ROOTPATH . 'vendor/autoload.php';
            
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@valueeducator.com';
            $mail->Password = 'Value@100kk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            
            // Recipients
            $mail->setFrom('noreply@valueeducator.com', 'Value Educator');
            $mail->addAddress($email);
            $mail->addBCC('value.educator@gmail.com');
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Value Educator!';
            
            $message = "Dear $name,<br><br>
                Welcome to Value Educator! We're thrilled to have you as part of our community of investors.<br><br>
                Your account has been successfully created, and you can now access all our premium investment research and recommendations.<br><br>
                As promised, you can download your free copy of 'Beyond the Radar' from your dashboard.<br><br>
                If you have any questions or need assistance, please don't hesitate to contact our support team at value.educator@gmail.com.<br><br>
                Thank you for choosing Value Educator!<br><br>
                Best regards,<br>
                Admin Team at Value Educator";
            
            $mail->Body = $message;
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'PHPMailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
    
    // Helper function to record user login information
    private function recordUserLogin($userId)
    {
        $agent = $this->request->getUserAgent();
        
        // Determine device type
        if ($agent->isMobile()) {
            // Check if it's a tablet by looking for common tablet keywords
            $userAgent = $agent->getAgentString();
            $tabletKeywords = ['tablet', 'ipad', 'playbook', 'kindle', 'silk', 'android 3', 'android 4'];
            $isTablet = false;
            
            foreach ($tabletKeywords as $keyword) {
                if (stripos($userAgent, $keyword) !== false) {
                    $isTablet = true;
                    break;
                }
            }
            
            $deviceType = $isTablet ? 'Tablet' : 'Mobile';
        } else {
            $deviceType = 'Desktop';
        }
        
        $loginData = [
            'fld_user_id' => $userId,
            'fld_ip_address' => $this->request->getIPAddress(),
            'fld_user_agent' => $agent->getAgentString(),
            'fld_device_type' => $deviceType,
            'fld_browser' => $agent->getBrowser() . ' ' . $agent->getVersion(),
            'fld_platform' => $agent->getPlatform()
        ];
        
        $db = \Config\Database::connect();
        $db->table('ve_user_logins')->insert($loginData);
    }

    // Helper method to determine redirect URL based on user subscriptions
    private function getUserRedirectUrl($userId)
    {
        $db = \Config\Database::connect();
        
        // Get active subscriptions for the user
        $subscriptions = $db->table('ve_user_subscriptions')
            ->where('user_id', $userId)
            ->where('status', 1) // Active subscriptions
            ->where('end_date >=', date('Y-m-d')) // Not expired
            ->get()
            ->getResultArray();
        
        if (empty($subscriptions)) {
            // No active subscriptions, redirect to emerging titan dashboard
            return base_url('dashboard-emerging-titan');
        }
        
        // Extract product IDs
        $productIds = array_column($subscriptions, 'product_id');
        
        // Check if user has both product IDs 1 and 2
        if (in_array(1, $productIds) && in_array(2, $productIds)) {
            return base_url('dashboard-emerging-titan');
        }
        
        // Check if user has only product ID 2 (Tiny Titans)
        if (in_array(2, $productIds) && !in_array(1, $productIds)) {
            return base_url('dashboard-tiny-titan');
        }
        
        // Default fallback
        return base_url('dashboard-emerging-titan');
    }

    // Update user profile
    public function updateProfile()
    {
        if ($this->request->isAJAX()) {
            // Check if user is logged in
            if (!session()->get('isLoggedIn')) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User not logged in'
                ]);
            }
            
            $userId = session()->get('userId');
            
            // Get form data
            $name = $this->request->getPost('edit_name');
            $email = $this->request->getPost('edit_email');
            $mobile = $this->request->getPost('edit_mobile');
            $day = $this->request->getPost('day');
            $month = $this->request->getPost('month');
            $year = $this->request->getPost('year');
            $panNo = $this->request->getPost('edit_pan_no');
            
            // Validate inputs
            $validation = \Config\Services::validation();
            
            $rules = [
                'edit_name' => 'required|min_length[3]|max_length[100]',
                'edit_email' => 'required|valid_email',
                'edit_mobile' => 'required|min_length[10]|max_length[20]',
                'edit_pan_no' => 'required|min_length[10]|max_length[10]|alpha_numeric'
            ];
            
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validation->getErrors()
                ]);
            }
            
            // Check if email is already taken by another user
            $existingUser = $this->userModel->where('fld_email', $email)
                                            ->where('id !=', $userId)
                                            ->first();
            if ($existingUser) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email is already taken by another user'
                ]);
            }
            
            // Prepare date of birth
            $dateOfBirth = null;
            if (!empty($day) && !empty($month) && !empty($year)) {
                // Validate date components
                if (checkdate($month, $day, $year)) {
                    $dateOfBirth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Invalid date of birth'
                    ]);
                }
            }
            
            // Update user data
            $userData = [
                'fld_full_name' => $name,
                'fld_email' => $email,
                'fld_mobile' => $mobile,
                'fld_date_of_birth' => $dateOfBirth,
                'fld_pan_no' => strtoupper($panNo),
                'fld_updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Update user in database
            $this->userModel->update($userId, $userData);
            
            // Update session data
            session()->set('userName', $name);
            session()->set('userEmail', $email);
            session()->set('userMobile', $mobile);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);
        }
        
        return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Access denied']);
    }

    // Update profile picture
    public function updateProfilePicture()
    {
        if ($this->request->isAJAX()) {
            // Check if user is logged in
            if (!session()->get('isLoggedIn')) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User not logged in'
                ]);
            }
            
            $userId = session()->get('userId');
            
            $file = $this->request->getFile('imageUpload');
            
            // Check if file was uploaded
            if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No file uploaded or upload error occurred'
                ]);
            }
            
            // Validate file
            if (!$file->isValid()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid file uploaded'
                ]);
            }
            
            // Check file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Only JPG, PNG, GIF, and WEBP images are allowed'
                ]);
            }
            
            // Check file size (5MB max)
            if ($file->getSize() > 5 * 1024 * 1024) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File size must be less than 5MB'
                ]);
            }
            
            // Get current user to check for existing profile picture
            $currentUser = $this->userModel->find($userId);
            
            // Generate new file name
            $newName = $userId . '_' . time() . '.' . $file->getExtension();
            
            // Move file to uploads directory
            if (!$file->move(ROOTPATH . 'public/uploads/profile_pictures', $newName)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to move uploaded file'
                ]);
            }
            
            // Delete old profile picture if exists
            if (!empty($currentUser['fld_profile_image'])) {
                $oldImagePath = ROOTPATH . 'public/' . $currentUser['fld_profile_image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            // Update user profile picture in database using Query Builder
            $db = \Config\Database::connect();
            $updateData = [
                'fld_profile_image' => 'uploads/profile_pictures/' . $newName,
                'fld_updated_at' => date('Y-m-d H:i:s')
            ];
            
            try {
                $builder = $db->table('ve_users');
                $builder->where('id', $userId);
                $result = $builder->update($updateData);
                
                if (!$result) {
                    // Delete the uploaded file if update failed
                    @unlink(ROOTPATH . 'public/uploads/profile_pictures/' . $newName);
                    
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update profile picture in database'
                    ]);
                }
                
                // Update session data
                session()->set('userProfileImage', 'uploads/profile_pictures/' . $newName);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Profile picture updated successfully',
                    'image_path' => base_url('uploads/profile_pictures/' . $newName)
                ]);
            } catch (\Exception $e) {
                // Delete the uploaded file if exception occurred
                @unlink(ROOTPATH . 'public/uploads/profile_pictures/' . $newName);
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Access denied']);
    }

    // Get user profile data for the edit form
    public function getProfileData()
    {
        if ($this->request->isAJAX()) {
            // Check if user is logged in
            if (!session()->get('isLoggedIn')) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User not logged in'
                ]);
            }
            
            $userId = session()->get('userId');
            $user = $this->userModel->find($userId);
            
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }
            
            // Parse date of birth
            $day = '';
            $month = '';
            $year = '';
            
            if (!empty($user['fld_date_of_birth'])) {
                $dateParts = explode('-', $user['fld_date_of_birth']);
                if (count($dateParts) === 3) {
                    $year = $dateParts[0];
                    $month = $dateParts[1];
                    $day = $dateParts[2];
                }
            }
            
            return $this->response->setJSON([
                'success' => true,
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['fld_full_name'],
                    'email' => $user['fld_email'],
                    'mobile' => $user['fld_mobile'],
                    'pan_no' => $user['fld_pan_no'] ?? '',
                    'profile_image' => $user['fld_profile_image'] ?? '',
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ]
            ]);
        }
        
        return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Access denied']);
    }
    
    // Add a health check endpoint
    public function healthCheck()
    {
        try {
            $checks = [
                'database' => $this->checkDatabase(),
                'session' => $this->checkSession(),
                'email' => $this->checkEmailService(),
                'memory' => $this->checkMemory(),
                'disk' => $this->checkDiskSpace()
            ];
            
            $allHealthy = array_reduce($checks, function($carry, $check) {
                return $carry && $check['status'] === 'ok';
            }, true);
            
            return $this->response->setJSON([
                'status' => $allHealthy ? 'healthy' : 'unhealthy',
                'timestamp' => Time::now()->toDateTimeString(),
                'checks' => $checks
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
                'timestamp' => Time::now()->toDateTimeString()
            ], 500);
        }
    }
    
    private function checkDatabase()
    {
        try {
            $db = \Config\Database::connect();
            $result = $db->query('SELECT 1')->getResult();
            
            return [
                'status' => 'ok',
                'message' => 'Database connection successful'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed: ' . $e->getMessage()
            ];
        }
    }
    
    private function checkSession()
    {
        try {
            $sessionId = session_id();
            if (empty($sessionId)) {
                session_start();
                $sessionId = session_id();
            }
            
            $_SESSION['health_check'] = time();
            
            return [
                'status' => 'ok',
                'message' => 'Session working',
                'session_id' => $sessionId
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Session error: ' . $e->getMessage()
            ];
        }
    }
    
    private function checkEmailService()
    {
        try {
            // Just check if we can create a PHPMailer instance
            $mail = new PHPMailer(true);
            
            return [
                'status' => 'ok',
                'message' => 'Email service available'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Email service error: ' . $e->getMessage()
            ];
        }
    }
    
    private function checkMemory()
    {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = ini_get('memory_limit');
        $memoryPercent = ($memoryUsage / 1024 / 1024); // Convert to MB
        
        return [
            'status' => $memoryPercent < 256 ? 'ok' : 'warning', // Warning if > 256MB
            'message' => "Memory usage: {$memoryPercent}MB / {$memoryLimit}",
            'usage_bytes' => $memoryUsage
        ];
    }
    
    private function checkDiskSpace()
    {
        $freeSpace = disk_free_space(ROOTPATH);
        $totalSpace = disk_total_space(ROOTPATH);
        $percentUsed = (($totalSpace - $freeSpace) / $totalSpace) * 100;
        
        return [
            'status' => $percentUsed < 90 ? 'ok' : 'warning', // Warning if > 90% used
            'message' => sprintf("Disk usage: %.2f%%", $percentUsed),
            'free_bytes' => $freeSpace
        ];
    }
    
    // Add client error logging endpoint
    public function logClientError()
    {
        if ($this->request->isAJAX()) {
            $errorData = $this->request->getPost();
            
            $this->authLogger->logError('Client-side error', $errorData);
            
            return $this->response->setJSON(['success' => true]);
        }
        
        return $this->response->setStatusCode(403)->setJSON(['success' => false]);
    }

    public function loginPage()
    {
        // If user is already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->getUserRedirectUrl(session()->get('userId')));
        }
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Login - Value Educator',
                'description' => 'Login to your Value Educator account to access premium investment research and recommendations.'
            ]
        ];
        
        return view('front/login', $data);
    }
}