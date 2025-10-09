<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acara Sekolah - EduSys</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt w-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('pilihMapel')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-pen w-6 mr-3"></i>
                <span>Lihat Nilai</span>
            </a>
            <a href="{{ route('lihatAbsensi') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-list-check w-6 mr-3"></i>
                <span>Lihat Absensi</span>
            </a>
            <a href="{{ route('lihatAcaraSiswa')}}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-calendar-check mr-3"></i>
                <span>Acara</span>
            </a>
            <a href="{{ route('pilihMapelMateri') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-book-open w-6 mr-3"></i>
                <span>Lihat Materi</span>
            </a>
            <a href="{{ route('lihatPengumumanSiswa')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-bullhorn mr-3"></i>
                <span>Pengumuman</span>
            </a>
            <a href="{{ route('pilihMapelTugas') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-upload w-6 mr-3"></i>
                <span>Lihat Tugas</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full">
                    <i class="fa-solid fa-sign-out-alt w-6 mr-3"></i>
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
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Acara Sekolah</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=S" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            <header class="mb-8 bg-indigo-600 p-6 rounded-2xl shadow-lg text-white">
                <h1 class="text-2xl md:text-3xl font-bold">Kalender Acara Sekolah</h1>
                <p class="text-indigo-200 mt-2">Jangan lewatkan berbagai kegiatan menarik di sekolah!</p>
            </header>

            <!-- Acara Mendatang -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Acara Mendatang</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($daftarAcara as $acara)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="w-16 h-16 bg-indigo-100 text-indigo-600 flex flex-col items-center justify-center rounded-lg font-bold">
                                    <span class="text-2xl leading-none">{{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('d') }}</span>
                                    <span class="text-xs uppercase">{{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('M') }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $acara->judul_acara }}</h3>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('l, d F Y') }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-2"><i class="fa-solid fa-map-marker-alt mr-2 text-gray-400"></i>{{ $acara->lokasi }}</p>
                            <p class="text-sm text-gray-600"><i class="fa-solid fa-users mr-2 text-gray-400"></i>Peserta: {{ $acara->peserta }}</p>
                            @if($acara->deskripsi)
                            <p class="text-sm text-gray-600 mt-3 border-t pt-3">{{ $acara->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-md">
                        <i class="fa-solid fa-calendar-xmark text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 font-semibold text-lg">Tidak ada acara mendatang.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Acara Lampau -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Acara Lampau</h2>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <ul class="space-y-4">
                        @forelse($acaraLampau as $acara)
                        <li class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $acara->judul_acara }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('d F Y') }}</p>
                            </div>
                            <span class="text-sm font-medium text-gray-400">Selesai</span>
                        </li>
                        @empty
                        <li class="text-center py-4 text-gray-500">Tidak ada riwayat acara.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </main>
    </div>

    <script>
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });
    </script>
</body>
</html>
