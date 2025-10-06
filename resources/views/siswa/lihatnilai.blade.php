<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Mata Pelajaran - Sistem Nilai</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 for notifications (Dihapus karena tidak ada aksi, namun CDN dipertahankan) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom styles */
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-graduation-cap text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">Sistem Nilai</span>
            </a>
        </div>
        <nav class="mt-6">
            <!-- Link Kembalian dipertahankan -->
            <a href="{{ route('pilihMapel') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-arrow-left mr-3"></i>
                <span>Kembali ke Mapel</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-file-invoice mr-3"></i>
                <span>Detail Nilai</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <!-- Contoh Logout -->
            <button class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full text-left">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i><span>Logout</span>
            </button>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Nilai Mata Pelajaran</h1>
            <div class="flex items-center space-x-4">
                 <!-- Avatar inisial S (Siswa) -->
                 <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/38a169/ffffff?text=S" alt="User Avatar">
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            
            <header class="mb-8 bg-blue-600 p-8 rounded-2xl shadow-lg text-white">
                <h2 class="text-3xl font-bold mb-2">Nilai {{ $namaMapel }}</h2>
                <p class="text-blue-200">Tampilan nilai untuk **{{ $namaSiswa }}** di kelas **{{ $namaKelas }}**.</p>
            </header>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Rincian Nilai Mata Pelajaran</h2>
                    <!-- Indikator KKM -->
                    <div class="p-2 px-4 bg-gray-100 rounded-lg text-sm font-medium text-gray-600">
                        KKM (Kriteria Ketuntasan Minimal): <strong>{{ $kkm }}</strong>
                    </div>
                </div>
                
                <!-- Table for single student detail (Transposed view for clarity) -->
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-inner">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider w-48">Komponen Penilaian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nilai Anda</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status Ketuntasan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @forelse ($nilaiSiswa as $key => $nilai)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">Nilai {{ strtoupper($key) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-semibold text-gray-700">{{ $nilai ?? 'N/A' }}</td>
                                    @php
                                        $status = ($nilai ?? 0) >= $kkm ? 'Tuntas' : 'Belum Tuntas';
                                        $statusClass = $nilai >= $kkm ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100';
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-500">Belum ada data nilai untuk mata pelajaran ini.</td>
                                </tr>
                            @endforelse

                            <!-- Rata-rata Akhir -->
                            <tr class="bg-indigo-50 border-t-2 border-indigo-200">
                                <td class="px-6 py-4 whitespace-nowrap text-base font-bold text-indigo-800">RATA-RATA AKHIR</td>
                                <td class="px-6 py-4 whitespace-nowrap text-2xl font-extrabold 
                                    {{ $rataRata >= $kkm ? 'text-green-700' : 'text-red-700' }}">
                                    {{ number_format($rataRata, 2) }}
                                </td>
                                @php
                                    $finalStatus = $rataRata >= $kkm ? 'LULUS' : 'REMIDI';
                                    $finalStatusClass = $rataRata >= $kkm ? 'text-white bg-green-600' : 'text-white bg-red-600';
                                @endphp
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-extrabold rounded-full {{ $finalStatusClass }} shadow-md">
                                        {{ $finalStatus }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Menghilangkan pesan jika data kosong karena ini adalah data tunggal siswa -->
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Sidebar Toggle ---
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    if(menuButton && sidebar && overlay) {
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    }
    
    // --- Semua LOGIC EDIT/HAPUS DIHAPUS karena ini adalah menu siswa (hanya baca) ---
});
</script>

</body>
</html>
