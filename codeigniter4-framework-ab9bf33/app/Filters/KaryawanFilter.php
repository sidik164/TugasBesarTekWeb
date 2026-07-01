<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filter karyawan: memastikan user login DAN role === 'karyawan'.
 * Jika bukan karyawan, redirect ke dashboard admin.
 */
class KaryawanFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->has('user_id')) {
            return redirect()->to(site_url('/'))->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') !== 'karyawan') {
            return redirect()->to(site_url('admin/dashboard'))->with('error', 'Halaman ini khusus untuk karyawan.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
