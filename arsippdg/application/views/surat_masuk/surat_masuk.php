<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<section class="dashboard-content">
<div class="container">

    <div class="mb-4">
        <h2 class="section-title">
            <i class="bi bi-inbox"></i> <?= $subtitle ?>
        </h2>
        <p class="text-muted">Daftar surat masuk yang diterima</p>
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
        <button class="btn btn-secondary" formaction="<?= site_url('suratmasuk/export'); ?>">
            <i class="bi bi-download"></i> Export
        </button>
    </form>

    <!-- FILTER -->
    <form method="get" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control"
                       placeholder="Cari nomor / asal / perihal"
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
                <a href="<?= site_url('suratmasuk'); ?>" class="btn btn-outline-secondary w-100">
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
                         <th>Pengirim</th>
                         <th>Perihal</th>
                         <th>Status</th>
                         <th class="text-center">Aksi</th>
                     </tr>
                 </thead>
                 <tbody>
     
                 <?php if (!empty($page_object)): foreach ($page_object as $surat): ?>
                     <tr>
                         <td><span class="badge bg-primary">Masuk</span></td>
                         <td><strong><?= $surat->nomor_surat ?></strong></td>
                         <td><?= date('d M Y', strtotime($surat->tanggal_surat)) ?></td>
                         <td><?= $surat->asal_surat ?></td>
                         <td><?= $surat->perihal ?></td>
                         <td>
                             <button class="btn btn-sm <?= $surat->status=='aktif'?'btn-success':'btn-secondary' ?>"
                                     data-bs-toggle="modal"
                                     data-bs-target="#statusModal<?= $surat->id ?>">
                                 <?= ucfirst($surat->status) ?>
                             </button>
                         </td>
     
                         <td class="text-center">
                             <a href="<?= site_url('suratmasuk/update/'.$surat->id); ?>" class="btn btn-sm btn-outline-success">
                                 <i class="bi bi-pencil"></i>
                             </a>
                             <a href="<?= site_url('suratmasuk/detail/'.$surat->id); ?>" class="btn btn-sm btn-outline-primary">
                                 <i class="bi bi-eye"></i>
                             </a>
                             <button class="btn btn-sm btn-outline-danger"
                                     data-bs-toggle="modal"
                                     data-bs-target="#hapusModal<?= $surat->id ?>">
                                 <i class="bi bi-trash"></i>
                             </button>
                         </td>
                     </tr>
     
                     <?php
                         $data['surat'] = $surat;
                         $this->load->view('surat_masuk/modal_ubah_status', $data);
                         $this->load->view('surat_masuk/konfirmasi_hapus', $data);
                     ?>
     
                 <?php endforeach; else: ?>
                     <tr>
                         <td colspan="7" class="text-center text-muted">
                             Tidak ada data ditemukan
                         </td>
                     </tr>
                 <?php endif; ?>
     
                 </tbody>
             </table>
         </div>
     </div>

</div>
</section>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>