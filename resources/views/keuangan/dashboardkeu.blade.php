<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keuangan Sekolah</title>
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

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-gray-100 p-6 flex flex-col items-center">
        <div class="text-2xl font-bold text-center mb-8">
            <i class="fas fa-chart-line text-indigo-500 mr-2"></i>
            Finan.
        </div>
        <nav class="w-full">
            <ul>
                <li class="mb-4">
                    <a href="#" class="flex items-center p-3 rounded-lg bg-gray-800 text-indigo-400 font-semibold transition-colors duration-200">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-arrow-down mr-3 text-lg text-green-400"></i>
                        Pemasukan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-arrow-up mr-3 text-lg text-red-400"></i>
                        Pengeluaran
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-file-invoice-dollar mr-3 text-lg text-yellow-400"></i>
                        Laporan
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10">
            Dashboard Keuangan Sekolah 📈
        </h1>

        <!-- Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <p class="text-lg font-medium text-gray-500 mb-2">Total Pemasukan</p>
                <p class="text-3xl font-bold text-green-600">Rp 25.000.000</p>
                <!-- Ganti dengan variabel PHP Anda: Rp {{ number_format($totalPemasukan,0,',','.') }} -->
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <p class="text-lg font-medium text-gray-500 mb-2">Total Pengeluaran</p>
                <p class="text-3xl font-bold text-red-600">Rp 15.000.000</p>
                <!-- Ganti dengan variabel PHP Anda: Rp {{ number_format($totalPengeluaran,0,',','.') }} -->
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <p class="text-lg font-medium text-gray-500 mb-2">Saldo Akhir</p>
                <p class="text-3xl font-bold text-indigo-600">Rp 10.000.000</p>
                <!-- Ganti dengan variabel PHP Anda: Rp {{ number_format($saldo,0,',','.') }} -->
            </div>
        </div>

        <!-- Tabel Pemasukan -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-8">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Pemasukan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-xl">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-xl">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Contoh data placeholder -->
                        <tr class="hover:bg-green-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2023-10-26</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Sumbangan siswa baru</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp 10.000.000</td>
                        </tr>
                        <tr class="hover:bg-green-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2023-10-25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Dana BOS</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp 15.000.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Pengeluaran -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Pengeluaran</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-xl">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-xl">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Contoh data placeholder -->
                        <tr class="hover:bg-red-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2023-10-26</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Belanja ATK</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">Rp 5.000.000</td>
                        </tr>
                        <tr class="hover:bg-red-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2023-10-25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Gaji guru dan staf</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">Rp 10.000.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
