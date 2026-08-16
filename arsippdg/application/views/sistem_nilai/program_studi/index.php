<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-diagram-3 text-success"></i> Program Studi</h1>
            <p class="text-muted mb-0">Kelola data master program studi.</p>
        </div>
        <a href="<?= site_url('sistem-nilai/master-data/program-studi/tambah'); ?>" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Program Studi</a>
    </div>

    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="get" action="<?= site_url('sistem-nilai/master-data/program-studi'); ?>" class="row g-2 mb-4">
            <div class="col-sm-8 col-md-6"><input type="search" name="q" class="form-control" value="<?= html_escape($keyword); ?>" placeholder="Cari kode atau nama program studi"></div>
            <div class="col-auto"><button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i> Cari</button></div>
            <?php if ($keyword !== ''): ?><div class="col-auto"><a href="<?= site_url('sistem-nilai/master-data/program-studi'); ?>" class="btn btn-outline-secondary">Reset</a></div><?php endif; ?>
        </form>

        <div class="table-responsive"><table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>No.</th><th>Kode</th><th>Nama Program Studi</th><th>Jenjang</th><th>Status</th><th>Diperbarui</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($program_studi)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Data program studi belum tersedia.</td></tr>
                <?php else: ?>
                    <?php foreach ($program_studi as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1; ?></td><td><code><?= html_escape($item->kode_prodi); ?></code></td><td><?= html_escape($item->nama_prodi); ?></td>
                        <td><span class="badge bg-primary"><?= html_escape($item->jenjang); ?></span></td>
                        <td><span class="badge <?= $item->status === 'Aktif' ? 'bg-success' : 'bg-secondary'; ?>"><?= html_escape($item->status); ?></span></td>
                        <td><?= date('d-m-Y H:i', strtotime($item->updated_at)); ?></td>
                        <td class="text-end">
                            <a href="<?= site_url('sistem-nilai/master-data/program-studi/ubah/' . $item->id); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Ubah</a>
                            <form method="post" action="<?= site_url('sistem-nilai/master-data/program-studi/hapus/' . $item->id); ?>" class="d-inline delete-form" data-delete-confirm="Program studi <?= html_escape($item->nama_prodi); ?> akan dihapus. Data terkait juga akan ikut terhapus."><button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button></form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table></div>
    </div></div>
</main>
