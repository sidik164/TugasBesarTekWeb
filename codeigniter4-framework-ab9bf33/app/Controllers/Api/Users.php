<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        return $this->response->setJSON((new UserModel())->orderBy('id', 'ASC')->findAll());
    }

    public function show(int $id)
    {
        return $this->response->setJSON((new UserModel())->find($id));
    }

    public function create()
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getPost();
        $model = new UserModel();
        $model->insert([
            'nama' => $payload['nama'] ?? '',
            'username' => $payload['username'] ?? '',
            'password' => isset($payload['password']) ? password_hash((string) $payload['password'], PASSWORD_DEFAULT) : '',
            'role' => $payload['role'] ?? 'karyawan',
        ]);

        return $this->response->setJSON(['status' => 'created', 'id' => $model->getInsertID()])->setStatusCode(201);
    }

    public function update(int $id)
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getRawInput();
        $data = array_filter([
            'nama' => $payload['nama'] ?? null,
            'username' => $payload['username'] ?? null,
            'role' => $payload['role'] ?? null,
            'password' => ! empty($payload['password']) ? password_hash((string) $payload['password'], PASSWORD_DEFAULT) : null,
        ], static fn ($value) => $value !== null);

        (new UserModel())->update($id, $data);

        return $this->response->setJSON(['status' => 'updated']);
    }

    public function delete(int $id)
    {
        (new UserModel())->delete($id);

        return $this->response->setJSON(['status' => 'deleted']);
    }
}