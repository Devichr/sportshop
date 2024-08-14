<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class OwnerAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    $session = session();
    if (!$session->get('isLoggedIn')) {
        log_message('error', 'User not logged in');
        return redirect()->to('/login')->with('error', 'You must be logged in to access this page.');
    }

    if ($session->get('role') !== 'owner') {
        log_message('error', 'Owner Only');
        return redirect()->to('/')->with('error', 'Owner only.');
    }
}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah response
    }
}
