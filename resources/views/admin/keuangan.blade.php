<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan - Sistem Manajemen Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
        /* Modal transition */
        .modal {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="/" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 bg-gray-200 font-semibold text-gray-700">
                <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                <span>Keuangan</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Keuangan</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700"><i class="fa-solid fa-bell"></i></button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            <!-- Banner -->
            <div class="bg-indigo-600 rounded-xl p-8 mb-8 text-white shadow-none">
                <h2 class="text-3xl font-bold mb-2">Modul Keuangan</h2>
                <p class="text-indigo-200">Kelola pemasukan, pengeluaran, tagihan siswa, dan laporan keuangan sekolah.</p>
            </div>

            <!-- Ringkasan Saldo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-green-100 p-6 rounded-xl text-center shadow-none">
                    <h3 class="text-lg font-semibold text-gray-800">Total Pemasukan</h3>
                    <p class="text-green-600 text-2xl font-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-100 p-6 rounded-xl text-center shadow-none">
                    <h3 class="text-lg font-semibold text-gray-800">Total Pengeluaran</h3>
                    <p class="text-red-600 text-2xl font-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-100 p-6 rounded-xl text-center shadow-none">
                    <h3 class="text-lg font-semibold text-gray-800">Saldo</h3>
                    <p class="text-blue-600 text-2xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Menu Keuangan -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <button id="pemasukan-btn" class="bg-green-100 hover:bg-green-200 p-6 rounded-xl flex items-center space-x-4 transition shadow-none text-left">
                    <i class="fa-solid fa-plus-circle text-3xl text-green-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Pemasukan</h3>
                        <p class="text-gray-500 text-sm">Catat uang masuk</p>
                    </div>
                </button>
                <button id="pengeluaran-btn" class="bg-red-100 hover:bg-red-200 p-6 rounded-xl flex items-center space-x-4 transition shadow-none text-left">
                    <i class="fa-solid fa-minus-circle text-3xl text-red-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Pengeluaran</h3>
                        <p class="text-gray-500 text-sm">Catat uang keluar</p>
                    </div>
                </button>
                <a href="#grafikLaporan" class="bg-blue-100 hover:bg-blue-200 p-6 rounded-xl flex items-center space-x-4 transition shadow-none">
                    <i class="fa-solid fa-chart-line text-3xl text-blue-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Laporan</h3>
                        <p class="text-gray-500 text-sm">Grafik saldo kumulatif</p>
                    </div>
                </a>
                <a href="{{ route('tagihanSiswa') }}" class="bg-yellow-100 hover:bg-yellow-200 p-6 rounded-xl flex items-center space-x-4 transition shadow-none">
                    <i class="fa-solid fa-file-invoice-dollar text-3xl text-yellow-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Tagihan Siswa</h3>
                        <p class="text-gray-500 text-sm">Kelola tagihan & gabungkan nama siswa</p>
                    </div>
                </a>
            </div>

            <!-- Grafik Saldo Kumulatif -->
            <div id="grafikLaporan" class="bg-white rounded-xl p-6 mb-8 shadow-none">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Grafik Saldo Kumulatif</h3>
                <canvas id="keuanganChart" class="w-full h-64"></canvas>
            </div>

            <!-- Tabel Transaksi & Tagihan -->
            <div class="bg-white rounded-xl p-6 shadow-none">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Daftar Transaksi & Tagihan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                        <tr class="bg-gray-100 text-left text-gray-600 text-sm uppercase">
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Jenis</th>
                            <th class="p-3">Deskripsi</th>
                            <th class="p-3">Jumlah</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($transaksi as $item)
                            <tr class="border-b">
                                <td class="p-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td class="p-3 font-semibold {{ $item->jenis == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($item->jenis) }}
                                </td>
                                <td class="p-3">{{ $item->keterangan }}</td>
                                <td class="p-3">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td class="p-3 flex gap-2">
                                    <a href="#" class="text-blue-500 hover:underline">Edit</a>
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-3 text-center text-gray-500">Belum ada data transaksi.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- Pemasukan Modal -->
<div id="pemasukan-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-1/2 lg:w-1/3 transform transition-transform duration-300 scale-95">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-semibold text-green-600">Tambah Pemasukan</h3>
            <button class="close-modal-btn text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form id="pemasukan-form" method="POST" action="{{ route('storePemasukan') }}">
            @csrf
            <input type="hidden" name="jenis" value="pemasukan">
            <div class="mb-4">
                <label for="jumlah-pemasukan" class="block text-gray-700 font-medium mb-2">Jumlah (Rp)</label>
                <input type="number" id="jumlah-pemasukan" name="jumlah" placeholder="Contoh: 500000" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="mb-4">
                <label for="tanggal-pemasukan" class="block text-gray-700 font-medium mb-2">Tanggal</label>
                <input type="date" id="tanggal-pemasukan" name="tanggal" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="mb-6">
                <label for="keterangan-pemasukan" class="block text-gray-700 font-medium mb-2">Keterangan</label>
                <textarea id="keterangan-pemasukan" name="keterangan" rows="3" placeholder="Masukkan keterangan pemasukan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required></textarea>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" class="cancel-btn bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Pengeluaran Modal -->
<div id="pengeluaran-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-1/2 lg:w-1/3 transform transition-transform duration-300 scale-95">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-semibold text-red-600">Tambah Pengeluaran</h3>
            <button class="close-modal-btn text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form id="pengeluaran-form" method="POST" action="{{ route('storePengeluaran') }}">
             @csrf
             <input type="hidden" name="jenis" value="pengeluaran">
            <div class="mb-4">
                <label for="jumlah-pengeluaran" class="block text-gray-700 font-medium mb-2">Jumlah (Rp)</label>
                <input type="number" id="jumlah-pengeluaran" name="jumlah" placeholder="Contoh: 150000" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" required>
            </div>
            <div class="mb-4">
                <label for="tanggal-pengeluaran" class="block text-gray-700 font-medium mb-2">Tanggal</label>
                <input type="date" id="tanggal-pengeluaran" name="tanggal" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" required>
            </div>
            <div class="mb-6">
                <label for="keterangan-pengeluaran" class="block text-gray-700 font-medium mb-2">Keterangan</label>
                <textarea id="keterangan-pengeluaran" name="keterangan" rows="3" placeholder="Masukkan keterangan pengeluaran" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" required></textarea>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" class="cancel-btn bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart functionality
const ctx = document.getElementById('keuanganChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Saldo Kumulatif',
            data: @json($saldoKumulatifData),
            borderColor: 'rgba(79, 70, 229, 1)', // Indigo color
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            pointHoverRadius: 6,
            pointBackgroundColor: 'rgba(79, 70, 229, 1)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        interaction: { mode: 'nearest', axis: 'x', intersect: false },
        scales: {
            x: { grid: { display: false } },
            y: {
                title: { display: true, text: 'Saldo (Rp)' },
                beginAtZero: true,
                ticks: { callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); } }
            }
        }
    }
});

