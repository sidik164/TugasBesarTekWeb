<?php
$endpointRows = [
    ['GET', '/api/users', 'Daftar user'],
    ['GET', '/api/users/{id}', 'Detail user'],
    ['POST', '/api/users', 'Tambah user'],
    ['PUT', '/api/users/{id}', 'Update user'],
    ['DELETE', '/api/users/{id}', 'Hapus user'],
    ['GET', '/api/modules', 'Daftar modul'],
    ['GET', '/api/modules/{id}', 'Detail modul'],
    ['POST', '/api/modules', 'Tambah modul'],
    ['PUT', '/api/modules/{id}', 'Update modul'],
    ['DELETE', '/api/modules/{id}', 'Hapus modul'],
];

$sampleUserPayload = [
    'nama' => 'Budi Santoso',
    'username' => 'budi',
    'password' => 'rahasia123',
    'role' => 'karyawan',
];

$sampleModulePayload = [
    'judul' => 'Pelatihan Digital Manufacturing',
    'urutan' => 4,
];
?>

<div class="card p-4 shadow-sm mb-4">
    <h4 class="mb-2">REST API Docs</h4>
    <p class="text-muted mb-0">Endpoint JSON untuk pengolahan data user dan modul pelatihan.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-lg-6">
        <div class="card p-4 shadow-sm h-100">
            <h5 class="mb-2">Cara Pakai Cepat</h5>
            <ol class="mb-0 ps-3 text-muted">
                <li>Buka endpoint lewat browser untuk metode GET.</li>
                <li>Gunakan JSON body untuk POST dan PUT.</li>
                <li>Endpoint DELETE menghapus data berdasarkan ID.</li>
                <li>User dan modul sudah terhubung ke database ci4.</li>
            </ol>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card p-4 shadow-sm h-100">
            <h5 class="mb-2">Contoh Payload</h5>
            <div class="mb-3">
                <small class="text-uppercase text-muted fw-semibold">POST /api/users</small>
                <pre class="api-code mb-0"><?php echo esc(json_encode($sampleUserPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
            </div>
            <div>
                <small class="text-uppercase text-muted fw-semibold">POST /api/modules</small>
                <pre class="api-code mb-0"><?php echo esc(json_encode($sampleModulePayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
            </div>
        </div>
    </div>
</div>

<div class="card p-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Endpoint</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($endpointRows as $row): ?>
                    <tr>
                        <td><span class="badge bg-dark"><?php echo esc($row[0]); ?></span></td>
                        <td><?php echo esc($row[1]); ?></td>
                        <td><?php echo esc($row[2]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>