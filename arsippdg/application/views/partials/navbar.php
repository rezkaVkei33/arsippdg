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
                    <i class="bi bi-card-list"></i> 
                        Daftar Surat Masuk
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       data-bs-auto-close="false">
                       <i class="fas fa-envelope"></i>
                        Surat Masuk
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" 
                            href="<?= site_url('suratmasuk'); ?>">
                            <i class="bi bi-card-list"></i> Daftar Surat Masuk</a>
                        </li>
                        <li><a class="dropdown-item" 
                        href="<?= site_url('suratmasuk/add'); ?>">
                        <i class="bi bi-plus-circle"></i> Tambah Surat Masuk</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       data-bs-auto-close="false">
                       <i class="fas fa-paper-plane"></i>
                        Surat Keluar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" 
                        href="<?= site_url('suratkeluar'); ?>">
                        <i class="bi bi-card-list"></i> 
                        Daftar Surat Keluar</a></li>
                        <li><a class="dropdown-item" 
                        href="<?= site_url('suratkeluar/create'); ?>">
                        <i class="bi bi-plus-circle"></i> 
                        Tambah Surat Keluar</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       data-bs-auto-close="false">
                       <i class="bi bi-folder2-open"></i>
                       Arsip
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" 
                        href="<?= site_url('arsip/masuk'); ?>">
                        <i class="bi bi-inbox"></i>
                        Arsip Masuk</a></li>
                        <li><a class="dropdown-item" 
                        href="<?= site_url('arsip/keluar'); ?>"><i class="bi bi-send"></i> 
                        <i class="bi bi-box-seam"></i>
                        Arsip Keluar</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <?= $this->session->userdata('username'); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person"></i> <?= $this->session->userdata('username'); ?>
                            </a>
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
