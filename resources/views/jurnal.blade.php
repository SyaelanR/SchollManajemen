<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jurnal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Daftar Jurnal</h1>
            <!-- Tombol Tambah Jurnal, diubah untuk memicu modal CSS -->
            <a href="#tambah-jurnal-modal" class="flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-md">
                <i class="fas fa-plus mr-2"></i>
                <span>Tambah Jurnal</span>
            </a>
        </div>
        
        <!-- Tabel Daftar Jurnal -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Jurnal Umum</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nominal</th>
                        </tr>
                    </thead>
                    <tbody id="jurnal-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Data Jurnal akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal CSS Murni untuk Tambah Jurnal -->
    <div id="tambah-jurnal-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-lg w-full relative z-10">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Tambah Jurnal Manual</h2>
            <form id="jurnal-form" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                    </div>
                    <div>
                        <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                            <option value="Debit">Debit</option>
                            <option value="Kredit">Kredit</option>
                            <option value="Kas">Kas</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="nominal" class="block text-sm font-medium text-gray-700">Nominal</label>
                        <input type="number" name="nominal" id="nominal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                    </div>
                    <div class="md:col-span-2">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition-colors duration-200">
                        Simpan Jurnal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Notifikasi Berhasil -->
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
        // Data jurnal awal (simulasi database)
        let jurnalData = [
            { tanggal: "2024-05-20", keterangan: "Pembelian ATK", metode: "Kas", nominal: "150000" },
            { tanggal: "2024-05-19", keterangan: "Pendapatan dari penjualan", metode: "Debit", nominal: "500000" },
            { tanggal: "2024-05-18", keterangan: "Gaji Karyawan", metode: "Kredit", nominal: "2500000" },
            { tanggal: "2024-05-17", keterangan: "Biaya listrik dan air", metode: "Kas", nominal: "300000" },
            { tanggal: "2024-05-16", keterangan: "Pendapatan jasa", metode: "Debit", nominal: "1200000" }
        ];

        const jurnalForm = document.getElementById('jurnal-form');
        const jurnalTableBody = document.getElementById('jurnal-table-body');
        const suksesMessage = document.getElementById('sukses-message');
        
        // Fungsi untuk merender tabel jurnal
        function renderJurnalTable() {
            jurnalTableBody.innerHTML = '';
            jurnalData.forEach(item => {
                const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.tanggal}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.keterangan}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.metode}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.nominal}</td>
                    </tr>
                `;
                jurnalTableBody.innerHTML += row;
            });
        }

        // Handler saat formulir disubmit
        function handleFormSubmit(event) {
            event.preventDefault();
            
            // Ambil nilai dari input
            const tanggal = document.getElementById('tanggal').value;
            const metode = document.getElementById('metode_pembayaran').value;
            const nominal = document.getElementById('nominal').value;
            const keterangan = document.getElementById('keterangan').value;
            
            // Validasi sederhana
            if (!tanggal || !nominal || !keterangan) {
                // Dalam aplikasi nyata, Anda bisa menampilkan modal error
                console.error("Semua field harus diisi.");
                return;
            }

            // Buat objek jurnal baru
            const newJurnal = {
                tanggal: tanggal,
                metode: metode,
                nominal: nominal,
                keterangan: keterangan,
            };

            // Tambahkan jurnal baru ke array
            jurnalData.push(newJurnal);
            
            // Perbarui tabel di UI
            renderJurnalTable();
            
            // Tampilkan modal sukses
            suksesMessage.textContent = 'Jurnal berhasil disimpan.';
            window.location.hash = 'sukses-modal';
            
            // Tutup modal sukses secara otomatis
            setTimeout(() => {
                window.location.hash = '';
            }, 2000);

            // Reset formulir
            jurnalForm.reset();
        }

        // Menambahkan event listener ke formulir
        jurnalForm.addEventListener('submit', handleFormSubmit);

        // Render tabel saat halaman dimuat
        document.addEventListener('DOMContentLoaded', renderJurnalTable);
    </script>
</body>
</html>
