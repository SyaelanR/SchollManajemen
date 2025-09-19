<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas - Sistem Manajemen Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Custom styles */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar */
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
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        /* Modal transition */
        .modal {
            transition: opacity 0.3s ease-in-out;
        }
        .modal-content {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
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
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Daftar Kelas</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                    <span>Jadwal Pelajaran</span>
                </a>
                 <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-exclamation-triangle w-6 h-6 mr-3"></i>
                    <span>Pelanggaran</span>
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
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Daftar Kelas</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User Avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 md:p-8 flex-1">
                @if (session('success'))
                    <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex justify-between items-center" role="alert">
                        <div>
                            <p class="font-bold">Berhasil!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                        <button onclick="document.getElementById('success-alert').style.display='none'">&times;</button>
                    </div>
                @endif

                {{-- Menampilkan error validasi --}}
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                        <p class="font-bold">Gagal!</p>
                        <ul class="list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Daftar Kelas Tersedia</h2>
                        <button id="add-class-btn" class="w-full md:w-auto bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center justify-center whitespace-nowrap">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Tambah Kelas
                        </button>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
                        <input type="text" placeholder="Cari nama kelas..." class="w-full md:flex-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <select class="w-full md:w-auto p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                            <option value="">Semua Angkatan</option>
                            @forelse ($angkatans as $angkatan)
                                <option value="{{$angkatan->angkatan}}">{{$angkatan->angkatan}}</option>
                            @empty
                                <option value="" disabled selected>Belum ada</option>
                            @endforelse
                        </select>
                    </div>
                    @if (count($kelasList) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($kelasList as $kelas)
                        <!-- Class Card -->
                        <div class="bg-gray-50 rounded-xl shadow-md p-6 relative hover:shadow-lg transition duration-300 group">
                             <!-- Delete Button -->
                            <button type="button" class="delete-btn absolute top-4 right-4 text-gray-400 hover:text-red-600 transition z-10 opacity-0 group-hover:opacity-100" data-id="{{$kelas->id_kelas}}" data-name="{{$kelas->nama_kelas}}">
                                <i class="fa-solid fa-trash-alt"></i>
                            </button>
                            
                            <!-- Form for Viewing Class -->
                            <form id="view-class-form-{{$kelas->id_kelas}}" action="{{route('lihatKelas')}}" method="POST" class="hidden">
                                 @csrf
                                 <input type="hidden" name="id_kelas" value="{{$kelas->id_kelas}}">
                            </form>
                            
                            <!-- Clickable Area -->
                            <a href="#" onclick="event.preventDefault(); document.getElementById('view-class-form-{{$kelas->id_kelas}}').submit();" class="block">
                                <div class="flex items-center mb-4">
                                    <div class="bg-blue-100 text-blue-600 p-4 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-school text-2xl"></i>
                                    </div>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">{{$kelas->nama_kelas}}</h3>
                                <div class="flex items-center text-gray-600 mt-4">
                                    <i class="fa-solid fa-magnifying-glass text-sm mr-2"></i>
                                    <span class="text-sm">{{$kelas->jurusan}}</span>
                                </div>
                                <div class="flex items-center text-gray-600 mt-2">
                                    <i class="fa-solid fa-user-tie text-sm mr-2"></i>
                                    <span class="text-sm">{{$kelas->wali_kelas}}</span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <i class="fa-solid fa-box-open text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 font-semibold text-lg">Belum ada data kelas.</p>
                        <p class="text-gray-500 mt-2">Silakan tambahkan kelas baru untuk memulai</p>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Add/Edit Class Modal -->
    <div id="class-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
        <div class="modal-content bg-white rounded-xl shadow-2xl p-6 md:p-8 w-11/12 md:w-2/3 lg:w-1/2 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800">Tambah Kelas Baru</h3>
                <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <form id="class-form" action="{{route('storeKelas')}}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="class-name" class="block text-gray-700 font-medium mb-2">Nama Kelas</label>
                    <input type="text" id="class-name" name="nama_kelas" placeholder="Contoh: 10 IPA 1" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="wali-kelas" class="block text-gray-700 font-medium mb-2">Wali Kelas</label>
                    <input type="text" id="wali-kelas" name="wali_kelas" placeholder="Contoh: Budi Setiawan, S.Pd." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="jurusan" class="block text-gray-700 font-medium mb-2">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan" placeholder="Contoh: Teknik Informatika" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-6">
                    <label for="class-year" class="block text-gray-700 font-medium mb-2">Angkatan</label>
                    <select name="id_angkatan" id="class-year" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                        <option value="" disabled selected>Pilih Angkatan</option>
                        @forelse ($angkatans as $angkatan)
                            <option value="{{$angkatan->id_angkatan}}">{{$angkatan->angkatan}}</option>
                        @empty
                            <option value="" disabled>Belum ada angkatan</option>
                        @endforelse
                    </select>
                </div>
                <div class="flex flex-col sm:flex-row justify-end gap-4">
                    <button type="button" id="cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
        <div class="modal-content bg-white rounded-xl shadow-2xl p-6 md:p-8 w-11/12 md:max-w-md transform transition-transform duration-300 scale-95">
            <div class="text-center">
                <i class="fa-solid fa-triangle-exclamation text-5xl text-red-500 mb-4"></i>
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus kelas <strong id="delete-class-name" class="font-bold"></strong>?</p>
            </div>
            <!-- NOTE: The action URL will be set dynamically by JavaScript -->
            <form id="delete-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <button type="button" id="cancel-delete-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition duration-300">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Sidebar Toggle Functionality ---
            const menuButton = document.getElementById('menu-button');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            };

            if (menuButton) menuButton.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);

            // --- Add/Edit Modal Functionality ---
            const classModal = document.getElementById('class-modal');
            const addClassBtn = document.getElementById('add-class-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const cancelBtn = document.getElementById('cancel-btn');

            const openModal = (modalEl) => {
                if (!modalEl) return;
                const modalContent = modalEl.querySelector('.modal-content');
                modalEl.classList.remove('hidden');
                setTimeout(() => {
                    modalEl.classList.remove('opacity-0');
                    if (modalContent) modalContent.classList.remove('scale-95');
                }, 10);
            };

            const closeModal = (modalEl) => {
                if (!modalEl) return;
                const modalContent = modalEl.querySelector('.modal-content');
                modalEl.classList.add('opacity-0');
                if (modalContent) modalContent.classList.add('scale-95');
                setTimeout(() => {
                    modalEl.classList.add('hidden');
                }, 300);
            };

            if (addClassBtn) addClassBtn.addEventListener('click', () => openModal(classModal));
            if (closeModalBtn) closeModalBtn.addEventListener('click', () => closeModal(classModal));
            if (cancelBtn) cancelBtn.addEventListener('click', () => closeModal(classModal));
            if (classModal) classModal.addEventListener('click', (event) => {
                if (event.target === classModal) closeModal(classModal);
            });

            // --- Delete Modal Functionality ---
            const deleteModal = document.getElementById('delete-modal');
            const deleteForm = document.getElementById('delete-form');
            const deleteClassName = document.getElementById('delete-class-name');
            const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
            const deleteBtns = document.querySelectorAll('.delete-btn');

            deleteBtns.forEach(btn => {
                btn.addEventListener('click', (event) => {
                    // Stop the click from triggering the card's link
                    event.stopPropagation(); 
                    
                    const classId = btn.dataset.id;
                    const className = btn.dataset.name;
                    
                    // Set the class name in the confirmation message
                    if(deleteClassName) deleteClassName.textContent = className;
                    
                    // Dynamically set the form action URL. 
                    // Assumes your delete route is something like '/kelas/{id}'
                    if(deleteForm) deleteForm.action = `{{ url('kelas') }}/${classId}`;
                    
                    openModal(deleteModal);
                });
            });

            if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', () => closeModal(deleteModal));
            if (deleteModal) deleteModal.addEventListener('click', (event) => {
                if (event.target === deleteModal) closeModal(deleteModal);
            });
            
            // --- Auto-hide success alert ---
            const successAlert = document.getElementById('success-alert');
            if(successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.style.display = 'none', 500);
                }, 5000); // Hide after 5 seconds
            }
        });
    </script>
</body>
</html>
