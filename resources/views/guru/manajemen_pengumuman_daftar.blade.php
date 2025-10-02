<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengumuman - Sistem Manajemen Sekolah</title>
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
        /* Custom scrollbar for better aesthetics */
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
        /* Sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
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
        <nav class="mt-6 flex-1">
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Menu untuk Guru -->
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-pen w-6 h-6 mr-3"></i>
                <span>Input Nilai</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-list-check w-6 h-6 mr-3"></i>
                <span>Input Absensi</span>
            </a>
            <!-- Halaman Aktif: Pengumuman -->
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-bullhorn w-6 h-6 mr-3"></i>
                <span>Pengumuman</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-puzzle-piece w-6 h-6 mr-3"></i>
                <span>Ekstrakulikuler</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-circle-exclamation w-6 h-6 mr-3"></i>
                <span>Pelanggaran Siswa</span>
            </a>
        </nav>
        <div class="p-6">
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full">
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
            <div>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Pengumuman</h1>
                <p class="text-sm text-gray-500">Kelas: 10A - Bahasa Indonesia</p>
            </div>
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

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            <div class="flex justify-end mb-6">
                <button id="add-announcement-btn" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 flex items-center">
                    <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Pengumuman
                </button>
            </div>

            <!-- Announcement List -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-semibold mb-6 text-gray-800">Daftar Pengumuman</h3>
                <div id="announcement-list" class="space-y-6">
                    <!-- Contoh Pengumuman 1 -->
                    @forelse ($daftarPengumuman ?? [] as $Pengumuman)
                    <div class="border-b pb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">{{$Pengumuman->judul}}</h4>
                                <p class="mt-1 text-gray-600">{{$Pengumuman->isi}}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ \Carbon\Carbon::parse($Pengumuman->created_at)->format('d M Y') }}</p>
                            </div>
                            <div class="flex space-x-3 flex-shrink-0 ml-4">
                                <button class="text-gray-500 hover:text-blue-600 transition duration-200" title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button class="text-gray-500 hover:text-red-600 transition duration-200" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div>
                        <h1>Kosong</h1>
                    </div>
                    @endforelse
                    
                 

                    <!-- Placeholder untuk saat tidak ada pengumuman -->
                    <!-- <div class="text-center text-gray-500 py-10">
                        <i class="fa-solid fa-bell-slash text-4xl mb-4"></i>
                        <p class="text-lg">Belum ada pengumuman untuk kelas ini.</p>
                    </div> -->
                </div>
            </div>
        </main>
    </div>

    <!-- Modal for Add/Edit Announcement -->
    <div id="announcement-modal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 invisible opacity-0">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 md:p-8 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-title" class="text-2xl font-bold text-gray-800">Tambah Pengumuman Baru</h2>
                <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>
            <form action="{{ route('storePengumumanDaftar', [$infoJKA->id_kelas, $infoJKA->id_mapel]) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul</label>
                    <input type="text" id="judul" name="judul" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan judul pengumuman" required>
                </div>
                <div class="mb-6">
                    <label for="isi" class="block text-gray-700 font-semibold mb-2">Isi Pengumuman</label>
                    <textarea id="isi" name="isi" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tuliskan isi pengumuman di sini..." required></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="cancel-btn" class="py-2 px-6 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="py-2 px-6 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">Simpan</button>
                </div>
                <div>
                    <br>
                    <p>Noted: Pengumuman ini akan otomatis terhapus setelah satu minggu</p>
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
        const modal = document.getElementById('announcement-modal');
        const modalContent = modal.querySelector('div');
        const addBtn = document.getElementById('add-announcement-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const form = document.getElementById('announcement-form');

        const openModal = () => {
            modal.classList.remove('invisible', 'opacity-0');
            modalContent.classList.remove('scale-95');
        };

        const closeModal = () => {
            modalContent.classList.add('scale-95');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('invisible');
                form.reset(); // Reset form fields on close
            }, 300);
        };

        addBtn.addEventListener('click', () => {
            document.getElementById('modal-title').textContent = 'Tambah Pengumuman Baru';
            openModal();
        });

        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Form submission (contoh)
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const title = document.getElementById('judul').value;
            const content = document.getElementById('isi').value;
            
            console.log('Pengumuman Disimpan:', { title, content });
            // Di sini Anda akan menambahkan logika untuk mengirim data ke server
            // dan kemudian memperbarui daftar pengumuman di halaman
            
            closeModal();
            // Tampilkan notifikasi sukses (opsional)
            alert('Pengumuman berhasil disimpan!');
        });
    });
</script>

</body>
</html>
