<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Pembayaran Pelanggan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }
        .sidebar {
            background-image: linear-gradient(180deg, #1f2937 0%, #111827 100%);
        }
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
        .modal-overlay.is-visible {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }
        @keyframes popIn {
            0% { transform: scale(0.8) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .modal-content { animation: popIn 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55); }
        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            pointer-events: none;
        }
        .notification.is-visible {
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 sidebar text-gray-100 p-6 flex flex-col rounded-r-3xl">
        <div class="text-2xl font-bold text-center mb-8 text-indigo-400">
            <i class="fas fa-chart-line mr-2"></i>
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
    <main class="flex-1 p-8 overflow-y-auto bg-gradient-to-br from-blue-50 to-indigo-100">
        <h1 class="text-3xl font-extrabold mb-6 text-gray-900 drop-shadow-md">Terima Pembayaran Pelanggan</h1>

        <!-- Daftar Invoice Piutang (Belum Lunas) -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Daftar Invoice Piutang</h2>
            <div class="overflow-x-auto rounded-lg">
                <table id="invoice-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Invoice</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan/Walisantri</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Piutang</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Example data (Belum Lunas) -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">01 Mei 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Adi Wijaya</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">Rp 5.000.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">30 Mei 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-semibold">Belum Lunas</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="javascript:void(0)" onclick="openPaymentModal(this)" class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <i class="fas fa-dollar-sign mr-1"></i> Terima Pembayaran
                                </a>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">10 Mei 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Budi Santoso</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">Rp 1.200.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">09 Juni 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-semibold">Belum Lunas</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="javascript:void(0)" onclick="openPaymentModal(this)" class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <i class="fas fa-dollar-sign mr-1"></i> Terima Pembayaran
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Daftar Invoice Lunas -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Daftar Invoice Lunas</h2>
            <div class="overflow-x-auto rounded-lg">
                <table id="invoice-lunas-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Invoice</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan/Walisantri</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Piutang</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Example data (Lunas) -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">15 Mei 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Fatimah Azzahra</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">Rp 3.500.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">14 Juni 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">Lunas</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <span class="text-gray-400">Tidak ada aksi</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Form Pembayaran -->
    <div id="payment-modal" class="modal-overlay">
        <div class="modal-content bg-white p-6 rounded-xl shadow-2xl max-w-lg w-full relative z-10">
            <button onclick="closePaymentModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times-circle text-2xl"></i>
            </button>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Penerimaan Pembayaran</h2>
            <form id="payment-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
                        <input type="date" id="tanggal" name="tanggal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2" required>
                    </div>
                    <div>
                        <label for="akun" class="block text-sm font-medium text-gray-700 mb-1">Akun Kas/Bank</label>
                        <select id="akun" name="akun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2" required>
                            <option value="">-- Pilih Akun --</option>
                            <option value="kas">Kas</option>
                            <option value="bank_bca">Bank BCA</option>
                            <option value="bank_mandiri">Bank Mandiri</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="nominal" class="block text-sm font-medium text-gray-700 mb-1">Nominal Diterima</label>
                        <input type="number" id="nominal" name="nominal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2" required>
                    </div>
                    <div>
                        <label for="referensi" class="block text-sm font-medium text-gray-700 mb-1">Nomor Referensi/Bukti</label>
                        <input type="text" id="referensi" name="referensi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-save mr-2"></i>Simpan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notification" class="notification bg-green-500 text-white py-3 px-6 rounded-lg shadow-xl flex items-center gap-2">
        <i class="fas fa-check-circle"></i>
        <span>Pembayaran berhasil disimpan!</span>
    </div>
    
    <script>
        // Get elements
        const paymentForm = document.getElementById('payment-form');
        const paymentModal = document.getElementById('payment-modal');
        const nominalInput = document.getElementById('nominal');
        const notification = document.getElementById('notification');

        // Function to open the modal and pre-fill the nominal
        function openPaymentModal(button) {
            const row = button.closest('tr');
            const totalPiutangText = row.children[2].textContent;
            
            // Remove "Rp " and dots (.), then convert to a number
            const nominal = parseInt(totalPiutangText.replace(/Rp |\./g, ''));
            
            // Fill the nominal input
            nominalInput.value = nominal;
            
            // Show the modal
            paymentModal.classList.add('is-visible');
        }

        // Function to close the modal
        function closePaymentModal() {
            paymentModal.classList.remove('is-visible');
        }

        // Function to show the notification
        function showNotification(message) {
            notification.textContent = message;
            notification.classList.add('is-visible');
            setTimeout(() => {
                notification.classList.remove('is-visible');
            }, 3000); // Hide after 3 seconds
        }

        // Handle form submission
        paymentForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Here you can add logic to send data to the server
            // For now, we will just show a notification and close the modal

            showNotification('Pembayaran berhasil disimpan!');
            closePaymentModal();
            
            // Reset the form after submission
            paymentForm.reset();
        });
    </script>
</body>
</html>
