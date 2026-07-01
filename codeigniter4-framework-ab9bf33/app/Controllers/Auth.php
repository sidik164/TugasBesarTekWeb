<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->has('user_id')) {
            return $this->redirectByRole();
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $login = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->groupStart()
            ->where('username', $login)
            ->orWhere('email', $login)
            ->groupEnd()
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id' => $user['id'],
                'nama' => $user['nama'],
                'role' => $user['role'],
            ]);

            // Redirect ke dashboard sesuai role
            return $this->redirectByRole($user['role']);
        }

        return redirect()->to(site_url('/'))->with('error', 'Username/email atau password salah.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('/'))->with('message', 'Kamu sudah logout.');
    }

    /**
     * Redirect user ke dashboard sesuai role.
     */
    private function redirectByRole(?string $role = null)
    {
        $role = $role ?? session()->get('role');

        if ($role === 'admin') {
            return redirect()->to(site_url('admin/dashboard'));
        }

        return redirect()->to(site_url('karyawan/dashboard'));
    }
}