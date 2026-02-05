<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<section class="dashboard-content">
    <div class="container">

        <!-- HEADER -->
        <div class="mb-4">
            <h2 class="section-title">
                <i class="bi bi-box-seam"></i>
                <?= $subtitle ?>
            </h2>
            <p class="text-muted">
                Detail surat keluar dan arsip digital
            </p>
        </div>

        <div class="row g-4">

            <!-- INFORMASI SURAT -->
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Informasi Surat Keluar</h6>
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
                                <th>Pihak Tujuan</th>
                                <td><?= $surat->pihak ?></td>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <td><?= $surat->perihal ?></td>
                            </tr>
                            <tr>
                                <th>Ringkasan</th>
                                <td><?= $surat->ringkasan ?? '-' ?></td>
                            </tr>
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
                            <tr>
                                <th>Dicatat Pada</th>
                                <td><?= date('d M Y H:i', strtotime($surat->created_at)) ?></td>
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
                            Buka di Drive
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <?php if ($surat->drive_mime_type == 'application/pdf'): ?>
                            <iframe
                                src="https://drive.google.com/file/d/<?= $surat->drive_file_id ?>/preview"
                                width="100%" height="500"
                                style="border:0;">
                            </iframe>
                        <?php else: ?>
                            <div class="p-4 text-center text-muted">
                                File tidak dapat dipratinjau
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- CATATAN / DISPOSISI -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Catatan / Disposisi</h6>
                    </div>
                    <div class="card-body">

                        <ul class="list-group mb-3">
                            <?php 
                            // Tampilkan catatan jika ada
                            if (isset($catatan) && !empty($catatan)): 
                                foreach ($catatan as $c):
                            ?>
                                <li class="list-group-item">
                                    <?= $c->isi_catatan ?? $c->isi_disposisi ?>
                                    <div class="text-muted small">
                                        <?= date('d M Y H:i', strtotime($c->created_at)) ?>
                                    </div>
                                </li>
                            <?php 
                                endforeach;
                            else: 
                            ?>
                                <li class="list-group-item text-muted">
                                    Belum ada catatan
                                </li>
                            <?php endif; ?>
                        </ul>

                        <form method="post" action="<?= site_url('catatan/add'); ?>">
                            <input type="hidden" name="surat_keluar_id" value="<?= $surat->id ?>">
                            <div class="mb-3">
                                <textarea name="isi_catatan" class="form-control" rows="3" placeholder="Tambah catatan..." required></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-plus"></i> Tambah Catatan
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- AKSI -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="<?= site_url('suratkeluar') ?>"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <div>
                <?php if ($surat->status != 'diarsipkan'): ?>
                    <button class="btn btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#statusModal<?= $surat->id ?>">
                        <i class="bi bi-archive"></i> Arsipkan Surat
                    </button>
                <?php endif; ?>
                
                <a href="<?= site_url('suratkeluar/update/'.$surat->id) ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                
                <button class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#hapusModal<?= $surat->id ?>">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        </div>

    </div>
</section>

<!-- MODAL UBAH STATUS -->
<div class="modal fade" id="statusModal<?= $surat->id ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">UBAH STATUS SURAT</h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <form method="post"
                  action="<?= site_url('suratkeluar/change_status/'.$surat->id) ?>">

                <div class="modal-body">
                    <p>
                        Nomor Surat:
                        <strong><?= $surat->nomor_surat ?></strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif"
                                <?= $surat->status == 'aktif' ? 'selected' : '' ?>>
                                Aktif
                            </option>
                            <option value="diarsipkan"
                                <?= $surat->status == 'diarsipkan' ? 'selected' : '' ?>>
                                Diarsipkan
                            </option>
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
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                            class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="hapusModal<?= $surat->id ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Batal
        </button>
        <a href="<?= site_url('suratkeluar/delete/'.$surat->id) ?>" class="btn btn-danger">
          Ya, Hapus
        </a>
      </div>

    </div>
  </div>
</div>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
