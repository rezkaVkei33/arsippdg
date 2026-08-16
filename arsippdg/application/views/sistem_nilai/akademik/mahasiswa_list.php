<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-people text-success"></i> Daftar Mahasiswa</h1>
            <p class="text-muted mb-0">Tahun Akademik: <?= html_escape($tahun_akademik->tahun ?? '-'); ?> / Semester: <?= html_escape((string) ($semester ?: '-')); ?></p>
        </div>
        <a href="<?= site_url('sistem-nilai/akademik/khs'); ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($mahasiswa)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada mahasiswa untuk tahun akademik dan semester ini.</td></tr>
                        <?php else: ?>
                            <?php foreach ($mahasiswa as $row): ?>
                                <tr>
                                    <td><?= html_escape($row->nim); ?></td>
                                    <td><?= html_escape($row->nama); ?></td>
                                    <td><?= html_escape($row->nama_prodi ?: '-'); ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('sistem-nilai/akademik/khs-mahasiswa/' . (int) $row->id . '/' . (int) $tahun_akademik->id); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Lihat KHS
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
