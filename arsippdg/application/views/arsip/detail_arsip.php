<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<section class="dashboard-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-archive-fill"></i> Detail Arsip Surat</span>
                        <span class="badge bg-secondary">
                            <?= ucfirst($arsip->jenis_surat) ?>
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Nomor Surat</label>
                                <p class="fs-5"><strong><?= $arsip->nomor_surat ?></strong></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Tanggal Surat</label>
                                <p class="fs-5"><strong><?= date('d F Y', strtotime($arsip->tanggal_surat)) ?></strong></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">
                                    <?= $arsip->jenis_surat === 'masuk' ? 'Pengirim' : 'Pihak Tujuan' ?>
                                </label>
                                <p class="fs-5"><strong><?= $arsip->pihak ?></strong></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Perihal</label>
                                <p class="fs-5"><strong><?= $arsip->perihal ?></strong></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Ringkasan</label>
                            <p><?= nl2br($arsip->ringkasan) ?></p>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Tanggal Diarsipkan</label>
                                <p><?= date('d F Y H:i:s', strtotime($arsip->tanggal_diarsipkan)) ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Tipe File</label>
                                <p><?= $arsip->drive_mime_type ?></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">File Surat</label>
                            <div>
                                <a href="<?= $arsip->drive_file_url ?>" target="_blank" class="btn btn-outline-primary">
                                    <i class="bi bi-download"></i> Buka File
                                </a>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="<?= $arsip->jenis_surat === 'masuk' ? site_url('arsip/masuk') : site_url('arsip/keluar'); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <div>
                                <button class="btn btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#hapusModal">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL HAPUS -->
<div class="modal fade" id="hapusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus arsip nomor <strong><?= $arsip->nomor_surat ?></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= site_url('arsip/delete/'.$arsip->id); ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
