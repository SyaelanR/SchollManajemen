<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pilih Kelas - Manajemen Absensi</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
 body{font-family:'Inter',sans-serif;}
 .sidebar{transition:transform .3s ease-in-out,box-shadow .3s ease-in-out;}
</style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
        
                <a href="{{ route('inputtugas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Input Nilai</span>
                </a>

                <a href="{{ route('absensi.daftar') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                    <i class="fa-solid fa-list-check mr-3"></i>
                    <span>Input Absensi</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-puzzle-piece mr-3"></i>
                    <span>Ekstrakulikuler</span>
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
        <div class="absolute bottom-0 w-full p-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
    
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Daftar Kelas</h1>
        </header>

        <main class="p-6 md:p-8 flex-1">
            {{-- ✅ Flash message sukses --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 font-semibold shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-xl font-semibold mb-6">Pilih kelas untuk input absensi:</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($classes as $class)
                        <a href="{{ route('absensi.kelas', $class->id) }}"
                           class="block bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold p-6 rounded-xl shadow transition duration-200">
                           <div class="text-2xl mb-2"><i class="fa-solid fa-door-open"></i></div>
                           {{ $class->nama }}<br>
                           <span class="text-sm text-gray-600">Jumlah Siswa: {{ $class->jumlah_siswa }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>

<script>
const menuButton=document.getElementById('menu-button');
const sidebar=document.getElementById('sidebar');
const overlay=document.getElementById('overlay');
const toggleSidebar=()=>{sidebar.classList.toggle('-translate-x-full');overlay.classList.toggle('hidden');};
menuButton.addEventListener('click',toggleSidebar);
overlay.addEventListener('click',toggleSidebar);
</script>

</body>
</html>
