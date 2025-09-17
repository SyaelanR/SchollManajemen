<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Angkatan - Sistem Manajemen Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- SweetAlert2 untuk notifikasi dan konfirmasi hapus --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom styles */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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
        /* Modal transition */
        .modal {
            transition: opacity 0.3s ease-in-out;
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
                    <i class="fa-solid fa-layer-group w-6 h-6 mr-3"></i>
                    <span>Manajemen Angkatan</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Guru</span>
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Angkatan</h1>
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
                {{-- Menampilkan pesan sukses dari session --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                {{-- Menampilkan error validasi --}}
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                        <p class="font-bold">Gagal!</p>
                        <ul class="list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <!-- Action Bar -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Angkatan</h2>
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <div class="relative w-full md:w-64">
                                <input type="text" placeholder="Cari tahun ajaran..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <button id="add-angkatan-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Tambah Angkatan
                            </button>
                        </div>
                    </div>

                    <!-- School Year Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px] text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-600">Tahun Ajaran</th>
                                    <th class="p-3 font-semibold text-gray-600">Semester</th>
                                    <th class="p-3 font-semibold text-gray-600">Tanggal mulai</th>
                                    <th class="p-3 font-semibold text-gray-600">Tanggal selesai</th>
                                    <th class="p-3 font-semibold text-gray-600">Tingkat</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                {{-- Loop untuk menampilkan data dari database --}}
                                @forelse ($angkatans as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 text-gray-800 font-medium">{{ $item->angkatan }}</td>
                                        <td class="p-3 text-gray-700">{{$item->semester}}</td>
                                        <td class="p-3 text-gray-700">{{$item->tanggal_mulai}}</td>
                                        <td class="p-3 text-gray-700">{{$item->tanggal_selesai}}</td>
                                        <td class="p-3 text-gray-700">{{$item->tingkat}}</td>
                                        <td class="p-3 text-center">
                                            <div class="flex justify-center space-x-3">
                                                {{-- Tombol Edit dengan data attributes untuk di-pass ke JS --}}
                                                <button class="text-blue-600 hover:text-blue-800 edit-btn" title="Edit"
                                                    data-id="{{ $item->id_angkatan }}"
                                                    data-angkatan="{{ $item->angkatan }}"
                                                    data-id-tingkat="{{ $item->id_tingkat }}"
                                                    data-tanggal-mulai="{{ $item->tanggal_mulai }}"
                                                    data-tanggal-selesai="{{ $item->tanggal_selesai }}">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </button>
                                                {{-- Form untuk Hapus --}}
                                                <form action="{{ route('destroyAngkatan', $item->id_angkatan) }}" method="POST" class="inline-block delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Pesan jika tidak ada data --}}
                                    <tr>
                                        <td colspan="6" class="p-3 text-center text-gray-500">
                                            <div class="text-center py-12">
                                                <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                                <p class="text-gray-600 font-semibold text-lg">Belum ada data Angkatan.</p>
                                                <p class="text-gray-500 mt-2">Silakan tambahkan Angkatan baru</p>
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

    <!-- Add Modal -->
    <div id="add-angkatan-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-1/2 lg:w-1/3 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Tambah Angkatan Baru</h3>
                <button id="add-close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <form id="add-angkatan-form" action="{{ route('storeAngkatan') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="angkatan" class="block text-gray-700 font-medium mb-2">Tahun Ajaran</label>
                    <input type="text" id="angkatan" name="angkatan" placeholder="Contoh: 2026/2027" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required value="{{ old('angkatan') }}">
                </div>
                 <div class="mb-4">
                    <label for="tingkat" class="block text-gray-700 font-medium mb-2">Tingkat</label>
                    <select id="tingkat" name="id_tingkat" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                        <option value="" disabled selected>Pilih Tingkat</option>
                        @forelse ($tingkats as $tingkat)
                            <option value="{{ $tingkat->id_tingkat }}" {{ old('id_tingkat') == $tingkat->id_tingkat ? 'selected' : '' }}>
                                {{ $tingkat->tingkat }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada data tingkat</option>
                        @endforelse
                    </select>
                </div>
                <div class="mb-4">
                    <label for="tanggal_mulai" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required value="{{ old('tanggal_mulai') }}">
                </div>
                <div class="mb-4">
                    <label for="tanggal_selesai" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required value="{{ old('tanggal_selesai') }}">
                </div>
                
                <div class="flex justify-end gap-4">
                    <button type="button" id="add-cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="edit-angkatan-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-1/2 lg:w-1/3 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h3 id="edit-modal-title" class="text-2xl font-semibold text-gray-800">Edit Angkatan</h3>
                <button id="edit-close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <form id="edit-angkatan-form" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_angkatan" class="block text-gray-700 font-medium mb-2">Tahun Ajaran</label>
                    <input type="text" id="edit_angkatan" name="angkatan" placeholder="Contoh: 2026/2027" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                 <div class="mb-4">
                    <label for="edit_tingkat" class="block text-gray-700 font-medium mb-2">Tingkat</label>
                    <select id="edit_tingkat" name="id_tingkat" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                        <option value="" disabled>Pilih Tingkat</option>
                        @forelse ($tingkats as $tingkat)
                            <option value="{{ $tingkat->id_tingkat }}">
                                {{ $tingkat->tingkat }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada data tingkat</option>
                        @endforelse
                    </select>
                </div>
                <div class="mb-4">
                    <label for="edit_tanggal_mulai" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                    <input type="date" id="edit_tanggal_mulai" name="tanggal_mulai" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="edit_tanggal_selesai" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                    <input type="date" id="edit_tanggal_selesai" name="tanggal_selesai" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                
                <div class="flex justify-end gap-4">
                    <button type="button" id="edit-cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Update</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Sidebar Toggle Functionality ---
            const menuButton = document.getElementById('menu-button');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            };

            menuButton.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // --- Add Modal Elements ---
            const addAngkatanModal = document.getElementById('add-angkatan-modal');
            const addModalContent = addAngkatanModal.querySelector('div > div');
            const addAngkatanBtn = document.getElementById('add-angkatan-btn');
            const addCloseModalBtn = document.getElementById('add-close-modal-btn');
            const addCancelBtn = document.getElementById('add-cancel-btn');
            const addAngkatanForm = document.getElementById('add-angkatan-form');
            
            // --- Edit Modal Elements ---
            const editAngkatanModal = document.getElementById('edit-angkatan-modal');
            const editModalContent = editAngkatanModal.querySelector('div > div');
            const editCloseModalBtn = document.getElementById('edit-close-modal-btn');
            const editCancelBtn = document.getElementById('edit-cancel-btn');
            const editAngkatanForm = document.getElementById('edit-angkatan-form');
            
            // --- Base URL for Form Actions ---
            const updateUrlBase = "{{ url('manajemen-angkatan') }}"; // URL diperbaiki

            // --- Generic Modal Open/Close Functions ---
            const openModal = (modal, content) => {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    content.classList.remove('scale-95');
                }, 10);
            };

            const closeModal = (modal, content) => {
                modal.classList.add('opacity-0');
                content.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            };

            // --- ADD MODAL LOGIC ---
            addAngkatanBtn.addEventListener('click', () => {
                addAngkatanForm.reset();
                openModal(addAngkatanModal, addModalContent);
            });
            addCloseModalBtn.addEventListener('click', () => closeModal(addAngkatanModal, addModalContent));
            addCancelBtn.addEventListener('click', () => closeModal(addAngkatanModal, addModalContent));
            addAngkatanModal.addEventListener('click', (event) => {
                if (event.target === addAngkatanModal) {
                    closeModal(addAngkatanModal, addModalContent);
                }
            });

            // --- EDIT MODAL LOGIC ---
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const angkatan = button.dataset.angkatan;
                    const idTingkat = button.dataset.idTingkat;
                    const tanggalMulai = button.dataset.tanggalMulai;
                    const tanggalSelesai = button.dataset.tanggalSelesai;

                    // Populate form
                    editAngkatanForm.querySelector('#edit_angkatan').value = angkatan;
                    editAngkatanForm.querySelector('#edit_tingkat').value = idTingkat;
                    editAngkatanForm.querySelector('#edit_tanggal_mulai').value = tanggalMulai;
                    editAngkatanForm.querySelector('#edit_tanggal_selesai').value = tanggalSelesai;

                    // Set action
                    editAngkatanForm.action = `${updateUrlBase}/${id}`;

                    // Open modal
                    openModal(editAngkatanModal, editModalContent);
                });
            });
            editCloseModalBtn.addEventListener('click', () => closeModal(editAngkatanModal, editModalContent));
            editCancelBtn.addEventListener('click', () => closeModal(editAngkatanModal, editModalContent));
            editAngkatanModal.addEventListener('click', (event) => {
                if (event.target === editAngkatanModal) {
                    closeModal(editAngkatanModal, editModalContent);
                }
            });

            // --- Functionality for DELETE Confirmation ---
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); 
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Jika ada error validasi dari Laravel, buka kembali modal tambah
            @if ($errors->any())
                openModal(addAngkatanModal, addModalContent);
            @endif
        });
    </script>

</body>
</html>

