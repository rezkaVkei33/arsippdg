<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('sistem-nilai'); ?>">
            <img src="<?= base_url('assets/img/LogoPoltek.png'); ?>" width="40" alt="Logo PDG">
            <span>Sistem Nilai PDG</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sistemNilaiNavbar" aria-controls="sistemNilaiNavbar" aria-expanded="false" aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="sistemNilaiNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-database"></i> Master Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/master-data/program-studi'); ?>"><i class="bi bi-diagram-3"></i> Program Studi</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/master-data/mahasiswa'); ?>"><i class="bi bi-people"></i> Mahasiswa</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/master-data/tahun-akademik'); ?>"><i class="bi bi-calendar-range"></i> Tahun Akademik</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/master-data/mata-kuliah'); ?>"><i class="bi bi-book"></i> Mata Kuliah</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/master-data/penawaran-mata-kuliah'); ?>"><i class="bi bi-journal-plus"></i> Penawaran Mata Kuliah</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-clipboard-check"></i> Penilaian</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/penilaian/upload-nilai'); ?>"><i class="bi bi-cloud-arrow-up"></i> Upload Nilai</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/penilaian/daftar-nilai'); ?>"><i class="bi bi-clipboard-data"></i> Daftar Nilai</a></li>
                        <li><a class="dropdown-item text-danger" href="<?= site_url('sistem-nilai/penilaian/hapus-nilai'); ?>"><i class="bi bi-trash"></i> Hapus Nilai</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-mortarboard"></i> Akademik</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/akademik/khs'); ?>"><i class="bi bi-file-earmark-text"></i> KHS</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/akademik/ips'); ?>"><i class="bi bi-graph-up-arrow"></i> IPS</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/akademik/ipk'); ?>"><i class="bi bi-bar-chart-line"></i> IPK</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/akademik/transkrip-nilai'); ?>"><i class="bi bi-file-earmark-richtext"></i> Transkrip Nilai</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/laporan/rekap-mahasiswa'); ?>"><i class="bi bi-people-fill"></i> Rekap Mahasiswa</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/laporan/rekap-nilai'); ?>"><i class="bi bi-file-bar-graph"></i> Rekap Nilai</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/laporan/rekap-mata-kuliah'); ?>"><i class="bi bi-journals"></i> Rekap Mata Kuliah</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-gear"></i> Pengaturan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/pengaturan/grade'); ?>"><i class="bi bi-sliders"></i> Grade</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('sistem-nilai/pengaturan/tanda-tangan'); ?>"><i class="bi bi-pen"></i> Tanda Tangan</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown ms-lg-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-person-circle"></i> <?= html_escape(current_username()); ?></a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text small text-muted"><i class="bi bi-shield-lock"></i> <?= role_label(); ?></span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= site_url('auth/logout'); ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
