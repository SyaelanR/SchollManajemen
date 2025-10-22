<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Absensi - EduSys</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
 body{font-family:'Inter',sans-serif;}
 .sidebar{transition:transform .3s ease-in-out,box-shadow .3s ease-in-out;}
 .status-select{
   appearance:none;
   background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'%3e%3cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3e%3c/svg%3e");
   background-repeat:no-repeat;
   background-position:right 0.5rem center;
   background-size:1.5em;
   padding-right:2.5rem;
   border:none;
   border-radius:0.5rem;
   cursor:pointer;
   font-weight:600;
 }
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
        <header class="bg-white shadow-lg p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-slate-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-slate-800">Input Absensi - Kelas {{ $kelas }}</h1>
        </header>

        <main class="p-4 md:p-8 flex-1">
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-start mb-6 space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('absensi.daftar') }}" class="flex items-center px-4 py-2 text-indigo-600 bg-indigo-100 rounded-full hover:bg-indigo-200 transition-colors duration-200">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <h3 class="text-xl font-bold text-slate-800">Data Absensi Siswa</h3>
                </div>

                <form method="POST" action="{{ route('absensi.store',$kelas) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-lg font-semibold text-slate-700 mb-2">Tanggal:</label>
                        <!-- Visually displayed date -->
                        <div id="display-date" class="px-4 py-2 w-full max-w-xs border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 cursor-pointer flex items-center justify-between">
                            <span id="formatted-date"></span>
                            <i class="fa-solid fa-calendar text-slate-500"></i>
                        </div>
                        <!-- Hidden input for form submission -->
                        <input type="date" id="tanggal_absensi" name="tanggal_absensi" value="{{ now()->toDateString() }}" class="hidden">
                    </div>
                    <div class="overflow-x-auto rounded-xl shadow-inner border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-indigo-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider ">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach($students as $s)
                                <tr class="hover:bg-indigo-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-slate-900">{{ $s['id'] }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-900">{{ $s['nama'] }}</td>
                                    <td class="px-6 py-4">
                                        <select name="status[{{ $s['id'] }}]" class="status-select px-3 py-1 w-28 text-sm rounded-lg shadow-sm">
                                            <option value="Hadir">Hadir</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Alfa">Alfa</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-6 py-3 font-semibold text-white rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 bg-gradient-to-r from-purple-600 to-indigo-600">
                            Simpan Absensi
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    // Function to toggle sidebar
    const toggleSidebar = () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    };
    
    // Event listeners
    menuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
    
    // --- Logic to style the status dropdown like a badge ---
    document.querySelectorAll('.status-select').forEach(sel => {
        const updateStatusStyle = () => {
            // Reset existing classes
            sel.classList.remove('bg-green-100', 'text-green-800', 'bg-yellow-100', 'text-yellow-800', 'bg-orange-100', 'text-orange-800', 'bg-red-100', 'text-red-800');
            
            // Apply new classes based on the selected value
            const status = sel.value;
            switch (status) {
                case 'Hadir':
                    sel.classList.add('bg-green-100', 'text-green-800');
                    break;
                case 'Izin':
                    sel.classList.add('bg-yellow-100', 'text-yellow-800');
                    break;
                case 'Sakit':
                    sel.classList.add('bg-orange-100', 'text-orange-800');
                    break;
                case 'Alfa':
                    sel.classList.add('bg-red-100', 'text-red-800');
                    break;
            }
        };
        
        // Initial styling on page load
        updateStatusStyle();
        
        // Add event listener for future changes
        sel.addEventListener('change', updateStatusStyle);
    });

    // --- Logic for custom date display ---
    const dateInput = document.getElementById('tanggal_absensi');
    const displayDate = document.getElementById('display-date');
    const formattedDateSpan = document.getElementById('formatted-date');

    // Function to format the date
    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = days[date.getDay()];
        const day = date.getDate();
        const monthName = months[date.getMonth()];
        const year = date.getFullYear();

        return `${dayName}, ${day} ${monthName} ${year}`;
    };

    // Set initial formatted date
    formattedDateSpan.textContent = formatDate(dateInput.value);

    // Update formatted date when a new date is selected
    dateInput.addEventListener('change', (event) => {
        formattedDateSpan.textContent = formatDate(event.target.value);
    });

    // Open the date picker when the display div is clicked
    displayDate.addEventListener('click', () => {
        dateInput.showPicker();
    });
</script>

</body>
</html>
