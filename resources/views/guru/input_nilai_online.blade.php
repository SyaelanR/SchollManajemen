<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai - EduSys</title>
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
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>
    
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-pen mr-3"></i>
                <span>Input Nilai</span>
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                <i class="fa-solid fa-list-check mr-3"></i>
                <span>Input Absensi</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full text-left">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i><span>Logout</span>
                </button>
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
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Input Nilai Siswa</h1>
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
            <header class="mb-8">
                <a href="javascript:void(0)" onclick="history.back()" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition duration-300 mb-4">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    <span class="font-semibold">Kembali</span>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Input Nilai: <span class="text-indigo-600">{{ $infoMapel->nama_mapel ?? 'Mapel' }} - Kelas {{ $infoKelas->kelas->nama_kelas ?? 'Kelas' }}</span></h1>
                <h1 class="text-2xl font-bold text-gray-900"> <span class="text-indigo-600">{{$infoDaftarNilai->keterangan ?? 'Keterangan Nilai' }}</span></h1>
                <p class="text-gray-500 mt-2">Silakan input nilai untuk siswa yang belum dinilai.</p>
            </header>
            
            <!-- Siswa Belum Dinilai -->
            <div class="bg-white p-6 rounded-2xl shadow-xl mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center"><i class="fa-solid fa-pencil-alt text-yellow-500 mr-3"></i>Siswa Belum Dinilai</h2>
                <form action="{{ route('storeNilaiSiswa') }}" method="POST" id="form-belum-dinilai">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Nama Siswa</th>
                                    <th class="border px-4 py-2">NISN</th>
                                    <th class="border px-4 py-2 text-center">File Tugas</th>
                                    <th class="border px-4 py-2">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse (($daftarSiswa ?? []) as $nilai)
                            @if ($nilai->nilai == '0')
                                <tr class="text-center hover:bg-gray-50">
                                    <td class="border px-4 py-2 text-left">{{$nilai->siswa->name}}</td>
                                    <td class="border px-4 py-2">{{$nilai->siswa->nisn_nik}}</td>
                                    <td class="border px-4 py-2 text-center">
                                        @if ($nilai->nama_fileTugas == null)
                                        <p class="text-yellow-600 hover:underline">Belum Mengmpulkan</p>
                                        @elseif ($nilai->nama_fileTugas != null)
                                        <a href="{{ route('lihatTugasSiswa', [$nilai->nama_fileTugas])}}" class="text-blue-600 hover:underline">Lihat File</a>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2"><input type="number" name="nilai[{{ $nilai->id_daftar_nilai_siswa }}]" min="0" max="100" class="w-20 text-center px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"></td>
                                </tr>
                            @endif
                            @empty
                            <tr class="text-center">
                                <td colspan="4" class="border px-4 py-2 text-center">
                                    <div class="text-center py-12">
                                        <i class="fa-solid fa-folder-open text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada siswa yang perlu dinilai.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Siswa Sudah Dinilai -->
            <div class="bg-white p-6 rounded-2xl shadow-xl">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center"><i class="fa-solid fa-check-circle text-green-500 mr-3"></i>Siswa Sudah Dinilai</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border px-4 py-2 text-left">Nama Siswa</th>
                                <th class="border px-4 py-2">NISN</th>
                                <th class="border px-4 py-2 text-center">File Tugas</th>
                                <th class="border px-4 py-2 text-center">Nilai</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (($daftarSiswa ?? []) as $nilai)
                            @if ($nilai->nilai != '0')
                            <tr class="text-center hover:bg-gray-50">
                                <td class="border px-4 py-2 text-left">{{$nilai->siswa->name}}</td>
                                <td class="border px-4 py-2">{{$nilai->siswa->nisn_nik}}</td>
                                <td class="border px-4 py-2 text-center">
                                    @if ($nilai->nama_fileTugas == null)
                                    <a href="#" class="text-blue-600 hover:underline">Belum Mengmpulkan</a>
                                    @elseif ($nilai->nama_fileTugas != null)
                                    <a href="{{ route('lihatTugasSiswa', [$nilai->nama_fileTugas])}}" class="text-blue-600 hover:underline">Lihat File</a>
                                    @endif
                                </td>
                                <td class="border px-4 py-2 font-semibold">{{$nilai->nilai}}</td>
                                <td class="border px-4 py-2">
                                    <button class="text-blue-600 hover:text-blue-800" title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr class="text-center">
                                <td colspan="5" class="border px-4 py-2 text-center">
                                    <div class="text-center py-12">
                                        <i class="fa-solid fa-folder-open text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada siswa yang sudah dinilai.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse   
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // DOM Elements
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        // Functions
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Event Listeners
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>
    @livewireScripts
</body>
</html>

