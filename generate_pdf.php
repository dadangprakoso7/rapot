<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// 1. Validasi Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Halaman ini hanya bisa diakses melalui form submission");
}

// 2. Ambil Data Form
$data = $_POST;

// 3. Fungsi Bantu
function angkaKeHuruf($nilai) {
    if ($nilai >= 85) return 'A';
    if ($nilai >= 76) return 'B';
    if ($nilai >= 60) return 'C';
    if ($nilai >= 50) return 'D';
    return 'E';
}

function formatTanggal($date) {
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    
    $tanggal = date('j', strtotime($date));
    $bulan_num = date('n', strtotime($date));
    $tahun = date('Y', strtotime($date));
    
    return $tanggal . ' ' . $bulan[$bulan_num] . ' ' . $tahun;
}

// 4. Mapping TTD Wali Kelas
$ttd_wali_map = [
    'Dadang Prakoso' => 'dadang.png',
    'Nadiyatul Khoiriyah' => 'nadiyatul.png',
    'M. Rachmadsyah' => 'rahmat.png',
    'Indah Purwati' => 'indah.png'
];

$ttd_wali_file = $ttd_wali_map[$data['wali_santri']] ?? '';

// 5. Konfigurasi DomPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('defaultPaperSize', 'F4');
$options->set('defaultPaperOrientation', 'portrait');

$dompdf = new Dompdf($options);

// 6. Base URL untuk Gambar
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$base_url = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);

// 7. HTML Content
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rapot Santri</title>
    <style>
    @page {
        size: 21cm 33cm; /* F4 size */
        margin-left: 1.5cm;
        margin-right: 1.5cm;
        margin-top: 0cm;
        margin-bottom: 2cm;
    }
    body {
        font-family: Calibri, Arial, sans-serif;
        font-size: 12pt;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }
    .container {
        width: 100%;
    }
    .kop {
        text-align: center;
        margin-bottom: 10px;
    }
    .kop img {
        width: 100%;
        height: auto;
    }
    .judul {
        text-align: center;
        font-size: 16pt;
        font-weight: bold;
        text-decoration: underline;
        margin: 10px 0 20px;
    }
    .identitas-table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }
    .identitas-table td {
        padding: 2px 4px;
        vertical-align: top;
    }
    .identitas-table td.label {
        width: 30%;
    }
    .identitas-table td.titikdua {
        width: 2%;
    }
    table.nilai {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }
    table.nilai, .nilai th, .nilai td {
        border: 1px solid #000;
    }
    .nilai th, .nilai td {
        padding: 8px;
        font-weight: normal;
    }
    .nilai th {
        background-color: #f2f2f2;
        text-align: center;
    }
    .nilai td {
        text-align: left;
    }
    .nilai .nilai-angka, .nilai .nilai-huruf {
        text-align: center;
    }
    .ttd-container {
        width: 100%;
        font-size: 12pt;
    }
    .ttd-container .tanggal {
        text-align: right;
        margin-bottom: 5px;
    }
    .ttd-container .mengetahui {
        text-align: center;
        margin-bottom: 10px;
    }
    .ttd-table {
        width: 100%;
        border: none;
    }
    .ttd-table td {
        text-align: center;
        vertical-align: top;
        padding: 0 10px;
    }
    .ttd-table img {
        height: 80px;
        margin-bottom: 5px;
    }
    </style>

</head>
<body>
    <div class="container">
        <!-- Kop -->
        <div class="kop">
            <img src="' . $base_url . '/assets/kop.png" alt="Kop Surat">
        </div>

        <!-- Judul -->
        <div class="judul">
            LAPORAN HASIL BELAJAR & MENGAJI<br>
            SEMESTER ' . htmlspecialchars($data['semester']) . ' TAHUN AJARAN ' .
            htmlspecialchars($data['tahun_ajaran_awal']) . '/' . htmlspecialchars($data['tahun_ajaran_akhir']) . '
        </div>

        <!-- Identitas -->
        <table class="identitas-table">
            <tr>
                <td class="label">Nama Santri/Wati</td>
                <td class="titikdua">:</td>
                <td>' . htmlspecialchars($data['nama_santri']) . '</td>
            </tr>
            <tr>
                <td class="label">NIS</td>
                <td class="titikdua">:</td>
                <td>' . htmlspecialchars($data['nomor_induk']) . '</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td class="titikdua">:</td>
                <td>' . htmlspecialchars($data['kelas']) . '</td>
            </tr>
        </table>

        <!-- Nilai -->
        <table class="nilai">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Bidang Studi</th>
                    <th colspan="2">Nilai</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th>Angka</th>
                    <th>Huruf</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>Tartil</td>
                    <td class="nilai-angka">' . htmlspecialchars($data['tartil']) . '</td>
                    <td class="nilai-huruf">' . angkaKeHuruf($data['tartil']) . '</td>
                    <td></td>
                </tr>
                <tr>
                    <td>02</td>
                    <td>Hafalan Doa Harian</td>
                    <td class="nilai-angka">' . htmlspecialchars($data['doa_harian']) . '</td>
                    <td class="nilai-huruf">' . angkaKeHuruf($data['doa_harian']) . '</td>
                    <td></td>
                </tr>
                <tr>
                    <td>03</td>
                    <td>Hafalan Surah Pendek</td>
                    <td class="nilai-angka">' . htmlspecialchars($data['surah_pendek']) . '</td>
                    <td class="nilai-huruf">' . angkaKeHuruf($data['surah_pendek']) . '</td>
                    <td></td>
                </tr>
                <tr>
                    <td>04</td>
                    <td>Hafalan Ayat Pilihan</td>
                    <td class="nilai-angka">' . htmlspecialchars($data['ayat_pilihan']) . '</td>
                    <td class="nilai-huruf">' . angkaKeHuruf($data['ayat_pilihan']) . '</td>
                    <td></td>
                </tr>
                <tr>
                    <td>05</td>
                    <td>Praktek Sholat</td>
                    <td class="nilai-angka">' . htmlspecialchars($data['sholat']) . '</td>
                    <td class="nilai-huruf">' . angkaKeHuruf($data['sholat']) . '</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- TTD -->
        <div class="ttd-container">
            <div class="tanggal">Surabaya, ' . formatTanggal($data['tanggal']) . '</div>
            <div class="mengetahui">Mengetahui,</div>
            <table class="ttd-table">
                <tr>
                    <td>Kepala Sekolah</td>
                    <td>Wali Kelas</td>
                </tr>
                <tr>
                    <td><img src="' . $base_url . '/assets/ttd.png" alt="TTD Kepala Sekolah"></td>
                    <td><img src="' . $base_url . '/assets/' . $ttd_wali_file . '" alt="TTD Wali Kelas"></td>
                </tr>
                <tr>
                    <td>( Nadiyatul Khoiriyah )</td>
                    <td>( ' . htmlspecialchars($data['wali_santri']) . ' )</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
';


// 8. Proses PDF
$dompdf->loadHtml($html);
$dompdf->render();

// 9. Output PDF
$dompdf->stream('rapot_' . $data['nama_santri'] . '.pdf', ['Attachment' => 0]);

// Untuk debugging (opsional)
// file_put_contents('debug.html', $html);
// echo "HTML telah disimpan ke debug.html";
?>