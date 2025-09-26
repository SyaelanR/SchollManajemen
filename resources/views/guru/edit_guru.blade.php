<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Guru - Edit Data</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
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
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .notification-container {
            transition: opacity 0.5s ease-in-out;
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
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('manajemenAngkatan') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-layer-group w-6 h-6 mr-3"></i>
                    <span>Manajemen Angkatan</span>
                </a>
                <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="{{ route('manajemenGuru') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Guru</span>
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
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Data Guru</h1>
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

            <!-- ### CONTENT UTAMA - Perubahan dimulai dari sini ### -->
            <main class="p-6 md:p-8 flex-1">
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl">
                    <!-- Header Form -->
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200">
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <i class="fa-solid fa-user-pen text-2xl text-indigo-600"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Edit Data Guru</h2>
                            <p class="text-sm text-gray-500">Perbarui informasi guru di bawah ini.</p>
                        </div>
                    </div>

                    <!-- Container untuk Notifikasi -->
                    <div id="notification-container" class="mb-6"></div>
                    
                    <!-- Form Edit Guru -->
                    <div id="edit-form-container">
                        <form id="edit-guru-form" action="{{ route('updateGuru', $teacher->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="1">
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Input NIK -->
                                <div class="mb-4">
                                    <label for="edit_nik" class="block text-gray-700 font-medium mb-2">NIK</label>
                                    <input type="text" id="edit_nik" name="nik" value="{{ $teacher->nisn_nik }}" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300" required>
                                </div>
                                <!-- Input Nama Lengkap -->
                                <div class="mb-4">
                                    <label for="edit_nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                                    <input type="text" id="edit_nama" name="name" value="{{ $teacher->name }}" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300" required>
                                </div>
                                <!-- Input Tempat Lahir -->
                                <div class="mb-4">
                                    <label for="edit_tempat_lahir" class="block text-gray-700 font-medium mb-2">Tempat Lahir</label> 
                                    <input type="text" id="edit_tempat_lahir" name="tempat_lahir" value="{{ $teacher->tempat_lahir }}" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300" required>
                                </div>
                                <!-- Input Tanggal Lahir -->
                                <div class="mb-4">
                                    <label for="edit_tanggal_lahir" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                                    <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" value="{{ $teacher->tanggal_lahir }}" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300" required>
                                </div>
                                 <!-- Input Usia -->
                                <div class="mb-4">
                                    <label for="edit_usia" class="block text-gray-700 font-medium mb-2">Usia (Tahun)</label>
                                    <input type="number" id="edit_usia" name="usia" class="w-full p-3 bg-gray-200 border border-gray-300 rounded-lg cursor-not-allowed" readonly>
                                </div>
                                <!-- Input Jabatan -->
                                <div class="mb-4">
                                    <label for="edit_jabatan" class="block text-gray-700 font-medium mb-2">Jabatan</label>
                                    <select id="edit_jabatan" name="jabatan" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg appearance-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300" required>
                                        <option value="guru" @if($teacher->role == 'guru') selected @endif>Guru</option>
                                        <option value="staf" @if($teacher->role == 'staf') selected @endif>Staf</option>
                                    </select>
                                </div>
                                <!-- Input Alamat -->
                                <div class="mb-4 md:col-span-2">
                                    <label for="edit_alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                                    <textarea id="edit_alamat" name="alamat" rows="3" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300" required>{{ $teacher->alamat }}</textarea>
                                </div>
                                <!-- Input Nomor Telepon -->
                                <div class="mb-4">
                                    <label for="edit_no_telp" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                                    <input type="tel" id="edit_no_telp" name="no_telp" value="{{ $teacher->no_telp }}" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300" required>
                                </div>
                                 <!-- Input Username -->
                                <div class="mb-4">
                                    <label for="edit_username" class="block text-gray-700 font-medium mb-2">Username</label>
                                    <input type="text" id="edit_username" name="username" value="{{ $teacher->username }}" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300" required>
                                </div>
                                <!-- Input Password -->
                                <div class="md:col-span-2">
                                     <label for="edit_password" class="block text-gray-700 font-medium mb-2">Password Baru (Opsional)</label>
                                     <div class="flex items-center gap-4">
                                        <div class="relative w-full">
                                            <input type="password" id="edit_password" name="password" placeholder="Kosongkan jika tidak ingin diubah" class="w-full p-3 pr-10 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition duration-300">
                                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="bg-amber-500 text-white font-semibold py-3 px-5 rounded-lg hover:bg-amber-600 transition-all duration-300 ease-in-out transform hover:-translate-y-px whitespace-nowrap">
                                            <i class="fa-solid fa-key mr-2"></i>Reset Password
                                        </button>
                                     </div>
                                </div>
                            </div>
                            <!-- Tombol Aksi -->
                            <div class="flex justify-end gap-4 mt-6 pt-6 border-t border-gray-200">
                                <a href="{{ route('manajemenGuru') }}" class="bg-white border border-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:-translate-y-px">Batal</a>
                                <button type="submit" class="flex items-center justify-center gap-2 bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out transform hover:-translate-y-px shadow-lg hover:shadow-indigo-400/50">
                                    <i class="fa-solid fa-save"></i>
                                    <span>Update</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
            <!-- ### Perubahan berakhir di sini ### -->
        </div>
    </div>
    <script>
        // Logika sederhana untuk sidebar
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Logika JavaScript untuk notifikasi, kalkulasi usia, dan toggle password
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('edit-guru-form');
            const notificationContainer = document.getElementById('notification-container');
            const tanggalLahirInput = document.getElementById('edit_tanggal_lahir');
            const usiaInput = document.getElementById('edit_usia');
            const passwordInput = document.getElementById('edit_password');
            const togglePasswordButton = document.getElementById('toggle-password');

            // Fungsi untuk menghitung usia
            const calculateAge = () => {
                const birthDateString = tanggalLahirInput.value;
                if (!birthDateString) {
                    usiaInput.value = '';
                    return;
                }
                const birthDate = new Date(birthDateString);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                usiaInput.value = age >= 0 ? age : '';
            };

            // Hitung usia saat halaman dimuat
            calculateAge();

            // Hitung ulang usia saat tanggal lahir diubah
            tanggalLahirInput.addEventListener('change', calculateAge);
            
            // Logika untuk toggle password
            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Ganti ikon mata
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });

            // Fungsi untuk menampilkan notifikasi
            const showNotification = (message, type) => {
                const colorClasses = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
                const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                const titleText = type === 'success' ? 'Berhasil!' : 'Gagal!';

                const notificationDiv = document.createElement('div');
                notificationDiv.className = `notification-container border-l-4 p-4 rounded-md opacity-0 ${colorClasses}`;
                notificationDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="fa-solid ${iconClass} mr-3 text-xl"></i>
                        <div>
                            <p class="font-bold">${titleText}</p>
                            <p>${message}</p>
                        </div>
                    </div>
                `;
                
                notificationContainer.innerHTML = '';
                notificationContainer.appendChild(notificationDiv);

                setTimeout(() => {
                    notificationDiv.classList.remove('opacity-0');
                }, 10);

                setTimeout(() => {
                    notificationDiv.classList.add('opacity-0');
                    setTimeout(() => {
                        notificationContainer.innerHTML = '';
                    }, 500);
                }, 5000);
            };

            // Tangani pengiriman formulir
            // form.addEventListener('submit', (e) => {
            //     // Hapus logic JS untuk submit, karena kita akan menggunakan submit form standar Laravel
            // });
        });
    </script>
</body>
</html>
