<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<section class="dashboard-content">
    <div class="container">

        <!-- HEADER -->
        <div class="mb-4">
            <h2 class="section-title">
                <i class="bi bi-archive-fill"></i> Detail Arsip Surat Keluar
            </h2>
            <p class="text-muted">
                Detail arsip surat keluar yang telah diarsipkan
            </p>
        </div>

        <div class="row g-4">

            <!-- INFORMASI ARSIP -->
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Informasi Arsip Surat Keluar</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0 small">
                            <tr>
                                <th width="40%">Nomor Surat</th>
                                <td><?= $arsip->nomor_surat ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Surat</th>
                                <td><?= date('d M Y', strtotime($arsip->tanggal_surat)) ?></td>
                            </tr>
                            <tr>
                                <th>Pihak Tujuan</th>
                                <td><?= $arsip->pihak ?></td>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <td><?= $arsip->perihal ?></td>
                            </tr>
                            <tr>
                                <th>Ringkasan</th>
                                <td><?= $arsip->ringkasan ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Diarsipkan Pada</th>
                                <td><?= date('d M Y H:i', strtotime($arsip->tanggal_diarsipkan)) ?></td>
                            </tr>
                            <tr>
                                <th>Tipe File</th>
                                <td><?= $arsip->drive_mime_type ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PREVIEW PDF -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span>Preview Dokumen</span>
                        <a href="<?= $arsip->drive_file_url ?>" target="_blank"
                           class="btn btn-sm btn-light">
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                    <div class="card-body text-center p-0" style="min-height: 500px;">
                        <?php if ($arsip->drive_mime_type === 'application/pdf'): ?>
                            <iframe src="<?= $arsip->drive_file_url ?>"
                                    style="width: 100%; height: 500px; border: none;"></iframe>
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center"
                                 style="height: 500px; background: #f8f9fa;">
                                <div class="text-center">
                                    <i class="bi bi-file-earmark-text"
                                       style="font-size: 4rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">
                                        File: <?= pathinfo($arsip->drive_file_name ?? 'file', PATHINFO_EXTENSION) ?>
                                    </p>
                                    <a href="<?= $arsip->drive_file_url ?>"
                                       target="_blank"
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Buka File
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- ACTION BUTTONS -->
        <div class="row g-4 mt-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between">
                    <a href="<?= site_url('arsip/keluar') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <div>
                        <button class="btn btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#hapusModal<?= $arsip->id ?>">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL HAPUS -->
<div class="modal fade" id="hapusModal<?= $arsip->id ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-gradient text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
            </div>
            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin menghapus arsip nomor <strong><?= $arsip->nomor_surat ?></strong> ini?
                </p>
                <div class="alert alert-warning small mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    File di Google Drive juga akan dihapus secara permanen.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= site_url('arsip/delete/'.$arsip->id) ?>" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
