<main class="container py-4" style="max-width: 760px;">
    <div class="mb-4">
        <h1 class="h3 mb-1"><i class="bi bi-trash text-danger"></i> Hapus Nilai Mahasiswa</h1>
        <p class="text-muted mb-0">Hapus seluruh nilai mata kuliah seorang mahasiswa pada tahun akademik dan semester tertentu.</p>
    </div>

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        Data nilai yang dihapus tidak dapat dipulihkan. Pastikan mahasiswa, tahun akademik, dan semester sudah benar.
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="post" action="<?= site_url('sistem-nilai/penilaian/proses-hapus-nilai'); ?>" class="delete-form" data-delete-confirm="Seluruh nilai mata kuliah mahasiswa pada tahun akademik dan semester yang dipilih akan dihapus permanen.">
                <div class="mb-3">
                    <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id" id="mahasiswa_id" class="form-select" required>
                        <option value="">Pilih Mahasiswa</option>
                        <?php foreach ($mahasiswa_options as $item): ?>
                            <option value="<?= (int) $item->id; ?>"><?= html_escape($item->nim . ' - ' . $item->nama . ($item->nama_prodi ? ' (' . $item->nama_prodi . ')' : '')); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="tahun_akademik_id" class="form-label">Tahun Akademik</label>
                        <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-select" required>
                            <option value="">Pilih Tahun Akademik</option>
                            <?php foreach ($tahun_akademik_options as $item): ?>
                                <option value="<?= (int) $item->id; ?>"><?= html_escape($item->tahun . ' / ' . $item->semester); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="semester" class="form-label">Semester Mata Kuliah</label>
                        <select name="semester" id="semester" class="form-select" required>
                            <option value="">Pilih Semester</option>
                            <?php foreach ($semester_options as $value => $label): ?>
                                <option value="<?= html_escape($value); ?>"><?= html_escape($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Hapus Semua Nilai</button>
                    <a href="<?= site_url('sistem-nilai/penilaian/daftar-nilai'); ?>" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</main>
