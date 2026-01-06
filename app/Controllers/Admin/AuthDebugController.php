<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\LoggerService;

class AuthDebugController extends BaseController
{
    protected $logger;
    
    public function __construct()
    {
        $this->logger = new LoggerService();
    }
    
    public function index()
    {
        // Only accessible in development or with admin rights
        if (ENVIRONMENT === 'production' && (!session()->get('isLoggedIn') || session()->get('userRole') !== 'admin')) {
            return redirect()->to(base_url())->with('error', 'Access denied');
        }
        
        $data = [
            'recentErrors' => $this->logger->getRecentErrors(100),
            'systemInfo' => $this->getSystemInfo()
        ];
        
        return view('admin/auth_debug', $data);
    }
    
    private function getSystemInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'ci_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'session_save_path' => session_save_path(),
            'session_gc_maxlifetime' => ini_get('session.gc_maxlifetime'),
            'timezone' => date_default_timezone_get(),
            'current_time' => date('Y-m-d H:i:s'),
            'disk_free_space' => $this->formatBytes(disk_free_space(ROOTPATH)),
            'disk_total_space' => $this->formatBytes(disk_total_space(ROOTPATH))
        ];
    }
    
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}