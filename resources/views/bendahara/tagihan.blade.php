<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tagihan</title>
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
    <!-- ===== Sidebar ===== -->
    <aside class="w-64 bg-gray-900 text-gray-100 p-6 flex flex-col shadow-lg">
        <div class="text-2xl font-bold text-center mb-8">
            <i class="fas fa-wallet text-indigo-500 mr-2"></i>Keuangan
        </div>
        <nav class="w-full">
            <ul>
                <li class="mb-2">
                    <a href="/bendahara/dashboard" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/pembelian" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-shopping-cart mr-3 text-lg text-cyan-400"></i>
                        Pembelian
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/penjualan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-handshake mr-3 text-lg text-green-400"></i>
                        Penjualan
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/supplier" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-truck mr-3 text-lg text-purple-400"></i>
                        Supplier
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/coa" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-area mr-3 text-lg text-yellow-400"></i>
                        C.O.A
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/jurnal" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-book mr-3 text-lg text-red-400"></i>
                        Jurnal
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/bendahara/laporan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-pie mr-3 text-lg text-lime-400"></i>
                        Laporan
                    </a>
                </li>
            </ul>
            <li class="mb-2">
                    <a href="/bendahara/tagihan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-chart-pie mr-3 text-lg text-lime-400"></i>
                        Tagihan Siswa
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- ===== Main ===== -->
    <main class="flex-1 p-8 overflow-y-auto w-full">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Manajemen Tagihan</h1>
            <button id="tambahTagihanBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg shadow-md transition-colors">
                <i class="fas fa-plus mr-2"></i> Tambah Tagihan
            </button>
        </div>

        <!-- Notifikasi -->
        <div id="notifikasi" class="hidden bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg"></div>

        <!-- Tabel Tagihan -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Wali Santri ID</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Kelas</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Deskripsi</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Jatuh Tempo</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Bukti Transfer</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-table-body" class="bg-white divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Tagihan -->
        <div id="tambahTagihanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4">Tambah Tagihan Baru</h3>
                    <form id="tambahTagihanForm">
                        <div class="mb-4 text-left">
                             <label for="waliSantriId" class="block text-sm font-medium text-gray-700">ID Wali Santri</label>
                             <input type="text" id="waliSantriId" name="waliSantriId" placeholder="cth: siswa-001" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                             <label for="namaSantri" class="block text-sm font-medium text-gray-700">Nama Santri</label>
                             <input type="text" id="namaSantri" name="namaSantri" placeholder="cth: Budi Santoso" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                             <label for="kelasSantri" class="block text-sm font-medium text-gray-700">Kelas</label>
                             <input type="text" id="kelasSantri" name="kelasSantri" placeholder="cth: X A" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Tagihan</label>
                            <input type="text" id="description" name="description" placeholder="cth: SPP Bulan Oktober" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (IDR)</label>
                            <input type="number" id="amount" name="amount" placeholder="cth: 500000" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                            <label for="dueDate" class="block text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
                            <input type="date" id="dueDate" name="dueDate" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg">Simpan</button>
                            <button type="button" id="batalBtn" class="w-full mt-2 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

