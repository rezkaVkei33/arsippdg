<main class="container py-4" style="max-width: 980px;">
    <div class="mb-4">
        <h1 class="h3 mb-1"><i class="bi bi-cloud-arrow-up text-success"></i> Upload Nilai</h1>
        <p class="text-muted mb-0">Upload nilai mahasiswa berdasarkan program studi, tahun akademik, semester, dan angkatan.</p>
    </div>

    <?php if ($this->session->flashdata('import_errors')): ?>
        <div class="alert alert-danger">
            <strong>Periksa data berikut:</strong>
            <ul class="mb-0 mt-2">
                <?php foreach ($this->session->flashdata('import_errors') as $error): ?>
                    <li><?= html_escape($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <?= form_open_multipart('sistem-nilai/penilaian/import-nilai', ['id' => 'uploadNilaiForm']); ?>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="program_studi_id" class="form-label">Program Studi</label>
                        <select name="program_studi_id" id="program_studi_id" class="form-select" required>
                            <option value="">Pilih Program Studi</option>
                            <?php foreach ($program_studi_options as $item): ?>
                                <option value="<?= (int) $item->id; ?>"><?= html_escape($item->nama_prodi); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_akademik_id" class="form-label">Tahun Akademik</label>
                        <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-select" required>
                            <option value="">Pilih Tahun Akademik</option>
                            <?php foreach ($tahun_akademik_options as $item): ?>
                                <option value="<?= (int) $item->id; ?>"><?= html_escape($item->tahun . ' / ' . $item->semester); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="semester" class="form-label">Semester</label>
                        <select name="semester" id="semester" class="form-select" required>
                            <option value="">Pilih Semester</option>
                            <?php foreach ($semester_options as $option): ?>
                                <option value="<?= $option === 'Ganjil' ? '1' : '2'; ?>"><?= html_escape($option); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="angkatan" class="form-label">Angkatan</label>
                        <select name="angkatan" id="angkatan" class="form-select" required>
                            <option value="">Pilih Angkatan</option>
                            <?php foreach ($angkatan_options as $item): ?>
                                <option value="<?= html_escape($item->angkatan); ?>"><?= html_escape($item->angkatan); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mata_kuliah_id" class="form-label">Mata Kuliah</label>
                        <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-select" required>
                            <option value="">Pilih Mata Kuliah</option>
                            <?php foreach ($mata_kuliah_options as $item): ?>
                                <option value="<?= (int) $item->id; ?>"><?= html_escape($item->kode_mk . ' - ' . $item->nama_mk); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Download Template</label>
                    <a class="btn btn-outline-success" href="<?= site_url('sistem-nilai/penilaian/download-template'); ?>" id="downloadTemplateBtn"><i class="bi bi-download"></i> Download Template</a>
                    <div class="form-text">Template akan dibuat berdasarkan program studi, tahun akademik, semester, dan angkatan yang dipilih.</div>
                </div>

                <div class="mb-4">
                    <label for="file_excel" class="form-label">Upload File Nilai</label>
                    <input id="file_excel" name="file_excel" type="file" class="form-control" accept=".xlsx,.xls" required>
                    <div class="form-text">File wajib berisi kolom: NIM, Nama Mahasiswa, Nilai Angka, Nilai Huruf, Bobot.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan Kolom</label>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr><th>Kolom</th><th>Keterangan</th><th>Wajib</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>nim</td><td>NIM mahasiswa sesuai filter</td><td>Ya</td></tr>
                                <tr><td>nama</td><td>Nama mahasiswa</td><td>Ya</td></tr>
                                <tr><td>nilai_angka</td><td>Nilai persentase 0 - 100</td><td>Ya</td></tr>
                                <tr><td>nilai_huruf</td><td>Nilai huruf, contoh A, B+, BC</td><td>Ya</td></tr>
                                <tr><td>bobot</td><td>Bobot nilai 0 - 100</td><td>Ya</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <button type="submit" class="btn btn-success"><i class="bi bi-upload"></i> Upload Nilai</button>
                <a href="<?= site_url('sistem-nilai'); ?>" class="btn btn-outline-secondary">Kembali</a>
            <?= form_close(); ?>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('uploadNilaiForm');
        const downloadBtn = document.getElementById('downloadTemplateBtn');
        const fields = ['program_studi_id', 'tahun_akademik_id', 'semester', 'angkatan'];

        function buildDownloadUrl() {
            const params = new URLSearchParams();
            for (const field of fields) {
                const value = document.getElementById(field)?.value || '';
                if (value) {
                    params.set(field === 'tahun_akademik_id' ? 'tahun_akademik' : field, value);
                }
            }
            const base = '<?= site_url('sistem-nilai/penilaian/download-template'); ?>';
            return params.toString() ? base + '?' + params.toString() : base;
        }

        for (const field of fields) {
            document.getElementById(field)?.addEventListener('change', function () {
                downloadBtn.href = buildDownloadUrl();
            });
        }

        form.addEventListener('submit', function (event) {
            const program_studi_id = document.getElementById('program_studi_id').value;
            const tahun_akademik_id = document.getElementById('tahun_akademik_id').value;
            const semester = document.getElementById('semester').value;
            const angkatan = document.getElementById('angkatan').value;
            const mata_kuliah_id = document.getElementById('mata_kuliah_id').value;

            if (!program_studi_id || !tahun_akademik_id || !semester || !angkatan || !mata_kuliah_id) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Semua filter harus dipilih sebelum upload nilai.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
