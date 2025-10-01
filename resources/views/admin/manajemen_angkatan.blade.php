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
         .modal-content {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
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
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>
             <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-layer-group mr-3"></i>
                <span>Manajemen Angkatan</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-user-graduate mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-chalkboard-user mr-3"></i>
                <span>Manajemen Guru</span>
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
            <!-- Session Messages Handling -->
            @if (session('success'))
                <div id="session-success" data-message="{{ session('success') }}" class="hidden"></div>
            @endif
            @if ($errors->any())
                <div id="validation-errors" data-errors='@json($errors->all())' class="hidden"></div>
            @endif

             <header class="mb-8 bg-indigo-600 p-8 rounded-2xl shadow-lg text-white">
                <h2 class="text-3xl font-bold mb-2">Manajemen Angkatan</h2>
                <p class="text-indigo-200">Kelola semua tahun ajaran yang tersedia di sekolah.</p>
            </header>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <!-- Action Bar -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Angkatan</h2>
                    <button id="add-angkatan-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Tambah Angkatan
                    </button>
                </div>

                <!-- School Year Table -->
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px] text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Tahun Ajaran</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Semester</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Tanggal Mulai</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Tanggal Selesai</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Tingkat</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($angkatans as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-800 font-medium">{{ $item->angkatan }}</td>
                                    <td class="p-3 text-gray-700 capitalize">{{$item->semester}}</td>
                                    <td class="p-3 text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') }}</td>
                                    <td class="p-3 text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d F Y') }}</td>
                                    <td class="p-3 text-gray-700">{{$item->tingkat}}</td>
                                    <td class="p-3 text-center">
                                        <div class="flex justify-center space-x-4">
                                            <button class="text-blue-600 hover:text-blue-800 edit-btn" title="Edit"
                                                data-id="{{ $item->id_angkatan }}"
                                                data-angkatan="{{ $item->angkatan }}"
                                                data-id-tingkat="{{ $item->id_tingkat }}"
                                                data-tanggal-mulai="{{ $item->tanggal_mulai }}"
                                                data-tanggal-selesai="{{ $item->tanggal_selesai }}"
                                                data-semester="{{ $item->semester }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
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
                                <tr>
                                    <td colspan="6" class="p-3 text-center text-gray-500">
                                        <div class="text-center py-12">
                                            <i class="fa-solid fa-folder-open text-5xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-600 font-semibold text-lg">Belum ada data Angkatan.</p>
                                            <p class="text-gray-500 mt-2">Silakan tambahkan Angkatan baru.</p>
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
<div id="add-angkatan-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4 hidden opacity-0">
    <div class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-transform duration-300 scale-95">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-2xl font-semibold text-gray-800">Tambah Angkatan Baru</h3>
            <button id="add-close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form id="add-angkatan-form" action="{{ route('storeAngkatan') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="angkatan" class="block text-gray-700 font-medium mb-2">Tahun Ajaran</label>
                    <input type="text" id="angkatan" name="angkatan" placeholder="Contoh: 2026/2027" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required value="{{ old('angkatan') }}">
                </div>
                 <div>
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
                <div>
                    <label for="tanggal_mulai" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required value="{{ old('tanggal_mulai') }}">
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required value="{{ old('tanggal_selesai') }}">
                </div>
            </div>
            <div class="flex justify-end gap-4 p-6 bg-gray-50 rounded-b-xl">
                <button type="button" id="add-cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>
    
<!-- Edit Modal -->
<div id="edit-angkatan-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4 hidden opacity-0">
    <div class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-transform duration-300 scale-95">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 id="edit-modal-title" class="text-2xl font-semibold text-gray-800">Edit Angkatan</h3>
            <button id="edit-close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form id="edit-angkatan-form" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <div>
                    <label for="edit_angkatan" class="block text-gray-700 font-medium mb-2">Tahun Ajaran</label>
                    <input type="text" id="edit_angkatan" name="angkatan" placeholder="Contoh: 2026/2027" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                 <div>
                    <label for="edit_tingkat" class="block text-gray-700 font-medium mb-2">Tingkat</label>
                    <select id="edit_tingkat" name="id_tingkat" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                        <option value="" disabled>Pilih Tingkat</option>
                        @forelse ($tingkats as $tingkat)
                            <option value="{{ $tingkat->id_tingkat }}">{{ $tingkat->tingkat }}</option>
                        @empty
                            <option value="" disabled>Tidak ada data tingkat</option>
                        @endforelse
                    </select>
                </div>
                <div>
                    <label for="edit_tanggal_mulai" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                    <input type="date" id="edit_tanggal_mulai" name="tanggal_mulai" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label for="edit_tanggal_selesai" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                    <input type="date" id="edit_tanggal_selesai" name="tanggal_selesai" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label for="edit_semester" class="block text-gray-700 font-medium mb-2">Semester</label>
                    <select id="edit_semester" name="semester" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                        <option value="" disabled>Pilih Semester</option>
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-4 p-6 bg-gray-50 rounded-b-xl">
                <button type="button" id="edit-cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Update</button>
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
    if(menuButton && sidebar && overlay) {
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
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

    const validationErrors = document.getElementById('validation-errors');
    if (validationErrors) {
        const errors = JSON.parse(validationErrors.dataset.errors);
        let errorText = '<ul class="list-disc list-inside text-left">';
        errors.forEach(error => {
            errorText += `<li>${error}</li>`;
        });
        errorText += '</ul>';
        Swal.fire({
            icon: 'error',
            title: 'Gagal Validasi',
            html: errorText,
        });
    }

    // --- Modal Control ---
    const addAngkatanModal = document.getElementById('add-angkatan-modal');
    const editAngkatanModal = document.getElementById('edit-angkatan-modal');
    
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
        setTimeout(() => modalEl.classList.add('hidden'), 300);
    };

    // Add Modal Listeners
    document.getElementById('add-angkatan-btn').addEventListener('click', () => {
        document.getElementById('add-angkatan-form').reset();
        openModal(addAngkatanModal);
    });
    document.getElementById('add-close-modal-btn').addEventListener('click', () => closeModal(addAngkatanModal));
    document.getElementById('add-cancel-btn').addEventListener('click', () => closeModal(addAngkatanModal));
    addAngkatanModal.addEventListener('click', e => { if (e.target === addAngkatanModal) closeModal(addAngkatanModal); });

    // Edit Modal Listeners
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const data = button.dataset;
            const form = document.getElementById('edit-angkatan-form');
            form.action = `{{ url('manajemen-angkatan') }}/${data.id}`;
            form.querySelector('#edit_angkatan').value = data.angkatan;
            form.querySelector('#edit_tingkat').value = data.idTingkat;
            form.querySelector('#edit_tanggal_mulai').value = data.tanggalMulai;
            form.querySelector('#edit_tanggal_selesai').value = data.tanggalSelesai;
            form.querySelector('#edit_semester').value = data.semester;
            openModal(editAngkatanModal);
        });
    });
    document.getElementById('edit-close-modal-btn').addEventListener('click', () => closeModal(editAngkatanModal));
    document.getElementById('edit-cancel-btn').addEventListener('click', () => closeModal(editAngkatanModal));
    editAngkatanModal.addEventListener('click', e => { if (e.target === editAngkatanModal) closeModal(editAngkatanModal); });
    
    // --- Delete Confirmation ---
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // If validation fails, reopen the add modal.
    // This is handled by Blade rendering a variable, which JS then checks.
    const validationFailed = document.getElementById('validation-errors') !== null;
    if (validationFailed) {
        openModal(addAngkatanModal);
    }
});
</script>
</body>
</html>

