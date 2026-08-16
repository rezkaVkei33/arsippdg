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
            <form method="get" action="<?= site_url('sistem-nilai/akademik/riwayat-mahasiswa'); ?>" class="row g-2 mb-4">
                <input type="hidden" name="tahun_id" value="<?= (int) ($tahun_akademik->id ?? 0); ?>">
                <input type="hidden" name="semester" value="<?= html_escape((string) ($semester ?? '')); ?>">
                <div class="col-md-5">
                    <select name="prodi" class="form-select">
                        <option value="">Semua Program Studi</option>
                        <?php foreach ($program_studi_options as $item): ?>
                            <option value="<?= (int) $item->id; ?>" <?= (string) $selected_prodi === (string) $item->id ? 'selected' : ''; ?>><?= html_escape($item->nama_prodi); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-search"></i> Filter</button>
                </div>
                <?php if ($selected_prodi !== ''): ?>
                    <div class="col-auto">
                        <a href="<?= site_url('sistem-nilai/akademik/riwayat-mahasiswa?tahun_id=' . (int) ($tahun_akademik->id ?? 0) . '&semester=' . urlencode((string) ($semester ?? ''))); ?>" class="btn btn-outline-secondary">Reset</a>
                    </div>
                <?php endif; ?>
            </form>

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

            <?php $pagination_links = $this->pagination->create_links(); ?>
            <?php if ($pagination_links !== ''): ?>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
                    <small class="text-muted">Menampilkan <?= count($mahasiswa); ?> dari <?= $total_rows; ?> data</small>
                    <?= $pagination_links; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