// Sidebar toggle
const menuButton = document.getElementById('menu-button');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const toggleSidebar = () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
};
menuButton.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', toggleSidebar);

// Modal functionality
const pemasukanModal = document.getElementById('pemasukan-modal');
const pengeluaranModal = document.getElementById('pengeluaran-modal');
const pemasukanBtn = document.getElementById('pemasukan-btn');
const pengeluaranBtn = document.getElementById('pengeluaran-btn');

const openModal = (modal) => {
    if (!modal) return;
    const modalContent = modal.querySelector('.modal-content');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        if (modalContent) modalContent.classList.remove('scale-95');
    }, 10);
};

const closeModal = (modal) => {
    if (!modal) return;
    const modalContent = modal.querySelector('.modal-content');
    modal.classList.add('opacity-0');
    if (modalContent) modalContent.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        const form = modal.querySelector('form');
        if (form) form.reset();
        
        // Reset tanggal ke hari ini
        const dateInput = form.querySelector('input[type="date"]');
        if(dateInput) dateInput.valueAsDate = new Date();

    }, 300);
};

pemasukanBtn.addEventListener('click', () => openModal(pemasukanModal));
pengeluaranBtn.addEventListener('click', () => openModal(pengeluaranModal));

document.querySelectorAll('.close-modal-btn, .cancel-btn').forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal');
        closeModal(modal);
    });
});

document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal(modal);
        }
    });
});

// Set default date to today for both modals
document.querySelectorAll('input[type="date"]').forEach(input => {
    input.valueAsDate = new Date();
});

</script>

</body>
</html>
