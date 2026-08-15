<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div><h1 class="h3 mb-1"><i class="bi bi-people text-success"></i> Mahasiswa</h1><p class="text-muted mb-0">Kelola data master mahasiswa.</p></div>
        <div class="d-flex gap-2"><a href="<?= site_url('sistem-nilai/master-data/mahasiswa/upload'); ?>" class="btn btn-outline-success"><i class="bi bi-file-earmark-excel"></i> Upload Excel</a><a href="<?= site_url('sistem-nilai/master-data/mahasiswa/tambah'); ?>" class="btn btn-success"><i class="bi bi-person-plus"></i> Tambah Mahasiswa</a></div>
    </div>

    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="get" action="<?= site_url('sistem-nilai/master-data/mahasiswa'); ?>" class="row g-2 mb-4"><div class="col-sm-8 col-md-6"><input type="search" name="q" class="form-control" value="<?= html_escape($keyword); ?>" placeholder="Cari NIM, nama, atau program studi"></div><div class="col-auto"><button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i> Cari</button></div><?php if ($keyword !== ''): ?><div class="col-auto"><a href="<?= site_url('sistem-nilai/master-data/mahasiswa'); ?>" class="btn btn-outline-secondary">Reset</a></div><?php endif; ?></form>
        <div class="table-responsive"><table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>No.</th><th>NIM</th><th>Nama</th><th>Jenis Kelamin</th><th>Program Studi</th><th>Angkatan</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody><?php if (empty($mahasiswa)): ?><tr><td colspan="8" class="text-center text-muted py-4">Data mahasiswa belum tersedia.</td></tr><?php else: ?><?php foreach ($mahasiswa as $index => $item): ?><tr>
                <td><?= $index + 1; ?></td><td><code><?= html_escape($item->nim); ?></code></td><td><?= html_escape($item->nama); ?></td><td><?= $item->jenis_kelamin === 'L' ? 'Laki-laki' : ($item->jenis_kelamin === 'P' ? 'Perempuan' : '-'); ?></td><td><?= html_escape($item->kode_prodi ? $item->kode_prodi . ' — ' . $item->nama_prodi : '-'); ?></td><td><?= html_escape($item->angkatan ?: '-'); ?></td><td><span class="badge <?= $item->status === 'Aktif' ? 'bg-success' : 'bg-secondary'; ?>"><?= html_escape($item->status); ?></span></td>
                <td class="text-end"><a href="<?= site_url('sistem-nilai/master-data/mahasiswa/ubah/' . $item->id); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Ubah</a><form method="post" action="<?= site_url('sistem-nilai/master-data/mahasiswa/hapus/' . $item->id); ?>" class="d-inline" onsubmit="return confirm('Hapus data mahasiswa ini?');"><button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button></form></td>
            </tr><?php endforeach; ?><?php endif; ?></tbody>
        </table></div>
    </div></div>
</main>
