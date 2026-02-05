<div class="modal fade" id="statusModal<?= $surat->id ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="post" action="<?= site_url('suratmasuk/change_status/'.$surat->id); ?>">
                <div class="modal-header bg-primary text-white">
                    <h5>Ubah Status</h5>
                </div>

                <div class="modal-body">
                    <div class="container">
                        <div class="alert alert-warning small mb-0">
                                <i class="bi bi-exclamation-triangle"></i>
                                Mengarsipkan surat akan menyimpan salinan ke tabel arsip.
                        </div>
                        <div class="mt-3">
                        <select name="status" class="form-select">
                            <option value="aktif" <?= $surat->status=='aktif'?'selected':'' ?>>Aktif</option>
                            <option value="diarsipkan" <?= $surat->status=='diarsipkan'?'selected':'' ?>>Diarsipkan</option>
                        </select>
                        </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>
