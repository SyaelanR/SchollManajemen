<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Supplier</title>
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
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
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
                    <a href="#" class="flex items-center p-3 rounded-lg bg-gray-800 text-indigo-400 font-semibold transition-colors duration-200">
                        <i class="fas fa-building mr-3 text-lg"></i>
                        Supplier
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
            Manajemen Supplier 🏢
        </h1>

        <!-- Control Panel -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 flex flex-col md:flex-row items-center justify-between">
            <div class="relative w-full md:w-64 mb-4 md:mb-0">
                <input type="text" placeholder="Cari supplier..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-300">
                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <a href="#" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 w-full md:w-auto text-center">
                <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Supplier
            </a>
        </div>
        
        <!-- Daftar Supplier -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Supplier</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-xl">Nama Perusahaan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Contoh data dari file rancangan -->
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">PT Sumber Makmur</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">08123456789</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Bandung</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-900">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">CV Media Sekolah</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">08987654321</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Bandung</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-900">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
