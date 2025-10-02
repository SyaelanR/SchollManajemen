<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Manajemen Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Custom styles */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        /* Sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>

            @can('view-admin')
            <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-user-graduate mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="{{ route('manajemenGuru') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-chalkboard-user mr-3"></i>
                <span>Manajemen Guru</span>
            </a>
            <a href="{{ route('manajemenMapel') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-book mr-3"></i>
                <span>Manajemen Mapel</span>
            </a>
            <a href="{{ route('manajemenKelas') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-door-closed mr-3"></i>
                <span>Manajemen Kelas</span>
            </a>
            <a href="{{ route('manajemenJadwal')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-calendar-alt mr-3"></i>
                <span>Manajemen Jadwal</span>
            </a>
            <a href="{{ route('manajAcara')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-calendar-check mr-3"></i>
                <span>Acara</span>
            </a>
            <a href="{{ route('manajemenAngkatan') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-bookmark mr-3"></i>
                <span>Angkatan</span>
            </a>
            <a href="{{ route('manajemenRapor') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-book-open mr-3"></i>
                <span>Rapor</span>
            </a>
            <a href="{{ route('manajemenKurikulum') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-book-open-reader mr-3"></i>
                <span>Kurikulum</span>
            </a>
            <a href="{{ route('manajemenTingkat') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-layer-group mr-3"></i>
                <span>Tingkat</span>
            </a>
            @endcan

            @can('view-guru')
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-pen mr-3"></i>
                <span>Input Nilai</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-list-check mr-3"></i>
                <span>Input Absensi</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-puzzle-piece mr-3"></i>
                <span>Ekstrakulikuler</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-circle-exclamation mr-3"></i>
                <span>Pelanggaran Siswa</span>
            </a>
            @endcan

            @can('view-siswa')
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-pen mr-3"></i>
                <span>Lihat Nilai</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-list-check mr-3"></i>
                <span>Lihat Absensi</span>
            </a>
            @endcan

            @can('view-adminDev')
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-users mr-3"></i>
                <span>Manajemen Klien</span>
            </a>
            @endcan
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full">
                    <i class="fa-solid fa-sign-out-alt mr-3"></i>
                    <span>Logout</span>
                </a>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <!-- Mobile Menu Button -->
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Selamat Datang</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            <!-- Welcome Banner -->
            <div class="bg-indigo-600 rounded-xl shadow-lg p-8 mb-8 text-white">
                <h2 class="text-3xl font-bold mb-2">{{$username}}</h2>
                <p class="text-indigo-200">{{$time}}</p>
            </div>

            @can('view-admin')
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total Siswa</p>
                        <p class="text-3xl font-bold text-gray-800">1,250</p>
                    </div>
                    <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full">
                        <i class="fa-solid fa-user-graduate text-2xl"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total Guru</p>
                        <p class="text-3xl font-bold text-gray-800">75</p>
                    </div>
                    <div class="bg-teal-100 text-teal-600 p-4 rounded-full">
                        <i class="fa-solid fa-chalkboard-user text-2xl"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Kelas</p>
                        <p class="text-3xl font-bold text-gray-800">30</p>
                    </div>
                    <div class="bg-orange-100 text-orange-600 p-4 rounded-full">
                        <i class="fa-solid fa-school-flag text-2xl"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Acara Mendatang</p>
                        <p class="text-3xl font-bold text-gray-800">5</p>
                    </div>
                    <div class="bg-pink-100 text-pink-600 p-4 rounded-full">
                        <i class="fa-solid fa-calendar-check text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Main Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Students Overview -->
                <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Ringkasan Kehadiran Siswa</h3>
                    <p class="text-gray-500 mb-6">Data kehadiran untuk minggu ini.</p>
                    <div class="h-64 rounded-lg">
                        <canvas id="attendanceChartAdmin"></canvas>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Akses Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('manajemenSiswa')}}" class="flex items-center p-3 bg-indigo-50 hover:bg-indigo-100 rounded-lg text-indigo-700 font-medium transition duration-300"><i class="fa-solid fa-plus-circle mr-3"></i> Tambah Siswa Baru</a></li>
                        <li><a href="#" class="flex items-center p-3 bg-teal-50 hover:bg-teal-100 rounded-lg text-teal-700 font-medium transition duration-300"><i class="fa-solid fa-file-invoice mr-3"></i> Buat Tagihan SPP</a></li>
                        <li><a href="#" class="flex items-center p-3 bg-pink-50 hover:bg-pink-100 rounded-lg text-pink-700 font-medium transition duration-300"><i class="fa-solid fa-calendar-plus mr-3"></i> Tambah Acara Sekolah</a></li>
                    </ul>
                </div>
            </div>
            @endcan

            @can('view-guru')
                {{-- GURU --}}
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-md flex items-center space-x-4">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fa-solid fa-calendar-day text-2xl text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Jadwal Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-800">{{$jumlahSesi}} Sesi</p>
                        </div>
                    </div>
                </div>

                <!-- Main Grid Layout -->
                <div class="grid grid-cols-1 gap-8">
                    <!-- Left Column: Schedule -->
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Jadwal Mengajar Hari Ini</h3>
                        <div class="space-y-4">
                            <!-- Schedule Item -->
                            @forelse ($jadwalHariIni as $jadwal)
                            <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                                <div class="w-20 text-center mr-4">
                                    <p class="font-bold text-green-600 text-lg">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                                </div>
                                <div class="border-l-4 border-green-500 pl-4 flex-1">
                                    <p class="font-semibold text-gray-800">{{$jadwal->mapel->nama_mapel}}</p>
                                    <p class="text-sm text-gray-600"><i class="fa-solid fa-users mr-2"></i>{{$jadwal->kelas->nama_kelas}}&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-house mr-1"></i> {{$jadwal->ruangan}}</p>
                                </div>
                            </div>
                             @empty
                            <div class="text-center text-gray-500 py-10">
                                <i class="fa-solid fa-calendar-xmark text-4xl mb-4"></i>
                                <p class="text-lg">Tidak ada jadwal mengajar hari ini.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Shortcuts -->
                     <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Pintasan</h3>
                        <div class="space-y-3">
                           <a href="{{ route('lihatjadwalG') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                               <i class="fa-solid fa-calendar-alt text-xl text-indigo-600 mr-4"></i>
                               <span class="font-medium text-gray-700">Lihat Semua Jadwal</span>
                           </a>
                           <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                               <i class="fa-solid fa-pen-to-square text-xl text-green-600 mr-4"></i>
                               <span class="font-medium text-gray-700">Input Nilai Siswa</span>
                           </a>
                           <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                               <i class="fa-solid fa-calendar-check text-xl text-yellow-600 mr-4"></i>
                               <span class="font-medium text-gray-700">Input Absensi Kelas</span>
                           </a>
                        </div>
                    </div>
                </div>
                @endcan


            @can('view-siswa')
            {{-- SISWA --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Kolom Kiri: Jadwal & Keuangan -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Jadwal Pelajaran -->
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Jadwal Pelajaran Hari Ini</h3>
                        <div class="h-[500px] overflow-y-auto pr-2">
                            {{-- Ganti dengan @forelse ($jadwals as $jadwal) di aplikasi Laravel Anda --}}

                            {{-- Tampilan jika jadwal kosong --}}
                            @forelse ($jadwalHariIni as $jadwal)
                            <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                                <div class="w-20 text-center mr-4">
                                    <p class="font-bold text-green-600 text-lg">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                                </div>
                                <div class="border-l-4 border-green-500 pl-4 flex-1">
                                    <p class="font-semibold text-gray-800">{{$jadwal->mapel->nama_mapel}}</p>
                                    <p class="text-sm text-gray-600"><i class="fa-solid fa-user mr-2"></i>{{$jadwal->mapel->guru->name}}&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-house mr-1"></i> {{$jadwal->ruangan}}</p>
                                </div>
                            </div>
                             @empty
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center text-gray-400">
                                    <i class="fa-solid fa-calendar-check text-4xl mb-2"></i>
                                    <p class="font-medium">Tidak ada jadwal pelajaran hari ini.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Kolom Kanan: Kehadiran & Tagihan -->
                <div class="space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Persentase Kehadiran</h3>
                        <div class="w-full h-48 flex items-center justify-center">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                     <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Tagihan</h3>
                        <div class="h-[180px] overflow-y-auto ">
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-3 pr-2">SPP Bulan September</td>
                                        <td class="py-3 text-right"><span class="bg-red-100 text-red-700 font-medium py-1 px-3 rounded-full text-xs">Belum Lunas</span></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 pr-2">Uang Buku Paket</td>
                                        <td class="py-3 text-right"><span class="bg-green-100 text-green-700 font-medium py-1 px-3 rounded-full text-xs">Lunas</span></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 pr-2">Uang Buku Paket</td>
                                        <td class="py-3 text-right"><span class="bg-green-100 text-green-700 font-medium py-1 px-3 rounded-full text-xs">Lunas</span></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 pr-2">Uang Buku Paket</td>
                                        <td class="py-3 text-right"><span class="bg-green-100 text-green-700 font-medium py-1 px-3 rounded-full text-xs">Lunas</span></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 pr-2">Uang Buku Paket</td>
                                        <td class="py-3 text-right"><span class="bg-green-100 text-green-700 font-medium py-1 px-3 rounded-full text-xs">Lunas</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- === KARTU PENGUMUMAN DAN ACARA DIMULAI DI SINI === -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card Pengumuman -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Pengumuman Terbaru</h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        <!-- Item Pengumuman 1 -->
                        <div class="border-l-4 border-orange-400 pl-4 py-2">
                            <h4 class="font-semibold text-gray-900">Tugas Makalah Sejarah</h4>
                            <p class="text-sm text-gray-600 line-clamp-2">Harap kumpulkan makalah tentang Kerajaan Majapahit paling lambat tanggal 15 Oktober. Detail format penulisan...</p>
                            <span class="text-xs text-gray-400">2 hari yang lalu</span>
                        </div>
                        <!-- Item Pengumuman 2 -->
                        <div class="border-l-4 border-blue-400 pl-4 py-2">
                            <h4 class="font-semibold text-gray-900">UTS Matematika</h4>
                            <p class="text-sm text-gray-600 line-clamp-2">UTS Matematika akan dilaksanakan pada hari Senin, 6 Oktober 2025. Materi mencakup Bab 1 sampai Bab 3...</p>
                            <span class="text-xs text-gray-400">3 hari yang lalu</span>
                        </div>
                    </div>
                </div>

                <!-- Card Acara Sekolah -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Acara Sekolah</h3>
                         <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        <!-- Item Acara 1 -->
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-red-100 text-red-600 flex flex-col items-center justify-center rounded-lg font-bold">
                                <span class="text-2xl leading-none">17</span>
                                <span class="text-xs uppercase">OKT</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Lomba Cerdas Cermat</h4>
                                <p class="text-sm text-gray-600"><i class="fa-solid fa-clock mr-1"></i> 08:00 - Selesai</p>
                                <p class="text-sm text-gray-600"><i class="fa-solid fa-map-marker-alt mr-1"></i> Aula Sekolah</p>
                            </div>
                        </div>
                         <!-- Item Acara 2 -->
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-green-100 text-green-600 flex flex-col items-center justify-center rounded-lg font-bold">
                                <span class="text-2xl leading-none">25</span>
                                <span class="text-xs uppercase">OKT</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Class Meeting</h4>
                                <p class="text-sm text-gray-600"><i class="fa-solid fa-clock mr-1"></i> 09:00 - Selesai</p>
                                <p class="text-sm text-gray-600"><i class="fa-solid fa-map-marker-alt mr-1"></i> Lapangan Olahraga</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- === KARTU PENGUMUMAN DAN ACARA BERAKHIR DI SINI === -->

            @endcan

            @can('view-adminDev')
            {{-- ADMINDEV --}}
            <div class="flex flex-col md:flex-row items-center justify-between mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between w-full md:w-auto mb-4 md:mb-0">
                    <div>
                        <p class="text-gray-500">Total Klien</p>
                        <p class="text-3xl font-bold text-gray-800">125</p>
                    </div>
                    <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full">
                        <i class="fa-solid fa-users text-2xl"></i>
                    </div>
                </div>
                <a href="{{ route('tambahKlien') }}">
                    <button class="bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 w-full md:w-auto">
                        <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Klien
                    </button>
                </a>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-semibold mb-6 text-gray-800">Daftar Klien</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Klien</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Sekolah</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($cliens as $clien)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$clien->id_sekolah}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$clien->nama_sekolah}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$clien->email}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($clien->status == 'Aktif')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    @elseif ($clien->status == 'Pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif ($clien->status == 'Non-Aktif')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Non Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('infoKlien')}}" method="POST">
                                        @csrf
                                        <a href="{{ route('infoKlien')}}" class="text-indigo-600 hover:text-indigo-900 mr-2" onclick="event.preventDefault(); this.closest('form').submit();">Info</a>
                                        <select name="id_sekolah" class="hidden">
                                            <option value="{{$clien->id_sekolah}}"></option>
                                        </select>
                                    </form>
                                    <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">
                                    <div class="text-center py-12">
                                        <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada data Klien.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endcan

        </main>
    </div>
</div>

<script>
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    const toggleSidebar = () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    };

    menuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    document.addEventListener('DOMContentLoaded', () => {
        // Chart for Siswa
        if (document.getElementById('attendanceChart')) {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Izin', 'Sakit', 'Alpa'],
                    datasets: [{
                        label: 'Persentase Kehadiran',
                        data: [70, 10, 10, 10], // Sample data
                        backgroundColor: ['rgba(79, 70, 229, 0.8)', 'rgba(251, 191, 36, 0.8)', 'rgba(59, 130, 246, 0.8)', 'rgba(239, 68, 68, 0.8)'],
                        borderColor: ['#4f46e5', '#fbb_f24', '#3b82f6', '#ef4444'],
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }
        
        // Chart for Admin
        if (document.getElementById('attendanceChartAdmin')) {
             const ctxAdmin = document.getElementById('attendanceChartAdmin').getContext('2d');
            new Chart(ctxAdmin, {
                type: 'bar', // Bar chart for admin
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                    datasets: [{
                        label: 'Kehadiran (%)',
                        data: [95, 92, 98, 96, 94], // Sample data
                        backgroundColor: 'rgba(79, 70, 229, 0.8)',
                        borderColor: '#4f46e5',
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }
    });
</script>

</body>
</html>