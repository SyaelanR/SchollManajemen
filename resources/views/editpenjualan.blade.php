<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Style untuk notifikasi */
        .notification {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #10B981; /* bg-emerald-500 */
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            font-weight: 600;
            text-align: center;
            z-index: 1000;
            transition: top 0.5s ease-in-out, opacity 0.5s ease-in-out;
            opacity: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .notification.show {
            top: 20px;
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
                    <a href="/pelanggan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-2-00">
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
                    <a href="/penjualan" class="flex items-center p-3 rounded-lg bg-gray-800 text-indigo-400 font-semibold transition-colors duration-200">
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
            </ul>
        </nav>
    </aside>
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Edit Penjualan</h1>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md max-w-lg mx-auto">
            <form id="edit-penjualan-form" class="space-y-4">
                <input type="hidden" id="sale-id-input">
                <div>
                    <label for="pelanggan-edit" class="block text-sm font-medium text-gray-700">Pelanggan</label>
                    <input type="text" name="pelanggan-edit" id="pelanggan-edit" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </div>
                <div>
                    <label for="produk-edit" class="block text-sm font-medium text-gray-700">Produk</label>
                    <input type="text" name="produk-edit" id="produk-edit" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </div>
                <div>
                    <label for="jumlah-edit" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah-edit" id="jumlah-edit" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" min="1" required>
                </div>
                <div>
                    <label for="tanggal_transaksi-edit" class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi-edit" id="tanggal_transaksi-edit" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div>
                    <label for="cara_bayar-edit" class="block text-sm font-medium text-gray-700">Cara Bayar</label>
                    <select name="cara_bayar-edit" id="cara_bayar-edit" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Kartu Kredit">Kartu Kredit</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
                <div class="flex justify-between pt-4">
                    <a href="/penjualan" class="px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md hover:bg-gray-400 transition-colors duration-200 text-center">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors text-center font-semibold shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>
    <div id="notification-modal" class="notification">
        <i class="fas fa-check-circle fa-2x text-white"></i>
        <p>Data Penjualan Berhasil Diperbarui!</p>
    </div>

    <script>
        // Data yang disimulasikan (Harus sama dengan index.html)
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

        const params = new URLSearchParams(window.location.search);
        const saleId = parseInt(params.get('id'));
        const saleToEdit = penjualanData.find(sale => sale.id === saleId);

        const form = document.getElementById('edit-penjualan-form');
        const pelangganInput = document.getElementById('pelanggan-edit');
        const produkInput = document.getElementById('produk-edit');
        const jumlahInput = document.getElementById('jumlah-edit');
        const tanggalInput = document.getElementById('tanggal_transaksi-edit');
        const caraBayarSelect = document.getElementById('cara_bayar-edit');
        const saleIdInput = document.getElementById('sale-id-input');
        const notificationModal = document.getElementById('notification-modal');

        // Fungsi untuk memuat data penjualan yang akan diedit
        function loadFormData() {
            if (!saleToEdit) {
                console.error('Penjualan tidak ditemukan.');
                window.location.href = '/penjualan';
                return;
            }

            const pelanggan = pelangganData.find(p => p.id === saleToEdit.pelangganId);
            const produk = produkData.find(p => p.id === saleToEdit.produkId);

            saleIdInput.value = saleToEdit.id;
            pelangganInput.value = pelanggan ? pelanggan.nama : 'Tidak Ditemukan';
            produkInput.value = produk ? produk.nama : 'Tidak Ditemukan';
            jumlahInput.value = saleToEdit.jumlah;
            tanggalInput.value = saleToEdit.tanggal;
            caraBayarSelect.value = saleToEdit.cara_bayar;
        }

        // Event listener untuk pengiriman formulir edit
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const index = penjualanData.findIndex(sale => sale.id === saleId);
            if (index !== -1) {
                const produk = produkData.find(p => p.id === saleToEdit.produkId);
                const updatedSale = {
                    id: saleId,
                    tanggal: tanggalInput.value,
                    pelangganId: saleToEdit.pelangganId,
                    produkId: saleToEdit.produkId,
                    jumlah: parseInt(jumlahInput.value),
                    harga: produk.harga * parseInt(jumlahInput.value),
                    cara_bayar: caraBayarSelect.value
                };
                
                penjualanData[index] = updatedSale;

                // Tampilkan notifikasi
                notificationModal.classList.add('show');
                
                // Alihkan ke halaman utama setelah 2 detik
                setTimeout(() => {
                    window.location.href = '/penjualan';
                }, 2000);
            }
        });

        // Muat data form saat halaman dimuat
        document.addEventListener('DOMContentLoaded', loadFormData);
    </script>
</body>
</html>
