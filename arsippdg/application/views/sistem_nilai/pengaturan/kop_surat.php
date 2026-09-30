<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-image text-success"></i> Kop Surat</h1>
            <p class="text-muted mb-0">Kelola satu gambar kop yang akan ditampilkan di bagian atas PDF KHS.</p>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success" role="alert"><?= html_escape($this->session->flashdata('success')); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert"><?= html_escape($this->session->flashdata('error')); ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 mb-0"><?= $kop_surat ? 'Ubah Kop Surat' : 'Tambah Kop Surat'; ?></h2>
                </div>
                <div class="card-body">
                    <form method="post"
                          action="<?= $kop_surat ? site_url('sistem-nilai/pengaturan/kop-surat/update/' . (int) $kop_surat->id) : site_url('sistem-nilai/pengaturan/kop-surat/simpan'); ?>"
                          enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_kop" class="form-label">Nama Kop Surat <span class="text-danger">*</span></label>
                            <input type="text" id="nama_kop" name="nama_kop" maxlength="150" required class="form-control"
                                   value="<?= html_escape($kop_surat->nama_kop ?? ''); ?>" placeholder="Contoh: Kop Surat Resmi Politeknik Darma Ganesha">
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Kop Surat <?= $kop_surat ? '(opsional jika tidak diganti)' : '<span class="text-danger">*</span>'; ?></label>
                            <input type="file" id="gambar" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.gif" <?= $kop_surat ? '' : 'required'; ?>>
                            <div class="form-text">Format JPG, JPEG, PNG, atau GIF. Maksimal 5 MB. Gambar baru akan menggantikan gambar lama.</div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="1" <?= (int) ($kop_surat->status ?? 1) === 1 ? 'selected' : ''; ?>>Aktif — digunakan pada ekspor KHS</option>
                                <option value="0" <?= (int) ($kop_surat->status ?? 1) === 0 ? 'selected' : ''; ?>>Nonaktif</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> <?= $kop_surat ? 'Simpan Perubahan' : 'Simpan Kop Surat'; ?></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3"><h2 class="h5 mb-0">Pratinjau</h2></div>
                <div class="card-body">
                    <?php if ($kop_surat && !empty($kop_surat->gambar)): ?>
                        <img src="<?= base_url('assets/' . $kop_surat->gambar); ?>" alt="Pratinjau kop surat" class="img-fluid border rounded p-2 mb-3">
                        <dl class="row mb-3">
                            <dt class="col-sm-4">Nama</dt><dd class="col-sm-8"><?= html_escape($kop_surat->nama_kop); ?></dd>
                            <dt class="col-sm-4">Status</dt><dd class="col-sm-8"><span class="badge <?= (int) $kop_surat->status === 1 ? 'bg-success' : 'bg-secondary'; ?>"><?= (int) $kop_surat->status === 1 ? 'Aktif' : 'Nonaktif'; ?></span></dd>
                        </dl>
                        <form method="post" action="<?= site_url('sistem-nilai/pengaturan/kop-surat/hapus/' . (int) $kop_surat->id); ?>" class="delete-form" data-delete-confirm="Data kop surat dan file gambarnya akan dihapus.">
                            <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Hapus Kop Surat</button>
                        </form>
                    <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-image display-5 d-block mb-3"></i>
                            Belum ada gambar kop surat.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
