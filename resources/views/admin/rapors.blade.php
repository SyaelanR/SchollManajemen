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

        .page-break {
            page-break-after: always;
            clear: both;
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
{{-- <body onload="window.print()"> --}}
<body>
    @foreach ($processedRapors as $index => $data)
        <div class="container">
            <div class="header">
                <h3>FORMAT PENCAPAIAN KETUNTASAN BELAJAR</h3>
                <h4>BERDASARKAN NILAI AKHIR (RAPOR)</h4>
                <h4>TAHUN PELAJARAN {{ $kelasInfo->angkatan->angkatan ?? 'N/A' }}</h4>
            </div>

            <!-- Data Siswa dan Sekolah -->
            <div class="data-siswa">
                <table>
                    <tr>
                        <td>NAMA SISWA</td>
                        <td>:</td>
                        <td><strong>{{ strtoupper($data['siswa']->name) }}</strong></td>
                        <td style="width: 20%;">NISN</td>
                        <td>:</td>
                        <td>{{ $data['siswa']->nisn_nik }}</td>
                    </tr>
                    <tr>
                        <td>KELAS</td>
                        <td>:</td>
                        <td>{{ $kelasInfo->nama_kelas }}</td>
                        <td>SEMESTER</td>
                        <td>:</td>
                        <td>{{ ucfirst($kelasInfo->angkatan->semester ?? 'N/A') }}</td>
                    </tr>
                    <tr>
                        <td>SEKOLAH</td>
                        <td>:</td>
                        <td colspan="4">{{$kelasInfo->angkatan->sekolah->nama_sekolah}}</td> {{-- Ganti dengan data sekolah dinamis jika ada --}}
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
                    @php
                        $totalTugas = 0;
                        $totalUTS = 0;
                        $totalUAS = 0;
                        $totalNilaiAkhir = 0;
                        $mapelCount = $data['rapor']->count();
                    @endphp

                    @forelse ($data['rapor'] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $item['mapel']->nama_mapel ?? 'N/A' }}</td>
                            <td>{{ $item['scores']['Tugas'] ?? '-' }}</td>
                            <td>{{ $item['scores']['UTS'] ?? '-' }}</td>
                            <td>{{ $item['scores']['UAS'] ?? '-' }}</td>
                            <td>{{ $item['scores']['Nilai Akhir'] ?? '-' }}</td>
                            <td>{{ ($item['scores']['Nilai Akhir'] ?? 0) >= 75 ? 'Tuntas' : 'Belum Tuntas' }}</td>
                        </tr>
                        @php
                            $totalTugas += $item['scores']['Tugas'] ?? 0;
                            $totalUTS += $item['scores']['UTS'] ?? 0;
                            $totalUAS += $item['scores']['UAS'] ?? 0;
                            $totalNilaiAkhir += $item['scores']['Nilai Akhir'] ?? 0;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="7">Tidak ada data nilai untuk ditampilkan.</td>
                        </tr>
                    @endforelse

                    <!-- Baris Jumlah -->
                    <tr class="footer-row">
                        <td colspan="2" class="text-left">Jumlah</td>
                        <td>{{ $totalTugas }}</td>
                        <td>{{ $totalUTS }}</td>
                        <td>{{ $totalUAS }}</td>
                        <td>{{ $totalNilaiAkhir }}</td>
                        <td></td>
                    </tr>
                    <!-- Baris Rata-rata -->
                    <tr class="footer-row">
                        <td colspan="2" class="text-left">Rata-rata</td>
                        <td>{{ $mapelCount > 0 ? round($totalTugas / $mapelCount) : 0 }}</td>
                        <td>{{ $mapelCount > 0 ? round($totalUTS / $mapelCount) : 0 }}</td>
                        <td>{{ $mapelCount > 0 ? round($totalUAS / $mapelCount) : 0 }}</td>
                        <td>{{ $mapelCount > 0 ? round($totalNilaiAkhir / $mapelCount) : 0 }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <!-- Keterangan Absensi -->
            <div class="keterangan-absensi clearfix">
                <div class="kiri">
                    <p><strong>Ketidakhadiran</strong></p>
                    <table>
                        <tr><td>Izin</td><td>:</td><td>{{ $data['absensi']['Izin'] ?? 0 }} hari</td></tr>
                        <tr><td>Sakit</td><td>:</td><td>{{ $data['absensi']['Sakit'] ?? 0 }} hari</td></tr>
                        <tr><td>Tanpa Keterangan (Alpha)</td><td>:</td><td>{{ $data['absensi']['Alpha'] ?? 0 }} hari</td></tr>
                    </table>
                </div>
            </div>

            <div class="clearfix"></div>

            <!-- Tanda Tangan -->
            <div class="tanda-tangan">
                <div style="text-align: left;">
                    <p>Mengetahui,</p>
                    <p>Orang Tua/Wali</p>
                    <div class="spacer"></div>
                    <p>(................................)</p>
                </div>
                <div style="text-align: right;">
                    <p>{{$kelasInfo->angkatan->sekolah->alamat}}, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
                    <p>Wali Kelas</p>
                    <div class="spacer"></div>
                    <p><strong>{{ $kelasInfo->wali_kelas ?? '(................................)' }}</strong></p>
                </div>
            </div>
        </div>

        {{-- Jangan tambahkan page-break setelah item terakhir --}}
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