<script>
    // Data dummy sebagai pengganti database
    let invoices = [
        { id: 1, waliSantriId: 'siswa-001', nama: 'Abdul Fatah', kelas: 'X IPA', description: 'SPP Bulan Oktober', amount: 300000, dueDate: '2023-10-31', status: 'Belum Dibayar', proof: null },
        { id: 2, waliSantriId: 'siswa-002', nama: 'Siti Rahma', kelas: 'XI IPS', description: 'Uang Buku', amount: 150000, dueDate: '2023-11-15', status: 'Menunggu Verifikasi', proof: 'https://img-s-msn-com.akamaized.net/tenant/amp/entityid/AA1N9CsD.img?w=1280&h=853&m=4&q=75' },
        { id: 3, waliSantriId: 'siswa-001', nama: 'Abdul Fatah', kelas: 'X IPA', description: 'Uang Seragam', amount: 500000, dueDate: '2023-09-30', status: 'Lunas', proof: 'https://cinemags.org/wp-content/uploads/2023/05/the-nun-2-750x398.png' }
    ];

    // UI Elements
    const tableBody = document.getElementById('invoice-table-body');
    const notifEl = document.getElementById('notifikasi');
    const tambahTagihanBtn = document.getElementById('tambahTagihanBtn');
    const tambahTagihanModal = document.getElementById('tambahTagihanModal');
    const batalBtn = document.getElementById('batalBtn');
    const tambahTagihanForm = document.getElementById('tambahTagihanForm');

    function showNotification(msg, isError = false) {
        notifEl.textContent = msg;
        notifEl.className = `p-4 mb-6 rounded-lg ${isError ? 'bg-red-100 border-l-4 border-red-500 text-red-700' : 'bg-green-100 border-l-4 border-green-500 text-green-700'}`;
        notifEl.classList.remove('hidden');
        setTimeout(() => notifEl.classList.add('hidden'), 4000);
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', minimumFractionDigits:0 }).format(amount);
    }

    // Fungsi untuk menampilkan data dari array ke tabel
    function renderInvoices() {
        tableBody.innerHTML = '';
        invoices.forEach(inv => {
            const row = document.createElement('tr');
            row.dataset.id = inv.id;
            row.innerHTML = `
                <td class="px-4 py-3 text-sm font-medium text-gray-700 whitespace-nowrap">${inv.waliSantriId}</td>
                <td class="px-4 py-3 text-sm">${inv.nama}</td>
                <td class="px-4 py-3 text-sm">${inv.kelas}</td>
                <td class="px-4 py-3 text-sm">${inv.description}</td>
                <td class="px-4 py-3 text-sm">${formatCurrency(inv.amount)}</td>
                <td class="px-4 py-3 text-sm">${inv.dueDate}</td>
                <td class="px-4 py-3 text-sm font-semibold ${inv.status==='Lunas'?'text-green-600':inv.status==='Menunggu Verifikasi'?'text-yellow-500':'text-red-500'}">${inv.status}</td>
                <td class="px-4 py-3 text-sm">
                    ${inv.proof ? `<a href="${inv.proof}" target="_blank" class="text-indigo-600 hover:underline">Lihat Bukti</a>` : '<span class="text-gray-400">Belum Ada</span>'}
                </td>
                <td class="px-4 py-3 text-sm">
                    ${inv.proof && inv.status !== 'Lunas' ? `<button onclick="markPaid(${inv.id})" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Tandai Lunas</button>` : ''}
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Fungsi untuk menandai tagihan sebagai lunas
    window.markPaid = (invoiceId) => {
        const invoiceToUpdate = invoices.find(inv => inv.id === invoiceId);
        if (invoiceToUpdate) {
            invoiceToUpdate.status = 'Lunas';
            renderInvoices();
            showNotification('Tagihan berhasil ditandai Lunas!');
        } else {
            showNotification("Gagal memperbarui status tagihan.", true);
        }
    };

    tambahTagihanBtn.onclick = () => tambahTagihanModal.classList.remove('hidden');
    batalBtn.onclick = () => { tambahTagihanModal.classList.add('hidden'); tambahTagihanForm.reset(); };

    tambahTagihanForm.onsubmit = (e) => {
        e.preventDefault();
        const f = new FormData(tambahTagihanForm);
        const newInvoice = {
            id: invoices.length ? Math.max(...invoices.map(inv => inv.id)) + 1 : 1,
            waliSantriId: f.get('waliSantriId'),
            nama: f.get('namaSantri'),
            kelas: f.get('kelasSantri'),
            description: f.get('description'),
            amount: parseInt(f.get('amount')),
            dueDate: f.get('dueDate'),
            status: "Belum Dibayar",
            proof: null,
        };
        
        invoices.push(newInvoice);
        renderInvoices();
        tambahTagihanModal.classList.add('hidden');
        tambahTagihanForm.reset();
        showNotification('Tagihan berhasil ditambahkan!');
    };

    window.onload = renderInvoices;
</script>
</body>
</html>
