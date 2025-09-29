<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Supplier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Pure CSS modal styles */
        .modal-overlay {
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .modal-overlay:target {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }

        @keyframes popIn {
            0% {
                transform: scale(0.8) translateY(20px);
                opacity: 0;
            }
            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .modal-content {
            animation: popIn 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen">
    <aside class="w-64 bg-gray-900 text-gray-100 p-6 flex flex-col items-center">
        <div class="text-2xl font-bold text-center mb-8">
            <i class="fas fa-chart-line text-indigo-500 mr-2"></i>
            Finan.
        </div>
        <nav class="w-full">
            <ul>
                <li class="mb-4">
                    <a href="/" class="flex items-center p-3 rounded-lg bg-gray-800 text-indigo-400 font-semibold transition-colors duration-200">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/produk" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-box mr-3 text-lg text-yellow-400"></i>
                        Produk
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/supplier" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-truck mr-3 text-lg text-purple-400"></i>
                        Supplier
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/pelanggan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-users mr-3 text-lg text-blue-400"></i>
                        Pelanggan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/pembelian" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-shopping-cart mr-3 text-lg text-cyan-400"></i>
                        Pembelian
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/penjualan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-handshake mr-3 text-lg text-green-400"></i>
                        Penjualan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/jurnal" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-book mr-3 text-lg text-red-400"></i>
                        Jurnal
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/laporan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-pie mr-3 text-lg text-lime-400"></i>
                        Laporan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/coa" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-pie mr-3 text-lg text-lime-400"></i>
                        COA
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Daftar Supplier</h1>
            <!-- Tombol untuk memicu modal, diubah dengan hash -->
            <a href="#tambah-supplier-modal" class="flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                <span>Tambah Supplier Baru</span>
            </a>
        </div>
        
        <!-- Tabel Daftar Supplier -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Supplier Saat Ini</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="supplier-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Supplier</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr data-id="1">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">PT Sumber Makmur</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">08123456789</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">info@sumbermakmur.com</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Jl. Pahlawan No. 123, Jakarta</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="/supplier/editsupplier" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="#konfirmasi-hapus-modal" class="text-red-600 hover:text-red-900 delete-btn" data-supplier-id="1" data-supplier-name="PT Sumber Makmur">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <tr data-id="2">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">CV Media Sekolah</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">08987654321</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">sales@mediasekolah.co.id</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Jl. Merdeka No. 45, Bandung</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="/supplier/editsupplier" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="#konfirmasi-hapus-modal" class="text-red-600 hover:text-red-900 delete-btn" data-supplier-id="2" data-supplier-name="CV Media Sekolah">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal CSS Murni untuk Tambah Supplier -->
    <div id="tambah-supplier-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-lg w-full relative z-10">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Tambah Supplier Baru</h2>
            <form id="supplierForm" class="space-y-4">
                <div>
                    <label for="nama_supplier" class="block text-sm font-medium text-gray-700">Nama Supplier</label>
                    <input type="text" id="nama_supplier" name="nama_supplier" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div>
                    <label for="kontak" class="block text-sm font-medium text-gray-700">Kontak</label>
                    <input type="text" id="kontak" name="kontak" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div>
                    <label for="alamat_email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <input type="email" id="alamat_email" name="alamat_email" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition-colors duration-200">
                        Simpan Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal CSS Murni untuk Konfirmasi Hapus -->
    <div id="konfirmasi-hapus-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full relative z-10 text-center">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <div class="flex flex-col items-center">
                <i class="fas fa-exclamation-triangle text-orange-500 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2 text-gray-900">Konfirmasi Hapus</h2>
                <p class="text-gray-600 mb-6" id="delete-confirmation-text">Apakah Anda yakin ingin menghapus supplier ini?</p>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </a>
                    <button id="confirm-delete-btn" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md shadow-md hover:bg-red-700 transition-colors duration-200">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal CSS Murni untuk Notifikasi Berhasil -->
    <div id="berhasil-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full relative z-10 text-center">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <div class="flex flex-col items-center">
                <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2 text-gray-900">Berhasil!</h2>
                <p class="text-gray-600" id="success-message">Supplier berhasil ditambahkan.</p>
                <div class="mt-6">
                    <a href="#" id="closeSuccessBtn" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md shadow-md hover:bg-green-600 transition-colors duration-200">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const supplierForm = document.getElementById('supplierForm');
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const deleteConfirmationText = document.getElementById('delete-confirmation-text');
            const successModalMessage = document.getElementById('success-message');
            const closeSuccessBtn = document.getElementById('closeSuccessBtn');
            const supplierTableBody = document.querySelector('#supplier-table tbody');

            // Handle Add Supplier form submission
            supplierForm.addEventListener('submit', (event) => {
                event.preventDefault();

                const nama = document.getElementById('nama_supplier').value;
                const kontak = document.getElementById('kontak').value;
                const email = document.getElementById('alamat_email').value;
                const alamat = document.getElementById('alamat').value;
                const newId = Date.now(); // Simple unique ID for demonstration

                const newRow = document.createElement('tr');
                newRow.dataset.id = newId;
                newRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${nama}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${kontak}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${email}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${alamat}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="/supplier/editsupplier" class="text-indigo-600 hover:text-indigo-900 mr-4">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="#konfirmasi-hapus-modal" class="text-red-600 hover:text-red-900 delete-btn" data-supplier-id="${newId}" data-supplier-name="${nama}">
                            <i class="fa-solid fa-trash-alt"></i>
                        </a>
                    </td>
                `;

                supplierTableBody.appendChild(newRow);

                successModalMessage.textContent = 'Supplier berhasil ditambahkan.';
                window.location.hash = 'berhasil-modal';
                supplierForm.reset();

                // Simulate success and close after a delay
                setTimeout(() => {
                    window.location.hash = '';
                }, 2000);
            });

            // Handle delete button click using event delegation on the table body
            supplierTableBody.addEventListener('click', (event) => {
                const deleteButton = event.target.closest('.delete-btn');
                if (deleteButton) {
                    event.preventDefault();
                    const supplierId = deleteButton.dataset.supplierId;
                    const supplierName = deleteButton.dataset.supplierName;
                    
                    // Update the confirmation text with the supplier's name
                    deleteConfirmationText.textContent = `Apakah Anda yakin ingin menghapus supplier "${supplierName}"?`;
                    
                    // Store the supplier ID on the confirmation button
                    confirmDeleteBtn.dataset.supplierId = supplierId;
                    
                    window.location.hash = 'konfirmasi-hapus-modal';
                }
            });

            // Handle confirmation of deletion
            confirmDeleteBtn.addEventListener('click', () => {
                const supplierId = confirmDeleteBtn.dataset.supplierId;
                const rowToRemove = document.querySelector(`tr[data-id="${supplierId}"]`);
                if (rowToRemove) {
                    rowToRemove.remove();
                }

                window.location.hash = ''; // Close the confirmation modal

                // Show the success modal for a brief moment
                successModalMessage.textContent = 'Supplier berhasil dihapus.';
                window.location.hash = 'berhasil-modal';
                
                setTimeout(() => {
                    window.location.hash = '';
                }, 2000);
            });

            // Close success modal on button click
            closeSuccessBtn.addEventListener('click', () => {
                window.location.hash = '';
            });
        });
    </script>
</body>
</html>
