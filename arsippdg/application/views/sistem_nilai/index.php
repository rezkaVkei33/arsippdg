<?php $this->load->view('partials/head'); ?>
<?php $this->load->view('partials/navbar'); ?>

<main class="container py-5">
    <div class="card border-0 shadow-sm"><div class="card-body p-5 text-center">
        <i class="bi bi-mortarboard display-3 text-success"></i>
        <h1 class="h3 mt-3">Dashboard Sistem Nilai</h1>
        <p class="text-muted mb-0">Anda masuk sebagai <?= html_escape(role_label()); ?>. Menu dan modul Sistem Nilai dapat ditambahkan di area ini tanpa membuka akses ke Arsip Surat.</p>
    </div></div>
</main>

<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('partials/scripts'); ?>
