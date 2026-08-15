<main class="container py-4" style="max-width: 820px;">
    <div class="mb-4"><h1 class="h3 mb-1"><i class="bi bi-file-earmark-excel text-success"></i> Upload Data Mahasiswa</h1><p class="text-muted mb-0">Form persiapan impor data mahasiswa dari file Excel.</p></div>
    <div class="alert alert-info"><i class="bi bi-info-circle"></i> Unduh template, lengkapi data, lalu unggah kembali file Excel tersebut.</div>
    <?php if ($this->session->flashdata('import_errors')): ?>
        <div class="alert alert-danger"><strong>Periksa data berikut:</strong><ul class="mb-0 mt-2"><?php foreach ($this->session->flashdata('import_errors') as $error): ?><li><?= html_escape($error); ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <?= form_open_multipart('sistem-nilai/master-data/mahasiswa/import', ['id' => 'uploadMahasiswaForm']); ?>
            <div class="mb-4">
                <label class="form-label d-block">1. Download Template</label>
                <a class="btn btn-outline-success" href="<?= site_url('sistem-nilai/master-data/mahasiswa/template'); ?>"><i class="bi bi-download"></i> Download Template</a>
                <div class="form-text">Gunakan template ini agar format kolom sesuai.</div>
            </div>
            <div class="mb-4">
                <label for="file_excel" class="form-label">2. Upload File</label>
                <input id="file_excel" name="file_excel" type="file" class="form-control" accept=".xlsx,.xls" required>
                <div class="form-text">Format file yang direncanakan: .xlsx atau .xls.</div>
            </div>
            <div class="mb-4">
                <label class="form-label">3. Keterangan</label>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light"><tr><th>Kolom</th><th>Keterangan</th><th>Wajib</th></tr></thead>
                        <tbody>
                            <tr><td>nim</td><td>NIM mahasiswa, harus unik</td><td>Ya</td></tr>
                            <tr><td>nama</td><td>Nama lengkap mahasiswa</td><td>Ya</td></tr>
                            <tr><td>jenis_kelamin</td><td><code>L</code> atau <code>P</code></td><td>Tidak</td></tr>
                            <tr><td>kode_prodi</td><td>Kode program studi yang telah terdaftar</td><td>Tidak</td></tr>
                            <tr><td>angkatan</td><td>Tahun empat digit, contoh <code>2026</code></td><td>Tidak</td></tr>
                            <tr><td>status</td><td>Aktif, Cuti, Lulus, Nonaktif, atau Drop Out</td><td>Ya</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-success"><i class="bi bi-upload"></i> Import Excel</button><a href="<?= site_url('sistem-nilai/master-data/mahasiswa'); ?>" class="btn btn-outline-secondary">Kembali</a>
        <?= form_close(); ?>
    </div></div>
</main>
