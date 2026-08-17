<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-pen text-success"></i> <?= html_escape($page_title); ?></h1>
            <p class="text-muted mb-0">Isi formulir untuk menambah atau mengubah data tanda tangan pejabat.</p>
        </div>
        <a href="<?= site_url('sistem-nilai/pengaturan/tanda-tangan'); ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="post" action="<?= $pejabat_id ? site_url('sistem-nilai/pengaturan/tanda-tangan/update/' . (int) $pejabat_id) : site_url('sistem-nilai/pengaturan/tanda-tangan/simpan'); ?>" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="nama_pejabat" class="form-label">Nama Pejabat <span class="text-danger">*</span></label>
                            <input type="text" id="nama_pejabat" name="nama_pejabat" class="form-control <?= form_error('nama_pejabat') ? 'is-invalid' : ''; ?>" value="<?= html_escape($nama_pejabat); ?>" placeholder="Contoh: Frasetyo Angga Saputra, S.E., M.Ak.">
                            <?php if (form_error('nama_pejabat')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('nama_pejabat'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control <?= form_error('jabatan') ? 'is-invalid' : ''; ?>" value="<?= html_escape($jabatan); ?>" placeholder="Contoh: Direktur">
                            <?php if (form_error('jabatan')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('jabatan'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="nomor_induk" class="form-label">Nomor Induk</label>
                            <input type="text" id="nomor_induk" name="nomor_induk" class="form-control <?= form_error('nomor_induk') ? 'is-invalid' : ''; ?>" value="<?= html_escape($nomor_induk); ?>" placeholder="NUPTK atau NIP">
                            <?php if (form_error('nomor_induk')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('nomor_induk'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_ttd" class="form-label">Tanggal Tanda Tangan <span class="text-danger">*</span></label>
                            <input type="date" id="tanggal_ttd" name="tanggal_ttd" class="form-control <?= form_error('tanggal_ttd') ? 'is-invalid' : ''; ?>" value="<?= html_escape($tanggal_ttd); ?>">
                            <?php if (form_error('tanggal_ttd')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('tanggal_ttd'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="ttd_file" class="form-label">File Tanda Tangan (JPG/PNG) <span class="text-danger"><?= !$pejabat_id ? '*' : ''; ?></span></label>
                            <input type="file" id="ttd_file" name="ttd_file" class="form-control <?= form_error('ttd_file') ? 'is-invalid' : ''; ?>" accept="image/*">
                            <small class="text-muted">Ukuran maksimal 5MB. Format: JPG, JPEG, PNG, GIF</small>
                            <?php if (!empty($ttd_path)): ?>
                                <div class="mt-2">
                                    <p class="mb-2"><small class="text-muted">File saat ini:</small></p>
                                    <img src="<?= base_url('assets/' . $ttd_path); ?>" alt="Tanda Tangan" style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                </div>
                            <?php endif; ?>
                            <?php if (form_error('ttd_file')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('ttd_file'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="cap_file" class="form-label">File Cap (JPG/PNG)</label>
                            <input type="file" id="cap_file" name="cap_file" class="form-control <?= form_error('cap_file') ? 'is-invalid' : ''; ?>" accept="image/*">
                            <small class="text-muted">Ukuran maksimal 5MB. Format: JPG, JPEG, PNG, GIF. Opsional.</small>
                            <?php if (!empty($cap_path)): ?>
                                <div class="mt-2">
                                    <p class="mb-2"><small class="text-muted">File saat ini:</small></p>
                                    <img src="<?= base_url('assets/' . $cap_path); ?>" alt="Cap" style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                </div>
                            <?php endif; ?>
                            <?php if (form_error('cap_file')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('cap_file'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select <?= form_error('status') ? 'is-invalid' : ''; ?>">
                                <option value="1" <?= $status === 1 ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?= $status === 0 ? 'selected' : ''; ?>>Nonaktif</option>
                            </select>
                            <small class="text-muted">Status aktif berarti tanda tangan akan digunakan pada dokumen PDF.</small>
                            <?php if (form_error('status')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('status'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Simpan</button>
                            <a href="<?= site_url('sistem-nilai/pengaturan/tanda-tangan'); ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
