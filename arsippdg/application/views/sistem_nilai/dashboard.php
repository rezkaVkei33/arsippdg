<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-mortarboard text-success"></i> Dashboard Sistem Nilai</h1>
            <p class="text-muted mb-0">Ringkasan data akademik yang tersedia di sistem.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success-subtle text-success p-3"><i class="bi bi-people fs-3"></i></div>
                    <div><div class="text-muted small">Total Mahasiswa</div><div class="h2 mb-0"><?= number_format($summary->total_mahasiswa, 0, ',', '.'); ?></div></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary-subtle text-primary p-3"><i class="bi bi-diagram-3 fs-3"></i></div>
                    <div><div class="text-muted small">Total Program Studi</div><div class="h2 mb-0"><?= number_format($summary->total_program_studi, 0, ',', '.'); ?></div></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning-subtle text-warning-emphasis p-3"><i class="bi bi-book fs-3"></i></div>
                    <div><div class="text-muted small">Total Mata Kuliah</div><div class="h2 mb-0"><?= number_format($summary->total_mata_kuliah, 0, ',', '.'); ?></div></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger-subtle text-danger p-3"><i class="bi bi-clipboard-x fs-3"></i></div>
                    <div><div class="text-muted small">Mahasiswa Belum Dinilai</div><div class="h2 mb-0"><?= number_format($summary->mahasiswa_belum_dinilai, 0, ',', '.'); ?></div><div class="small text-muted">Tahun akademik aktif</div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4"><h2 class="h5 mb-0"><i class="bi bi-people-fill text-success"></i> Mahasiswa per Program Studi</h2></div>
                <div class="card-body px-4 pb-4">
                    <?php if (empty($mahasiswa_per_prodi)): ?>
                        <p class="text-muted mb-0">Data program studi belum tersedia.</p>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($mahasiswa_per_prodi as $item): ?>
                                <div class="col-sm-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="small text-muted"><?= html_escape($item->kode_prodi ?: 'Program Studi'); ?></div>
                                        <div class="fw-semibold"><?= html_escape($item->nama_prodi); ?></div>
                                        <div class="fs-4 text-success mt-2"><?= number_format((int) $item->total_mahasiswa, 0, ',', '.'); ?> <span class="fs-6 text-muted">mahasiswa</span></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4"><h2 class="h5 mb-0"><i class="bi bi-calendar-check text-success"></i> Tahun Akademik Aktif</h2></div>
                <div class="card-body px-4 pb-4">
                    <?php if (empty($tahun_akademik_aktif)): ?>
                        <div class="text-muted">Belum ada tahun akademik yang berstatus aktif.</div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($tahun_akademik_aktif as $item): ?>
                                <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <span><?= html_escape($item->tahun . ' / ' . $item->semester); ?></span>
                                    <span class="badge bg-success">Aktif</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
