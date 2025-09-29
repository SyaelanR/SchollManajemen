<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pembelian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8; /* Latar belakang lebih terang */
        }
        .sidebar {
            background-image: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .menu-card {
            background-image: linear-gradient(145deg, #ffffff 0%, #f9fafb 100%);
            transition: all 0.3s ease-in-out;
        }
        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        .icon-container {
            transition: all 0.3s ease-in-out;
        }
        .menu-card:hover .icon-container {
            transform: scale(1.1);
        }

        .report-card {
            @apply bg-white p-6 rounded-2xl shadow-lg;
            transition: all 0.3s ease-in-out;
        }
        .report-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
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
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 drop-shadow-md">Modul Pembelian</h1>
                <p class="text-sm text-gray-500 mt-1">Pilih menu untuk mengelola transaksi pembelian Anda.</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 hidden md:block">Selamat Datang, Bendahara!</span>
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer hover:text-gray-900 transition-colors"></i>
            </div>
        </header>

        <!-- Bagian Menu Utama Pembelian -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 mb-8">
            <!-- Kartu Menu: Daftar & Persetujuan -->
            <a href="/bendahara/persetujuan" class="menu-card rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                <div class="p-5 bg-indigo-500 text-white rounded-full mb-4 shadow-lg icon-container">
                    <i class="fas fa-check-circle text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Daftar & Persetujuan</h3>
                <p class="text-sm text-gray-500 mt-2">Periksa dan setujui pengajuan pembelian dari admin.</p>
            </a>

            <!-- Kartu Menu: Pembayaran Supplier -->
            <a href="/bendahara/pembayaran" class="menu-card rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                <div class="p-5 bg-green-500 text-white rounded-full mb-4 shadow-lg icon-container">
                    <i class="fas fa-file-invoice-dollar text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Pembayaran Supplier</h3>
                <p class="text-sm text-gray-500 mt-2">Lakukan pembayaran untuk transaksi yang sudah disetujui.</p>
            </a>
        </div>

        <!-- Bagian Laporan dan Ringkasan -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6 drop-shadow-sm">Ringkasan Aktivitas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Kartu Ringkasan Pembelian Bulanan -->
            <div class="report-card flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pengeluaran Bulan Ini</p>
                    <h4 class="text-3xl font-extrabold text-blue-600 mt-1">Rp 12.500.000</h4>
                </div>
                <div class="p-4 bg-blue-100 text-blue-600 rounded-full">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>

            <!-- Kartu Jumlah Transaksi -->
            <div class="report-card flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                    <h4 class="text-3xl font-extrabold text-indigo-600 mt-1">14</h4>
                </div>
                <div class="p-4 bg-indigo-100 text-indigo-600 rounded-full">
                    <i class="fas fa-receipt text-2xl"></i>
                </div>
            </div>
            
            <!-- Kartu Status Pengajuan -->
            <div class="report-card flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pengajuan Menunggu</p>
                    <h4 class="text-3xl font-extrabold text-red-500 mt-1">3</h4>
                </div>
                <div class="p-4 bg-red-100 text-red-500 rounded-full">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Tabel Pengajuan Terbaru -->
        <div class="report-card mt-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Pengajuan Terbaru</h3>
            <div class="overflow-x-auto rounded-xl">
                <table class="min-w-full bg-white shadow-inner">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left font-bold">No. Pengajuan</th>
                            <th class="py-3 px-6 text-left font-bold">Supplier</th>
                            <th class="py-3 px-6 text-left font-bold">Total</th>
                            <th class="py-3 px-6 text-left font-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">INV-20230103</td>
                            <td class="py-4 px-6">PT. Sejahtera Abadi</td>
                            <td class="py-4 px-6 font-semibold">Rp 2.500.000</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">Menunggu</span></td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">INV-20230102</td>
                            <td class="py-4 px-6">CV. Sentosa Jaya</td>
                            <td class="py-4 px-6 font-semibold">Rp 750.000</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Disetujui</span></td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">INV-20230101</td>
                            <td class="py-4 px-6">PT. Maju Bersama</td>
                            <td class="py-4 px-6 font-semibold">Rp 1.500.000</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Disetujui</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
