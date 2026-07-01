<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->has('user_id')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('auth/login');
    }
}
