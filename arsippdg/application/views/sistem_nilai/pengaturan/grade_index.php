<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div><h1 class="h3 mb-1"><i class="bi bi-sliders text-success"></i> Grade</h1><p class="text-muted mb-0">Kelola data grade untuk penilaian mahasiswa.</p></div>
        <a href="<?= site_url('sistem-nilai/pengaturan/grade/tambah'); ?>" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Grade</a>
    </div>

    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="get" action="<?= site_url('sistem-nilai/pengaturan/grade'); ?>" class="row g-2 mb-4">
            <div class="col-sm-6 col-md-5">
                <input type="search" name="q" class="form-control" value="<?= html_escape($keyword); ?>" placeholder="Cari kode atau keterangan grade">
            </div>
            <div class="col-auto"><button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i> Cari</button></div>
            <?php if ($keyword !== ''): ?><div class="col-auto"><a href="<?= site_url('sistem-nilai/pengaturan/grade'); ?>" class="btn btn-outline-secondary">Reset</a></div><?php endif; ?>
        </form>
        <div class="table-responsive"><table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>No.</th><th>Kode</th><th>Nilai Min</th><th>Nilai Max</th><th>Bobot</th><th>Keterangan</th><th class="text-end">Aksi</th></tr></thead>
            <tbody><?php if (empty($grades)): ?><tr><td colspan="7" class="text-center text-muted py-4">Data grade belum tersedia.</td></tr><?php else: ?><?php foreach ($grades as $index => $row): ?><tr>
                <td><?= $index + 1 + (($current_page - 1) * $per_page); ?></td>
                <td><span class="badge bg-primary"><?= html_escape($row->kode); ?></span></td>
                <td><?= number_format((float) $row->nilai_min, 2, ',', '.'); ?></td>
                <td><?= number_format((float) $row->nilai_max, 2, ',', '.'); ?></td>
                <td><?= number_format((float) $row->bobot, 2, ',', '.'); ?></td>
                <td><?= html_escape($row->keterangan ?: '-'); ?></td>
                <td class="text-end">
                    <a href="<?= site_url('sistem-nilai/pengaturan/grade/ubah/' . (int) $row->id); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Ubah</a>
                    <form method="post" action="<?= site_url('sistem-nilai/pengaturan/grade/hapus/' . (int) $row->id); ?>" class="d-inline delete-form" data-delete-confirm="Data grade <?= html_escape($row->kode . ' - ' . $row->keterangan); ?> akan dihapus.">
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr><?php endforeach; ?><?php endif; ?></tbody>
        </table></div>

        <?php $pagination_links = $this->pagination->create_links(); ?>
        <?php if ($pagination_links !== ''): ?>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
                <small class="text-muted">Menampilkan <?= count($grades); ?> dari <?= $total_rows; ?> data</small>
                <?= $pagination_links; ?>
            </div>
        <?php endif; ?>
    </div></div>
</main>
