<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Hasil Studi</title>
    <style>
        @page {
            size: A4;
            margin: 8mm 10mm 10mm 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            background: #fff;
            font-size: 11px;
        }

        .page {
            width: 100%;
            min-height: 100%;
            box-sizing: border-box;
        }

        .header-wrap {
            border: 2px solid #111;
            border-bottom: 3px solid #111;
            padding: 8px 14px 6px 14px;
            background: #fff;
        }

        .header-row {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .logo-box {
            display: table-cell;
            width: 70px;
            text-align: center;
            vertical-align: middle;
        }

        .logo-box img {
            width: 52px;
            height: 52px;
        }

        .instansi-box {
            display: table-cell;
            vertical-align: middle;
            padding-left: 12px;
            text-align: center;
        }

        .instansi-box .brand {
            font-weight: bold;
            font-size: 16px;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .instansi-box .subbrand {
            font-weight: bold;
            font-size: 10px;
            letter-spacing: 0.2px;
            margin-top: 2px;
        }

        .instansi-box .alamat {
            font-size: 8px;
            margin-top: 3px;
            line-height: 1.4;
        }

        .title-wrap {
            text-align: center;
            margin-top: 12px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .title-wrap h1 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.7px;
        }

        .meta {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 4px;
        }

        .meta td {
            padding: 3px 4px;
            vertical-align: top;
        }

        .meta .label {
            font-weight: bold;
            width: 18%;
        }

        .meta .value {
            width: 32%;
        }

        .table-wrap {
            margin-top: 8px;
            border: 2px solid #111;
            border-collapse: collapse;
        }

        table.khs {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10px;
        }

        table.khs th,
        table.khs td {
            border: 1px solid #111;
            padding: 4px 5px;
            text-align: center;
            vertical-align: middle;
        }

        table.khs th {
            font-weight: bold;
            background: #f4f4f4;
        }

        table.khs td.left {
            text-align: left;
        }

        .summary-row {
            width: 100%;
            margin-top: 12px;
            overflow: hidden;
        }

        .summary-left {
            width: 58%;
            float: left;
        }

        .summary-right {
            width: 42%;
            float: right;
        }

        .note-box {
            border: 1px solid #111;
            background: #fff;
            margin-top: 0;
        }

        .note-box table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .note-box td {
            border: 1px solid #111;
            padding: 4px 5px;
        }

        .note-box .label {
            font-weight: bold;
            text-align: right;
            width: 65%;
        }

        .keterangan {
            border: 1px solid #111;
            margin-top: 10px;
            padding: 6px 8px;
            font-size: 10px;
            line-height: 1.5;
        }

        .keterangan table {
            width: 100%;
            border-collapse: collapse;
        }

        .keterangan td {
            border: 1px solid #111;
            padding: 4px;
            text-align: center;
        }

        .signature-box {
            width: 255px;
            margin-top: 24px;
            margin-left: auto;
            text-align: center;
            font-size: 11px;
        }

        .signature-box .date {
            margin-bottom: 40px;
        }

        .signature-box .name {
            font-weight: bold;
            font-size: 12px;
            margin-top: 4px;
        }

        .signature-box .nip {
            margin-top: 2px;
            font-size: 10px;
        }

        .stamp {
            position: relative;
            margin: 0 auto;
            width: 120px;
            height: 120px;
        }

        .stamp-ring {
            width: 115px;
            height: 115px;
            border: 2px solid #c00;
            border-radius: 50%;
            margin: 0 auto;
            position: relative;
        }

        .stamp-ring::before,
        .stamp-ring::after {
            content: "";
            position: absolute;
            inset: 7px;
            border: 1px solid #c00;
            border-radius: 50%;
        }

        .stamp-text {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
            color: #c00;
            transform: rotate(-15deg);
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header-wrap">
            <div class="header-row">
                <div class="logo-box">
                    <img src="<?= base_url('assets/img/LogoPoltek.png'); ?>" alt="Logo Poltek">
                </div>
                <div class="instansi-box">
                    <div class="brand">POLITEKNIK DARMA GANESHA</div>
                    <div class="subbrand">PERHOTELAN – SISTEM INFORMASI</div>
                    <div class="alamat">Alamat : Kampus 1, Jl. M. Faqot No 9 Air Merbau Tanjung Pandan, Belitung<br>
                    Kampus 2. Jl. Wisma Ria II, Halang, Manggar, Belitung Timur<br>
                    Provinsi Kep. Bangka Belitung Telp : 0817-8211-9043<br>
                    Website : www.poltekdg.ac.id &nbsp;&nbsp; Email : admin@poltekdg.ac.id</div>
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
                <td>: <?= html_escape(($tahun_akademik->semester ?? '')) . ' / ' . (strtolower((string) ($tahun_akademik->semester ?? '')) === 'ganjil' ? 'Ganjil' : 'Genap'); ?></td>
            </tr>
            <tr>
                <td class="label">Tahun Akademik</td>
                <td class="value">: <?= html_escape((string) ($tahun_akademik->tahun ?? '-')); ?> / <?= html_escape((string) ($tahun_akademik->tahun ?? '-')); ?></td>
                <td class="label"></td>
                <td></td>
            </tr>
        </table>

        <div class="table-wrap">
            <table class="khs">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 14%;">Kode MK</th>
                        <th style="width: 33%;">Mata Kuliah</th>
                        <th style="width: 8%;">SKS</th>
                        <th style="width: 11%;">Nilai Huruf</th>
                        <th style="width: 12%;">Nilai Angka</th>
                        <th style="width: 12%;">Mutu</th>
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

        <div class="summary-row">
            <div class="summary-left">
                <div class="note-box">
                    <table>
                        <tr>
                            <td class="label">Indeks Prestasi Semester</td>
                            <td><?= html_escape(number_format((float) $ip, 2, ',', '.')); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Total Mutu</td>
                            <td><?= html_escape(number_format((float) $total_nilai_mutu, 2, ',', '.')); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Indeks Prestasi Kumulatif</td>
                            <td><?= html_escape(number_format((float) $ip, 2, ',', '.')); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Total SKS yang ditempuh</td>
                            <td><?= html_escape((string) number_format((float) $total_sks, 0, ',', '.')); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Total SKS yang diperoleh</td>
                            <td><?= html_escape((string) number_format((float) $total_sks, 0, ',', '.')); ?></td>
                        </tr>
                    </table>
                </div>

                <div class="keterangan">
                    <div style="font-weight:bold; margin-bottom:6px;">Keterangan :</div>
                    <table>
                        <tr>
                            <td>Nilai Huruf (Mutu)</td>
                            <td>A</td>
                            <td>B</td>
                            <td>C</td>
                            <td>D</td>
                            <td>E</td>
                        </tr>
                        <tr>
                            <td>Bobot</td>
                            <td>4</td>
                            <td>3</td>
                            <td>2</td>
                            <td>1</td>
                            <td>0</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="summary-right">
                <div class="signature-box">
                    <div class="date">Belitung, <?= html_escape($tanggal_update); ?></div>
                    <div>Direktur</div>
                    <div class="stamp">
                        <div class="stamp-ring"></div>
                        <div class="stamp-text">R</div>
                    </div>
                    <div class="name">FRASETYO ANGGA SAPUTRA, S.E., M.Ak.</div>
                    <div class="nip">NUPTK. 0960774765430262</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
