<main class="container py-4" style="max-width: 820px;">
    <div class="mb-4"><h1 class="h3 mb-1"><i class="bi bi-file-earmark-excel text-success"></i> Upload Data Mahasiswa</h1><p class="text-muted mb-0">Form persiapan impor data mahasiswa dari file Excel.</p></div>
    <div class="alert alert-info"><i class="bi bi-info-circle"></i> Form ini hanya tampilan. Proses validasi dan impor Excel belum diaktifkan.</div>
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <form id="uploadMahasiswaForm" enctype="multipart/form-data" onsubmit="return false;">
            <div class="mb-4"><label for="file_excel" class="form-label">File Excel</label><input id="file_excel" name="file_excel" type="file" class="form-control" accept=".xlsx,.xls"><div class="form-text">Format yang direncanakan: .xlsx atau .xls.</div></div>
            <div class="mb-4"><h2 class="h6">Format kolom Excel</h2><div class="table-responsive"><table class="table table-sm table-bordered mb-0"><thead class="table-light"><tr><th>Kolom</th><th>Keterangan</th><th>Wajib</th></tr></thead><tbody><tr><td>nim</td><td>NIM mahasiswa, harus unik</td><td>Ya</td></tr><tr><td>nama</td><td>Nama lengkap mahasiswa</td><td>Ya</td></tr><tr><td>jenis_kelamin</td><td><code>L</code> atau <code>P</code></td><td>Tidak</td></tr><tr><td>kode_prodi</td><td>Kode program studi yang telah terdaftar</td><td>Tidak</td></tr><tr><td>angkatan</td><td>Tahun empat digit, contoh <code>2026</code></td><td>Tidak</td></tr><tr><td>status</td><td>Aktif, Cuti, Lulus, Nonaktif, atau Drop Out</td><td>Ya</td></tr></tbody></table></div></div>
            <button type="button" class="btn btn-success" disabled><i class="bi bi-upload"></i> Import Excel (belum aktif)</button><a href="<?= site_url('sistem-nilai/master-data/mahasiswa'); ?>" class="btn btn-outline-secondary">Kembali</a>
        </form>
    </div></div>
</main>
