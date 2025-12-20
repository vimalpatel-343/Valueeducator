<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        // For admin routes, check if the user is an admin
        $uri = service('uri');
        if ($uri->getSegment(1) === 'admin') {
            // Check if the user is an admin
            if (!session()->get('isAdmin')) {
                session()->setFlashdata('error', 'You do not have permission to access the admin area.');
                return redirect()->to('/auth');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}