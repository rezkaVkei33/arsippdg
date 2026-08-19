<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div><h1 class="h3 mb-1"><i class="bi bi-pen text-success"></i> Tanda Tangan Pejabat</h1><p class="text-muted mb-0">Kelola data tanda tangan dan cap pejabat untuk dokumen.</p></div>
        <a href="<?= site_url('sistem-nilai/pengaturan/tanda-tangan/tambah'); ?>" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Tanda Tangan</a>
    </div>

    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="get" action="<?= site_url('sistem-nilai/pengaturan/tanda-tangan'); ?>" class="row g-2 mb-4">
            <div class="col-sm-6 col-md-5">
                <input type="search" name="q" class="form-control" value="<?= html_escape($keyword); ?>" placeholder="Cari nama, nomor induk, atau jabatan">
            </div>
            <div class="col-auto"><button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i> Cari</button></div>
            <?php if ($keyword !== ''): ?><div class="col-auto"><a href="<?= site_url('sistem-nilai/pengaturan/tanda-tangan'); ?>" class="btn btn-outline-secondary">Reset</a></div><?php endif; ?>
        </form>
        <div class="table-responsive"><table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Nama Pejabat</th><th>Jabatan</th><th>Nomor Induk</th><th>Tanggal TTD</th><th class="text-center">TTD</th><th class="text-center">Cap</th><th class="text-center">Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody><?php if (empty($pejabat)): ?><tr><td colspan="8" class="text-center text-muted py-4">Data tanda tangan belum tersedia.</td></tr><?php else: ?><?php foreach ($pejabat as $row): ?><tr>
                <td><?= html_escape($row->nama_pejabat); ?></td>
                <td><?= html_escape($row->jabatan); ?></td>
                <td><code><?= html_escape($row->nomor_induk ?: '-'); ?></code></td>
                <td><?= date('d M Y', strtotime($row->tanggal_ttd)); ?></td>
                <td class="text-center">
                    <?php if (!empty($row->ttd_path)): ?>
                        <a href="<?= base_url('assets/' . $row->ttd_path); ?>" target="_blank" class="badge bg-info text-decoration-none"><i class="bi bi-image"></i> Lihat</a>
                    <?php else: ?>
                        <span class="badge bg-secondary">-</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if (!empty($row->cap_path)): ?>
                        <a href="<?= base_url('assets/' . $row->cap_path); ?>" target="_blank" class="badge bg-info text-decoration-none"><i class="bi bi-image"></i> Lihat</a>
                    <?php else: ?>
                        <span class="badge bg-secondary">-</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <form method="post" action="<?= site_url('sistem-nilai/pengaturan/tanda-tangan/toggle-status/' . $row->id); ?>" class="d-inline">
                        <button type="submit" class="btn btn-sm <?= (int) $row->status === 1 ? 'btn-success' : 'btn-secondary'; ?>" title="Klik untuk mengubah status">
                            <?= (int) $row->status === 1 ? '<i class="bi bi-check-circle"></i> Aktif' : '<i class="bi bi-x-circle"></i> Nonaktif'; ?>
                        </button>
                    </form>
                </td>
                <td class="text-end">
                    <a href="<?= site_url('sistem-nilai/pengaturan/tanda-tangan/ubah/' . $row->id); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Ubah</a>
                    <form method="post" action="<?= site_url('sistem-nilai/pengaturan/tanda-tangan/hapus/' . $row->id); ?>" class="d-inline delete-form" data-delete-confirm="Data tanda tangan <?= html_escape($row->nama_pejabat); ?> akan dihapus beserta file gambarnya.">
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr><?php endforeach; ?><?php endif; ?></tbody>
        </table></div>

        <?php $pagination_links = $this->pagination->create_links(); ?>
        <?php if ($pagination_links !== ''): ?>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
                <small class="text-muted">Menampilkan <?= count($pejabat); ?> dari <?= $total_rows; ?> data</small>
                <?= $pagination_links; ?>
            </div>
        <?php endif; ?>
    </div></div>
</main>
