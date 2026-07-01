<?php
$editingId = (int) ($editingId ?? 0);
$urlPrefix = $urlPrefix ?? ($active ?? '');
?>
<div class="card p-4 shadow-sm mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
        <div>
            <h4 class="mb-1"><?php echo esc($title ?? 'Data'); ?></h4>
            <p class="text-muted mb-0"><?php echo esc($message ?? ''); ?></p>
        </div>
        <span class="badge bg-light text-dark border"><?php echo $editingId > 0 ? 'Mode edit' : 'Mode tambah'; ?></span>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success mb-4"><?php echo esc(session()->getFlashdata('message')); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger mb-4"><?php echo esc(session()->getFlashdata('error')); ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo esc($action ?? '#'); ?>" class="row g-3 crud-form" enctype="multipart/form-data">
        <?php if (function_exists('csrf_field')): ?>
            <?php echo csrf_field(); ?>
        <?php endif; ?>
        <input type="hidden" name="id" value="<?php echo esc((string) $editingId); ?>">
        <?php foreach (($fields ?? []) as $field): ?>
            <div class="col-12 col-md-<?php echo ($field['type'] ?? '') === 'select' ? '6' : '6'; ?>">
                <label class="form-label"><?php echo esc($field['label'] ?? $field['name']); ?></label>
                <?php if (($field['type'] ?? 'text') === 'select'): ?>
                    <select name="<?php echo esc($field['name']); ?>" class="form-select" required>
                        <?php foreach (($field['options'] ?? []) as $optionValue => $optionLabel): ?>
                            <option value="<?php echo esc((string) $optionValue); ?>" <?php echo (($field['value'] ?? '') === $optionValue) ? 'selected' : ''; ?>><?php echo esc($optionLabel); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif (($field['type'] ?? '') === 'textarea'): ?>
                    <textarea name="<?php echo esc($field['name']); ?>" class="form-control" rows="5" required><?php echo esc((string) ($field['value'] ?? '')); ?></textarea>
                <?php elseif (($field['type'] ?? '') === 'file'): ?>
                    <?php if (!empty($field['value'])): ?>
                        <div class="mb-2">
                            <span class="badge bg-info">File Saat Ini: <?php echo esc($field['value']); ?></span>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="<?php echo esc($field['name']); ?>" class="form-control" accept=".pdf,image/*" <?php echo empty($field['value']) && ($field['required'] ?? false) ? 'required' : ''; ?>>
                    <small class="text-muted">Format: PDF, JPG, PNG.</small>
                <?php else: ?>
                    <input type="<?php echo esc($field['type'] ?? 'text'); ?>" name="<?php echo esc($field['name']); ?>" class="form-control" value="<?php echo esc((string) ($field['value'] ?? '')); ?>" <?php echo (($field['type'] ?? 'text') === 'password') ? '' : 'required'; ?>>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="col-12 d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-primary px-4"><?php echo $editingId > 0 ? 'Update' : 'Tambah'; ?></button>
            <?php if ($editingId > 0): ?>
                <a class="btn btn-outline-secondary" href="<?php echo esc(site_url($urlPrefix)); ?>">Batal</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card p-4 shadow-sm">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <h5 class="mb-0">Daftar Data</h5>
        <div class="d-flex align-items-center gap-3">
            <?php if (isset($filterOptions)): ?>
                <form method="get" action="<?php echo esc(site_url($urlPrefix)); ?>" class="d-flex align-items-center gap-2">
                    <label for="filter_select" class="form-label mb-0 text-nowrap small text-muted">Filter:</label>
                    <select name="<?php echo esc($filterOptions['name']); ?>" id="filter_select" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php foreach ($filterOptions['options'] as $val => $label): ?>
                            <option value="<?php echo esc((string)$val); ?>" <?php echo ((string)$filterOptions['selected'] === (string)$val) ? 'selected' : ''; ?>>
                                <?php echo esc($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            <?php endif; ?>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?php echo count($records ?? []); ?> data</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0 crud-table">
            <thead>
                <tr>
                    <?php foreach (($columns ?? []) as $column): ?>
                        <th><?php echo esc($column); ?></th>
                    <?php endforeach; ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (! empty($records)): ?>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <?php foreach (($record['cells'] ?? []) as $value): ?>
                                <td><?php echo esc($value); ?></td>
                            <?php endforeach; ?>
                            <td class="text-nowrap crud-actions">
                                <a class="btn btn-sm btn-outline-primary" href="<?php echo esc(site_url($urlPrefix . '/edit/' . ($record['id'] ?? 0))); ?>">Edit</a>
                                <a class="btn btn-sm btn-outline-danger btn-delete" href="<?php echo esc(site_url($urlPrefix . '/delete/' . ($record['id'] ?? 0))); ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php echo (count($columns ?? []) + 1) ?: 1; ?>" class="text-muted">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>