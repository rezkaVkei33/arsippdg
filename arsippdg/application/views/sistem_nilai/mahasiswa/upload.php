<main class="container py-4" style="max-width: 820px;">
    <div class="mb-4"><h1 class="h3 mb-1"><i class="bi bi-file-earmark-excel text-success"></i> Upload Data Mahasiswa</h1><p class="text-muted mb-0">Form persiapan impor data mahasiswa dari file Excel.</p></div>
    <div class="alert alert-info"><i class="bi bi-info-circle"></i> Form ini hanya tampilan. Proses validasi dan impor Excel belum diaktifkan.</div>
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <form id="uploadMahasiswaForm" enctype="multipart/form-data" onsubmit="return false;">
            <div class="mb-4">
                <label class="form-label d-block">1. Download Template</label>
                <button type="button" class="btn btn-outline-success" disabled><i class="bi bi-download"></i> Download Template</button>
                <div class="form-text">Template akan disediakan pada tahap berikutnya.</div>
            </div>
            <div class="mb-4">
                <label for="file_excel" class="form-label">2. Upload File</label>
                <input id="file_excel" name="file_excel" type="file" class="form-control" accept=".xlsx,.xls">
                <div class="form-text">Format file yang direncanakan: .xlsx atau .xls.</div>
            </div>
            <div class="mb-4">
                <label for="keterangan" class="form-label">3. Keterangan</label>
                <textarea id="keterangan" name="keterangan" class="form-control" rows="4" placeholder="Tambahkan keterangan upload bila diperlukan."></textarea>
            </div>
            <button type="button" class="btn btn-success" disabled><i class="bi bi-upload"></i> Import Excel (belum aktif)</button><a href="<?= site_url('sistem-nilai/master-data/mahasiswa'); ?>" class="btn btn-outline-secondary">Kembali</a>
        </form>
    </div></div>
</main>
