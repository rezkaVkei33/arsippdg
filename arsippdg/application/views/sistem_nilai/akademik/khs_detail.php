<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-file-earmark-text text-success"></i> Kartu Hasil Studi</h1>
        </div>
        <a href="<?= site_url('sistem-nilai/akademik/riwayat-mahasiswa?tahun_id=' . (int) $tahun_akademik->id . '&semester=' . (int) $tahun_akademik->semester); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3"><strong>Nama Mahasiswa</strong><div><?= html_escape($mahasiswa->nama ?: '-'); ?></div></div>
                <div class="col-md-3"><strong>NIM</strong><div><?= html_escape($mahasiswa->nim ?: '-'); ?></div></div>
                <div class="col-md-3"><strong>Program Studi</strong><div><?= html_escape($mahasiswa->nama_prodi ?: '-'); ?></div></div>
                <div class="col-md-3"><strong>Semester</strong><div><?= html_escape((string) ($tahun_akademik->semester ?? '-')); ?></div></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Mata Kuliah</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Nilai Huruf</th>
                            <th>Nilai Angka</th>
                            <th>Nilai Mutu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($khs)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data KHS untuk mahasiswa ini.</td></tr>
                        <?php else: ?>
                            <?php foreach ($khs as $index => $row): ?>
                                <tr>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= html_escape($row->kode_mk ?: '-'); ?></td>
                                    <td><?= html_escape($row->nama_mk ?: '-'); ?></td>
                                    <td><?= html_escape((string) $row->sks); ?></td>
                                    <td><?= html_escape($row->nilai_huruf ?: '-'); ?></td>
                                    <td><?= html_escape((string) $row->nilai_angka); ?></td>
                                    <td><?= html_escape((string) $row->nilai_mutu); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($khs)): ?>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Jumlah</th>
                                <th><?= html_escape((string) $total_sks); ?></th>
                                <th colspan="2"></th>
                                <th><?= html_escape((string) $total_nilai_mutu); ?></th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-end">IP</th>
                                <th><?= html_escape(number_format((float) $ip, 2, ',', '.')); ?></th>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <button type="button" class="btn btn-outline-success" disabled>
                    <i class="bi bi-download"></i> Export KHS
                </button>
            </div>
        </div>
    </div>
</main>
