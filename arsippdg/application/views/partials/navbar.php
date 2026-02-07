<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid px-4">

        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= site_url('dashboard'); ?>">
            <img src="<?= base_url('assets/img/LogoPoltek.png'); ?>" width="40">
            <span>Arsip Surat PDG</span>
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent"
                aria-controls="navbarContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('dashboard'); ?>">Dashboard</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       data-bs-auto-close="false">
                        Surat Masuk
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('suratmasuk'); ?>">Daftar</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('suratmasuk/add'); ?>">Tambah</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       data-bs-auto-close="false">
                        Surat Keluar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('suratkeluar'); ?>">Daftar</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('suratkeluar/create'); ?>">Tambah</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       data-bs-auto-close="false">
                        Arsip
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('arsip/masuk'); ?>">Arsip Masuk</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('arsip/keluar'); ?>">Arsip Keluar</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">
                        <?= $this->session->userdata('username'); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item text-danger" href="<?= site_url('auth/logout'); ?>">Logout</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
