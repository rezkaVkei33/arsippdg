<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-file-earmark-text text-success"></i> <?= html_escape($page_title); ?></h1>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="get" action="<?= site_url('sistem-nilai/akademik/khs'); ?>" class="row g-2 align-items-end mb-4">
                <div class="col-md-5">
                    <label class="form-label">Tahun Akademik</label>
                    <select name="tahun_id" class="form-select">
                        <option value="">Semua Tahun Akademik</option>
                        <?php foreach ($tahun_akademik_options as $item): ?>
                            <option value="<?= (int) $item->id; ?>" <?= (string) $selected_tahun_id === (string) $item->id ? 'selected' : ''; ?>><?= html_escape($item->tahun . ' / ' . $item->semester); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        <option value="">Semua Semester</option>
                        <?php foreach ($semester_options as $value => $label): ?>
                            <option value="<?= html_escape((string) $value); ?>" <?= (string) $selected_semester === (string) $value ? 'selected' : ''; ?>><?= html_escape($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success"><i class="bi bi-search"></i> Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tahun Akademik</th>
                            <th>Semester</th>
                            <th>SKS</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($riwayat)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">Data riwayat akademik belum tersedia.</td></tr>
                        <?php else: ?>
                            <?php foreach ($riwayat as $row): ?>
                                <tr>
                                    <td><?= html_escape($row->tahun ?: '-'); ?></td>
                                    <td><?= html_escape($row->semester ?: '-'); ?></td>
                                    <td><?= html_escape((string) round((float) $row->total_sks, 2)); ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('sistem-nilai/akademik/riwayat-mahasiswa?tahun_id=' . (int) $row->id . '&semester=' . urlencode((string) $row->semester)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
