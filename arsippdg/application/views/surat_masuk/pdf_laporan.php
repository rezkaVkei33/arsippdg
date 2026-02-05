<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4 landscape;
            margin: 20mm 15mm;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }
        table {
                width: 100%;
                border-collapse: collapse;
                font-size: 11px;
                margin-top: 10px;
            }

        .judul {
            text-align: center;
            margin: 15px 0 10px 0;
        }

        .judul h3 {
            margin: 0;
            text-transform: uppercase;
            font-size: 14px;
        }

        .judul p {
            margin: 3px 0 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #eaeaea;
            text-align: center;
            font-weight: bold;
        }

        td {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- WRAPPER KOP (CENTER HALAMAN) -->
<div style="width:85%; margin:0 auto;">

    <table width="100%" cellspacing="0" cellpadding="0" style="border:none;">
        <tr>
            <!-- LOGO -->
            <td width="15%" style="border:none; vertical-align:top;">
                <img src="<?= base_url('assets/img/LogoPoltek.png') ?>" alt="Logo Poltekdg"
                     style="width:80px;">
            </td>

            <!-- TEKS KOP (RATA KIRI) -->
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


    <!-- JUDUL LAPORAN -->
        <div style="text-align:center; margin-top:15px;">
        <h3 style="margin:0; text-transform:uppercase;">
            Laporan Surat Masuk
        </h3>
        <p style="margin:4px 0 0; font-size:11px;">
            Tanggal: <?= date('d-m-Y') ?>
        </p>
    </div>


    <!-- TABEL -->
    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="margin-top:10px; border-collapse:collapse; font-size:11px;">
    <thead>
        <tr style="background:#eee; font-weight:bold;">
            <th width="4%">No</th>
            <th width="16%">Nomor Surat</th>
            <th width="18%">Asal Surat</th>
            <th width="10%">Tanggal</th>
            <th width="22%">Perihal</th>
            <th width="30%">Ringkasan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($surats as $s): ?>
        <tr>
            <td align="center"><?= $no++ ?></td>
            <td><?= $s->nomor_surat ?></td>
            <td><?= $s->asal_surat ?></td>
            <td align="center"><?= date('d-m-Y', strtotime($s->tanggal_surat)) ?></td>
            <td><?= $s->perihal ?></td>
            <td><?= $s->ringkasan ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>


</body>
</html>
