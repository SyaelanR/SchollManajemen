<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas - Sistem Manajemen Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">
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
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <div class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Daftar Tugas</h1>
        </header>

        <main class="p-6 md:p-8 flex-1">
            <div class="flex items-center mb-4">
                <a href="javascript:void(0)" onclick="history.back()" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition duration-300">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    <span class="font-semibold">Kembali</span>
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Tugas: {{$infoKelas->kelas->nama_kelas ?? 'N/A'}} - {{$infoMapel->nama_mapel ?? 'N/A'}}</h2>
                    <button id="add-task-btn" class="bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Tugas
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px] text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600">Keterangan</th>
                                <th class="p-3 font-semibold text-gray-600">Tanggal</th>
                                <th class="p-3 font-semibold text-gray-600">Deadline</th>
                                <th class="p-3 font-semibold text-gray-600 text-center">File</th>
                                <th class="p-3 font-semibold text-gray-600 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                        @forelse (($daftarTugas ?? []) as $tugas)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 font-medium text-gray-800">{{$tugas->keterangan}}</td>
                                <td class="p-3 text-gray-600">{{ \Carbon\Carbon::parse($tugas->created_at)->format('d M Y') }}</td>
                                <td class="p-3 text-gray-600">{{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}</td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('lihatSoalSiswa', [$tugas->nama_file])}}" class="text-indigo-600 hover:underline">Lihat File</a>
                                </td>
                                <td class="p-3 text-center">
                                    <div class="flex items-center justify-center space-x-4">
                                        <a href="#" class="text-blue-500 hover:text-blue-700" title="Edit">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                                <i class="fa-solid fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">
                                    <div class="text-center py-12">
                                        <i class="fa-solid fa-folder-open text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada daftar tugas.</p>
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

<div id="task-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-xl shadow-lg w-11/12 md:w-1/2 p-6 relative">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Tambah Tugas Baru</h2>
        <button id="close-task-modal-btn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition duration-300">
            <i class="fa-solid fa-times text-2xl"></i>
        </button>
        <form action="{{route('storeTugas',[$infoKelas->kelas->id_kelas ?? 0, $infoMapel->id_mapel ?? 0])}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="mb-4">
                <label for="task-name" class="block text-gray-700 font-semibold mb-2">Keterangan Tugas</label>
                <input type="text" id="task-name" name="keterangan_tugas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan Keterangan Tugas" required>
            </div>
            <div class="mb-4">
                <label for="task-type-select" class="block text-gray-700 font-semibold mb-2">File</label>
                <input type="file" id="task-file" name="file" class="w-full px-4 py-2" accept="application/pdf">
            </div>
            <div class="mb-4">
                <label for="task-due-date" class="block text-gray-700 font-semibold mb-2">Deadline</label>
                <input 
                    type="datetime-local" 
                    id="task-due-date" 
                    name="deadline" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    required
                >
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan Tugas</button>
            </div>
        </form>
    </div>
</div>

<script>
const menuButton = document.getElementById('menu-button');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const addTaskBtn = document.getElementById('add-task-btn');
const taskModal = document.getElementById('task-modal');
const closeTaskModalBtn = document.getElementById('close-task-modal-btn');
const taskForm = document.getElementById('task-form');

// Toggle sidebar
const toggleSidebar = () => { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); };
menuButton.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', toggleSidebar);

// Modal tambah tugas
addTaskBtn.addEventListener('click',()=>{taskModal.classList.remove('hidden');});
closeTaskModalBtn.addEventListener('click',()=>{taskModal.classList.add('hidden');});
// Hapus event listener submit form agar form bisa submit ke server
// taskForm.addEventListener('submit',(e)=>{
//     e.preventDefault();
//     taskModal.classList.add('hidden');
//     taskForm.reset();
// });
</script>
</body>
</html>
