<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Materi - Sistem Manajemen Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
        .modal { transition: opacity 0.3s ease-in-out; }
        .modal-content { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

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
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-list-check mr-3"></i>
                <span>Input Absensi</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-book-open-reader mr-3"></i>
                <span>Input Materi</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full text-left">
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
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Materi</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=G" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <main class="p-6 md:p-8 flex-1">
             <header class="mb-8 bg-indigo-600 p-6 rounded-2xl shadow-lg flex flex-wrap justify-between items-center text-white gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Daftar Materi: {{$infoJKA->kelas->nama_kelas ?? 'N/A'}} - {{$infoJKA->mapel->nama_mapel ?? 'N/A'}}</h1>
                    <p class="text-indigo-200 mt-2">Kelola semua materi yang telah diunggah.</p>
                </div>
                <a href="javascript:void(0)" onclick="history.back()" class="flex-shrink-0 inline-flex items-center bg-white text-indigo-600 hover:bg-gray-100 transition duration-300 px-4 py-2 rounded-lg shadow-md font-semibold">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    <span>Kembali</span>
                </a>
            </header>
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Semua Materi</h2>
                    <button id="add-task-btn" class="bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 flex items-center">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Materi
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px] text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Judul Materi</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Deskripsi</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Tanggal Unggah</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                        @forelse (($daftarMateri ?? []) as $materi)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 font-medium text-gray-800">{{$materi->judul_materi}}</td>
                                <td class="p-3 text-gray-600">{{$materi->deskripsi_materi}}</td>
                                <td class="p-3 text-gray-600">{{ \Carbon\Carbon::parse($materi->tanggal)->format('d M Y') }}</td>
                                <td class="p-3 text-center">
                                    <div class="flex items-center justify-center space-x-4">
                                        <a href="{{ route('lihatMateri', [$materi->nama_file])}}" class="text-blue-600 hover:text-blue-800" title="Lihat"><i class="fa-solid fa-eye"></i></a>                                        <button type="button" class="edit-materi-btn text-yellow-500 hover:text-yellow-700" title="Edit"
                                            data-id="{{ $materi->id_daftar_materi }}"
                                            data-judul="{{ $materi->judul_materi }}"
                                            data-deskripsi="{{ $materi->deskripsi_materi }}"
                                            data-file="{{ $materi->nama_file }}"
                                            data-url="{{ route('updateMateri', $materi->id_daftar_materi) }}"><i class="fa-solid fa-edit"></i></button>
                                        <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus"><i class="fa-solid fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">
                                    <div class="text-center py-12">
                                        <i class="fa-solid fa-folder-open text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada daftar materi.</p>
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

<div id="task-modal" class="modal fixed inset-0 z-[100] hidden flex items-center justify-center bg-gray-900 bg-opacity-50 p-4 opacity-0">
    <div class="modal-content bg-white rounded-xl shadow-lg w-full max-w-lg transform transition-all duration-300 ease-in-out scale-95">
        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Materi Baru</h2>
            <button id="close-task-modal-btn" class="text-gray-400 hover:text-gray-600 transition duration-300">
                <i class="fa-solid fa-times text-2xl"></i>
            </button>
        </div>
        <form action="{{route('storeMateri',[$infoJKA->id_kelas, $infoJKA->id_mapel])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="task-name" class="block text-gray-700 font-semibold mb-2">Judul Materi</label>
                    <input type="text" id="task-name" name="judul_materi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan Judul Materi" required>
                </div>
                 <div>
                    <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi_materi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan deskripsi singkat"></textarea>
                </div>
                <div>
                    <label for="task-file" class="block text-gray-700 font-semibold mb-2">File</label>
                    <input type="file" id="task-file" name="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="application/pdf">
                </div>
            </div>
            <div class="flex justify-end gap-4 p-6 bg-gray-50 rounded-b-xl">
                <button type="button" id="cancel-btn" class="bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan Materi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Materi -->
