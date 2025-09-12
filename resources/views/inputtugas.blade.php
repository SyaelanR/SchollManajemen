<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Tugas - Sistem Manajemen Sekolah</title>
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
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
        
                <a href="{{ route('inputtugas.index') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Input Nilai</span>
                </a>

                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-list-check mr-3"></i>
                    <span>Input Absensi</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-puzzle-piece mr-3"></i>
                    <span>Ekstrakulikuler</span>
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
        <div class="absolute bottom-0 w-full p-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Input Tugas</h1>
        </header>

        <main class="p-6 md:p-8 flex-1">
            <div class="flex items-center mb-4">
                <a href="javascript:void(0)" onclick="history.back()" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition duration-300">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    <span class="font-semibold">Kembali</span>
                </a>
            </div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Semua Tugas</h2>
                <button id="add-task-btn" class="bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Tugas
                </button>
            </div>

            <div id="assignment-details-container" class="bg-white p-6 rounded-xl shadow-md min-h-[300px]">
                <div class="text-center p-4 text-gray-500">
                    <p>Daftar tugas akan muncul di sini.</p>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Tambah Tugas -->
<div id="task-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-xl shadow-lg w-11/12 md:w-1/2 p-6 relative">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Form Tambah Tugas Baru</h2>
        <button id="close-task-modal-btn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition duration-300">
            <i class="fa-solid fa-times text-2xl"></i>
        </button>
        <form id="task-form">
            <div class="mb-4">
                <label for="task-name" class="block text-gray-700 font-semibold mb-2">Nama Tugas</label>
                <input type="text" id="task-name" name="task-name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan nama tugas" required>
            </div>
            <div class="mb-4">
                <label for="task-type-select" class="block text-gray-700 font-semibold mb-2">Kelas</label>
                <select id="task-type-select" name="task-type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="10A">Kelas 10A</option>
                    <option value="10B">Kelas 10B</option>
                    <option value="11A">Kelas 11A</option>
                    <option value="11B">Kelas 11B</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="task-due-date" class="block text-gray-700 font-semibold mb-2">Tanggal</label>
                <input type="date" id="task-due-date" name="task-due-date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
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
const detailsContainer = document.getElementById('assignment-details-container');
const taskModal = document.getElementById('task-modal');
const closeTaskModalBtn = document.getElementById('close-task-modal-btn');
const taskForm = document.getElementById('task-form');

// Mock data tugas
let mockTasks = [
    { id: 'pr1', name: 'Latihan Soal Matematika', dueDate: '25 Nov 2025', kelas: '10A' },
    { id: 'pr2', name: 'Esai Bahasa Indonesia', dueDate: '27 Nov 2025', kelas: '10B' },
    { id: 'uts1', name: 'Ulangan Fisika', dueDate: '01 Des 2025', kelas: '11A' },
    { id: 'uts2', name: 'Ulangan Kimia', dueDate: '03 Des 2025', kelas: '11B' }
];

// Toggle sidebar
const toggleSidebar = () => { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); };
menuButton.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', toggleSidebar);

// Render tugas
const renderAllTasks = () => {
    if(mockTasks.length===0){
        detailsContainer.innerHTML='<div class="text-center p-4 text-gray-500"><p>Belum ada tugas.</p></div>';
        return;
    }
    let html=`<div class="grid grid-cols-4 gap-4 bg-gray-200 text-gray-700 font-semibold p-4 rounded-xl shadow-sm">
        <div class="col-span-2">Nama Tugas</div>
        <div class="col-span-1">Tanggal</div>
        <div class="col-span-1">Aksi</div>
    </div><div class="mt-4 space-y-3">`;
    mockTasks.forEach(task=>{
        html+=`
        <div class="task-row grid grid-cols-4 gap-4 items-center p-4 bg-gray-100 rounded-xl shadow-sm hover:bg-gray-200 transition-colors">
            <div class="col-span-2 font-medium text-gray-800">${task.name}</div>
            <div class="col-span-1 text-gray-600">${task.dueDate}</div>
            <div class="col-span-1">
                <a href="/input-nilai/kelas/${task.kelas}/input-nilai" class="bg-indigo-600 text-white font-semibold py-1 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Masuk</a>
            </div>
        </div>`;
    });
    html+='</div>';
    detailsContainer.innerHTML=html;
}
renderAllTasks();

// Modal tambah tugas
addTaskBtn.addEventListener('click',()=>{taskModal.classList.remove('hidden');});
closeTaskModalBtn.addEventListener('click',()=>{taskModal.classList.add('hidden');});
taskForm.addEventListener('submit',(e)=>{
    e.preventDefault();
    const name=document.getElementById('task-name').value;
    const dueDate=document.getElementById('task-due-date').value;
    const kelas=document.getElementById('task-type-select').value;
    mockTasks.push({id:'t'+(mockTasks.length+1), name, dueDate, kelas});
    renderAllTasks();
    taskModal.classList.add('hidden');
    taskForm.reset();
});
</script>
</body>
</html>
