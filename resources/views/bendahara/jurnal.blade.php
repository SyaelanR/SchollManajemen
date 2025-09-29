<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jurnal</title>
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
            <h1 class="text-4xl font-extrabold text-gray-900">Manajemen Jurnal</h1>
            <div class="flex space-x-4">
                <button id="kunciPeriodeBtn" class="bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-lg shadow-md transition-colors">
                    <i class="fas fa-lock mr-2"></i> Kunci Periode
                </button>
                <button id="tambahJurnalBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg shadow-md transition-colors">
                    <i class="fas fa-plus mr-2"></i> Tambah Jurnal Penyesuaian
                </button>
            </div>
        </div>

        <!-- Notifikasi -->
        <div id="notifikasi" class="hidden bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg"></div>
        
        <!-- Filter dan Status Kunci -->
        <div class="flex items-center space-x-4 mb-6">
            <div class="flex-1 flex space-x-4">
                <div class="w-1/2">
                    <label for="filterBulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                    <select id="filterBulan" class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="all">Semua Bulan</option>
                        <option value="10" selected>Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="w-1/2">
                    <label for="filterTahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <input type="number" id="filterTahun" class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="2023">
                </div>
            </div>
            <div id="statusKunci" class="hidden px-3 py-1 bg-gray-200 text-gray-700 text-sm font-semibold rounded-full flex items-center space-x-2">
                <i class="fas fa-lock"></i>
                <span>Terkunci</span>
            </div>
        </div>

        <!-- Tabel Jurnal -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Deskripsi</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Akun (Debit)</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Debit</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Akun (Kredit)</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Kredit</th>
                        </tr>
                    </thead>
                    <tbody id="journal-table-body" class="bg-white divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Jurnal -->
        <div id="tambahJurnalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4">Tambah Jurnal Penyesuaian</h3>
                    <form id="tambahJurnalForm">
                        <div class="mb-4 text-left">
                            <label for="journalDate" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" id="journalDate" name="journalDate" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <input type="text" id="description" name="description" placeholder="cth: Biaya administrasi bank" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                             <label for="debitAccount" class="block text-sm font-medium text-gray-700">Akun (Debit)</label>
                             <input type="text" id="debitAccount" name="debitAccount" placeholder="cth: Biaya Bank" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                            <label for="debitAmount" class="block text-sm font-medium text-gray-700">Jumlah Debit (IDR)</label>
                            <input type="number" id="debitAmount" name="debitAmount" placeholder="cth: 50000" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                            <label for="creditAccount" class="block text-sm font-medium text-gray-700">Akun (Kredit)</label>
                            <input type="text" id="creditAccount" name="creditAccount" placeholder="cth: Kas Bank" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4 text-left">
                            <label for="creditAmount" class="block text-sm font-medium text-gray-700">Jumlah Kredit (IDR)</label>
                            <input type="number" id="creditAmount" name="creditAmount" placeholder="cth: 50000" class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg">Simpan</button>
                            <button type="button" id="batalJurnalBtn" class="w-full mt-2 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

