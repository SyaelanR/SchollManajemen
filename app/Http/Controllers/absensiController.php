<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Tampilkan daftar kelas untuk memilih input absensi
     */
    public function daftarKelas()
    {
        // Data dummy daftar kelas
        $classes = [
            (object)['id' => '10A', 'nama' => 'Kelas 10A', 'jumlah_siswa' => 30],
            (object)['id' => '10B', 'nama' => 'Kelas 10B', 'jumlah_siswa' => 28],
            (object)['id' => '11A', 'nama' => 'Kelas 11A', 'jumlah_siswa' => 29],
            (object)['id' => '11B', 'nama' => 'Kelas 11B', 'jumlah_siswa' => 25],
            (object)['id' => '12A', 'nama' => 'Kelas 12A', 'jumlah_siswa' => 27],
            (object)['id' => '12B', 'nama' => 'Kelas 12B', 'jumlah_siswa' => 35],
        ];

        // kirim ke view: resources/views/absensi/daftar.blade.php
        return view('absensi.daftar', compact('classes'));
    }

    /**
     * Form input absensi per kelas
     * @param string $kelas contoh: 10A
     */
    public function inputAbsen($kelas)
    {
        /**
         * Data dummy siswa dikelompokkan per kelas
         * agar saat pilih 10A hanya siswa 10A yang tampil
         */
        $allStudents = [
    '10A' => [
        ['id' => 101, 'nama' => 'Aisyah Putri'],
        ['id' => 102, 'nama' => 'Bagus Saputra'],
        ['id' => 103, 'nama' => 'Citra Anggraini'],
        ['id' => 104, 'nama' => 'Dedi Firmansyah'],
        ['id' => 105, 'nama' => 'Eka Rahmawati'],
        ['id' => 106, 'nama' => 'Farhan Alif'],
        ['id' => 107, 'nama' => 'Gina Rosalia'],
        ['id' => 108, 'nama' => 'Hari Santoso'],
        ['id' => 109, 'nama' => 'Indah Wulandari'],
        ['id' => 110, 'nama' => 'Joko Prasetyo'],
        ['id' => 111, 'nama' => 'Kiki Sari'],
        ['id' => 112, 'nama' => 'Lutfi Maulana'],
        ['id' => 113, 'nama' => 'Maya Fitri'],
        ['id' => 114, 'nama' => 'Nanda Pratama'],
        ['id' => 115, 'nama' => 'Oki Saputro'],
        ['id' => 116, 'nama' => 'Putri Ayu'],
        ['id' => 117, 'nama' => 'Qori Rahmah'],
        ['id' => 118, 'nama' => 'Rendi Kurniawan'],
        ['id' => 119, 'nama' => 'Salsa Amelia'],
        ['id' => 120, 'nama' => 'Tio Mahendra'],
        ['id' => 121, 'nama' => 'Umar Zaki'],
        ['id' => 122, 'nama' => 'Vina Lestari'],
        ['id' => 123, 'nama' => 'Wahyu Firmansyah'],
        ['id' => 124, 'nama' => 'Xenia Ratna'],
        ['id' => 125, 'nama' => 'Yoga Pratama'],
        ['id' => 126, 'nama' => 'Zahra Putri'],
        ['id' => 127, 'nama' => 'Agus Salim'],
        ['id' => 128, 'nama' => 'Bella Anggun'],
        ['id' => 129, 'nama' => 'Chandra Wijaya'],
        ['id' => 130, 'nama' => 'Dian Novita'],
    ],
    '10B' => [
        ['id' => 201, 'nama' => 'Aulia Rahman'],
        ['id' => 202, 'nama' => 'Bima Sakti'],
        ['id' => 203, 'nama' => 'Clara Maharani'],
        ['id' => 204, 'nama' => 'Danu Permana'],
        ['id' => 205, 'nama' => 'Evan Satrio'],
        ['id' => 206, 'nama' => 'Fahri Ramadhan'],
        ['id' => 207, 'nama' => 'Gita Puspita'],
        ['id' => 208, 'nama' => 'Hana Amelia'],
        ['id' => 209, 'nama' => 'Indra Prakoso'],
        ['id' => 210, 'nama' => 'Jihan Kartika'],
        ['id' => 211, 'nama' => 'Kurnia Adit'],
        ['id' => 212, 'nama' => 'Lia Hartati'],
        ['id' => 213, 'nama' => 'Mega Rahayu'],
        ['id' => 214, 'nama' => 'Niko Prasetya'],
        ['id' => 215, 'nama' => 'Omar Suryana'],
        ['id' => 216, 'nama' => 'Poppy Anggraeni'],
        ['id' => 217, 'nama' => 'Qomarudin'],
        ['id' => 218, 'nama' => 'Rina Setiawan'],
        ['id' => 219, 'nama' => 'Sigit Kurnia'],
        ['id' => 220, 'nama' => 'Tina Marlina'],
        ['id' => 221, 'nama' => 'Uci Rahmadani'],
        ['id' => 222, 'nama' => 'Vino Alamsyah'],
        ['id' => 223, 'nama' => 'Wulan Astuti'],
        ['id' => 224, 'nama' => 'Xaverius Dimas'],
        ['id' => 225, 'nama' => 'Yulia Pertiwi'],
        ['id' => 226, 'nama' => 'Zaki Nur'],
        ['id' => 227, 'nama' => 'Anita Lestari'],
        ['id' => 228, 'nama' => 'Bobby Sanjaya'],
    ],
    '11A' => [
        // 29 siswa
        // id mulai 301 dst
        ['id' => 301, 'nama' => 'Abdul Rahim'],
        ['id' => 302, 'nama' => 'Bella Prameswari'],
        ['id' => 303, 'nama' => 'Cahyo Adi'],
        ['id' => 304, 'nama' => 'Dewi Ayuning'],
        ['id' => 305, 'nama' => 'Edo Prakoso'],
        ['id' => 306, 'nama' => 'Fika Nurjanah'],
        ['id' => 307, 'nama' => 'Galih Setia'],
        ['id' => 308, 'nama' => 'Helmi Fadillah'],
        ['id' => 309, 'nama' => 'Intan Sari'],
        ['id' => 310, 'nama' => 'Januar Putra'],
        ['id' => 311, 'nama' => 'Kania Wulandari'],
        ['id' => 312, 'nama' => 'Luthfi Rahman'],
        ['id' => 313, 'nama' => 'Mega Lestari'],
        ['id' => 314, 'nama' => 'Naufal Rizky'],
        ['id' => 315, 'nama' => 'Olivia Arif'],
        ['id' => 316, 'nama' => 'Pramudya Ari'],
        ['id' => 317, 'nama' => 'Qisya Rahma'],
        ['id' => 318, 'nama' => 'Rendra Saputra'],
        ['id' => 319, 'nama' => 'Sari Indah'],
        ['id' => 320, 'nama' => 'Taufik Hidayat'],
        ['id' => 321, 'nama' => 'Uli Fatimah'],
        ['id' => 322, 'nama' => 'Vivi Anggraeni'],
        ['id' => 323, 'nama' => 'Wildan Pratama'],
        ['id' => 324, 'nama' => 'Xena Rahmadani'],
        ['id' => 325, 'nama' => 'Yanto Suprapto'],
        ['id' => 326, 'nama' => 'Zahra Anggun'],
        ['id' => 327, 'nama' => 'Andrean Fikri'],
        ['id' => 328, 'nama' => 'Berlian Putra'],
        ['id' => 329, 'nama' => 'Chika Maharani'],
    ],
    '11B' => [
        // 25 siswa
        ['id' => 401, 'nama' => 'Ananda Putri'],
        ['id' => 402, 'nama' => 'Bahrul Ilmi'],
        ['id' => 403, 'nama' => 'Cici Marlina'],
        ['id' => 404, 'nama' => 'Dicky Fathur'],
        ['id' => 405, 'nama' => 'Eka Salsabila'],
        ['id' => 406, 'nama' => 'Faris Dwi'],
        ['id' => 407, 'nama' => 'Gilang Prakoso'],
        ['id' => 408, 'nama' => 'Hilda Ayu'],
        ['id' => 409, 'nama' => 'Iqbal Maulana'],
        ['id' => 410, 'nama' => 'Jihan Amelia'],
        ['id' => 411, 'nama' => 'Kevin Nugraha'],
        ['id' => 412, 'nama' => 'Lia Fitria'],
        ['id' => 413, 'nama' => 'Miko Ramadhan'],
        ['id' => 414, 'nama' => 'Nabila Prameswari'],
        ['id' => 415, 'nama' => 'Omar Fadli'],
        ['id' => 416, 'nama' => 'Putra Arya'],
        ['id' => 417, 'nama' => 'Qian Rahma'],
        ['id' => 418, 'nama' => 'Rika Amalia'],
        ['id' => 419, 'nama' => 'Sofyan Hadi'],
        ['id' => 420, 'nama' => 'Tasya Lestari'],
        ['id' => 421, 'nama' => 'Umar Hilmi'],
        ['id' => 422, 'nama' => 'Vanya Putri'],
        ['id' => 423, 'nama' => 'Wilda Rani'],
        ['id' => 424, 'nama' => 'Xaverius Bintang'],
        ['id' => 425, 'nama' => 'Yoga Ari'],
    ],
    '12A' => [
        // 27 siswa
        ['id' => 501, 'nama' => 'Adi Saputra'],
        ['id' => 502, 'nama' => 'Bella Lestari'],
        ['id' => 503, 'nama' => 'Cahya Permana'],
        ['id' => 504, 'nama' => 'Diana Pertiwi'],
        ['id' => 505, 'nama' => 'Eko Prasetyo'],
        ['id' => 506, 'nama' => 'Fanny Nuraini'],
        ['id' => 507, 'nama' => 'Galang Seto'],
        ['id' => 508, 'nama' => 'Hani Rahmawati'],
        ['id' => 509, 'nama' => 'Irfan Hidayat'],
        ['id' => 510, 'nama' => 'Jasmine Alia'],
        ['id' => 511, 'nama' => 'Kirana Putri'],
        ['id' => 512, 'nama' => 'Lukman Hakim'],
        ['id' => 513, 'nama' => 'Mega Andini'],
        ['id' => 514, 'nama' => 'Nando Prayoga'],
        ['id' => 515, 'nama' => 'Oni Rahmat'],
        ['id' => 516, 'nama' => 'Putu Satria'],
        ['id' => 517, 'nama' => 'Qina Salsabila'],
        ['id' => 518, 'nama' => 'Rani Wulan'],
        ['id' => 519, 'nama' => 'Sandi Nugroho'],
        ['id' => 520, 'nama' => 'Tina Rosiana'],
        ['id' => 521, 'nama' => 'Uci Fadilah'],
        ['id' => 522, 'nama' => 'Vino Hartanto'],
        ['id' => 523, 'nama' => 'Wira Putra'],
        ['id' => 524, 'nama' => 'Xenia Dewi'],
        ['id' => 525, 'nama' => 'Yudha Fikri'],
        ['id' => 526, 'nama' => 'Zara Amelia'],
        ['id' => 527, 'nama' => 'Andre Saputra'],
    ],
    '12B' => [
        // 35 siswa
        ['id' => 601, 'nama' => 'Aditia Pratama'],
        ['id' => 602, 'nama' => 'Bella Anjani'],
        ['id' => 603, 'nama' => 'Cindy Maharani'],
        ['id' => 604, 'nama' => 'Dicky Ramadhan'],
        ['id' => 605, 'nama' => 'Evi Rahmadani'],
        ['id' => 606, 'nama' => 'Fauzan Hilmi'],
        ['id' => 607, 'nama' => 'Galuh Prameswari'],
        ['id' => 608, 'nama' => 'Hafidz Prakoso'],
        ['id' => 609, 'nama' => 'Indira Sari'],
        ['id' => 610, 'nama' => 'Jefri Hidayat'],
        ['id' => 611, 'nama' => 'Kiki Nuraini'],
        ['id' => 612, 'nama' => 'Lina Saputri'],
        ['id' => 613, 'nama' => 'Mamat Rahman'],
        ['id' => 614, 'nama' => 'Nia Anggraeni'],
        ['id' => 615, 'nama' => 'Oka Wira'],
        ['id' => 616, 'nama' => 'Pipit Amelia'],
        ['id' => 617, 'nama' => 'Qomarudin'],
        ['id' => 618, 'nama' => 'Randy Prasetyo'],
        ['id' => 619, 'nama' => 'Salsabila Putri'],
        ['id' => 620, 'nama' => 'Tio Fadillah'],
        ['id' => 621, 'nama' => 'Uli Purnama'],
        ['id' => 622, 'nama' => 'Vina Anggraini'],
        ['id' => 623, 'nama' => 'Wahyu Ramadhan'],
        ['id' => 624, 'nama' => 'Xaverius Rama'],
        ['id' => 625, 'nama' => 'Yuni Kartika'],
        ['id' => 626, 'nama' => 'Zidan Prasetya'],
        ['id' => 627, 'nama' => 'Agus Wicaksono'],
        ['id' => 628, 'nama' => 'Berlian Arif'],
        ['id' => 629, 'nama' => 'Chandra Putra'],
        ['id' => 630, 'nama' => 'Dewi Fitria'],
        ['id' => 631, 'nama' => 'Eko Santoso'],
        ['id' => 632, 'nama' => 'Fika Novia'],
        ['id' => 633, 'nama' => 'Gilang Ramadhan'],
        ['id' => 634, 'nama' => 'Helmi Putra'],
        ['id' => 635, 'nama' => 'Intan Maharani'],
    ],
];


        // ambil siswa sesuai kelas yg dipilih, default array kosong bila tidak ada
        $students = $allStudents[$kelas] ?? [];

        // kirim ke view: resources/views/absensi/input.blade.php
        return view('absensi.input', compact('students', 'kelas'));
    }

    /**
     * Simpan absensi
     */
    public function store(Request $request, $kelas)
    {
        $validated = $request->validate([
            'status' => 'required|array',
            'status.*' => 'required|in:Hadir,Sakit,Izin,Alfa',
        ]);

        $tanggal = Carbon::now()->toDateString();

        // Map status ke array data absensi lengkap (dummy)
        $result = collect($validated['status'])->map(function ($status, $siswaId) use ($kelas, $tanggal) {
            return [
                'siswa_id' => $siswaId,
                'kelas'    => $kelas,
                'tanggal'  => $tanggal,
                'status'   => $status,
            ];
        })->values();

        // 🔹 Kembali ke halaman daftar kelas dengan flash message
        return redirect()
            ->route('absensi.daftar')
            ->with('success', "Absensi kelas {$kelas} berhasil disimpan (dummy)!");
    }
}
