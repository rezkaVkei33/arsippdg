<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<section class="dashboard-content">
<div class="container">

    <div class="mb-4">
        <h2 class="section-title">
            <i class="bi bi-box-seam"></i> <?= $subtitle ?>
        </h2>
        <p class="text-muted">Daftar surat keluar yang telah dikirim</p>
    </div>

    <!-- EXPORT -->
    <form method="get" class="d-flex gap-2 mb-3">
        <select name="format" class="form-select w-auto" required>
            <option value="">-- Pilih Format --</option>
            <option value="excel">Excel</option>
            <option value="pdf">PDF</option>
        </select>
        <input type="hidden" name="q" value="<?= $keyword ?? '' ?>">
        <input type="hidden" name="bulan" value="<?= $bulan ?? '' ?>">
        <button class="btn btn-secondary" formaction="<?= site_url('suratkeluar/export'); ?>">
            <i class="bi bi-download"></i> Export
        </button>
    </form>

    <!-- FILTER -->
    <form method="get" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control"
                       placeholder="Cari nomor / pihak / perihal"
                       value="<?= $keyword ?? '' ?>">
            </div>
            <div class="col-md-4">
                <input type="month" name="bulan" class="form-control"
                       value="<?= $bulan ?? '' ?>">
            </div>
        </div>

        <div class="row g-2 mt-2">
            <div class="col-md-2 offset-md-4">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="<?= site_url('suratkeluar'); ?>" class="btn btn-outline-secondary w-100">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <!-- TABLE -->
<div class="recent-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Pihak Tujuan</th>
                    <th>Perihal</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php if (!empty($page_object)): foreach ($page_object as $surat): ?>
                <tr>
                    <td><span class="badge bg-secondary">Keluar</span></td>
                    <td><strong><?= $surat->nomor_surat ?></strong></td>
                    <td><?= date('d M Y', strtotime($surat->tanggal_surat)) ?></td>
                    <td><?= $surat->pihak ?></td>
                    <td><?= $surat->perihal ?></td>
                    <td>
                        <button class="btn btn-sm <?= $surat->status=='aktif'?'btn-success':'btn-secondary' ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#statusModal<?= $surat->id ?>">
                            <?= ucfirst($surat->status) ?>
                        </button>
                    </td>

                    <td class="text-center">
                        <a href="<?= site_url('suratkeluar/update/'.$surat->id); ?>" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= site_url('suratkeluar/detail/'.$surat->id); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#hapusModal<?= $surat->id ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- MODAL UBAH STATUS -->
                <div class="modal fade" id="statusModal<?= $surat->id ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="<?= site_url('suratkeluar/change_status/'.$surat->id); ?>" method="post">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Ubah Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="alert alert-warning small mb-0">
                                                <i class="bi bi-exclamation-triangle"></i>
                                                Mengarsipkan surat akan menyimpan salinan ke tabel arsip.
                                        </div>
                                        <div class="mt-3">
                                            <select name="status" class="form-select" required>
                                                <option value="aktif" <?= $surat->status=='aktif'?'selected':'' ?>>Aktif</option>
                                                <option value="diarsipkan" <?= $surat->status=='diarsipkan'?'selected':'' ?>>Diarsipkan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- MODAL HAPUS -->
                <div class="modal fade" id="hapusModal<?= $surat->id ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Konfirmasi Hapus</h5>
            
                            </div>
                           <div class="modal-body">
                            Hapus surat <strong><?= $surat->nomor_surat ?></strong>?
                                <div class="alert alert-warning small">
                                   <i class="bi bi-exclamation-triangle"></i>
                                    File di Google Drive ikut terhapus
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <a href="<?= site_url('suratkeluar/delete/'.$surat->id); ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Tidak ada data surat keluar</td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

    <!-- PAGINATION -->
    <nav>
        <?= $this->pagination->create_links(); ?>
    </nav>

</div>
</section>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
