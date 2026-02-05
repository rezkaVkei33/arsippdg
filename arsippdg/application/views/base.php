<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<!-- MAIN CONTENT -->
<section class="hero-section" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="hero-content text-white text-center">
            <img src="<?= base_url('assets/img/LogoPoltek.png'); ?>" alt="Logo" style="width: 20rem; height: 20rem; margin-bottom: 20px;">
            <h1>Arsip Surat PDG</h1>
            <h4>Selamat Datang di Dashboard</h4>
        </div>
    </div>
</section>

<section class="dashboard-content mt-5">
    <div class="container">

        <div class="row mb-4">
            <div class="col">
                <h2>Statistik Sistem</h2>
                <p class="text-muted">Ringkasan data surat</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="bi bi-inbox-fill"></i>
                    <h2><?= $surat_masuk; ?></h2>
                    <p>Surat Masuk</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="bi bi-send-fill"></i>
                    <h2><?= $surat_keluar; ?></h2>
                    <p>Surat Keluar</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="bi bi-archive-fill"></i>
                    <h2><?= $arsip_masuk; ?></h2>
                    <p>Arsip Masuk</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="bi bi-archive-fill"></i>
                    <h2><?= $arsip_keluar; ?></h2>
                    <p>Arsip Keluar</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- LOGIN HISTORY SECTION -->
<section class="login-history mt-5 mb-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-clock-history me-2"></i>Riwayat Login</h2>
                <p class="text-muted">10 Login terakhir Anda</p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <?php if (empty($last_login)): ?>
                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle me-2"></i>Belum ada riwayat login
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                        <tr>
                                            <th style="color: #495057; font-weight: 600; width: 10%;">No.</th>
                                            <th style="color: #495057; font-weight: 600; width: 25%;"><i class="bi bi-person me-2"></i>Username</th>
                                            <th style="color: #495057; font-weight: 600; width: 40%;"><i class="bi bi-clock me-2"></i>Waktu Login</th>
                                            <th style="color: #495057; font-weight: 600; width: 25%;"><i class="bi bi-globe me-2"></i>Alamat IP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($last_login as $log): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        <?= htmlspecialchars($this->session->userdata('username')) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="bi bi-calendar-event me-2" style="color: #6c757d;"></i>
                                                    <?= date('d-m-Y H:i:s', strtotime($log->login_time)) ?>
                                                </td>
                                                <td>
                                                    <code style="background-color: #f8f9fa; padding: 4px 8px; border-radius: 4px; color: #d63384;">
                                                        <?= htmlspecialchars($log->ip_address) ?>
                                                    </code>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
