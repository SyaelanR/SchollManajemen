<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
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

        function calculateLabaRugi() {
            let penjualan = 0;
            let hpp = 0; // Cost of Goods Sold - assuming for simplicity
            let bebanOperasional = 0;

            journals.forEach(journal => {
                if (journal.debitAccount === 'Beban Gaji' || journal.debitAccount === 'Beban Operasional') {
                    bebanOperasional += journal.nominal;
                } else if (journal.kreditAccount === 'Penjualan') {
                    penjualan += journal.nominal;
                }
            });

            const labaKotor = penjualan - hpp;
            const labaBersih = labaKotor - bebanOperasional;

            return { penjualan, hpp, labaKotor, bebanOperasional, labaBersih };
        }

        function renderLabaRugi() {
            const labaRugi = calculateLabaRugi();
            const tableBody = document.getElementById('laba-rugi-table-body');
            let html = '';
            const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

            html += `
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">Pendapatan Operasional</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ml-4">Penjualan</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${formatRupiah(labaRugi.penjualan)}</td>
                    </tr>
                    <tr class="bg-gray-100 font-bold">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Total Pendapatan</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">${formatRupiah(labaRugi.penjualan)}</td>
                    </tr>
                </tbody>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">Beban Operasional</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ml-4">Beban Gaji</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${formatRupiah(labaRugi.bebanOperasional)}</td>
                    </tr>
                    <tr class="bg-gray-100 font-bold">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Total Beban Operasional</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">${formatRupiah(labaRugi.bebanOperasional)}</td>
                    </tr>
                </tbody>
                <tfoot class="bg-gray-900 text-white font-bold">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Laba Bersih</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">${formatRupiah(labaRugi.labaBersih)}</td>
                    </tr>
                </tfoot>
            `;
            tableBody.innerHTML = html;
        }

        function exportToExcel() {
            const labaRugi = calculateLabaRugi();
            const filename = 'Laporan_Laba_Rugi.csv';

            let csvContent = "Deskripsi,Saldo\n";
            csvContent += `Penjualan,${labaRugi.penjualan}\n`;
            csvContent += `Beban Operasional,${labaRugi.bebanOperasional}\n`;
            csvContent += `Laba Bersih,${labaRugi.labaBersih}\n`;

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
            renderLabaRugi();
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

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Laporan Keuangan</h1>
            <a href="dashboard.blade.php" class="flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
              
        <div id="laba-rugi-report" class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Laporan Laba Rugi</h2>
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
                    <tbody id="laba-rugi-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Konten Laba Rugi akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
