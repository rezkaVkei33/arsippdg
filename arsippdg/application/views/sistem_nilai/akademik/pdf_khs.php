<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KHS</title>
    <style>
        @page {
            size: A4;
            margin: 24mm 15mm 18mm 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #111;
            margin: 0;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .logo-wrap {
            display: table-cell;
            width: 70px;
            vertical-align: middle;
            text-align: center;
        }

        .logo-wrap img {
            width: 58px;
            height: 58px;
        }

        .instansi {
            display: table-cell;
            vertical-align: middle;
            text-align: left;
            padding-left: 12px;
        }

        .instansi h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .line {
            border-top: 2px solid #111;
            margin: 8px 0 10px 0;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 12px 0 6px 0;
            text-transform: uppercase;
        }

        .title-small {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 10px 0;
        }

        .year-box {
            text-align: center;
            margin: 8px auto 12px auto;
            font-weight: bold;
            font-size: 12px;
        }

        .meta {
            width: 100%;
            margin-bottom: 12px;
            border-collapse: collapse;
            font-size: 11px;
        }

        .meta td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .meta .label {
            width: 28%;
            font-weight: bold;
        }

        table.khs {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 10.5px;
        }

        table.khs th,
        table.khs td {
            border: 1px solid #111;
            padding: 5px 6px;
            text-align: center;
            vertical-align: middle;
        }

        table.khs th {
            background: #f1f1f1;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .summary {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
            font-size: 11px;
        }

        .summary td {
            border: 1px solid #111;
            padding: 5px 6px;
        }

        .summary .label {
            font-weight: bold;
            text-align: right;
            width: 80%;
        }

        .signature-wrap {
            width: 100%;
            margin-top: 30px;
            font-size: 11px;
        }

        .signature-box {
            width: 250px;
            margin-left: auto;
            text-align: center;
        }

        .signature-box .date-line {
            margin-top: 10px;
            margin-bottom: 28px;
            font-size: 11px;
        }

        .signature-box .name {
            font-weight: bold;
            margin-top: 10px;
            text-decoration: none;
            font-size: 12px;
        }

        .signature-box .nip {
            margin-top: 2px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-wrap">
            <img src="<?= base_url('assets/img/LogoPoltek.png'); ?>" alt="Logo Poltek">
        </div>
        <div class="instansi">
            <h2>Politeknik Darma Ganesha</h2>
        </div>
    </div>

    <div class="line"></div>

    <div class="title">Kartu Hasil Studi</div>

    <div class="year-box">
        Tahun Akademik : <?= html_escape($tahun_akademik->tahun ?? '-'); ?> / <?= html_escape($tahun_akademik->semester ?? '-'); ?>
    </div>

    <table class="meta">
        <tr>
            <td class="label">Nama Mahasiswa</td>
            <td>: <?= html_escape($mahasiswa->nama ?? '-'); ?></td>
            <td class="label">NIM</td>
            <td>: <?= html_escape($mahasiswa->nim ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">Program Studi</td>
            <td>: <?= html_escape($mahasiswa->nama_prodi ?? '-'); ?></td>
            <td class="label">Semester</td>
            <td>: <?= html_escape((string) ($tahun_akademik->semester ?? '-')); ?> / <?= html_escape(strtolower((string) ($tahun_akademik->semester ?? '-')) === 'ganjil' ? 'Ganjil' : 'Genap'); ?></td>
        </tr>
    </table>

    <table class="khs">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Mata Kuliah</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Nilai Huruf</th>
                <th>Nilai Angka</th>
                <th>Nilai Mutu</th>
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
                        <td class="text-left"><?= html_escape($row->nama_mk ?? '-'); ?></td>
                        <td><?= html_escape((string) ($row->sks ?? 0)); ?></td>
                        <td><?= html_escape($row->nilai_huruf ?? '-'); ?></td>
                        <td><?= html_escape((string) ($row->nilai_angka ?? 0)); ?></td>
                        <td><?= html_escape((string) ($row->nilai_mutu ?? 0)); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td class="label">Jumlah SKS</td>
            <td><?= html_escape((string) number_format((float) $total_sks, 2, ',', '.')); ?></td>
        </tr>
        <tr>
            <td class="label">Jumlah Nilai Mutu</td>
            <td><?= html_escape((string) number_format((float) $total_nilai_mutu, 2, ',', '.')); ?></td>
        </tr>
        <tr>
            <td class="label">IP</td>
            <td><?= html_escape(number_format((float) $ip, 2, ',', '.')); ?></td>
        </tr>
    </table>

    <div class="signature-wrap">
        <div class="signature-box">
            <div>Belitung, <?= html_escape($tanggal_update); ?></div>
            <div class="date-line">Direktur</div>
            <div class="name">Frasetyo Angga Saputra, S.E., M.Ak.</div>
            <div class="nip">NUPTK. </div>
        </div>
    </div>
</body>
</html>
