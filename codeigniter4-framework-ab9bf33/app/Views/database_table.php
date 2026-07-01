<div class="card p-4 shadow-sm">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                <i class="bi bi-grid-fill fs-4"></i>
            </div>
            <div>
                <h4 class="mb-1 fw-bold text-dark"><?php echo esc($title ?? 'Data'); ?></h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;"><?php echo esc($message ?? ''); ?></p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?php echo count($records ?? []); ?> data</span>
            <?php if (isset($exportUrl)): ?>
                <a href="<?php echo esc($exportUrl); ?>" class="btn btn-sm btn-success shadow-sm">
                    <i class="bi bi-file-earmark-excel"></i> Export CSV
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0 crud-table">
            <thead>
                <tr>
                    <?php foreach (($columns ?? []) as $column): ?>
                        <th><?php echo esc($column); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (! empty($records)): ?>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <?php foreach ($record as $value): ?>
                                <td><?php echo esc($value); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php echo count($columns ?? []) ?: 1; ?>">
                            <div class="empty-state">
                                <i class="bi bi-box-seam empty-state-icon d-block"></i>
                                <h5 class="mt-3 fw-bold text-dark">Data Kosong</h5>
                                <p class="text-muted mb-0">Belum ada catatan data yang tersedia di tabel ini.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>