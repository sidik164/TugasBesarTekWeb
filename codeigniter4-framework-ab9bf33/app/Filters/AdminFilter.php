<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filter admin: memastikan user login DAN role === 'admin'.
 * Jika bukan admin, redirect ke dashboard karyawan.
 */
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->has('user_id')) {
            return redirect()->to(site_url('/'))->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to(site_url('karyawan/dashboard'))->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
