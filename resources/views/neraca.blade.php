<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Neraca</title>
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
    <script>
        const journals = [
            { date: '2024-09-23', debitAccount: 'Piutang Usaha', kreditAccount: 'Penjualan', nominal: 5000000, type: 'Otomatis' },
            { date: '2024-09-22', debitAccount: 'Beban Gaji', kreditAccount: 'Kas Besar', nominal: 1500000, type: 'Otomatis' },
            { date: '2024-09-21', debitAccount: 'Kas Besar', kreditAccount: 'Penjualan', nominal: 10000000, type: 'Otomatis' },
            { date: '2024-09-20', debitAccount: 'Beban Operasional', kreditAccount: 'Kas Kecil', nominal: 500000, type: 'Otomatis' },
            { date: '2024-09-19', debitAccount: 'Kas Besar', kreditAccount: 'Modal Usaha', nominal: 20000000, type: 'Manual' }
        ];

        function calculateNeraca() {
            const accounts = {
                'Kas Kecil': 0, 'Kas Besar': 0, 'Piutang Usaha': 0,
                'Hutang Usaha': 0, 'Modal Usaha': 0
            };

            journals.forEach(journal => {
                if (journal.debitAccount === 'Kas Kecil' || journal.debitAccount === 'Kas Besar' || journal.debitAccount === 'Piutang Usaha') {
                    accounts[journal.debitAccount] += journal.nominal;
                } else if (journal.kreditAccount === 'Hutang Usaha' || journal.kreditAccount === 'Modal Usaha') {
                    accounts[journal.kreditAccount] += journal.nominal;
                }
            });

            return {
                aset_lancar: [
                    { akun: 'Kas Kecil', saldo: accounts['Kas Kecil'] },
                    { akun: 'Kas Besar', saldo: accounts['Kas Besar'] },
                    { akun: 'Piutang Usaha', saldo: accounts['Piutang Usaha'] }
                ],
                liabilitas: [
                    { akun: 'Hutang Usaha', saldo: accounts['Hutang Usaha'] }
                ],
                ekuitas: [
                    { akun: 'Modal Usaha', saldo: accounts['Modal Usaha'] }
                ]
            };
        }

        function renderNeraca() {
            const neraca = calculateNeraca();
            const tableBody = document.getElementById('neraca-table-body');
            let html = '';

            const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

            const totalAset = neraca.aset_lancar.reduce((sum, item) => sum + item.saldo, 0);
            const totalLiabilitas = neraca.liabilitas.reduce((sum, item) => sum + item.saldo, 0);
            const totalEkuitas = neraca.ekuitas.reduce((sum, item) => sum + item.saldo, 0);
            const totalKewajibanModal = totalLiabilitas + totalEkuitas;

            html += `
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
            `;
            neraca.aset_lancar.forEach(item => {
                html += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">${item.akun}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${formatRupiah(item.saldo)}</td>
                    </tr>
                `;
            });
            html += `
                <tr class="bg-gray-100 font-bold">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Total Aset</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">${formatRupiah(totalAset)}</td>
                </tr>
                </tbody>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kewajiban</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
            `;
            neraca.liabilitas.forEach(item => {
                html += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">${item.akun}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${formatRupiah(item.saldo)}</td>
                    </tr>
                `;
            });
            html += `
                <tr class="bg-gray-100 font-bold">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Total Kewajiban</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">${formatRupiah(totalLiabilitas)}</td>
                </tr>
                </tbody>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Modal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
            `;
            neraca.ekuitas.forEach(item => {
                html += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">${item.akun}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${formatRupiah(item.saldo)}</td>
                    </tr>
                `;
            });
            html += `
                <tr class="bg-gray-100 font-bold">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Total Modal</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">${formatRupiah(totalEkuitas)}</td>
                </tr>
                </tbody>
                <tfoot class="bg-gray-900 text-white font-bold">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Total Kewajiban dan Modal</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">${formatRupiah(totalKewajibanModal)}</td>
                    </tr>
                </tfoot>
            `;
            tableBody.innerHTML = html;
        }

        function exportToExcel() {
            const neraca = calculateNeraca();
            const filename = 'Laporan_Neraca.csv';

            let csvContent = "Aset,Saldo\n";
            neraca.aset_lancar.forEach(item => {
                csvContent += `${item.akun},${item.saldo}\n`;
            });
            csvContent += "\nKewajiban,Saldo\n";
            neraca.liabilitas.forEach(item => {
                csvContent += `${item.akun},${item.saldo}\n`;
            });
            csvContent += "\nModal,Saldo\n";
            neraca.ekuitas.forEach(item => {
                csvContent += `${item.akun},${item.saldo}\n`;
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            link.click();
            URL.revokeObjectURL(link.href);
        }

        function exportToPdf() {
            alert('Fitur export ke PDF belum tersedia di versi ini. Dalam aplikasi nyata, ini akan membutuhkan library eksternal atau server-side.');
        }

        window.onload = () => {
            renderNeraca();
        };
    </script>
    
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Laporan Keuangan</h1>
            
            <!-- Tombol Kembali ke Dashboard yang Diperbarui -->
            <a href="/laporan" class="flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Kembali ke Dashboard</span>
            </a>
            
        </div>
  
        <div id="neraca-report" class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Laporan Neraca</h2>
                <div>
                    <button onclick="exportToExcel()" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                        <i class="fas fa-file-excel mr-2"></i>Export Excel
                    </button>
                    <button onclick="exportToPdf()" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                        <i class="fas fa-file-pdf mr-2"></i>Export PDF
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody id="neraca-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Konten Neraca akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
