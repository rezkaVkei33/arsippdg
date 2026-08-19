<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-clipboard-data text-success"></i> Daftar Nilai</h1>
            <p class="text-muted mb-0">Kelola data nilai mahasiswa.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="get" action="<?= site_url('sistem-nilai/penilaian/daftar-nilai'); ?>" class="row g-2 mb-4">
                <div class="col-sm-6 col-md-5">
                    <input type="search" name="q" class="form-control" value="<?= html_escape($keyword); ?>" placeholder="Cari NIM, nama, atau mata kuliah">
                </div>
                <div class="col-sm-6 col-md-3">
                    <select name="prodi" class="form-select">
                        <option value="">Semua Program Studi</option>
                        <?php foreach ($program_studi_options as $item): ?>
                            <option value="<?= (int) $item->id; ?>" <?= (string) $selected_prodi === (string) $item->id ? 'selected' : ''; ?>><?= html_escape($item->nama_prodi); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-6 col-md-3">
                    <select name="mata_kuliah" class="form-select">
                        <option value="">Semua Mata Kuliah</option>
                        <?php foreach ($mata_kuliah_options as $item): ?>
                            <option value="<?= (int) $item->id; ?>" <?= (string) $selected_mata_kuliah === (string) $item->id ? 'selected' : ''; ?>><?= html_escape($item->semester . ' - ' . $item->kode_mk . ' - ' . $item->nama_mk); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i> Cari</button>
                </div>
                <?php if ($keyword !== '' || $selected_mata_kuliah !== '' || $selected_prodi !== ''): ?>
                    <div class="col-auto">
                        <a href="<?= site_url('sistem-nilai/penilaian/daftar-nilai'); ?>" class="btn btn-outline-secondary">Reset</a>
                    </div>
                <?php endif; ?>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th>Mata Kuliah</th>
                            <th>Tahun / Semester</th>
                            <th>Nilai Angka</th>
                            <th>Nilai Huruf</th>
                            <th>Bobot</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($nilai)): ?>
                            <tr><td colspan="10" class="text-center text-muted py-4">Data nilai belum tersedia.</td></tr>
                        <?php else: ?>
                            <?php foreach ($nilai as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 + (($current_page - 1) * $per_page); ?></td>
                                    <td><code><?= html_escape($item->nim); ?></code></td>
                                    <td><?= html_escape($item->nama); ?></td>
                                    <td><?= html_escape($item->nama_prodi ?: '-'); ?></td>
                                    <td><?= html_escape($item->kode_mk ? $item->kode_mk . ' - ' . $item->nama_mk : '-'); ?></td>
                                    <td><?= html_escape($item->tahun ? $item->tahun . ' / ' . $item->semester : '-'); ?></td>
                                    <td><?= html_escape($item->nilai_angka !== NULL ? number_format((float) $item->nilai_angka, 2, ',', '.') : '-'); ?></td>
                                    <td><span class="badge bg-primary"><?= html_escape($item->nilai_huruf ?: '-'); ?></span></td>
                                    <td><?= html_escape($item->bobot !== NULL ? number_format((float) $item->bobot, 2, ',', '.') : '-'); ?></td>
                                    <td class="text-end">
                                        <a href="<?= site_url('sistem-nilai/penilaian/ubah/' . $item->id); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Ubah</a>
                                        <form method="post" action="<?= site_url('sistem-nilai/penilaian/hapus/' . $item->id); ?>" class="d-inline delete-form" data-delete-confirm="Data nilai mahasiswa <?= html_escape($item->nama); ?> akan dihapus. Data terkait juga akan ikut terhapus.">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
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
                    <small class="text-muted">Menampilkan <?= count($nilai); ?> dari <?= $total_rows; ?> data</small>
                    <?= $pagination_links; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
