<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModulModel;

class Modules extends BaseController
{
    public function index()
    {
        return $this->response->setJSON((new ModulModel())->orderBy('urutan', 'ASC')->findAll());
    }

    public function show(int $id)
    {
        return $this->response->setJSON((new ModulModel())->find($id));
    }

    public function create()
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getPost();
        $model = new ModulModel();
        $model->insert([
            'judul' => $payload['judul'] ?? '',
            'urutan' => (int) ($payload['urutan'] ?? 1),
        ]);

        return $this->response->setJSON(['status' => 'created', 'id' => $model->getInsertID()])->setStatusCode(201);
    }

    public function update(int $id)
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getRawInput();
        $data = array_filter([
            'judul' => $payload['judul'] ?? null,
            'urutan' => isset($payload['urutan']) ? (int) $payload['urutan'] : null,
        ], static fn ($value) => $value !== null);

        (new ModulModel())->update($id, $data);

        return $this->response->setJSON(['status' => 'updated']);
    }

    public function delete(int $id)
    {
        (new ModulModel())->delete($id);

        return $this->response->setJSON(['status' => 'deleted']);
    }
}