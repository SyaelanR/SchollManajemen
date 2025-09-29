<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi Disetujui</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }
        .sidebar {
            background-image: linear-gradient(180deg, #1f2937 0%, #111827 100%);
        }
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
            0% { transform: scale(0.8) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .modal-content { animation: popIn 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55); }

        /* Gaya baru untuk notifikasi sukses (berbasis modal) */
        .success-modal {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out;
        }
        .success-modal.show {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 sidebar text-gray-100 p-6 flex flex-col rounded-r-3xl">
        <div class="text-2xl font-bold text-center mb-8 text-indigo-400">
            <i class="fas fa-chart-line mr-2"></i>
            Finan.
        </div>
         <nav class="w-full">
            <ul>
                <li class="mb-2">
                    <a href="/bendahara/dashboard" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/pembelian" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-shopping-cart mr-3 text-lg text-cyan-400"></i>
                        Pembelian
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/penjualan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-handshake mr-3 text-lg text-green-400"></i>
                        Penjualan
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/supplier" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-truck mr-3 text-lg text-purple-400"></i>
                        Supplier
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/coa" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-area mr-3 text-lg text-yellow-400"></i>
                        C.O.A
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/jurnal" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-book mr-3 text-lg text-red-400"></i>
                        Jurnal
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/laporan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-pie mr-3 text-lg text-lime-400"></i>
                        Laporan
                    </a>
                </li>
            </ul>
            <li class="mb-2">
                    <a href="/bendahara/tagihan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-pie mr-3 text-lg text-lime-400"></i>
                        Tagihan Siswa
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto bg-gradient-to-br from-blue-50 to-indigo-100">
        <header class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 drop-shadow-md">Transaksi Disetujui</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar transaksi penjualan yang telah disetujui.</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 hidden md:block">Selamat Datang, Bendahara!</span>
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer hover:text-gray-900 transition-colors"></i>
            </div>
        </header>

        <!-- Tabel Transaksi Disetujui -->
        <div class="bg-white p-6 rounded-xl shadow-md mt-8">
            <div class="overflow-x-auto rounded-xl">
                <table class="min-w-full bg-white shadow-inner">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left font-bold">No. Transaksi</th>
                            <th class="py-3 px-6 text-left font-bold">Pelanggan</th>
                            <th class="py-3 px-6 text-left font-bold">Total</th>
                            <th class="py-3 px-6 text-left font-bold">Status</th>
                            <th class="py-3 px-6 text-left font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">TRX-20240516A</td>
                            <td class="py-4 px-6">PT Maju Makmur</td>
                            <td class="py-4 px-6 font-semibold">Rp 2.500.000</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Disetujui</span></td>
                            <td class="py-4 px-6">
                                <a href="#penerimaan-modal" onclick="openPenerimaanModal(this)"
                                    data-transaction-id="TRX-20240516A" 
                                    data-customer="PT Maju Makmur" 
                                    data-total="Rp 2.500.000"
                                    data-numeric-total="2500000"
                                    class="text-green-600 hover:text-green-800 transition-colors">
                                    <i class="fas fa-dollar-sign mr-1"></i>Proses Penerimaan
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">TRX-20240515B</td>
                            <td class="py-4 px-6">Toko Bintang</td>
                            <td class="py-4 px-6 font-semibold">Rp 7.800.000</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Disetujui</span></td>
                            <td class="py-4 px-6">
                                <a href="#penerimaan-modal" onclick="openPenerimaanModal(this)"
                                    data-transaction-id="TRX-20240515B" 
                                    data-customer="Toko Bintang" 
                                    data-total="Rp 7.800.000"
                                    data-numeric-total="7800000"
                                    class="text-green-600 hover:text-green-800 transition-colors">
                                    <i class="fas fa-dollar-sign mr-1"></i>Proses Penerimaan
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">TRX-20240514C</td>
                            <td class="py-4 px-6">Ibu Dian</td>
                            <td class="py-4 px-6 font-semibold">Rp 1.100.000</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Disetujui</span></td>
                            <td class="py-4 px-6">
                                <a href="#penerimaan-modal" onclick="openPenerimaanModal(this)"
                                    data-transaction-id="TRX-20240514C" 
                                    data-customer="Ibu Dian" 
                                    data-total="Rp 1.100.000"
                                    data-numeric-total="1100000"
                                    class="text-green-600 hover:text-green-800 transition-colors">
                                    <i class="fas fa-dollar-sign mr-1"></i>Proses Penerimaan
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">TRX-20240513D</td>
                            <td class="py-4 px-6">PT. Angkasa</td>
                            <td class="py-4 px-6 font-semibold">Rp 9.500.000</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Disetujui</span></td>
                            <td class="py-4 px-6">
                                <a href="#penerimaan-modal" onclick="openPenerimaanModal(this)"
                                    data-transaction-id="TRX-20240513D" 
                                    data-customer="PT. Angkasa" 
                                    data-total="Rp 9.500.000"
                                    data-numeric-total="9500000"
                                    class="text-green-600 hover:text-green-800 transition-colors">
                                    <i class="fas fa-dollar-sign mr-1"></i>Proses Penerimaan
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">TRX-20240512E</td>
                            <td class="py-4 px-6">Toko Sentra</td>
                            <td class="py-4 px-6 font-semibold">Rp 3.300.000</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Disetujui</span></td>
                            <td class="py-4 px-6">
                                <a href="#penerimaan-modal" onclick="openPenerimaanModal(this)"
                                    data-transaction-id="TRX-20240512E" 
                                    data-customer="Toko Sentra" 
                                    data-total="Rp 3.300.000"
                                    data-numeric-total="3300000"
                                    class="text-green-600 hover:text-green-800 transition-colors">
                                    <i class="fas fa-dollar-sign mr-1"></i>Proses Penerimaan
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <!-- Modal untuk Penerimaan Pembayaran -->
    <div id="penerimaan-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-6 rounded-xl shadow-2xl max-w-lg w-full relative z-10">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Proses Penerimaan Pembayaran</h2>
            <!-- Bagian ini akan diisi secara otomatis -->
            <div class="bg-gray-100 p-4 rounded-xl mb-4 text-sm text-gray-700">
                <p><strong>No. Transaksi:</strong> <span id="modal-penerimaan-id"></span></p>
                <p><strong>Pelanggan:</strong> <span id="modal-penerimaan-pelanggan"></span></p>
                <p><strong>Total:</strong> <span id="modal-penerimaan-total" class="font-bold text-blue-600"></span></p>
            </div>
            <form id="form_penerimaan" class="space-y-4">
                <div>
                    <label for="akun_bank_terima" class="block text-sm font-medium text-gray-700">Pilih Akun Kas/Bank</label>
                    <select id="akun_bank_terima" name="akun_bank_terima" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option>Bank BCA</option>
                        <option>Kas Tunai</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_penerimaan" class="block text-sm font-medium text-gray-700">Tanggal Penerimaan</label>
                        <input type="date" id="tanggal_penerimaan" name="tanggal_penerimaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="nominal_terima" class="block text-sm font-medium text-gray-700">Nominal Penerimaan</label>
                        <input type="number" id="nominal_terima" name="nominal_terima" placeholder="Rp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
                <div>
                    <label for="metode_penerimaan" class="block text-sm font-medium text-gray-700">Metode Penerimaan</label>
                    <select id="metode_penerimaan" name="metode_penerimaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option>Transfer</option>
                        <option>Tunai</option>
                    </select>
                </div>
                <div>
                    <label for="no_referensi_terima" class="block text-sm font-medium text-gray-700">Nomor Referensi</label>
                    <input type="text" id="no_referensi_terima" name="no_referensi_terima" placeholder="Masukkan nomor referensi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="#" class="bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-full hover:bg-gray-300 transition-colors">Batal</a>
                    <button type="button" onclick="prosesPenerimaan()" class="bg-green-600 text-white font-medium py-2 px-4 rounded-full shadow-md hover:bg-green-700 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i> Simpan Penerimaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Notifikasi Sukses Baru -->
    <div id="success-message-modal" class="modal-overlay success-modal">
        <div class="modal-content bg-white p-8 rounded-2xl shadow-2xl max-w-sm w-full text-center relative">
               <button onclick="closeSuccessMessageModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </button>
            <div class="flex flex-col items-center justify-center">
                <div class="bg-green-100 p-4 rounded-full mb-4">
                    <i class="fas fa-check-circle text-5xl text-green-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Sukses!</h3>
                <p class="text-gray-600 mb-4">Penerimaan pembayaran berhasil disimpan.</p>
                <button onclick="closeSuccessMessageModal()" class="bg-green-600 text-white font-medium py-2 px-6 rounded-full shadow-md hover:bg-green-700 transition-colors">
                    Oke
                </button>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal penerimaan pembayaran
        function openPenerimaanModal(element) {
            const transactionId = element.getAttribute('data-transaction-id');
            const customer = element.getAttribute('data-customer');
            const total = element.getAttribute('data-total');
            const numericTotal = element.getAttribute('data-numeric-total');

            document.getElementById('modal-penerimaan-id').textContent = transactionId;
            document.getElementById('modal-penerimaan-pelanggan').textContent = customer;
            document.getElementById('modal-penerimaan-total').textContent = total;
            document.getElementById('nominal_terima').value = numericTotal;
        }
        
        // Fungsi untuk menampilkan modal notifikasi sukses
        function showSuccessMessageModal() {
            const modal = document.getElementById('success-message-modal');
            modal.classList.add('show');

            // Menutup notifikasi secara otomatis setelah 4 detik
            setTimeout(() => {
                modal.classList.remove('show');
            }, 4000); // 4000ms = 4 detik
        }

        // Fungsi untuk menutup modal notifikasi sukses
        function closeSuccessMessageModal() {
            const modal = document.getElementById('success-message-modal');
            modal.classList.remove('show');
        }

        // Fungsi yang dijalankan saat tombol "Simpan Penerimaan" diklik
        function prosesPenerimaan() {
            console.log("Memproses penerimaan...");
            
            // Menutup modal penerimaan
            window.location.hash = ''; 
            
            // Menampilkan modal notifikasi sukses
            showSuccessMessageModal();
        }
    </script>
</body>
</html>
