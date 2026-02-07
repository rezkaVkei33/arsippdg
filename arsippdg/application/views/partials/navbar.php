<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('dashboard'); ?>">
            <img src="<?= base_url('assets/img/LogoPoltek.png'); ?>" width="40">
            <span>Arsip Surat PDG</span>
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('dashboard'); ?>">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-inbox"></i> Surat Masuk
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('suratmasuk'); ?>">
                        <i class="bi bi-card-list"></i> 
                        Daftar Surat Masuk
                        </a></li>
                        <li><a class="dropdown-item" href="<?= site_url('suratmasuk/add'); ?>">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Data</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-inbox"></i> Surat Keluar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('suratkeluar'); ?>">
                            <i class="bi bi-card-list"></i>
                             Daftar Surat Keluar
                            </a></li>
                        <li><a class="dropdown-item" href="<?= site_url('suratkeluar/create'); ?>">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Data</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-archive"></i> Arsip
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('arsip/masuk'); ?>"><i class="bi bi-inbox"></i> Arsip Masuk</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('arsip/keluar'); ?>"><i class="bi bi-box-seam"></i> Arsip Keluar</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">
                           <i class="bi bi-file-earmark-text"></i> Catatan</a></li>
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
