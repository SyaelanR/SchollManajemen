<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tagihan - Sistem Manajemen Sekolah</title>
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
         /* Modal transition */
        .modal {
            transition: opacity 0.3s ease-in-out;
        }
        /* Custom checkbox style */
        .custom-checkbox {
            appearance: none;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
            position: relative;
            transition: background-color 0.2s, border-color 0.2s;
        }
        .custom-checkbox:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        .custom-checkbox:checked::after {
            content: '\f00c'; /* Font Awesome check icon */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: white;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.75rem;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
            <div class="p-6">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-shield-halved text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">AdminSys</span>
                </a>
            </div>
            <nav class="mt-6">
                 <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-building-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Klien</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-file-invoice-dollar w-6 h-6 mr-3"></i>
                    <span>Manajemen Tagihan</span>
                </a>
                 <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-cog w-6 h-6 mr-3"></i>
                    <span>Pengaturan</span>
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Detail Pembayaran Tagihan</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/1e293b/ffffff?text=SA" alt="Super Admin Avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <!-- Billing Info -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                    <div class="flex flex-col md:flex-row justify-between items-start mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Info Pembayaran: <span class="text-indigo-600">SPP Bulan Oktober 2025</span></h2>
                            <p class="text-gray-500 mt-1">Target Angkatan: 2025/2026 | Tenggat: 30 September 2025</p>
                        </div>
                        <a href="#" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center whitespace-nowrap mt-4 md:mt-0">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-blue-800 font-medium">Total Siswa</p>
                            <p class="text-2xl font-bold text-blue-600">150</p>
                        </div>
                         <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-green-800 font-medium">Sudah Membayar</p>
                            <p class="text-2xl font-bold text-green-600">128</p>
                        </div>
                         <div class="bg-red-50 p-4 rounded-lg">
                            <p class="text-sm text-red-800 font-medium">Belum Membayar</p>
                            <p class="text-2xl font-bold text-red-600">22</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Sudah Membayar -->
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center"><i class="fa-solid fa-check-circle text-green-500 mr-2"></i> Sudah Membayar</h3>
                        <div class="overflow-auto max-h-96">
                             <table class="w-full text-left">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th class="p-3 font-semibold text-gray-600">NISN</th>
                                        <th class="p-3 font-semibold text-gray-600">Nama Siswa</th>
                                        <th class="p-3 font-semibold text-gray-600">Tgl Bayar</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse ($sudahMembayar as $membayar)
                                    <tr class="hover:bg-gray-50"><td class="p-3">{{$membayar->nisn_nik}}</td><td class="p-3 font-medium">{{$membayar->name}}</td><td class="p-3">{{ \Carbon\Carbon::parse($membayar->updated_at)->format('d M Y') }}</td></tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="p-3 text-center text-gray-500">
                                            <div class="text-center py-12">
                                                <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                                <p class="text-gray-600 font-semibold text-lg">Belum ada.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                    <!-- Add more paid students as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Belum Membayar -->
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="flex justify-between items-center mb-4">
                             <h3 class="text-xl font-bold text-gray-800 flex items-center"><i class="fa-solid fa-exclamation-circle text-red-500 mr-2"></i> Belum Membayar</h3>
                             <button id="edit-payment-btn" class="bg-blue-100 text-blue-700 font-semibold py-2 px-4 rounded-lg hover:bg-blue-200 transition duration-300 flex items-center text-sm">
                                <i class="fa-solid fa-pencil mr-2"></i> Edit
                            </button>
                        </div>
                        <div class="overflow-auto max-h-96">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th class="p-3 font-semibold text-gray-600">NISN</th>
                                        <th class="p-3 font-semibold text-gray-600">Nama Siswa</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse ($belumMembayar as $belum)
                                    <tr class="hover:bg-gray-50"><td class="p-3">{{$belum->nisn_nik}}</td><td class="p-3 font-medium">{{$belum->name}}</td></tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="p-3 text-center text-gray-500">
                                            <div class="text-center py-12">
                                                <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                                <p class="text-gray-600 font-semibold text-lg">Belum ada.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                    <!-- Add more unpaid students as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Edit Payment Modal -->
    <div id="payment-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-1/2 lg:w-1/3 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Ubah Status Pembayaran</h3>
                <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <form>
                <p class="text-gray-600 mb-4">Pilih siswa yang sudah melakukan pembayaran.</p>
                <div class="border rounded-lg max-h-64 overflow-y-auto">
                    <table class="w-full table-fixed">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600 text-left">Nama Siswa</th>
                                <th class="p-3 w-16 text-center">
                                    <input type="checkbox" id="select-all" class="custom-checkbox">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                           <tr><td class="p-3 truncate">Bambang Hartono</td><td class="p-3 text-center"><input type="checkbox" class="custom-checkbox student-checkbox"></td></tr>
                           <tr><td class="p-3 truncate">Dewi Sandra</td><td class="p-3 text-center"><input type="checkbox" class="custom-checkbox student-checkbox"></td></tr>
                           <tr><td class="p-3 truncate">Bambang Hartono</td><td class="p-3 text-center"><input type="checkbox" class="custom-checkbox student-checkbox"></td></tr>
                           <tr><td class="p-3 truncate">Dewi Sandra</td><td class="p-3 text-center"><input type="checkbox" class="custom-checkbox student-checkbox"></td></tr>
                           <tr><td class="p-3 truncate">Bambang Hartono</td><td class="p-3 text-center"><input type="checkbox" class="custom-checkbox student-checkbox"></td></tr>
                           <tr><td class="p-3 truncate">Dewi Sandra</td><td class="p-3 text-center"><input type="checkbox" class="custom-checkbox student-checkbox"></td></tr>
                           <tr><td class="p-3 truncate">Bambang Hartono</td><td class="p-3 text-center"><input type="checkbox" class="custom-checkbox student-checkbox"></td></tr>
                           <tr><td class="p-3 truncate">Dewi Sandra</td><td class="p-3 text-center"><input type="checkbox" class="custom-checkbox student-checkbox"></td></tr>
                           <!-- List will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" id="cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
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

        // --- Modal Functionality ---
        const paymentModal = document.getElementById('payment-modal');
        const modalContent = paymentModal.querySelector('div');
        const editPaymentBtn = document.getElementById('edit-payment-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        const openModal = () => {
            paymentModal.classList.remove('hidden');
            setTimeout(() => {
                paymentModal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        };

        const closeModal = () => {
            paymentModal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                paymentModal.classList.add('hidden');
            }, 300);
        };

        editPaymentBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        paymentModal.addEventListener('click', (event) => {
            if (event.target === paymentModal) {
                closeModal();
            }
        });
        
        // --- Checkbox functionality ---
        const selectAllCheckbox = document.getElementById('select-all');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        
        selectAllCheckbox.addEventListener('change', (event) => {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });

    </script>

</body>
</html>

