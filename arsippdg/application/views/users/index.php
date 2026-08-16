<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Akun Master</h1>
            <p class="text-muted mb-0">Kelola seluruh akun pengguna dan role sistem.</p>
        </div>
        <a href="<?= site_url('users/create'); ?>" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah Pengguna</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>ID</th><th>Username</th><th>Role</th><th>Dibuat</th><th class="text-end">Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= (int) $user->id; ?></td>
                        <td><?= html_escape($user->username); ?><?= (int) $user->id === (int) current_user_id() ? ' <span class="badge bg-secondary">Anda</span>' : ''; ?></td>
                        <td><span class="badge <?= $user->role === 'arsip_surat' ? 'bg-primary' : 'bg-success'; ?>"><?= html_escape(role_label($user->role)); ?></span></td>
                        <td><?= date('d-m-Y H:i', strtotime($user->created_at)); ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="<?= site_url('users/edit/' . $user->id); ?>"><i class="bi bi-pencil"></i> Ubah</a>
                            <?php if ((int) $user->id !== (int) current_user_id()): ?>
                            <form action="<?= site_url('users/delete/' . $user->id); ?>" method="post" class="d-inline delete-form" data-delete-confirm="Akun pengguna <?= html_escape($user->username); ?> akan dihapus. Data terkait juga akan ikut terhapus.">
                                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?><tr><td colspan="5" class="text-center text-muted py-4">Belum ada pengguna.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
