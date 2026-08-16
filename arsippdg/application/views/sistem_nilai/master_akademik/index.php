<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1"><?= html_escape($label); ?></h1>
            <p class="text-muted mb-0">Kelola data <?= strtolower(html_escape($label)); ?>.</p>
        </div>
        <a class="btn btn-success" href="<?= site_url('sistem-nilai/master-data/'.$type.'/tambah'); ?>"><i class="bi bi-plus-circle"></i> Tambah</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="get" action="<?= site_url('sistem-nilai/master-data/'.$type); ?>" class="row g-2 mb-3">
                <div class="col-md-6">
                    <input class="form-control" name="q" value="<?= html_escape($keyword); ?>" placeholder="Cari data">
                </div>
                <?php if ($type !== 'tahun-akademik'): ?>
                    <div class="col-md-4">
                        <select name="prodi" class="form-select">
                            <option value="">Semua Program Studi</option>
                            <?php foreach ($program_studi_options as $item): ?>
                                <option value="<?= (int) $item->id; ?>" <?= (string) $selected_prodi === (string) $item->id ? 'selected' : ''; ?>><?= html_escape($item->nama_prodi); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="col-auto">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </div>
                <?php if ($keyword !== '' || ($type !== 'tahun-akademik' && $selected_prodi !== '')): ?>
                    <div class="col-auto">
                        <a href="<?= site_url('sistem-nilai/master-data/'.$type); ?>" class="btn btn-outline-secondary">Reset</a>
                    </div>
                <?php endif; ?>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <?php if($type==='tahun-akademik'): ?>
                                <th>Periode</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            <?php elseif($type==='mata-kuliah'): ?>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Status</th>
                            <?php else: ?>
                                <th>Mata Kuliah</th>
                                <th>Tahun Akademik</th>
                            <?php endif; ?>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Data <?= strtolower(html_escape($label)); ?> belum tersedia.</td></tr>
                        <?php else: ?>
                            <?php foreach($items as $n=>$i): ?>
                                <tr>
                                    <td><?= $n + 1 + (($current_page - 1) * $per_page); ?></td>
                                    <?php if($type==='tahun-akademik'): ?>
                                        <td><?= html_escape($i->tahun.' / '.$i->semester); ?></td>
                                        <td><?= html_escape(($i->tanggal_mulai?:'-').' s.d. '.($i->tanggal_selesai?:'-')); ?></td>
                                        <td><?= html_escape($i->status); ?></td>
                                    <?php elseif($type==='mata-kuliah'): ?>
                                        <td><?= html_escape($i->kode_mk); ?></td>
                                        <td><?= html_escape($i->nama_mk); ?></td>
                                        <td><?= $i->sks; ?></td>
                                        <td><?= $i->semester; ?></td>
                                        <td><?= html_escape($i->status); ?></td>
                                    <?php else: ?>
                                        <td><?= html_escape($i->kode_mk.' — '.$i->nama_mk); ?></td>
                                        <td><?= html_escape($i->tahun.' / '.$i->semester); ?></td>
                                    <?php endif; ?>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-primary" href="<?= site_url('sistem-nilai/master-data/'.$type.'/ubah/'.$i->id); ?>">Ubah</a>
                                        <form class="d-inline" method="post" action="<?= site_url('sistem-nilai/master-data/'.$type.'/hapus/'.$i->id); ?>" onsubmit="return confirm('Hapus data ini?');">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($this->pagination->create_links()): ?>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
                    <small class="text-muted">Menampilkan <?= count($items); ?> dari <?= $total_rows; ?> data</small>
                    <?= $this->pagination->create_links(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