<div id="edit-materi-modal" class="modal fixed inset-0 z-[100] hidden flex items-center justify-center bg-gray-900 bg-opacity-50 opacity-0 p-4">
    <div class="modal-content bg-white rounded-xl shadow-lg w-full max-w-lg transform transition-all duration-300 ease-in-out scale-95">
        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Edit Materi</h2>
            <button id="close-edit-modal-btn" class="text-gray-400 hover:text-gray-600 transition duration-300">
                <i class="fa-solid fa-times text-2xl"></i>
            </button>
        </div>
        <form id="edit-materi-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <div>
                    <label for="edit-judul" class="block text-gray-700 font-semibold mb-2">Judul Materi</label>
                    <input type="text" id="edit-judul" name="judul_materi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label for="edit-deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                    <textarea id="edit-deskripsi" name="deskripsi_materi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
                <div>
                    <label for="edit-file" class="block text-gray-700 font-semibold mb-2">Upload File Baru (Opsional)</label>
                    <p id="current-file" class="text-sm text-gray-500 mb-2">File saat ini: <span class="font-medium text-indigo-600"></span></p>
                    <input type="file" id="edit-file" name="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="application/pdf">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah file.</p>
                </div>
            </div>
            <div class="flex justify-end p-6 bg-gray-50 rounded-b-xl space-x-4">
                <button type="button" id="cancel-edit-btn" class="bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Sidebar
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebar = () => { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); };
    menuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Modal
    const addTaskBtn = document.getElementById('add-task-btn');
    const taskModal = document.getElementById('task-modal');
    const modalContent = taskModal.querySelector('.modal-content');
    const closeTaskModalBtn = document.getElementById('close-task-modal-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    const openModal = () => {
        taskModal.classList.remove('hidden');
        setTimeout(() => {
            taskModal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    };

    const closeModal = () => {
        modalContent.classList.add('scale-95');
        taskModal.classList.add('opacity-0');
        setTimeout(() => taskModal.classList.add('hidden'), 300);
    };

    addTaskBtn.addEventListener('click', openModal);
    closeTaskModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    taskModal.addEventListener('click', (e) => {
        if (e.target === taskModal) closeModal();
    });

    // Modal Edit Materi
    const editMateriModal = document.getElementById('edit-materi-modal');
    if (editMateriModal) {
        const editModalContent = editMateriModal.querySelector('.modal-content');
        const closeEditModalBtn = document.getElementById('close-edit-modal-btn');
        const cancelEditBtn = document.getElementById('cancel-edit-btn');
        const editMateriBtns = document.querySelectorAll('.edit-materi-btn');
        const editForm = document.getElementById('edit-materi-form');

        const openEditModal = (judul, deskripsi, file, url) => {
            editForm.action = url;
            editForm.querySelector('#edit-judul').value = judul;
            editForm.querySelector('#edit-deskripsi').value = deskripsi;
            editForm.querySelector('#current-file span').textContent = file;

            editMateriModal.classList.remove('hidden');
            setTimeout(() => {
                editMateriModal.classList.remove('opacity-0');
                editModalContent.classList.remove('scale-95');
            }, 10);
        };

        const closeEditModal = () => {
            editModalContent.classList.add('scale-95');
            editMateriModal.classList.add('opacity-0');
            setTimeout(() => editMateriModal.classList.add('hidden'), 300);
        };

        editMateriBtns.forEach(btn => btn.addEventListener('click', () => openEditModal(btn.dataset.judul, btn.dataset.deskripsi, btn.dataset.file, btn.dataset.url)));
        closeEditModalBtn.addEventListener('click', closeEditModal);
        cancelEditBtn.addEventListener('click', closeEditModal);
        editMateriModal.addEventListener('click', (e) => {
            if (e.target === editMateriModal) closeEditModal();
        });
    }
});
</script>
</body>
</html>
