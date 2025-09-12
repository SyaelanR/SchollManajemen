<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSys - Pilih Kelas</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-menu a:hover { transform: translateX(4px); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen antialiased">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg p-6 flex flex-col justify-between">
            <div>
                <a href="#" class="text-3xl font-bold text-indigo-600 mb-8 flex items-center space-x-2">
                    <i class="fa-solid fa-school text-2xl"></i>
                    <span>EduSys</span>
                </a>
                <nav class="space-y-4 text-gray-700 font-medium sidebar-menu">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300">
                        <i class="fa-solid fa-tachometer-alt mr-3"></i>Dashboard
                    </a>
                    <a href="{{ route('input.nilai') }}" class="block px-4 py-3 rounded-lg bg-indigo-50 text-indigo-600 font-semibold border-l-4 border-indigo-600 transition-all duration-300">
                        <i class="fa-solid fa-pen mr-3"></i>Input Nilai
                    </a>
                    <a href="{{ route('manajemenSiswa') }}" class="block px-4 py-3 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300">
                        <i class="fa-solid fa-graduation-cap mr-3"></i>Manajemen Siswa
                    </a>
                </nav>
            </div>
            <div class="mt-8">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 transition duration-200">
                        <i class="fa-solid fa-sign-out-alt mr-3"></i>Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-10 overflow-y-auto">
            <header class="mb-8">
                <h1 class="text-4xl font-extrabold text-gray-900">Pilih Kelas</h1>
                <p class="text-gray-500 mt-2 text-lg">Silakan pilih kelas untuk menginput tugas terlebih dahulu.</p>
            </header>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 text-gray-800 flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-2 text-gray-900">Selamat Datang, Guru!</h2>
                    <p class="text-gray-500 text-lg">Anda memiliki {{ count($classes) }} kelas untuk dikelola hari ini.</p>
                </div>
            </div>

            <!-- Kartu Kelas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($classes as $kelas)
                <a href="{{ route('tugas.perkelas', ['kelas' => $kelas]) }}" class="group block bg-white p-6 rounded-2xl shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-[1.03] hover:shadow-2xl hover:bg-indigo-50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $kelas }}</h3>
                        <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:rotate-6">
                            <i class="fa-solid fa-door-open text-xl"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-500">Jumlah siswa: {{ $classCounts[$kelas] ?? 0 }}</p>
                    <div class="mt-4 text-sm font-semibold text-indigo-500 flex items-center">
                        Masuk Kelas <i class="fa-solid fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </main>
    </div>

</body>
</html>
