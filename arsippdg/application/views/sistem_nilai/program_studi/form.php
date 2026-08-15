<main class="container py-4" style="max-width: 760px;">
    <div class="mb-4"><h1 class="h3 mb-1"><?= html_escape($page_title); ?></h1><p class="text-muted mb-0">Isi data program studi dengan lengkap.</p></div>
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <?= form_open($program_studi ? 'sistem-nilai/master-data/program-studi/perbarui/' . $program_studi->id : 'sistem-nilai/master-data/program-studi/simpan'); ?>
            <div class="row g-3">
                <div class="col-md-5"><label for="kode_prodi" class="form-label">Kode Program Studi</label><input id="kode_prodi" name="kode_prodi" maxlength="20" required class="form-control <?= form_error('kode_prodi') ? 'is-invalid' : ''; ?>" value="<?= html_escape(set_value('kode_prodi', $program_studi ? $program_studi->kode_prodi : '')); ?>"><div class="invalid-feedback"><?= form_error('kode_prodi'); ?></div></div>
                <div class="col-md-7"><label for="nama_prodi" class="form-label">Nama Program Studi</label><input id="nama_prodi" name="nama_prodi" maxlength="150" required class="form-control <?= form_error('nama_prodi') ? 'is-invalid' : ''; ?>" value="<?= html_escape(set_value('nama_prodi', $program_studi ? $program_studi->nama_prodi : '')); ?>"><div class="invalid-feedback"><?= form_error('nama_prodi'); ?></div></div>
                <div class="col-md-6"><label for="jenjang" class="form-label">Jenjang</label><?php $jenjang = set_value('jenjang', $program_studi ? $program_studi->jenjang : 'D3'); ?><select id="jenjang" name="jenjang" required class="form-select <?= form_error('jenjang') ? 'is-invalid' : ''; ?>"><?php foreach ($jenjang_options as $option): ?><option value="<?= $option; ?>" <?= $jenjang === $option ? 'selected' : ''; ?>><?= $option; ?></option><?php endforeach; ?></select><div class="invalid-feedback"><?= form_error('jenjang'); ?></div></div>
                <div class="col-md-6"><label for="status" class="form-label">Status</label><?php $status = set_value('status', $program_studi ? $program_studi->status : 'Aktif'); ?><select id="status" name="status" required class="form-select <?= form_error('status') ? 'is-invalid' : ''; ?>"><?php foreach ($status_options as $option): ?><option value="<?= $option; ?>" <?= $status === $option ? 'selected' : ''; ?>><?= $option; ?></option><?php endforeach; ?></select><div class="invalid-feedback"><?= form_error('status'); ?></div></div>
            </div>
            <div class="d-flex gap-2 mt-4"><button class="btn btn-success" type="submit"><i class="bi bi-save"></i> Simpan</button><a href="<?= site_url('sistem-nilai/master-data/program-studi'); ?>" class="btn btn-outline-secondary">Batal</a></div>
        <?= form_close(); ?>
    </div></div>
</main>
