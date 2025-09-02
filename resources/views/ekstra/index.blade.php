<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler - EduSys</title>
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
        <nav class="mt-6">
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                <i class="fa-solid fa-baseball-bat-ball w-6 h-6 mr-3"></i>
                <span>Ekstrakurikuler</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                <span>Keuangan</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Ekstrakurikuler</h1>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <main class="p-6 md:p-8 flex-1">
            <!-- Control Panel -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-4 flex flex-col md:flex-row items-center justify-between">
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <input type="text" id="search-input" placeholder="Cari ekstrakurikuler..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-300">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <select id="filter-select" class="w-full md:w-48 py-2 px-4 rounded-lg border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-300">
                        <option value="all">Semua Kategori</option>
                        <option value="olahraga">Olahraga</option>
                        <option value="seni">Seni</option>
                        <option value="sains">Sains</option>
                        <option value="bahasa">Bahasa</option>
                    </select>
                </div>
                <button id="add-button" class="mt-4 md:mt-0 bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 w-full md:w-auto">
                    <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Ekstrakurikuler
                </button>
            </div>

            <!-- Keterangan Warna Kategori -->
            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="flex items-center gap-1"><span class="w-4 h-4 bg-green-500 rounded-full"></span> Olahraga</div>
                <div class="flex items-center gap-1"><span class="w-4 h-4 bg-purple-500 rounded-full"></span> Seni</div>
                <div class="flex items-center gap-1"><span class="w-4 h-4 bg-blue-500 rounded-full"></span> Sains</div>
                <div class="flex items-center gap-1"><span class="w-4 h-4 bg-red-500 rounded-full"></span> Bahasa</div>
            </div>

            <!-- Extracurricular List -->
            <div id="extracurricular-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($extracurriculars as $e)
                <div class="bg-white p-6 rounded-xl shadow-md flex flex-col justify-between transition-transform duration-300 hover:scale-105">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800">{{ $e->name }}</h3>
                            @php
                                $iconClass='fa-solid fa-star';
                                $categoryColor='text-gray-500';
                                switch($e->category){
                                    case 'olahraga': $iconClass='fa-solid fa-volleyball'; $categoryColor='text-green-500'; break;
                                    case 'seni': $iconClass='fa-solid fa-palette'; $categoryColor='text-purple-500'; break;
                                    case 'sains': $iconClass='fa-solid fa-atom'; $categoryColor='text-blue-500'; break;
                                    case 'bahasa': $iconClass='fa-solid fa-language'; $categoryColor='text-red-500'; break;
                                }
                            @endphp
                            <i class="{{ $iconClass }} text-2xl {{ $categoryColor }}"></i>
                        </div>
                        <p class="text-sm text-gray-500 mb-2 font-medium">{{ ucfirst($e->category) }}</p>
                        <p class="text-gray-600 mb-4 text-sm">{{ $e->description }}</p>
                        <div class="space-y-2 text-sm text-gray-700">
                            <p><i class="fa-solid fa-user-tie text-indigo-500 w-5 mr-2"></i> {{ $e->instructor }}</p>
                            <p><i class="fa-solid fa-clock text-indigo-500 w-5 mr-2"></i> {{ $e->schedule }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2 mt-4">
                        <form action="{{ route('ekstra.destroy', $e->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex-1 py-2 px-4 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600 transition duration-300"><i class="fa-solid fa-trash-alt mr-2"></i> Hapus</button>
                        </form>
                        <button onclick="editEkstra({{ $e->id }})" class="flex-1 py-2 px-4 rounded-lg bg-teal-500 text-white font-semibold hover:bg-teal-600 transition duration-300"><i class="fa-solid fa-edit mr-2"></i> Edit</button>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-[100] hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform transition-transform duration-300 scale-95 md:scale-100">
        <h2 id="modal-title" class="text-2xl font-bold text-gray-800 mb-6">Tambah Ekstrakurikuler Baru</h2>
        <form id="extracurricular-form" class="space-y-4" method="POST">
            @csrf
            <input type="hidden" id="ekstra-id" name="ekstra_id">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Ekstrakurikuler</label>
                <input type="text" id="name" name="name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="category" name="category" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih Kategori</option>
                    <option value="olahraga">Olahraga</option>
                    <option value="seni">Seni</option>
                    <option value="sains">Sains</option>
                    <option value="bahasa">Bahasa</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" rows="3" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
            <div>
                <label for="instructor" class="block text-sm font-medium text-gray-700">Pembimbing</label>
                <input type="text" id="instructor" name="instructor" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="schedule" class="block text-sm font-medium text-gray-700">Jadwal</label>
                <input type="text" id="schedule" name="schedule" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" id="close-modal" class="py-2 px-4 rounded-lg text-gray-600 bg-gray-200 hover:bg-gray-300 transition duration-300 font-semibold">Batal</button>
                <button type="submit" id="submit-button" class="py-2 px-4 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
const menuButton = document.getElementById('menu-button');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const addExtracurricularButton = document.getElementById('add-button');
const modal = document.getElementById('modal');
const closeModalButton = document.getElementById('close-modal');
const form = document.getElementById('extracurricular-form');
const modalTitle = document.getElementById('modal-title');
const ekstraIdInput = document.getElementById('ekstra-id');
const submitButton = document.getElementById('submit-button');

const toggleSidebar = () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
};

const openModal = (data=null) => {
    modal.classList.remove('hidden');
    if(data){
        modalTitle.textContent = "Edit Ekstrakurikuler";
        submitButton.textContent = "Update";
        ekstraIdInput.value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('category').value = data.category;
        document.getElementById('description').value = data.description;
        document.getElementById('instructor').value = data.instructor;
        document.getElementById('schedule').value = data.schedule;
        form.action = "/ekstra/update/"+data.id;
    } else {
        modalTitle.textContent = "Tambah Ekstrakurikuler Baru";
        submitButton.textContent = "Simpan";
        form.reset();
        form.action = "{{ route('ekstra.store') }}";
    }
};

const closeModal = () => {
    modal.classList.add('hidden');
    form.reset();
};

const editEkstra = (id) => {
    fetch(`/ekstra/${id}`)
        .then(res => res.json())
        .then(data => openModal(data));
};

menuButton.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', toggleSidebar);
addExtracurricularButton.addEventListener('click', ()=>openModal());
closeModalButton.addEventListener('click', closeModal);
</script>

</body>
</html>
