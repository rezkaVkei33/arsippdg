<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-sliders text-success"></i> <?= html_escape($page_title); ?></h1>
            <p class="text-muted mb-0">Isi formulir untuk menambah atau mengubah data grade.</p>
        </div>
        <a href="<?= site_url('sistem-nilai/pengaturan/grade'); ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="post" action="<?= $grade_id ? site_url('sistem-nilai/pengaturan/grade/update/' . (int) $grade_id) : site_url('sistem-nilai/pengaturan/grade/simpan'); ?>">

                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode Grade <span class="text-danger">*</span></label>
                            <input type="text" id="kode" name="kode" class="form-control <?= form_error('kode') ? 'is-invalid' : ''; ?>" value="<?= html_escape($kode); ?>" placeholder="Contoh: A, B, C, D, E" maxlength="10">
                            <small class="text-muted">Huruf besar saja (A-Z)</small>
                            <?php if (form_error('kode')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('kode'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nilai_min" class="form-label">Nilai Minimum <span class="text-danger">*</span></label>
                                    <input type="number" id="nilai_min" name="nilai_min" step="0.01" class="form-control <?= form_error('nilai_min') ? 'is-invalid' : ''; ?>" value="<?= html_escape((string) $nilai_min); ?>" placeholder="0.00">
                                    <?php if (form_error('nilai_min')): ?>
                                        <div class="invalid-feedback d-block"><?= form_error('nilai_min'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nilai_max" class="form-label">Nilai Maximum <span class="text-danger">*</span></label>
                                    <input type="number" id="nilai_max" name="nilai_max" step="0.01" class="form-control <?= form_error('nilai_max') ? 'is-invalid' : ''; ?>" value="<?= html_escape((string) $nilai_max); ?>" placeholder="100.00">
                                    <?php if (form_error('nilai_max')): ?>
                                        <div class="invalid-feedback d-block"><?= form_error('nilai_max'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bobot" class="form-label">Bobot <span class="text-danger">*</span></label>
                            <input type="number" id="bobot" name="bobot" step="0.01" class="form-control <?= form_error('bobot') ? 'is-invalid' : ''; ?>" value="<?= html_escape((string) $bobot); ?>" placeholder="0.00">
                            <small class="text-muted">Nilai bobot untuk perhitungan IP. Contoh: 4.00, 3.00, 2.00, 1.00, 0.00</small>
                            <?php if (form_error('bobot')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('bobot'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control <?= form_error('keterangan') ? 'is-invalid' : ''; ?>" value="<?= html_escape($keterangan); ?>" placeholder="Contoh: Sangat Baik, Baik, Cukup, Kurang, Tidak Lulus">
                            <?php if (form_error('keterangan')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('keterangan'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Simpan</button>
                            <a href="<?= site_url('sistem-nilai/pengaturan/grade'); ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-info-circle"></i> Informasi</h6>
                    <hr>
                    <p class="mb-2"><small><strong>Kode Grade:</strong> Identitas unik grade (A, B, C, dll)</small></p>
                    <p class="mb-2"><small><strong>Nilai Min - Max:</strong> Range nilai untuk grade ini</small></p>
                    <p class="mb-2"><small><strong>Bobot:</strong> Nilai bobot untuk perhitungan IP (Indeks Prestasi)</small></p>
                    <p class="mb-0"><small><strong>Keterangan:</strong> Deskripsi grade (opsional)</small></p>
                </div>
            </div>
        </div>
    </div>
</main>
