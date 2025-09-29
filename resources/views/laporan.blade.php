<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-gray-100 p-6 flex flex-col items-center shadow-lg">
        <div class="text-2xl font-bold text-center mb-10">
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

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Dashboard</h1>
            <div class="text-gray-500 flex items-center">
                <i class="fas fa-user-circle text-2xl mr-2"></i> Admin
            </div>
        </div>
        
        <!-- Summary Cards -->
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Ringkasan Keuangan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div id="pendapatan-card" class="bg-indigo-50 p-6 rounded-xl shadow-lg border-l-4 border-indigo-500"></div>
            <div id="beban-card" class="bg-rose-50 p-6 rounded-xl shadow-lg border-l-4 border-rose-500"></div>
            <div id="laba-bersih-card" class="bg-green-50 p-6 rounded-xl shadow-lg border-l-4 border-green-500"></div>
        </div>

        <!-- Links to Reports -->
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Laporan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Card for Neraca Report -->
            <a href="/laporan/neraca" class="block bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-lime-100 text-lime-600 rounded-full p-3 text-2xl">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <span class="text-lg font-bold text-gray-900">Laporan Neraca</span>
                </div>
                <p class="text-gray-500 text-sm">Lihat ringkasan aset, liabilitas, dan ekuitas perusahaan.</p>
            </a>

            <!-- Card for Laba Rugi Report -->
            <a href="/laporan/laba-rugi" class="block bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-pink-100 text-pink-600 rounded-full p-3 text-2xl">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="text-lg font-bold text-gray-900">Laporan Laba Rugi</span>
                </div>
                <p class="text-gray-500 text-sm">Analisis pendapatan, beban, dan laba bersih perusahaan.</p>
            </a>
        </div>

        <!-- Latest Journals Section -->
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Aktivitas Terbaru</h2>
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun Debit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun Kredit</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        </tr>
                    </thead>
                    <tbody id="latest-journals-body" class="bg-white divide-y divide-gray-200">
                        <!-- Konten jurnal terbaru akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        const journals = [
            { date: '2024-09-23', debitAccount: 'Piutang Usaha', kreditAccount: 'Penjualan', nominal: 5000000, type: 'Otomatis' },
            { date: '2024-09-22', debitAccount: 'Beban Gaji', kreditAccount: 'Kas Besar', nominal: 1500000, type: 'Otomatis' },
            { date: '2024-09-21', debitAccount: 'Kas Besar', kreditAccount: 'Penjualan', nominal: 10000000, type: 'Otomatis' },
            { date: '2024-09-20', debitAccount: 'Beban Operasional', kreditAccount: 'Kas Kecil', nominal: 500000, type: 'Otomatis' },
            { date: '2024-09-19', debitAccount: 'Kas Besar', kreditAccount: 'Modal Usaha', nominal: 20000000, type: 'Manual' },
            { date: '2024-09-18', debitAccount: 'Piutang Usaha', kreditAccount: 'Penjualan', nominal: 3500000, type: 'Otomatis' }
        ];

        const formatRupiah = (number) => new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(number);

        let pendapatan = 0;
        let beban = 0;

        journals.forEach(journal => {
            if (journal.kreditAccount === 'Penjualan') pendapatan += journal.nominal;
            if (journal.debitAccount.startsWith('Beban')) beban += journal.nominal;
        });

        const labaBersih = pendapatan - beban;

        document.getElementById('pendapatan-card').innerHTML =
            `<span class="font-semibold text-gray-500">Pendapatan</span><div class="text-3xl font-bold">${formatRupiah(pendapatan)}</div>`;
        document.getElementById('beban-card').innerHTML =
            `<span class="font-semibold text-gray-500">Beban</span><div class="text-3xl font-bold">${formatRupiah(beban)}</div>`;
        const labaBersihColor = labaBersih >= 0 ? 'text-green-600' : 'text-red-600';
        document.getElementById('laba-bersih-card').innerHTML =
            `<span class="font-semibold text-gray-500">Laba Bersih</span><div class="text-3xl font-bold ${labaBersihColor}">${formatRupiah(labaBersih)}</div>`;

        const latestJournals = journals.slice(0, 5);
        const tableBody = document.getElementById('latest-journals-body');
        tableBody.innerHTML = latestJournals.map(journal => {
            const typeColor = journal.type === 'Otomatis' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
            return `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${journal.date}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${journal.debitAccount}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${journal.kreditAccount}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">${formatRupiah(journal.nominal)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${typeColor}">
                            ${journal.type}
                        </span>
                    </td>
                </tr>`;
        }).join('');
    </script>
</body>
</html>
