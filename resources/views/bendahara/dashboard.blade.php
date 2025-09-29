<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Selamat Datang, Bendahara!</span>
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
            </div>
        </div>

        <!-- Bagian Notifikasi dan Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Kartu Notifikasi Transaksi -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold text-gray-500">Transaksi Menunggu Persetujuan</div>
                    <div class="text-3xl font-bold text-gray-900 mt-1">5</div>
                </div>
                <div class="bg-indigo-100 text-indigo-600 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>

            <!-- Kartu Invoice Jatuh Tempo -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold text-gray-500">Invoice Jatuh Tempo</div>
                    <div class="text-3xl font-bold text-gray-900 mt-1">2</div>
                </div>
                <div class="bg-red-100 text-red-600 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-file-invoice-dollar text-2xl"></i>
                </div>
            </div>

            <!-- Kartu Saldo Kas/Bank -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold text-gray-500">Saldo Kas/Bank</div>
                    <div class="text-3xl font-bold text-gray-900 mt-1">Rp 150.000.000</div>
                </div>
                <div class="bg-green-100 text-green-600 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-university text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Bagian Tabel Transaksi Terbaru -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Transaksi Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Contoh data transaksi statis -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">18 Mei 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Pemasukan</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Pembayaran dari Pelanggan C</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 25.000.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">17 Mei 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">Pengeluaran</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Pembayaran ke Supplier D</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 5.500.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">17 Mei 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Pemasukan</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Penjualan produk F</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp 10.000.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
