<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<section class="dashboard-content">
    <div class="container">

        <!-- HEADER -->
        <div class="mb-4">
            <h2 class="section-title">
                <?php if ($jenis_surat === 'masuk'): ?>
                    <i class="bi bi-inbox"></i>
                <?php elseif ($jenis_surat === 'keluar'): ?>
                    <i class="bi bi-box-seam"></i>
                <?php else: ?>
                    <i class="bi bi-archive-fill"></i>
                <?php endif; ?>
                <?= $subtitle ?>
            </h2>
            <p class="text-muted">
                Detail surat <?= ucfirst($jenis_surat) ?> dan arsip digital
            </p>
        </div>

        <div class="row g-4">

            <!-- INFORMASI SURAT -->
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header <?php 
                        if ($jenis_surat === 'masuk') echo 'bg-primary';
                        elseif ($jenis_surat === 'keluar') echo 'bg-secondary';
                        else echo 'bg-warning text-dark';
                    ?> text-white">
                        <h6 class="mb-0">Informasi Surat <?= ucfirst($jenis_surat) ?></h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0 small">
                            <tr>
                                <th width="40%">Nomor Surat</th>
                                <td><?= $surat->nomor_surat ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Surat</th>
                                <td><?= date('d M Y', strtotime($surat->tanggal_surat)) ?></td>
                            </tr>
                            <tr>
                                <th>
                                    <?php if ($jenis_surat === 'masuk'): ?>
                                        Asal Surat
                                    <?php else: ?>
                                        Pihak Tujuan
                                    <?php endif; ?>
                                </th>
                                <td>
                                    <?php if ($jenis_surat === 'masuk'): ?>
                                        <?= $surat->asal_surat ?? $surat->pihak ?>
                                    <?php else: ?>
                                        <?= $surat->pihak ?? $surat->asal_surat ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <td><?= $surat->perihal ?></td>
                            </tr>
                            <tr>
                                <th>Ringkasan</th>
                                <td><?= $surat->ringkasan ?? '-' ?></td>
                            </tr>
                            <?php if ($jenis_surat !== 'arsip' && isset($surat->status)): ?>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($surat->status == 'aktif'): ?>
                                        <button class="btn btn-sm btn-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#statusModal<?= $surat->id ?>">
                                            Aktif
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#statusModal<?= $surat->id ?>">
                                            Diarsipkan
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th><?= $jenis_surat === 'arsip' ? 'Diarsipkan Pada' : 'Dicatat Pada' ?></th>
                                <td><?= date('d M Y H:i', strtotime($jenis_surat === 'arsip' ? $surat->tanggal_diarsipkan : $surat->created_at)) ?></td>
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
                        <a href="<?= $surat->drive_file_url ?>" target="_blank"
                           class="btn btn-sm btn-light">
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                    <div class="card-body text-center p-0" style="min-height: 500px;">
                        <?php if ($surat->drive_mime_type === 'application/pdf'): ?>
                            <iframe src="<?= $surat->drive_file_url ?>"
                                    style="width: 100%; height: 500px; border: none;"></iframe>
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center"
                                 style="height: 500px; background: #f8f9fa;">
                                <div class="text-center">
                                    <i class="bi bi-file-earmark-text"
                                       style="font-size: 4rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">
                                        File: <?= pathinfo($surat->drive_file_name ?? 'file', PATHINFO_EXTENSION) ?>
                                    </p>
                                    <a href="<?= $surat->drive_file_url ?>"
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

        <!-- CATATAN SECTION (Hanya untuk surat aktif) -->
        <?php if ($jenis_surat !== 'arsip' && isset($catatan)): ?>
        <div class="row g-4 mt-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-chat-left-text"></i> Catatan</span>
                        <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalCatatan">
                            <i class="bi bi-plus"></i> Tambah Catatan
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if ($catatan): ?>
                            <div class="timeline">
                                <?php foreach ($catatan as $c): ?>
                                    <div class="timeline-item mb-3 pb-3 border-bottom">
                                        <strong><?= $c->user_name ?? 'System' ?></strong>
                                        <small class="text-muted d-block">
                                            <?= date('d M Y H:i', strtotime($c->created_at)) ?>
                                        </small>
                                        <p class="mb-0 mt-2"><?= nl2br($c->catatan ?? $c->isi_catatan) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center mb-0">Belum ada catatan</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- ACTION BUTTONS -->
        <div class="row g-4 mt-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between">
                    <a href="<?php 
                        if ($jenis_surat === 'masuk') {
                            echo site_url('suratmasuk');
                        } elseif ($jenis_surat === 'keluar') {
                            echo site_url('suratkeluar');
                        } else {
                            echo site_url('arsip/masuk');
                        }
                    ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <div>
                        <button class="btn btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#hapusModal<?= $surat->id ?>">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL UBAH STATUS -->
<?php if ($jenis_surat !== 'arsip'): ?>
<div class="modal fade" id="statusModal<?= $surat->id ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Ubah Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?php 
                if ($jenis_surat === 'masuk') {
                    echo site_url('suratmasuk/change_status/'.$surat->id);
                } elseif ($jenis_surat === 'keluar') {
                    echo site_url('suratkeluar/change_status/'.$surat->id);
                }
            ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif" <?= $surat->status === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="diarsipkan" <?= $surat->status === 'diarsipkan' ? 'selected' : '' ?>>Diarsipkan</option>
                        </select>
                    </div>
                    <?php if ($surat->status != 'diarsipkan'): ?>
                        <div class="alert alert-warning small mb-0">
                            <i class="bi bi-exclamation-triangle"></i>
                            Mengarsipkan surat akan menyimpan salinan ke tabel arsip.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- MODAL TAMBAH CATATAN -->
<?php if ($jenis_surat !== 'arsip' && isset($catatan)): ?>
<div class="modal fade" id="modalCatatan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Catatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?php 
                if ($jenis_surat === 'masuk') {
                    echo site_url('catatan/add');
                } elseif ($jenis_surat === 'keluar') {
                    echo site_url('catatan/add');
                }
            ?>">
                <input type="hidden" name="surat_masuk_id" value="<?= $jenis_surat === 'masuk' ? $surat->id : '' ?>">
                <input type="hidden" name="surat_keluar_id" value="<?= $jenis_surat === 'keluar' ? $surat->id : '' ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="isi_catatan" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- MODAL HAPUS -->
<div class="modal fade" id="hapusModal<?= $surat->id ?>" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-gradient text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin menghapus data <strong><?= $surat->nomor_surat ?></strong> ini?
                </p>
                <div class="alert alert-warning small mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    File di Google Drive juga akan dihapus secara permanen.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?php 
                    if ($jenis_surat === 'masuk') {
                        echo site_url('suratmasuk/delete/'.$surat->id);
                    } elseif ($jenis_surat === 'keluar') {
                        echo site_url('suratkeluar/delete/'.$surat->id);
                    } else {
                        echo site_url('arsip/delete/'.$surat->id);
                    }
                ?>" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
