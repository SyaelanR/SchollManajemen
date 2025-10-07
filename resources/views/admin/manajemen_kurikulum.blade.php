<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kurikulum - Sistem Manajemen Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        /* Sidebar and Modal transitions */
        .sidebar, .modal {
            transition: all 0.3s ease-in-out;
        }
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
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="{{ route('manajemenGuru') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                <span>Manajemen Guru</span>
            </a>
            <a href="{{ route('manajemenMapel') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-book w-6 h-6 mr-3"></i>
                <span>Manajemen Mapel</span>
            </a>
            <a href="{{ route('manajemenKelas') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-door-closed w-6 h-6 mr-3"></i>
                <span>Manajemen Kelas</span>
            </a>
            <a href="{{ route('manajemenJadwal')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                <span>Manajemen Jadwal</span>
            </a>
            <a href="{{ route('manajAcara') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-calendar-check w-6 h-6 mr-3"></i>
                <span>Acara</span>
            </a>
            <a href="{{ route('manajemenAngkatan') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-bookmark w-6 h-6 mr-3"></i>
                <span>Angkatan</span>
            </a>
            <a href="{{ route('manajemenRapor') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-book-open w-6 h-6 mr-3"></i>
                <span>Rapor</span>
            </a>
            <a href="{{ route('manajemenKurikulum') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-book-open-reader w-6 h-6 mr-3"></i>
                <span>Kurikulum</span>
            </a>
            <a href="{{ route('manajemenTingkat') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-layer-group w-6 h-6 mr-3"></i>
                <span>Tingkat</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
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
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Kurikulum</h1>
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
            <!-- Page Header -->
            <header class="mb-8 bg-indigo-600 p-8 rounded-2xl shadow-lg text-white">
                <h2 class="text-3xl font-bold mb-2">Manajemen Kurikulum</h2>
                <p class="text-indigo-200">Kelola semua kurikulum yang berlaku di sekolah.</p>
            </header>

            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                @if (session('success'))
                    <div id="session-success" data-message="{{ session('success') }}" class="hidden"></div>
                @endif
                @if ($errors->any())
                    <div id="validation-errors" data-errors='@json($errors->all())' class="hidden"></div>
                @endif
                <div class="relative w-full md:w-1/3 mb-4 md:mb-0">
                    <input type="text" placeholder="Cari kurikulum..." class="w-full pl-10 pr-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button id="add-curriculum-btn" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 flex items-center w-full md:w-auto justify-center">
                    <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Kurikulum
                </button>
            </div>

            <!-- Curriculum Table -->
            <div class="bg-white rounded-xl shadow-md overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kurikulum</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenjang</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Angkatan</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Matpel</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Contoh Row 1 -->
                        @forelse ($kurikulums as $kurikulum)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$kurikulum->nama_kurikulum}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$kurikulum->jenjang}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$kurikulum->angkatan->angkatan}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{$kurikulum->jumlah_matpel}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($kurikulum->status == 'non-aktif')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 capitalize">{{$kurikulum->status}}</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 capitalize">{{$kurikulum->status}}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                <button class="edit-btn text-blue-600 hover:text-blue-900 mr-3" title="Edit"
                                    data-id="{{ $kurikulum->id_kurikulum }}"
                                    data-nama="{{ $kurikulum->nama_kurikulum }}"
                                    data-jenjang="{{ $kurikulum->jenjang }}"
                                    data-angkatan_id="{{ $kurikulum->id_angkatan }}"
                                    data-jumlah_matpel="{{ $kurikulum->jumlah_matpel }}"
                                    data-status="{{ $kurikulum->status }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <form action="{{ route('destroyKurikulum', $kurikulum->id_kurikulum) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td>
                                <h1>Kosong</h1>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal for Add/Edit Curriculum -->
    <div id="curriculum-modal" class="modal fixed inset-0 bg-black bg-opacity-50 z-[60] flex items-center justify-center p-4 invisible opacity-0">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 md:p-8 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-title" class="text-2xl font-bold text-gray-800">Tambah Kurikulum Baru</h2>
                <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>
            <form id="curriculum-form" action="{{ route('storeKurikulum')}}" method="post">
                <input type="hidden" id="form-method" name="_method" value="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Kurikulum</label>
                        <input type="text" id="nama" name="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Kurikulum Merdeka" required>
                    </div>
                    <div>
                        <label for="jenjang" class="block text-gray-700 font-semibold mb-2">Jenjang Pendidikan</label>
                        <select id="jenjang" name="jenjang" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option value="">Pilih Jenjang</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                        </select>
                    </div>
                    <div>
                        <label for="angkatan" class="block text-gray-700 font-semibold mb-2">Tahun Angkatan</label>
                        <select id="angkatan" name="id_angkatan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option disabled value="">Pilih Tahun</option>
                            @forelse ($angkatans as $angkatan)
                            <option value="{{$angkatan->id_angkatan}}">{{$angkatan->angkatan}}</option>
                            @empty
                            <option value="">Tidak ada tahun yang tersedia</option>
                            @endforelse
                            <!-- Tahun akan diisi oleh JavaScript -->
                        </select>
                    </div>
                    <div>
                        <label for="jumlah_matpel" class="block text-gray-700 font-semibold mb-2">Jumlah Mata Pelajaran</label>
                        <input type="number" id="jumlah_matpel" name="jumlah_matpel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: 15" required>
                    </div>
                    <div>
                        <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center">
                                <input type="radio" name="status" value="aktif" class="form-radio h-4 w-4 text-indigo-600" checked>
                                <span class="ml-2 text-gray-700">Aktif</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status" value="non-aktif" class="form-radio h-4 w-4 text-indigo-600">
                                <span class="ml-2 text-gray-700">Tidak Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-8">
                    <button type="button" id="cancel-btn" class="py-2 px-6 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="py-2 px-6 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Sidebar toggle functionality
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Modal functionality
        const modal = document.getElementById('curriculum-modal');
        const modalContent = modal.querySelector('div');
        const addBtn = document.getElementById('add-curriculum-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const form = document.getElementById('curriculum-form');
        const formMethodInput = document.getElementById('form-method');

        const openModal = () => {
            modal.classList.remove('invisible', 'opacity-0');
        };

        const closeModal = () => {
            modalContent.classList.add('scale-95');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('invisible');
                form.reset();
            }, 300);
        };

        addBtn.addEventListener('click', () => {
            document.getElementById('modal-title').textContent = 'Tambah Kurikulum Baru';
            form.action = "{{ route('storeKurikulum') }}";
            formMethodInput.value = 'POST';
            openModal();
        });

        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // --- Edit Button Logic ---
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const data = this.dataset;
                
                // Set modal title
                document.getElementById('modal-title').textContent = 'Edit Kurikulum';

                // Populate form fields
                document.getElementById('nama').value = data.nama;
                document.getElementById('jenjang').value = data.jenjang;
                document.getElementById('angkatan').value = data.angkatan_id;
                document.getElementById('jumlah_matpel').value = data.jumlah_matpel;
                
                // Set radio button for status
                document.querySelector(`input[name="status"][value="${data.status}"]`).checked = true;

                // Update form action and method
                let updateUrl = "{{ route('updateKurikulum', ':id') }}";
                form.action = updateUrl.replace(':id', data.id);
                formMethodInput.value = 'PUT';

                // Open the modal
                openModal();
            });
        });

        // --- Delete Confirmation ---
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data kurikulum yang dihapus tidak dapat dikembalikan!",
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

        // (Anda bisa menambahkan penanganan untuk validation-errors di sini jika diperlukan)

    });
</script>

</body>
</html>