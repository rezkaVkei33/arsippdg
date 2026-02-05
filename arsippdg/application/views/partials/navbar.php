<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-4">

        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= site_url('dashboard'); ?>">
            <img src="<?= base_url('assets/img/LogoPoltek.png'); ?>" width="40">
            <span class="fw-semibold">Kancut Terbang Surat PDG</span>
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
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('dashboard'); ?>">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>

                <!-- SURAT MASUK -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-inbox"></i> Surat Masuk
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= site_url('suratmasuk'); ?>">
                                <i class="bi bi-card-list"></i> Daftar Surat Masuk
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= site_url('suratmasuk/add'); ?>">
                                <i class="bi bi-plus-circle"></i> Tambah Data
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- SURAT KELUAR -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-send"></i> Surat Keluar
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= site_url('suratkeluar'); ?>">
                                <i class="bi bi-card-list"></i> Daftar Surat Keluar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= site_url('suratkeluar/create'); ?>">
                                <i class="bi bi-plus-circle"></i> Tambah Data
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ARSIP -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-archive"></i> Arsip
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('arsip/masuk'); ?>">
                            <i class="bi bi-inbox"></i> Arsip Masuk</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('arsip/keluar'); ?>">
                            <i class="bi bi-box-seam"></i> Arsip Keluar</a></li>
                    </ul>
                </li>

                <!-- USER -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <?= $this->session->userdata('username'); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text">
                                <i class="bi bi-person"></i>
                                <?= $this->session->userdata('username'); ?>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= site_url('auth/logout'); ?>">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

