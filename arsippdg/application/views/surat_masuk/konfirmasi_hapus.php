<div class="modal fade" id="hapusModal<?= $surat->id ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5>Konfirmasi Hapus</h5>
            </div>

            <div class="modal-body">
                    Hapus surat <strong><?= $surat->nomor_surat ?></strong>?
                <div class="alert alert-warning small">
                  <i class="bi bi-exclamation-triangle"></i>
                    File di Google Drive ikut terhapus
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= site_url('suratmasuk/delete/'.$surat->id); ?>" class="btn btn-danger">
                Ya, Hapus
                </a>
        </div>

        </div>
    </div>
</div>