<script>
    // Data dummy sebagai pengganti database
    let journalEntries = [
        // Jurnal Otomatis dari Pembelian/Penjualan
        { id: 1, date: '2023-10-25', description: 'Penjualan produk', debitAccount: 'Kas', debitAmount: 2500000, creditAccount: 'Pendapatan Penjualan', creditAmount: 2500000 },
        { id: 2, date: '2023-10-26', description: 'Pembelian ATK', debitAccount: 'Beban Perlengkapan', debitAmount: 500000, creditAccount: 'Kas', creditAmount: 500000 },
        // Jurnal Penyesuaian
        { id: 3, date: '2023-10-31', description: 'Biaya admin bank', debitAccount: 'Beban Administrasi', debitAmount: 25000, creditAccount: 'Kas Bank', creditAmount: 25000 }
    ];

    // Array untuk menyimpan periode yang dikunci (bulan dan tahun)
    let lockedPeriods = []; // Contoh: [{ month: 10, year: 2023 }]

    // UI Elements
    const tableBody = document.getElementById('journal-table-body');
    const notifEl = document.getElementById('notifikasi');
    const tambahJurnalBtn = document.getElementById('tambahJurnalBtn');
    const kunciPeriodeBtn = document.getElementById('kunciPeriodeBtn');
    const tambahJurnalModal = document.getElementById('tambahJurnalModal');
    const batalJurnalBtn = document.getElementById('batalJurnalBtn');
    const tambahJurnalForm = document.getElementById('tambahJurnalForm');
    const filterBulanEl = document.getElementById('filterBulan');
    const filterTahunEl = document.getElementById('filterTahun');
    const statusKunciEl = document.getElementById('statusKunci');
    
    // Fungsi untuk menampilkan notifikasi
    function showNotification(msg, isError = false) {
        notifEl.textContent = msg;
        notifEl.className = `p-4 mb-6 rounded-lg ${isError ? 'bg-red-100 border-l-4 border-red-500 text-red-700' : 'bg-green-100 border-l-4 border-green-500 text-green-700'}`;
        notifEl.classList.remove('hidden');
        setTimeout(() => notifEl.classList.add('hidden'), 4000);
    }

    // Fungsi untuk format mata uang
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', minimumFractionDigits:0 }).format(amount);
    }

    // Fungsi untuk memeriksa apakah periode saat ini terkunci
    function isPeriodLocked() {
        const selectedMonth = parseInt(filterBulanEl.value);
        const selectedYear = parseInt(filterTahunEl.value);
        if (selectedMonth === 'all') return false; // Periode 'semua' tidak bisa dikunci
        return lockedPeriods.some(p => p.month === selectedMonth && p.year === selectedYear);
    }

    // Fungsi untuk memperbarui UI berdasarkan status kunci
    function updateUI() {
        const isLocked = isPeriodLocked();
        if (isLocked) {
            statusKunciEl.classList.remove('hidden');
            tambahJurnalBtn.disabled = true;
            tambahJurnalBtn.classList.add('opacity-50', 'cursor-not-allowed');
            kunciPeriodeBtn.disabled = true;
            kunciPeriodeBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            statusKunciEl.classList.add('hidden');
            tambahJurnalBtn.disabled = false;
            tambahJurnalBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            kunciPeriodeBtn.disabled = false;
            kunciPeriodeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // Fungsi untuk menampilkan data ke tabel berdasarkan filter
    function renderJournalEntries() {
        const selectedMonth = parseInt(filterBulanEl.value);
        const selectedYear = parseInt(filterTahunEl.value);
        
        let filteredEntries = journalEntries;
        
        if (selectedMonth !== 'all' && !isNaN(selectedMonth)) {
            filteredEntries = filteredEntries.filter(entry => {
                const entryDate = new Date(entry.date);
                return (entryDate.getMonth() + 1) === selectedMonth && entryDate.getFullYear() === selectedYear;
            });
        }
        
        tableBody.innerHTML = '';
        filteredEntries.forEach(entry => {
            const row = document.createElement('tr');
            row.dataset.id = entry.id;
            row.innerHTML = `
                <td class="px-4 py-3 text-sm font-medium text-gray-700 whitespace-nowrap">${entry.date}</td>
                <td class="px-4 py-3 text-sm">${entry.description}</td>
                <td class="px-4 py-3 text-sm">${entry.debitAccount}</td>
                <td class="px-4 py-3 text-sm">${formatCurrency(entry.debitAmount)}</td>
                <td class="px-4 py-3 text-sm">${entry.creditAccount}</td>
                <td class="px-4 py-3 text-sm">${formatCurrency(entry.creditAmount)}</td>
            `;
            tableBody.appendChild(row);
        });
        updateUI();
    }

    // Event listeners
    tambahJurnalBtn.onclick = () => tambahJurnalModal.classList.remove('hidden');
    batalJurnalBtn.onclick = () => { tambahJurnalModal.classList.add('hidden'); tambahJurnalForm.reset(); };

    kunciPeriodeBtn.onclick = () => {
        const selectedMonth = parseInt(filterBulanEl.value);
        const selectedYear = parseInt(filterTahunEl.value);
        
        if (selectedMonth === 'all') {
            showNotification('Tidak bisa mengunci "Semua Bulan". Silakan pilih bulan yang spesifik.', true);
            return;
        }

        if (isPeriodLocked()) {
             showNotification('Periode ini sudah terkunci.', true);
             return;
        }

        lockedPeriods.push({ month: selectedMonth, year: selectedYear });
        updateUI();
        showNotification('Periode keuangan berhasil dikunci.');
    };

    tambahJurnalForm.onsubmit = (e) => {
        e.preventDefault();
        
        const journalDate = tambahJurnalForm.journalDate.value;
        const entryDate = new Date(journalDate);
        const entryMonth = entryDate.getMonth() + 1;
        const entryYear = entryDate.getFullYear();

        const selectedMonth = parseInt(filterBulanEl.value);
        const selectedYear = parseInt(filterTahunEl.value);

        if (isPeriodLocked()) {
            showNotification('Periode ini sudah terkunci, tidak bisa menambahkan jurnal baru.', true);
            return;
        }
        
        if (entryMonth !== selectedMonth || entryYear !== selectedYear) {
             showNotification('Tanggal jurnal harus berada dalam periode yang dipilih.', true);
             return;
        }

        const f = new FormData(tambahJurnalForm);
        const newEntry = {
            id: journalEntries.length ? Math.max(...journalEntries.map(entry => entry.id)) + 1 : 1,
            date: f.get('journalDate'),
            description: f.get('description'),
            debitAccount: f.get('debitAccount'),
            debitAmount: parseInt(f.get('debitAmount')),
            creditAccount: f.get('creditAccount'),
            creditAmount: parseInt(f.get('creditAmount')),
        };
        
        if (newEntry.debitAmount !== newEntry.creditAmount) {
            showNotification('Jumlah debit dan kredit harus sama.', true);
            return;
        }

        journalEntries.push(newEntry);
        renderJournalEntries();
        tambahJurnalModal.classList.add('hidden');
        tambahJurnalForm.reset();
        showNotification('Jurnal berhasil ditambahkan!');
    };

    filterBulanEl.onchange = renderJournalEntries;
    filterTahunEl.onchange = renderJournalEntries;

    window.onload = renderJournalEntries;
</script>
</body>
</html>
