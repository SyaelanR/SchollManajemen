<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Gaya modal murni CSS */
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

        /* Menampilkan modal saat URL hash cocok */
        .modal-overlay:target {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }

        /* Keyframes untuk animasi pop-in yang elegan */
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
            <h1 class="text-4xl font-extrabold text-gray-900">Daftar Produk</h1>
            <!-- Tombol Tambah Produk Baru, diubah untuk memicu modal CSS -->
            <a href="#tambah-produk-modal" class="flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition-colors duration-200">
                <i class="fas fa-plus-circle mr-2"></i>
                <span>Tambah Produk Baru</span>
            </a>
        </div>
        
        <!-- Tabel Daftar Produk -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Produk Saat Ini</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Buku Matematika</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">BK-MTK-01</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Buku Pelajaran</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 50.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">100</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <!-- Tombol Edit diperbarui agar tidak menggunakan path non-existent -->
                                <a href="/produk/editproduk" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <!-- Tombol Hapus diperbarui untuk memicu modal baru -->
                                <a href="#hapus-produk-modal" class="text-red-600 hover:text-red-900">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Pensil 2B</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">AL-PNS-02</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Alat Tulis</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 2.500</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">500</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="/produk/editproduk" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="#hapus-produk-modal" class="text-red-600 hover:text-red-900">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Seragam Putih Abu</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">SRG-PA-01</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Seragam</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 120.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">50</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="/produk/editproduk" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="#hapus-produk-modal" class="text-red-600 hover:text-red-900">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Beras 5kg</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">S-BRS-01</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Sembako</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 60.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">20</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="/produk/editproduk" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="#hapus-produk-modal" class="text-red-600 hover:text-red-900">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal CSS Murni untuk Tambah Produk -->
    <div id="tambah-produk-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-lg w-full relative z-10">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Tambah Produk Baru</h2>
            <form id="productForm" class="space-y-4">
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" id="nama_produk" name="nama_produk" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="kode_produk" class="block text-sm font-medium text-gray-700">Kode Produk</label>
                    <input type="text" id="kode_produk" name="kode_produk" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input type="text" id="kategori" name="kategori" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" id="harga" name="harga" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" id="stok" name="stok" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition-colors duration-200">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal CSS Murni untuk Notifikasi Berhasil -->
    <div id="berhasil-modal" class="modal-overlay">
        <a href="/produk/editproduk" class="absolute top-0 left-0 w-full h-full"></a>
        
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full relative z-10 text-center">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            
            <div class="flex flex-col items-center">
                <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2 text-gray-900">Berhasil!</h2>
                <p class="text-gray-600">Produk berhasil ditambahkan.</p>
                <div class="mt-6">
                    <a href="#" id="closeSuccessBtn" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md shadow-md hover:bg-green-600 transition-colors duration-200">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal CSS Murni untuk Konfirmasi Hapus Produk -->
    <div id="hapus-produk-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full relative z-10 text-center">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            
            <div class="flex flex-col items-center">
                <i class="fas fa-exclamation-triangle text-orange-400 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2 text-gray-900">Konfirmasi Hapus</h2>
                <p class="text-gray-600">Apakah Anda yakin ingin menghapus produk ini?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="#" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md shadow-md hover:bg-red-700 transition-colors duration-200">
                        Ya, Hapus
                    </a>
                    <a href="#" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productForm = document.getElementById('productForm');

            // Tambahkan event listener untuk submit form
            productForm.addEventListener('submit', (event) => {
                event.preventDefault(); // Mencegah form untuk submit secara default
                
                // Tampilkan modal notifikasi berhasil
                window.location.hash = 'berhasil-modal';

                // Di sini Anda bisa menambahkan logika untuk memproses data form
                // Misalnya, menyimpan data ke server atau database lokal
                console.log('Form disubmit');
            });
        });
    </script>
</body>
</html>
