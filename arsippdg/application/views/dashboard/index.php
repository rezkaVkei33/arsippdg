<?php ?>
<!-- Dashboard Content -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h2>Riwayat Login</h2>
            <p class="text-muted">Histori login Anda dalam 10 kali terakhir</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Waktu Login</th>
                                <th>Alamat IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($last_login)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($last_login as $log): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($this->session->userdata('username')) ?></strong>
                                        </td>
                                        <td>
                                            <i class="bi bi-clock me-2"></i>
                                            <?= date('d-m-Y H:i:s', strtotime($log->login_time)) ?>
                                        </td>
                                        <td>
                                            <code><?= htmlspecialchars($log->ip_address) ?></code>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox"></i> Belum ada riwayat login
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

    code {
        background-color: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
        color: #666;
        font-size: 12px;
    }
</style>
