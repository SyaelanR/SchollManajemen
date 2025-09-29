<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Absensi - EduSys</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-pen mr-3"></i>
                <span>Input Nilai</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
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
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Daftar Absensi</h1>
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
            <!-- Session Messages Handling -->
            @if(session('success'))
                <div id="session-success" data-message="{{ session('success') }}" class="hidden"></div>
            @endif

            <header class="mb-8 bg-indigo-600 p-6 rounded-2xl shadow-lg flex flex-wrap justify-between items-center text-white gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Daftar Absensi: {{$infoKelas->kelas->nama_kelas ?? 'N/A'}} - {{$infoMapel->nama_mapel ?? 'N/A'}}</h1>
                    <p class="text-indigo-200 mt-2">Pilih sesi absensi untuk diisi atau buat sesi baru.</p>
                </div>
                <a href="{{ route('manajAbsensi') }}" class="flex-shrink-0 inline-flex items-center bg-white text-indigo-600 hover:bg-gray-100 transition duration-300 px-4 py-2 rounded-lg shadow-md font-semibold">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    <span>Kembali</span>
                </a>
            </header>
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Sesi Absensi</h2>
                    <button id="add-task-btn" class="bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 flex items-center">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Sesi
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px] text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Keterangan</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Tanggal</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Kategori</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                        @forelse (($daftarAbsensi ?? []) as $absensi)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 font-medium text-gray-800">{{$absensi->keterangan}}</td>
                                <td class="p-3 text-gray-600">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</td>
                                <td class="p-3 text-gray-600">
                                    <span class="bg-gray-200 text-gray-800 font-medium py-1 px-3 rounded-full text-xs">{{$absensi->kategori}}</span>
                                </td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('inputAbsensi', [$absensi->id_kelas, $absensi->id_mapel, $absensi->id_daftar_absensi])}}" class="bg-indigo-100 text-indigo-700 font-semibold py-2 px-4 rounded-lg hover:bg-indigo-200 transition duration-300">Masuk</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">
                                    <div class="text-center py-12">
                                        <i class="fa-solid fa-folder-open text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada sesi absensi.</p>
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
</div>

<!-- Modal Tambah Absensi -->
<div id="task-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-gray-900 bg-opacity-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg transform transition-all duration-300 ease-in-out" id="modal-content">
        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Sesi Absensi</h2>
            <button id="close-task-modal-btn" class="text-gray-400 hover:text-gray-600 transition duration-300">
                <i class="fa-solid fa-times text-2xl"></i>
            </button>
        </div>
        <form id="task-form" action="{{route('storeAbsensiDaftar',[$infoKelas->kelas->id_kelas ?? 0, $infoMapel->id_mapel ?? 0])}}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="task-name" class="block text-gray-700 font-semibold mb-2">Keterangan Absensi</label>
                    <input type="text" name="keterangan_absen" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Pertemuan ke-1" required>
                </div>
                <div>
                    <label for="task-type-select" class="block text-gray-700 font-semibold mb-2">Kategori Absensi</label>
                    <select name="kategori_absen" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        <option value="KBM">KBM</option>
                        <option value="Setoran">Setoran</option>
                        <option value="Halaqah">Halaqah</option>
                        <option value="Daurah">Daurah</option>
                    </select>
                </div>
                <div>
                    <label for="task-due-date" class="block text-gray-700 font-semibold mb-2">Tanggal</label>
                    <input type="date" name="tanggal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>
            <div class="flex justify-end p-6 bg-gray-50 rounded-b-xl">
                <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan Sesi</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Sidebar Toggle ---
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (menuButton) {
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    }

    // --- Modal Logic ---
    const addTaskBtn = document.getElementById('add-task-btn');
    const taskModal = document.getElementById('task-modal');
    const modalContent = document.getElementById('modal-content');
    const closeTaskModalBtn = document.getElementById('close-task-modal-btn');
    const taskForm = document.getElementById('task-form');

    if (addTaskBtn) {
        const openModal = () => {
            taskModal.classList.remove('hidden');
            setTimeout(() => modalContent.classList.add('scale-100', 'opacity-100'), 10);
        }
        const closeModal = () => {
            setTimeout(() => taskModal.classList.add('hidden'), 300);
        }

        addTaskBtn.addEventListener('click', openModal);
        closeTaskModalBtn.addEventListener('click', closeModal);
        taskModal.addEventListener('click', (e) => {
            if (e.target === taskModal) {
                closeModal();
            }
        });

        // The form submission itself is handled by Laravel, no need to preventDefault unless using AJAX.
    }
    
    // --- SweetAlert2 Notifications ---
    const successMessage = document.getElementById('session-success');
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: successMessage.dataset.message,
            timer: 2500,
            showConfirmButton: false
        });
    }
});
</script>
</body>
</html>
