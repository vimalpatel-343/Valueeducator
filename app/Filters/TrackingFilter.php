<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class TrackingFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if this is an AJAX request or admin panel
        if ($request->isAJAX() || strpos($request->getPath(), '/admin') === 0) {
            return;
        }
        
        // Get current user ID if logged in
        $session = \Config\Services::session();
        $userId = $session->get('userId');
        
        // Capture tracking data
        captureTrackingData($userId);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}