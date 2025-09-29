<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-gray-100 p-6 flex flex-col items-center">
        <div class="text-2xl font-bold text-center mb-8">
            <i class="fas fa-user-graduate text-indigo-500 mr-2"></i>
            Wali Siswa
        </div>
        <nav class="w-full">
            <ul>
                <li class="mb-2">
                    <a href="/wali/dashboard" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/wali/profil" class="flex items-center p-3 rounded-lg bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-user mr-3 text-lg text-green-400"></i>
                        Profil
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/wali/tagihan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-file-invoice-dollar mr-3 text-lg text-lime-400"></i>
                        Tagihan Siswa
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Profil Siswa</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Selamat Datang, Wali Siswa!</span>
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
            </div>
        </div>

        <!-- Kartu Profil Siswa -->
        <div class="bg-white p-8 rounded-xl shadow-md max-w-3xl mx-auto">
            <div class="flex flex-col md:flex-row items-center md:items-start md:space-x-8">
                <div class="flex-shrink-0 mb-6 md:mb-0">
                    <!-- Foto Profil -->
                    <img src="https://via.placeholder.com/150" alt="Foto Siswa" class="w-40 h-40 rounded-full border-4 border-indigo-500 object-cover">
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Biodata Siswa</h2>
                    <table class="min-w-full text-sm text-gray-700">
                        <tbody>
                            <tr>
                                <td class="py-2 font-semibold w-48">Nama Lengkap</td>
                                <td class="py-2">Ahmad Fauzan</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold">NIS</td>
                                <td class="py-2">2025001</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold">Kelas</td>
                                <td class="py-2">XI IPA 2</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold">Tanggal Lahir</td>
                                <td class="py-2">12 Januari 2009</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold">Alamat</td>
                                <td class="py-2">Jl. Melati No. 10, Surabaya</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold">Nomor HP</td>
                                <td class="py-2">0812 3456 7890</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold">Wali Kelas</td>
                                <td class="py-2">Ibu Siti Rahmawati</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Informasi Orang Tua / Wali -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Informasi Wali</h2>
                <table class="min-w-full text-sm text-gray-700">
                    <tbody>
                        <tr>
                            <td class="py-2 font-semibold w-48">Nama Wali</td>
                            <td class="py-2">Bapak Hendra Wijaya</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Nomor HP Wali</td>
                            <td class="py-2">0813 9876 5432</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Pekerjaan</td>
                            <td class="py-2">Pegawai Swasta</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Alamat Wali</td>
                            <td class="py-2">Jl. Kenanga No. 45, Surabaya</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
