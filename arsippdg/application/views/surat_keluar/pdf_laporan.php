<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 6px;
            border: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
    </style>
</head>
<body>

<!-- KOP SURAT -->
<div style="width:85%; margin:0 auto;">
    <table style="border:none;">
        <tr>
            <td width="15%" style="border:none; vertical-align:top;">
                <img src="<?= base_url('assets/img/LogoPoltek.png') ?>" style="width:80px;">
            </td>
            <td width="85%" style="border:none; text-align:left; padding-left:10px;">
                <div style="font-size:16px; font-weight:bold;">
                    POLITEKNIK DARMA GANESHA
                </div>
                <div style="font-size:14px; font-weight:bold;">
                    PERHOTELAN – SISTEM INFORMASI
                </div>
                <div style="font-size:11px; margin-top:4px;">
                    Keputusan Direktorat Jenderal Pendidikan Tinggi Nomor : 4185 Tahun 2014
                </div>
                <div style="font-size:11px;">
                    Kampus I. Jl. Mufakat No. 9 Air Merbau Tanjung Pandan, Belitung
                </div>
                <div style="font-size:11px;">
                    Kampus II. Jl. Masjid Al-Hidayah, Jalan Kurnia Jaya, Kec. Manggar, Belitung Timur
                </div>
                <div style="font-size:11px;">
                    Provinsi Kep. Bangka Belitung Telp : 0812-8711-9043
                </div>
                <div style="font-size:11px;">
                    Website: www.poltekdg.ac.id | Email: darmaganeshapoliteknik@gmail.com
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- GARIS -->
<div style="width:85%; margin:6px auto 15px;">
    <div style="border-top:2px solid #000;"></div>
    <div style="border-top:1px solid #000; margin-top:2px;"></div>
</div>

<!-- JUDUL -->
<div class="text-center" style="margin-bottom:10px;">
    <strong>LAPORAN SURAT KELUAR</strong><br>
    <span style="font-size:10px;">
        Tanggal: <?= date('d-m-Y') ?>
    </span>
</div>

<!-- TABEL -->
<table>
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="16%">Nomor Surat</th>
            <th width="18%">Pihak Tujuan</th>
            <th width="10%">Tanggal</th>
            <th width="22%">Perihal</th>
            <th width="30%">Ringkasan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($surats as $s): ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($s->nomor_surat) ?></td>
            <td><?= htmlspecialchars($s->pihak) ?></td>
            <td class="text-center"><?= date('d-m-Y', strtotime($s->tanggal_surat)) ?></td>
            <td><?= htmlspecialchars($s->perihal) ?></td>
            <td><?= htmlspecialchars($s->ringkasan) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
