<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pembelian</title>
    <!-- Tailwind CSS CDN untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts untuk font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
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

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-gray-100 p-6 flex flex-col items-center">
        <div class="text-2xl font-bold text-center mb-8">
            <i class="fas fa-chart-line text-indigo-500 mr-2"></i>
            Finan.
        </div>
        <nav class="w-full">
            <ul>
                <li class="mb-4">
                    <a href="/" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
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
                    <a href="/pembelian" class="flex items-center p-3 rounded-lg bg-gray-800 text-cyan-400 font-semibold transition-colors duration-200">
                        <i class="fas fa-shopping-cart mr-3 text-lg"></i>
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

    <!-- Konten Utama -->
    <main class="flex-1 p-8 overflow-y-auto">
        <!-- HANYA JUDUL, BAGIAN SELAMAT DATANG DIHILANGKAN -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Halaman Pembelian</h1>
        </div>

        <!-- Tombol untuk menambah pembelian baru -->
        <div class="flex justify-end mb-6">
            <a href="#tambah-modal" class="bg-indigo-600 text-white font-medium py-2 px-4 rounded-full shadow-md hover:bg-indigo-700 transition-colors">
                <i class="fas fa-plus mr-2"></i> Tambah Pembelian Baru
            </a>
        </div>

        <!-- Bagian Tabel Transaksi -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Transaksi Pembelian</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Supplier</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah & Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cara Bayar</th>
                        </tr>
                    </thead>
                    <tbody id="pembelian-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Data Dummy Statis -->
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2024-05-18</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">PT Maju Sejahtera</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Komputer</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">10 x Rp 5.000.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Transfer Bank</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2024-05-17</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">CV Solusi Digital</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Layanan Cloud</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">1 x Rp 12.000.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Tunai</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2024-05-16</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Global Tech Indonesia</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Printer</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">5 x Rp 3.500.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Debit Card</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal untuk Formulir Input Pembelian -->
    <div id="tambah-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>

        <div class="modal-content bg-white p-6 rounded-xl shadow-2xl max-w-lg w-full relative z-10">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Input Data Pembelian</h2>
            <form id="form_pembelian" class="space-y-4">
                <div>
                    <label for="supplier" class="block text-sm font-medium text-gray-700">Pilih Supplier</label>
                    <select id="supplier" name="supplier" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                        <option>PT Maju Sejahtera</option>
                        <option>CV Solusi Digital</option>
                        <option>Global Tech Indonesia</option>
                    </select>
                </div>
                <div>
                    <label for="produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" id="produk" name="produk" placeholder="Masukkan nama produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                    </div>
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga per Unit</label>
                        <input type="number" id="harga" name="harga" placeholder="Rp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                    </div>
                </div>
                <div>
                    <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                    <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                </div>
                <div>
                    <label for="cara_bayar" class="block text-sm font-medium text-gray-700">Cara Bayar</label>
                    <select id="cara_bayar" name="cara_bayar" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                        <option>Tunai</option>
                        <option>Transfer Bank</option>
                        <option>Debit Card</option>
                    </select>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="#" class="bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-full hover:bg-gray-300 transition-colors">Batal</a>
                    <button type="button" onclick="simpanPembelian()" class="bg-indigo-600 text-white font-medium py-2 px-4 rounded-full hover:bg-indigo-700 transition-colors">Simpan Pembelian</button>
                </div>
            </form>
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
                <p class="text-gray-600">Data pembelian berhasil disimpan.</p>
                <div class="mt-6">
                    <a href="#" id="closeSuccessBtn" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md shadow-md hover:bg-green-600 transition-colors duration-200">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function simpanPembelian() {
            // Dapatkan data dari formulir (untuk simulasi)
            const form = document.getElementById('form_pembelian');
            const data = {
                supplier: form.supplier.value,
                produk: form.produk.value,
                jumlah: form.jumlah.value,
                harga: form.harga.value,
                tanggal: form.tanggal_transaksi.value,
                caraBayar: form.cara_bayar.value
            };

            // ---- Simulasi Fungsi Backend ----
            // Di sini, Anda akan mengirim data ke server atau memprosesnya secara lokal.
            console.log("Data Pembelian Disimpan:", data);
            
            // Logika untuk menambah stok produk
            console.log(`Menambah stok produk '${data.produk}' sejumlah ${data.jumlah} unit.`);

            // Logika untuk membuat jurnal otomatis
            const total = data.jumlah * data.harga;
            console.log(`Membuat jurnal: (Debit: Persediaan, Kredit: Kas/Bank) sebesar Rp${total}.`);

            // Tampilkan notifikasi sukses dengan mengganti hash URL
            window.location.hash = 'berhasil-modal';
        }

        // Opsional: Untuk memastikan tombol 'Tutup' di modal berhasil juga menutup modal
        document.getElementById('closeSuccessBtn').addEventListener('click', function(event) {
            window.location.hash = ''; // Menghilangkan hash untuk menutup modal
        });
    </script>
</body>
</html>
