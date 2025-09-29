<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Manajemen Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Pure CSS modal styles */
        .modal-overlay {
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .modal-overlay:target {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }

        @keyframes popIn {
            0% {
                transform: scale(0.8) translateY(20px);
                opacity: 0;
            }
            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .modal-content {
            animation: popIn 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen">
    <!-- Sidebar Menu -->
    <aside class="w-64 bg-gray-900 text-gray-100 p-6 flex flex-col items-center">
        <div class="text-2xl font-bold text-center mb-8">
            <i class="fas fa-chart-line text-indigo-500 mr-2"></i>
            Finan.
        </div>
        <nav class="w-full">
            <ul>
                <li class="mb-4">
                    <a href="/" class="flex items-center p-3 rounded-lg bg-gray-800 text-indigo-400 font-semibold transition-colors duration-200">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/produk" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-box mr-3 text-lg text-yellow-400"></i>
                        Produk
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/supplier" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-truck mr-3 text-lg text-purple-400"></i>
                        Supplier
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/pelanggan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-users mr-3 text-lg text-blue-400"></i>
                        Pelanggan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/pembelian" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-shopping-cart mr-3 text-lg text-cyan-400"></i>
                        Pembelian
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/penjualan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-handshake mr-3 text-lg text-green-400"></i>
                        Penjualan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/jurnal" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-book mr-3 text-lg text-red-400"></i>
                        Jurnal
                    </a>
                </li>
                </li>
                <li class="mb-4">
                    <a href="/laporan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-pie mr-3 text-lg text-lime-400"></i>
                        Laporan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/coa" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-pie mr-3 text-lg text-lime-400"></i>
                        COA
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main id="main-content" class="flex-1 p-8 overflow-y-auto">
        <!-- Konten akan dimuat di sini oleh JavaScript -->
    </main>

    <!-- Modal Tambah/Edit Pelanggan -->
    <div id="tambah-pelanggan-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-lg w-full relative z-10">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <h2 id="modal-title" class="text-2xl font-bold mb-6 text-gray-900">Tambah Pelanggan</h2>
            <form id="pelanggan-form" class="space-y-4">
                <div>
                    <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="kontak" class="block text-sm font-medium text-gray-700">Kontak</label>
                    <input type="text" name="kontak" id="kontak" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="kelas_santri" class="block text-sm font-medium text-gray-700">Kelas/Relasi Santri</label>
                    <input type="text" name="kelas_santri" id="kelas_santri" class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors text-center font-semibold shadow-md">Simpan Pelanggan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="konfirmasi-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full relative z-10 text-center">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <div class="flex flex-col items-center">
                <i class="fas fa-exclamation-triangle text-orange-500 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2 text-gray-900">Konfirmasi Hapus</h2>
                <p class="text-gray-600">Apakah Anda yakin ingin menghapus pelanggan ini?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="#" id="confirm-delete-btn" class="px-6 py-2 bg-red-600 text-white font-semibold rounded-md shadow-md hover:bg-red-700 transition-colors duration-200">
                        Hapus
                    </a>
                    <a href="#" class="px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Notifikasi Berhasil -->
    <div id="sukses-modal" class="modal-overlay">
        <a href="#" class="absolute top-0 left-0 w-full h-full"></a>
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full relative z-10 text-center">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </a>
            <div class="flex flex-col items-center">
                <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2 text-gray-900">Berhasil!</h2>
                <p id="sukses-message" class="text-gray-600"></p>
                <div class="mt-6">
                    <a href="#" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md shadow-md hover:bg-green-600 transition-colors duration-200">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data yang disimulasikan (berfungsi seperti database)
        let pelangganData = [
            { id: 1, nama: "PT Sumber Makmur", kontak: "08123456789", kelas: "Kelas 10" },
            { id: 2, nama: "Toko Jaya Abadi", kontak: "08765432101", kelas: "Bukan Santri" }
        ];
        let nextPageId = pelangganData.length > 0 ? Math.max(...pelangganData.map(p => p.id)) + 1 : 1;
        let pelangganToDeleteId = null;

        const mainContent = document.getElementById('main-content');
        const pelangganForm = document.getElementById('pelanggan-form');
        const modalTitle = document.getElementById('modal-title');
        const suksesMessage = document.getElementById('sukses-message');
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        
        // Fungsi untuk merender halaman daftar pelanggan
        function renderDaftarPelanggan() {
            const pelangganRows = pelangganData.map(pelanggan => `
                <tr id="pelanggan-${pelanggan.id}">
                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">${pelanggan.nama}</div></td>
                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-500">${pelanggan.kontak}</div></td>
                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-500">${pelanggan.kelas}</div></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/pelanggan/editpelanggan?id=${pelanggan.id}" class="text-indigo-600 hover:text-indigo-900 mr-4"><i class="fa-solid fa-edit"></i></a>
                        <a href="#konfirmasi-modal" data-action="delete" data-id="${pelanggan.id}" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash-alt"></i></a>
                    </td>
                </tr>
            `).join('');

            mainContent.innerHTML = `
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-4xl font-extrabold text-gray-900">Daftar Pelanggan</h1>
                    <a href="#tambah-pelanggan-modal" class="flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Tambah Pelanggan</span>
                    </a>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Pelanggan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas/Relasi Santri</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="pelanggan-list">
                            ${pelangganRows}
                        </tbody>
                    </table>
                </div>
            `;
        }
        
        // Fungsi pengendali pengiriman formulir
        function handleFormSubmit(event) {
            event.preventDefault();
            const form = event.target;
            const newPelanggan = {
                id: nextPageId++,
                nama: form.nama_pelanggan.value,
                kontak: form.kontak.value,
                kelas: form.kelas_santri.value,
            };

            pelangganData.push(newPelanggan);
            
            suksesMessage.textContent = 'Pelanggan berhasil ditambahkan.';
            window.location.hash = 'sukses-modal';
            
            // Tutup modal sukses secara otomatis setelah 2 detik
            setTimeout(() => {
                window.location.hash = '';
            }, 2000);

            // Kosongkan formulir setelah disimpan
            form.reset();
        }

        // Fungsi pengendali untuk aksi tombol
        function handleActions(event) {
            const target = event.target.closest('a');
            if (!target) return;
            const action = target.dataset.action;

            if (action === 'delete') {
                event.preventDefault();
                pelangganToDeleteId = parseInt(target.dataset.id);
                window.location.hash = 'konfirmasi-modal';
            }
        }
        
        // Event listener untuk tombol konfirmasi hapus
        confirmDeleteBtn.addEventListener('click', () => {
            if (pelangganToDeleteId !== null) {
                pelangganData = pelangganData.filter(p => p.id !== pelangganToDeleteId);
                suksesMessage.textContent = 'Pelanggan berhasil dihapus.';
                window.location.hash = 'sukses-modal';
                
                // Tutup modal sukses secara otomatis
                setTimeout(() => {
                    window.location.hash = '';
                }, 2000);
            }
        });

        // Menghandle saat hash berubah (modal ditutup atau dibuka)
        window.addEventListener('hashchange', () => {
            if (window.location.hash === '') {
                renderDaftarPelanggan();
            }
        });

        // Event listener untuk pengiriman formulir
        pelangganForm.addEventListener('submit', handleFormSubmit);

        // Event listener untuk delegasi pada tombol aksi
        document.addEventListener('click', handleActions);

        // Render halaman awal saat aplikasi dimuat
        document.addEventListener('DOMContentLoaded', renderDaftarPelanggan);
    </script>
</body>
</html>
