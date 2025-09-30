<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Pencapaian Ketuntasan Belajar</title>
    <style>
        /* Gaya untuk dicetak */
        @page {
            size: A4;
            margin: 10mm; /* Atur margin agar lebih rapi saat dicetak */
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            margin: 0;
            padding: 0;
            line-height: 1.5;
            color: #000;
        }

        .container {
            width: 190mm; /* Lebar A4 dikurangi margin */
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h3, .header h4 {
            margin: 0;
            padding: 0;
        }

        /* Data Siswa */
        .data-siswa {
            width: 100%;
            margin-bottom: 5px;
        }
        .data-siswa table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-siswa td:first-child {
            width: 25%;
            padding-right: 10px;
        }
        .data-siswa td:nth-child(2) {
            width: 5%;
        }

        /* Box F-1b - Dihilangkan atau disembunyikan jika tidak digunakan */
        .box-f1b {
            border: 1px solid #000;
            width: 40px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            font-size: 14pt;
            position: absolute;
            top: 80px; /* Sesuaikan posisi agar mirip gambar */
            right: 10mm;
        }

        /* Tabel Nilai */
        .tabel-nilai {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .tabel-nilai th, .tabel-nilai td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
            font-size: 10pt;
        }
        .tabel-nilai th {
            font-weight: bold;
            background-color: #f0f0f0; /* Opsional: memberikan sedikit latar belakang pada header */
        }
        .tabel-nilai .text-left {
            text-align: left;
            padding-left: 5px;
        }
        .tabel-nilai .footer-row td {
            font-weight: bold;
        }

        /* Keterangan Absensi */
        .keterangan-absensi {
            margin-top: 20px;
            font-size: 10pt;
        }
        .keterangan-absensi .kiri {
            float: left;
            width: 45%;
        }
        .keterangan-absensi .kanan {
            float: right;
            width: 50%;
        }
        .keterangan-absensi table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 10pt;
        }
        .keterangan-absensi table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .keterangan-absensi table td:nth-child(2) {
            width: 5%;
            text-align: center;
        }
        .keterangan-absensi table td:nth-child(3) {
            width: 15%;
            text-align: center;
        }

        /* Tanda Tangan */
        .tanda-tangan {
            margin-top: 30px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .tanda-tangan div {
            width: 45%;
        }
        .tanda-tangan .spacer {
            height: 60px; /* Ruang untuk tanda tangan */
        }

        /* Utility */
        .float-right { float: right; }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Box F-1b (Diletakkan di posisi absolute, pastikan dompdf menanganinya dengan baik) -->
        <!-- <div class="box-f1b float-right">
            F-1b
        </div> -->

        <div class="header">
            <h3>FORMAT PENCAPAIAN KETUNTASAN BELAJAR</h3>
            <h4>BERDASARKAN NILAI AKHIR (RAPOR)</h4>
            <h4>TAHUN PELAJARAN 2020/2021</h4>
        </div>

        <!-- Data Siswa dan Sekolah -->
        <div class="data-siswa">
            <table>
                <tr>
                    <td>SEMESTER</td>
                    <td>:</td>
                    <td>2 (Dua)</td>
                </tr>
                <tr>
                    <td>KELAS</td>
                    <td>:</td>
                    <td>VI (Enam)</td>
                </tr>
                <tr>
                    <td>SEKOLAH</td>
                    <td>:</td>
                    <td>SDN 1 SAGARA</td>
                </tr>
                <tr>
                    <td>KECAMATAN</td>
                    <td>:</td>
                    <td>CIBALONG</td>
                </tr>
                <tr>
                    <td>KABUPATEN</td>
                    <td>:</td>
                    <td>GARUT</td>
                </tr>
            </table>
        </div>

        <!-- Tabel Nilai Utama -->
        <table class="tabel-nilai">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%;">No. <br></th>
                    <th rowspan="2" style="width: 25%;">Mata Pelajaran <br></th>
                    <th colspan="4">Nilai Hasil Belajar</th>
                    <th rowspan="2" style="width: 15%;">Keterangan <br></th>
                </tr>
                <tr>
                    <th style="width: 8%;">Tugas <br></th>
                    <th style="width: 8%;">UTS <br></th>
                    <th style="width: 8%;">UAS <br></th>
                    <th style="width: 8%; font-weight: bold; background-color: #e0e0e0;">Nilai Akhir <br></th>
                </tr>
            </thead>
            <tbody>
                <!-- Data Mata Pelajaran (Diperbarui untuk 4 kolom nilai) -->
                <!-- Nilai Akhir (Kolom 6) saya isi sebagai placeholder '90' -->
                <tr><td>1</td><td class="text-left">Pendidikan Agama</td><td>76</td><td>82</td><td>100</td><td>90</td><td></td></tr>
                <tr><td>2</td><td class="text-left">Pendidikan Kewarganegaraan</td><td>74</td><td>81</td><td>100</td><td>89</td><td></td></tr>
                <tr><td>3</td><td class="text-left">Bahasa Indonesia</td><td>75</td><td>82</td><td>100</td><td>88</td><td></td></tr>
                <tr><td>4</td><td class="text-left">Matematika</td><td>71</td><td>77</td><td>100</td><td>85</td><td></td></tr>
                <tr><td>5</td><td class="text-left">Ilmu Pengetahuan Alam</td><td>74</td><td>80</td><td>100</td><td>86</td><td></td></tr>
                <tr><td>6</td><td class="text-left">Ilmu Pengetahuan Sosial</td><td>75</td><td>81</td><td>97</td><td>84</td><td></td></tr>
                <tr><td>7</td><td class="text-left">Seni Budaya & Keterampilan</td><td>77</td><td>82</td><td>97</td><td>87</td><td></td></tr>
                <tr><td>8</td><td class="text-left">Pend. Jasmani, OR, dan Kesehatan</td><td>76</td><td>81</td><td>97</td><td>88</td><td></td></tr>
                <tr style="font-weight: bold;"><td rowspan="3">9</td><td class="text-left">Muatan Lokal</td><td colspan="5"></td></tr>
                <tr><td class="text-left" style="padding-left: 20px; font-weight: normal;">a. Bahasa Sunda</td><td>76</td><td>81</td><td>97</td><td>85</td><td></td></tr>
                <tr><td class="text-left" style="padding-left: 20px; font-weight: normal;">b. Bahasa Inggris</td><td>75</td><td>78</td><td>97</td><td>83</td><td></td></tr>
                
                <!-- Baris Jumlah (Diperbarui untuk 4 kolom nilai) -->
                <tr class="footer-row">
                    <td colspan="2" class="text-left">Jumlah</td>
                    <td>749</td>
                    <td>805</td>
                    <td>984</td>
                    <td>953</td> <!-- Placeholder jumlah Nilai Akhir -->
                    <td></td>
                </tr>
                <!-- Baris Rata-rata (Diperbarui untuk 4 kolom nilai) -->
                <tr class="footer-row">
                    <td colspan="2" class="text-left">Rata-rata</td>
                    <td>75</td>
                    <td>81</td>
                    <td>98</td>
                    <td>87</td> <!-- Placeholder rata-rata Nilai Akhir -->
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        <!-- Keterangan Absensi (Struktur Baru) -->
        <div class="keterangan-absensi clearfix">
            <div class="kiri">
                <p><strong>Ketidakhadiran</strong></p>
                <table>
                    <tr>
                        <td>Izin</td>
                        <td>:</td>
                        <td>0 hari</td> <!-- Placeholder -->
                    </tr>
                    <tr>
                        <td>Sakit</td>
                        <td>:</td>
                        <td>0 hari</td> <!-- Placeholder -->
                    </tr>
                    <tr>
                        <td>Tanpa Keterangan (Alpha)</td>
                        <td>:</td>
                        <td>0 hari</td> <!-- Placeholder -->
                    </tr>
                </table>
            </div>

            <div class="kanan">
                <!-- Bagian Kanan dibiarkan kosong atau bisa diisi keterangan lain jika diperlukan -->
            </div>
        </div>

        <div class="clearfix"></div>

        <!-- Tanda Tangan -->
        <div class="tanda-tangan">
            <div style="text-align: left;">
                <p>Diketahui oleh</p>
                <p>Kepala Sekolah,</p>
                <div class="spacer"></div>
                <p>(.........................................................)</p>
            </div>
            <div style="text-align: right;">
                <p>Sagara, 25 Juni 2021</p>
                <p>Guru Kelas</p>
                <div class="spacer"></div>
                <p>(.........................................................)</p>
            </div>
        </div>
    </div>
</body>
</html>
