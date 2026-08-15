<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<main class="container py-4" style="max-width: 760px;">
    <div class="mb-4">
        <h1 class="h3 mb-1"><?= $user ? 'Ubah Pengguna' : 'Tambah Pengguna'; ?></h1>
        <p class="text-muted mb-0">Password minimal 8 karakter. Kosongkan password saat mengubah bila tidak ingin menggantinya.</p>
    </div>
    <div class="card shadow-sm border-0"><div class="card-body p-4">
        <?= form_open($user ? 'users/edit/' . $user->id : 'users/create'); ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input id="username" name="username" type="text" class="form-control <?= form_error('username') ? 'is-invalid' : ''; ?>" value="<?= set_value('username', $user ? $user->username : ''); ?>" required maxlength="50" autocomplete="username">
                <div class="invalid-feedback"><?= form_error('username'); ?></div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <?php $selectedRole = set_value('role', $user ? $user->role : 'arsip_surat'); ?>
                <select id="role" name="role" class="form-select <?= form_error('role') ? 'is-invalid' : ''; ?>" required>
                    <option value="arsip_surat" <?= $selectedRole === 'arsip_surat' ? 'selected' : ''; ?>>Admin Arsip Surat</option>
                    <option value="sistem_nilai" <?= $selectedRole === 'sistem_nilai' ? 'selected' : ''; ?>>Admin Sistem Nilai</option>
                    <option value="master_akun" <?= $selectedRole === 'master_akun' ? 'selected' : ''; ?>>Master Akun</option>
                </select>
                <div class="invalid-feedback"><?= form_error('role'); ?></div>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password<?= $user ? ' baru (opsional)' : ''; ?></label>
                <input id="password" name="password" type="password" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" <?= $user ? '' : 'required'; ?> minlength="8" autocomplete="new-password">
                <div class="invalid-feedback"><?= form_error('password'); ?></div>
            </div>
            <div class="d-flex gap-2"><button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Simpan</button><a class="btn btn-outline-secondary" href="<?= site_url('users'); ?>">Batal</a></div>
        <?= form_close(); ?>
    </div></div>
</main>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
