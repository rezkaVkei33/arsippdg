<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Hasil Studi</title>
    <style>
        @page {
            size: A4;
            margin: 8mm 10mm 8mm 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            color: #111;
            background: #fff;
            font-size: 12px;
        }

        .page {
            width: 100%;
            min-height: 100%;
            box-sizing: border-box;
        }

        .kop-wrapper {
            border-bottom: 2px solid #111;
            padding: 0 8px 6px 8px;
            background: #fff;
        }

        .kop-header {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .logo-box {
            width: 72px;
            min-width: 72px;
            text-align: center;
            margin-left: -2px;
        }

        .logo-box img {
            width: 62px;
            height: 62px;
            display: block;
            margin: 0 auto;
        }

        .instansi {
            text-align: left;
            line-height: 1.35;
            font-weight: bold;
            flex: 1;
        }

        .instansi .brand {
            font-size: 18px;
            letter-spacing: 0.5px;
        }

        .instansi .subbrand {
            font-size: 11px;
        }

        .instansi .alamat {
            font-size: 9px;
            font-weight: normal;
        }

        .title-wrap {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .title-wrap h1 {
            margin: 0;
            font-size: 19px;
            letter-spacing: 0.5px;
        }

        .meta {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .meta td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .meta .label {
            width: 18%;
            font-weight: bold;
            white-space: nowrap;
        }

        .meta .value {
            width: 32%;
        }

        .table-wrap {
            border: 1px solid #111;
            background: #fff;
        }

        table.khs {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 11px;
        }

        table.khs th,
        table.khs td {
            border: 1px solid #111;
            padding: 4px 4px;
            text-align: center;
            vertical-align: middle;
        }

        table.khs th {
            font-weight: bold;
            background: #f8f8f8;
        }

        table.khs td.left {
            text-align: left;
        }

        .footer-area {
            width: 100%;
            margin-top: 12px;
        }

        .summary-left {
            width: 62%;
            float: left;
        }

        .summary-right {
            width: 36%;
            float: right;
        }

        .ips-label {
            font-size: 12px;
            font-weight: bold;
            margin: 2px 0 6px 0;
        }

        .mini-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #111;
            font-size: 11px;
        }

        .mini-table td {
            border: 1px solid #111;
            padding: 4px 5px;
        }

        .mini-table .label {
            width: 70%;
            font-weight: bold;
            text-align: right;
        }

        .keterangan {
            margin-top: 10px;
            font-size: 11px;
        }

        .keterangan .title {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .keterangan-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #111;
        }

        .keterangan-table td {
            border: 1px solid #111;
            padding: 4px 5px;
            text-align: center;
        }

        .signature-box {
            margin-top: 8px;
            text-align: center;
            font-size: 12px;
            width: 100%;
        }

        .signature-box .date {
            margin-bottom: 24px;
        }

        .signature-box .role {
            margin-bottom: 8px;
        }

        .signature-box .name {
            font-weight: bold;
            margin-top: 8px;
            font-size: 12px;
        }

        .signature-box .nip {
            margin-top: 2px;
            font-size: 10px;
        }

        .ttd-image {
            margin: 0 auto 6px auto;
            max-width: 180px;
            max-height: 90px;
            display: block;
        }

        .stamp-wrap {
            width: 130px;
            height: 90px;
            position: relative;
            margin: 0 auto 6px auto;
        }

        .stamp-circle {
            position: absolute;
            inset: 0;
            border: 2px solid #c00;
            border-radius: 50%;
        }

        .stamp-circle::before,
        .stamp-circle::after {
            content: "";
            position: absolute;
            inset: 10px;
            border: 1px solid #c00;
            border-radius: 50%;
        }

        .stamp-text {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #c00;
            font-weight: bold;
            font-size: 18px;
            transform: rotate(-18deg);
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="kop-wrapper">
            <div class="kop-header">
                <div class="logo-box">
                    <img src="<?= base_url('assets/img/LogoPoltek.png'); ?>" alt="Logo Poltek">
                </div>
                <div class="instansi">
                    <div class="brand">POLITEKNIK DARMA GANESHA</div>
                    <div class="subbrand">PERHOTELAN – SISTEM INFORMASI</div>
                    <div class="alamat">
                        Alamat : Kampus 1, Jl. M. Faqot No 9 Air Merbau Tanjung Pandan, Belitung<br>
                        Kampus 2. Jl. Wisma Ria II, Halang, Manggar, Belitung Timur<br>
                        Provinsi Kep. Bangka Belitung Telp : 0817-8211-9043<br>
                        Website : www.poltekdg.ac.id &nbsp;&nbsp; Email : admin@poltekdg.ac.id
                    </div>
                </div>
            </div>
        </div>

        <div class="title-wrap">
            <h1>KARTU HASIL STUDI (KHS)</h1>
        </div>

        <table class="meta">
            <tr>
                <td class="label">Nama Mahasiswa</td>
                <td class="value">: <?= html_escape($mahasiswa->nama ?? '-'); ?></td>
                <td class="label">Program Studi</td>
                <td>: <?= html_escape($mahasiswa->nama_prodi ?? '-'); ?></td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td class="value">: <?= html_escape($mahasiswa->nim ?? '-'); ?></td>
                <td class="label">Semester</td>
                <td>: <?= html_escape((string) ($semester_number ?? '1')); ?> / <?= html_escape((string) ($semester_label ?? 'Ganjil')); ?></td>
            </tr>
            <tr>
                <td class="label">Tahun Akademik</td>
                <td class="value">: <?= html_escape((string) ($tahun_akademik->tahun ?? '-')); ?></td>
                <td class="label"> </td>
                <td> </td>
            </tr>
        </table>

        <div class="table-wrap">
            <table class="khs">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 5%;">No</th>
                        <th rowspan="2" style="width: 12%;">Kode MK</th>
                        <th rowspan="2" style="width: 34%;">Mata Kuliah</th>
                        <th rowspan="2" style="width: 8%;">SKS</th>
                        <th colspan="2" style="width: 24%;">Nilai</th>
                        <th rowspan="2" style="width: 10%;">Mutu</th>
                    </tr>
                    <tr>
                        <th style="width: 12%;">Huruf</th>
                        <th style="width: 12%;">Angka</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($khs)): ?>
                        <tr>
                            <td colspan="7">Belum ada data KHS.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($khs as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= html_escape($row->kode_mk ?? '-'); ?></td>
                                <td class="left"><?= html_escape($row->nama_mk ?? '-'); ?></td>
                                <td><?= html_escape((string) ($row->sks ?? 0)); ?></td>
                                <td><?= html_escape($row->nilai_huruf ?? '-'); ?></td>
                                <td><?= html_escape((string) ($row->nilai_angka ?? 0)); ?></td>
                                <td><?= html_escape((string) ($row->nilai_mutu ?? 0)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3" style="font-weight:bold; text-align:center;">Jumlah</td>
                        <td style="font-weight:bold;"><?= html_escape((string) number_format((float) $total_sks, 0, ',', '.')); ?></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;"><?= html_escape(number_format((float) $total_nilai_mutu, 2, ',', '.')); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer-area">
            <div class="summary-left">
                <div class="ips-label">Index Prestasi Semester : <?= html_escape(number_format((float) $ip, 2, ',', '.')); ?></div>

                <table class="mini-table">
                    <tr>
                        <td class="label">Total Mutu</td>
                        <td><?= html_escape(number_format((float) $total_nilai_mutu, 2, ',', '.')); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Indeks Prestasi Kumulatif</td>
                        <td><?= html_escape(number_format((float) $ipk, 2, ',', '.')); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Total SKS yang ditempuh</td>
                        <td><?= html_escape((string) number_format((float) $total_sks_kumulatif, 0, ',', '.')); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Total SKS yang diperoleh</td>
                        <td><?= html_escape((string) number_format((float) $total_sks, 0, ',', '.')); ?></td>
                    </tr>
                </table>

                <div class="keterangan">
                    <div class="title">Keterangan :</div>
                    <table class="keterangan-table">
                        <tr>
                            <td style="font-weight:bold; width: 60%;">Nilai Huruf (Mutu)</td>
                            <td style="font-weight:bold; width: 40%;">Bobot</td>
                        </tr>
                        <?php if (!empty($grades)): ?>
                            <?php foreach ($grades as $grade): ?>
                                <tr>
                                    <td><?= html_escape($grade->kode ?? '-'); ?></td>
                                    <td><?= html_escape((string) ($grade->bobot ?? 0)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <div class="summary-right">
                <div class="signature-box">
                    <div class="date">Belitung, <?= html_escape($tanggal_update); ?></div>
                    <div class="role">Direktur</div>

                    <?php if (!empty($ttd) && !empty($ttd->ttd_path)): ?>
                        <img class="ttd-image" src="<?= base_url('assets/' . $ttd->ttd_path); ?>" alt="Tanda Tangan">
                    <?php else: ?>
                        <div class="stamp-wrap">
                            <div class="stamp-circle"></div>
                            <div class="stamp-text">R</div>
                        </div>
                    <?php endif; ?>

                    <div class="name"><?= html_escape($ttd->nama_pejabat ?? 'FRASETYO ANGGA SAPUTRA, S.E., M.Ak.'); ?></div>
                    <div class="nip"><?= !empty($ttd->nomor_induk) ? 'NUPTK. ' . html_escape($ttd->nomor_induk) : 'NUPTK. 0960774765430262'; ?></div>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</body>
</html>
