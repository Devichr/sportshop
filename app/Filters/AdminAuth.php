<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    $session = session();
    if (!$session->get('isLoggedIn')) {
        log_message('error', 'User not logged in');
        return redirect()->to('/login')->with('error', 'You must be logged in to access this page.');
    }

    if ($session->get('role') !== 'admin') {
        log_message('error', 'Access denied for non-admin user');
        return redirect()->to('/')->with('error', 'Access denied. Admins only.');
    }
}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah response
    }
}
