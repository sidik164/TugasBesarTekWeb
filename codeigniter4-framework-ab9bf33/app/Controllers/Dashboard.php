<?php

namespace App\Controllers;

/**
 * Dashboard controller — sekarang hanya berfungsi sebagai smart redirect.
 * Mengarahkan user ke dashboard sesuai role masing-masing.
 */
class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->has('user_id')) {
            return redirect()->to(site_url('/'));
        }

        $role = session()->get('role');

        if ($role === 'admin') {
            return redirect()->to(site_url('admin/dashboard'));
        }

        return redirect()->to(site_url('karyawan/dashboard'));
    }
}