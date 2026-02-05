<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<section class="dashboard-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-header bg-info bg-gradient text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-box-seam"></i>
                            <?= $subtitle ?>
                        </h5>
                    </div>

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="<?= isset($surat) ? site_url('suratkeluar/update/' . $surat->id) : site_url('suratkeluar/create') ?>">

                            <div class="mb-3">
                                <label class="form-label">Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control"
                                    value="<?= $surat->nomor_surat ?? '' ?>" placeholder="Nomor Surat" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pihak Tujuan</label>
                                <input type="text" name="pihak" class="form-control"
                                    value="<?= $surat->pihak ?? '' ?>" placeholder="Pihak Tujuan" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control"
                                    value="<?= $surat->tanggal_surat ?? '' ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Perihal</label>
                                <input type="text" name="perihal" class="form-control"
                                    value="<?= $surat->perihal ?? '' ?>" placeholder="Perihal" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ringkasan</label>
                                <textarea name="ringkasan" class="form-control" rows="4" placeholder="Ringkasan"><?= $surat->ringkasan ?? '' ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload File Surat</label>
                                <input type="file" name="file_surat" class="form-control" accept="application/pdf" <?= isset($surat) ? '' : 'required' ?>>
                                <small class="text-muted d-block mt-2">
                                    Format PDF
                                    <?php if (isset($surat)): ?>
                                        - Kosongkan jika tidak ingin mengganti file surat
                                    <?php else: ?>
                                        - Max. 5MB
                                    <?php endif; ?>
                                </small>
                            </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('suratkeluar'); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button class="btn btn-primary">
                                <i class="bi bi-upload"></i> Simpan
                            </button>
                        </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
