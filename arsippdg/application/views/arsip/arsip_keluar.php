<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<section class="dashboard-content">
<div class="container">

    <div class="mb-4">
        <h2 class="section-title">
            <i class="bi bi-archive-fill"></i> <?= $subtitle ?>
        </h2>
        <p class="text-muted">Daftar arsip surat keluar yang telah diarsipkan</p>
    </div>

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
                <a href="<?= site_url('arsip/keluar'); ?>" class="btn btn-outline-secondary w-100">
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
                         <th>Tanggal Diarsipkan</th>
                         <th class="text-center">Aksi</th>
                     </tr>
                 </thead>
                 <tbody>
     
                 <?php if (!empty($page_object)): foreach ($page_object as $arsip): ?>
                     <tr>
                         <td><span class="badge bg-secondary">Keluar</span></td>
                         <td><strong><?= $arsip->nomor_surat ?></strong></td>
                         <td><?= date('d M Y', strtotime($arsip->tanggal_surat)) ?></td>
                         <td><?= $arsip->pihak ?></td>
                         <td><?= $arsip->perihal ?></td>
                         <td><?= date('d M Y H:i', strtotime($arsip->tanggal_diarsipkan)) ?></td>
     
                         <td class="text-center">
                             <a href="<?= site_url('arsip/detail/'.$arsip->id); ?>" class="btn btn-sm btn-outline-primary">
                                 <i class="bi bi-eye"></i>
                             </a>
                             <button class="btn btn-sm btn-outline-warning"
                                     data-bs-toggle="modal"
                                     data-bs-target="#kembalikanModal<?= $arsip->id ?>">
                                 <i class="bi bi-arrow-counterclockwise"></i>
                             </button>
                             <button class="btn btn-sm btn-outline-danger"
                                     data-bs-toggle="modal"
                                     data-bs-target="#hapusModal<?= $arsip->id ?>">
                                 <i class="bi bi-trash"></i>
                             </button>
                         </td>
                     </tr>
     
                     <!-- MODAL KEMBALIKAN -->
                     <div class="modal fade" id="kembalikanModal<?= $arsip->id ?>" tabindex="-1">
                         <div class="modal-dialog modal-dialog-centered">
                             <div class="modal-content">
                                 <div class="modal-header bg-warning">
                                     <h5 class="modal-title">Konfirmasi Kembalikan ke Aktif</h5>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                 </div>
                                 <form method="post" action="<?= site_url('arsip/kembalikan/'.$arsip->id); ?>">
                                     <div class="modal-body">
                                         <p class="mb-2">
                                             Apakah Anda yakin ingin mengembalikan surat
                                             <strong><?= $arsip->nomor_surat ?></strong>
                                             ke <strong>status aktif</strong>?
                                         </p>
                                         <div class="alert alert-warning small">
                                             <i class="bi bi-info-circle"></i>
                                             Data arsip tidak akan hilang. Silakan hapus file arsip jika sudah tidak diperlukan.
                                         </div>
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                         <button type="submit" class="btn btn-warning">Ya, Kembalikan</button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
     
                     <!-- MODAL HAPUS -->
                     <div class="modal fade" id="hapusModal<?= $arsip->id ?>" tabindex="-1">
                         <div class="modal-dialog modal-dialog-centered">
                             <div class="modal-content">
                                 <div class="modal-header bg-danger text-white">
                                     <h5 class="modal-title">Konfirmasi Hapus</h5>
                                 </div>
                                 <div class="modal-body">
                                     Apakah Anda yakin ingin menghapus arsip nomor <strong><?= $arsip->nomor_surat ?></strong>?
                                     <div class="alert alert-warning small">
                                         <i class="bi bi-exclamation-triangle"></i>
                                         File arsip juga akan dihapus dari Google Drive.
                                     </div>
                                 </div>
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                     <a href="<?= site_url('arsip/delete/'.$arsip->id); ?>" class="btn btn-danger">Hapus</a>
                                 </div>
                             </div>
                         </div>
                     </div>
     
                 <?php endforeach; else: ?>
                     <tr>
                         <td colspan="7" class="text-center text-muted py-4">Tidak ada data arsip keluar</td>
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
