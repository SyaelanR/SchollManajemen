<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Absensi - {{ $kelas->nama_kelas }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar"
        class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                <span>Manajemen Guru</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                <span>Jadwal Pelajaran</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                <span>Keuangan</span>
            </a>
            <a href="{{ route('absensi.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 rounded-lg font-semibold">
                <i class="fa-solid fa-clipboard-check w-6 h-6 mr-3"></i>
                <span>Absensi</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-exclamation-triangle w-6 h-6 mr-3"></i>
                <span>Pelanggaran</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-cog w-6 h-6 mr-3"></i>
                <span>Pengaturan</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 lg:ml-64 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Absensi {{ $kelas->nama_kelas }}</h1>
            <a href="{{ route('absensi.index') }}" class="flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-full font-medium hover:bg-gray-300 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Kembali ke Daftar Kelas
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

                @foreach($siswa as $item)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-gray-200 py-4 last:border-b-0">
                        <div class="mb-2 sm:mb-0">
                            <p class="text-lg font-semibold text-gray-800">{{ $item->nama_siswa }}</p>
                            <p class="text-sm text-gray-500">NISN: {{ $item->nisn }}</p>
                        </div>
                        <div class="flex space-x-2 w-full sm:w-auto mt-2 sm:mt-0">
                            <input type="hidden" name="absensi[{{ $loop->index }}][siswa_id]" value="{{ $item->id }}">
                            <select name="absensi[{{ $loop->index }}][status]" class="form-select border rounded-lg p-2 flex-1">
                                <option value="Hadir">Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Alpa">Alpa</option>
                            </select>
                        </div>
                    </div>
                @endforeach
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold shadow-md hover:bg-indigo-700 transition-colors">
                        Simpan Absensi
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
