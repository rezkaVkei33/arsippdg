<main class="container py-4" style="max-width: 720px;">
    <div class="mb-4">
        <h1 class="h3 mb-1"><i class="bi bi-pencil-square text-success"></i> Ubah Nilai</h1>
        <p class="text-muted mb-0">Perbarui data nilai mahasiswa.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <?= form_open('sistem-nilai/penilaian/perbarui/' . $nilai->id); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">NIM</label>
                        <input type="text" class="form-control" value="<?= html_escape($mahasiswa->nim ?? ''); ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" value="<?= html_escape($mahasiswa->nama ?? ''); ?>" disabled>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Mata Kuliah</label>
                        <input type="text" class="form-control" value="<?= html_escape(($penawaran->kode_mk ?? '') . ' - ' . ($penawaran->nama_mk ?? '')); ?>" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="nilai_angka" class="form-label">Nilai Angka</label>
                        <input id="nilai_angka" name="nilai_angka" type="number" step="0.01" min="0" max="100" class="form-control <?= form_error('nilai_angka') ? 'is-invalid' : ''; ?>" value="<?= html_escape(set_value('nilai_angka', $nilai->nilai_angka ?? '')); ?>" placeholder="Kosongkan jika tidak ada">
                        <div class="invalid-feedback"><?= form_error('nilai_angka'); ?></div>
                    </div>
                    <div class="col-md-4">
                        <label for="nilai_huruf" class="form-label">Nilai Huruf</label>
                        <input id="nilai_huruf" name="nilai_huruf" maxlength="2" class="form-control <?= form_error('nilai_huruf') ? 'is-invalid' : ''; ?>" value="<?= html_escape(set_value('nilai_huruf', $nilai->nilai_huruf)); ?>">
                        <div class="invalid-feedback"><?= form_error('nilai_huruf'); ?></div>
                    </div>
                    <div class="col-md-4">
                        <label for="bobot" class="form-label">Bobot</label>
                        <input id="bobot" name="bobot" type="number" step="0.01" min="0" max="100" class="form-control <?= form_error('bobot') ? 'is-invalid' : ''; ?>" value="<?= html_escape(set_value('bobot', $nilai->bobot)); ?>">
                        <div class="invalid-feedback"><?= form_error('bobot'); ?></div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                    <a href="<?= site_url('sistem-nilai/penilaian/daftar-nilai'); ?>" class="btn btn-outline-secondary">Batal</a>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</main>
