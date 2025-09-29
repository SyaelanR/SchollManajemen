<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan</title>
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

        /* Tambahan untuk notifikasi yang bisa hilang otomatis */
        #sukses-modal {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        #sukses-modal.show {
            visibility: visible;
            opacity: 1;
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

    <main id="main-content" class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Daftar Penjualan</h1>
            <a href="#tambah-penjualan-modal" id="add-sale-btn" class="flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                <span>Tambah Penjualan</span>
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Penjualan Saat Ini</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="sales-table-body">
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <div id="tambah-penjualan-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-lg w-full relative z-10">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <h2 id="modal-title" class="text-2xl font-bold mb-6 text-gray-900">Tambah Penjualan</h2>
            <form id="penjualan-form" class="space-y-4">
                <div>
                    <label for="pelanggan" class="block text-sm font-medium text-gray-700">Pilih Pelanggan</label>
                    <select name="pelanggan" id="pelanggan" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </select>
                </div>
                <div>
                    <label for="produk" class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                    <select name="produk" id="produk" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </select>
                </div>
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" min="1" required>
                </div>
                <div>
                    <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div>
                    <label for="cara_bayar" class="block text-sm font-medium text-gray-700">Cara Bayar</label>
                    <input type="text" name="cara_bayar" id="cara_bayar" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors text-center font-semibold shadow-md">Simpan Penjualan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="konfirmasi-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full relative z-10 text-center">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <div class="flex flex-col items-center">
                <i class="fas fa-exclamation-triangle text-orange-500 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2 text-gray-900">Konfirmasi Hapus</h2>
                <p class="text-gray-600">Apakah Anda yakin ingin menghapus penjualan ini?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="#" id="confirm-delete-btn" class="px-6 py-2 bg-red-600 text-white font-semibold rounded-md shadow-md hover:bg-red-700 transition-colors duration-200">
                        Hapus
                    </a>
                    <a href="#" class="px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div id="sukses-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full relative z-10 text-center">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <div class="flex flex-col items-center">
                <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2 text-gray-900">Berhasil!</h2>
                <p id="sukses-message" class="text-gray-600"></p>
                <div class="mt-6">
                    <a href="#" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md shadow-md hover:bg-green-600 transition-colors duration-200">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data yang disimulasikan
        let pelangganData = [
            { id: 1, nama: 'PT Sumber Makmur' },
            { id: 2, nama: 'CV Media Sekolah' }
        ];

        let produkData = [
            { id: 1, nama: 'Buku Matematika', harga: 500000 },
            { id: 2, nama: 'Pensil 2B', harga: 25000 }
        ];

        let penjualanData = [
            { id: 1, tanggal: '2023-10-26', pelangganId: 1, produkId: 1, jumlah: 1, harga: 500000, cara_bayar: 'Transfer Bank' },
            { id: 2, tanggal: '2023-10-25', pelangganId: 2, produkId: 2, jumlah: 1, harga: 25000, cara_bayar: 'Tunai' }
        ];

        let nextPenjualanId = penjualanData.length > 0 ? Math.max(...penjualanData.map(p => p.id)) + 1 : 1;
        let penjualanToDeleteId = null;

        const salesTableBody = document.getElementById('sales-table-body');
        const penjualanForm = document.getElementById('penjualan-form');
        const pelangganSelect = document.getElementById('pelanggan');
        const produkSelect = document.getElementById('produk');
        const suksesMessage = document.getElementById('sukses-message');
        const suksesModal = document.getElementById('sukses-modal');
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');

        // Fungsi untuk merender tabel penjualan
        function renderPenjualanTable() {
            salesTableBody.innerHTML = ''; // Kosongkan tabel
            
            penjualanData.forEach(sale => {
                const pelanggan = pelangganData.find(p => p.id === sale.pelangganId);
                const produk = produkData.find(p => p.id === sale.produkId);
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${sale.tanggal}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${pelanggan ? pelanggan.nama : 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${produk ? produk.nama : 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp ${new Intl.NumberFormat('id-ID').format(sale.harga)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="/penjualan/editpenjualan?id=${sale.id}" data-action="edit" class="text-indigo-600 hover:text-indigo-900 mr-4 edit-btn">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="#konfirmasi-modal" data-id="${sale.id}" data-action="delete" class="text-red-600 hover:text-red-900 delete-btn">
                            <i class="fa-solid fa-trash-alt"></i>
                        </a>
                    </td>
                `;
                salesTableBody.appendChild(row);
            });
        }
        
        // Fungsi untuk mengisi pilihan di modal
        function populateModalOptions() {
            pelangganSelect.innerHTML = '';
            produkSelect.innerHTML = '';

            pelangganData.forEach(pelanggan => {
                const option = document.createElement('option');
                option.value = pelanggan.id;
                option.textContent = pelanggan.nama;
                pelangganSelect.appendChild(option);
            });

            produkData.forEach(produk => {
                const option = document.createElement('option');
                option.value = produk.id;
                option.textContent = produk.nama;
                produkSelect.appendChild(option);
            });
        }

        // Fungsi untuk menampilkan notifikasi sukses
        function showSuccessNotification(message) {
            suksesMessage.textContent = message;
            suksesModal.classList.add('show');
            setTimeout(() => {
                suksesModal.classList.remove('show');
            }, 3000); // Notifikasi akan hilang setelah 3 detik
        }
        
        // Fungsi untuk menangani pengiriman formulir
        penjualanForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const form = e.target;
            const pelangganId = parseInt(form.pelanggan.value);
            const produkId = parseInt(form.produk.value);
            const jumlah = parseInt(form.jumlah.value);
            const tanggal = form.tanggal_transaksi.value;
            const caraBayar = form.cara_bayar.value;

            // Dapatkan harga produk
            const produk = produkData.find(p => p.id === produkId);
            const hargaTotal = produk.harga * jumlah;

            const newPenjualan = {
                id: nextPenjualanId++,
                tanggal: tanggal,
                pelangganId: pelangganId,
                produkId: produkId,
                jumlah: jumlah,
                harga: hargaTotal,
                cara_bayar: caraBayar
            };
            
            penjualanData.push(newPenjualan);
            
            // Tutup modal form
            window.location.hash = '';

            // Tampilkan notifikasi sukses yang akan hilang otomatis
            showSuccessNotification('Penjualan berhasil disimpan!');
            
            form.reset();
            renderPenjualanTable();
        });
        
        // Fungsi untuk menangani aksi tombol
        document.addEventListener('click', (e) => {
            const target = e.target.closest('a');
            if (!target) return;

            const action = target.dataset.action;
            const id = parseInt(target.dataset.id);

            if (action === 'delete') {
                e.preventDefault();
                penjualanToDeleteId = id;
                window.location.hash = 'konfirmasi-modal';
            }
        });

        // Event listener untuk tombol konfirmasi hapus
        confirmDeleteBtn.addEventListener('click', () => {
            if (penjualanToDeleteId !== null) {
                penjualanData = penjualanData.filter(p => p.id !== penjualanToDeleteId);
                
                // Tutup modal konfirmasi
                window.location.hash = '';

                // Tampilkan notifikasi sukses yang akan hilang otomatis
                showSuccessNotification('Penjualan berhasil dihapus.');
                
                renderPenjualanTable();
            }
        });
        
        // Render halaman awal saat aplikasi dimuat
        document.addEventListener('DOMContentLoaded', () => {
            populateModalOptions();
            renderPenjualanTable();
        });
    </script>
</body>
</html>
