<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Wali Santri</title>
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
        <div class="text-2xl font-bold text-center mb-8">
            <i class="fas fa-user-shield text-indigo-500 mr-2"></i>
            Wali Santri
        </div>
        <nav class="w-full">
            <ul>
                <li class="mb-2">
                    <a href="/wali/dashboard" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/wali/profil" class="flex items-center p-3 rounded-lg bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-user mr-3 text-lg text-green-400"></i>
                        Profil
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/wali/tagihan" class="flex items-center p-3 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-file-invoice-dollar mr-3 text-lg text-lime-400"></i>
                        Tagihan Siswa
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto w-full">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Daftar Tagihan</h1>
        </div>
        
        <!-- Notifikasi -->
        <div id="notifikasi" class="hidden bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
            <p id="notifikasi-pesan"></p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Jatuh Tempo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="invoice-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Invoice data will be loaded here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk pilihan metode pembayaran -->
        <div id="paymentMethodModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4">Pilih Metode Pembayaran</h3>
                    <div class="items-center px-4 py-3">
                        <button id="transferBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200 mb-2">
                            Transfer
                        </button>
                        <button id="cashBtn" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200 mb-2">
                            Tunai
                        </button>
                        <button id="cancelMethodBtn" class="w-full mt-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk upload bukti transfer -->
        <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4">Unggah Bukti Transfer</h3>
                    <p class="text-sm text-gray-600 mb-4">Silakan unggah bukti transfer Anda.</p>
                    <div class="flex flex-col items-center">
                        <input type="file" id="buktiTransferFile" class="mb-4">
                        <button id="uploadBtn" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                            Unggah
                        </button>
                        <button id="cancelUploadBtn" class="w-full mt-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Data dummy untuk tagihan
        let invoices = [
            { id: "inv001", description: "SPP Bulan September 2024", amount: 250000, dueDate: "2024-09-30", status: "Belum Dibayar" },
            { id: "inv002", description: "Uang Saku Oktober 2024", amount: 150000, dueDate: "2024-10-10", status: "Belum Dibayar" },
            { id: "inv003", description: "Biaya Buku Tulis", amount: 75000, dueDate: "2024-09-25", status: "Belum Dibayar" },
            { id: "inv004", description: "Uang Pangkal", amount: 1500000, dueDate: "2024-07-20", status: "Sudah Dibayar" },
            { id: "inv005", description: "Kegiatan Ekstrakurikuler", amount: 75000, dueDate: "2024-09-15", status: "Sudah Dibayar" },
            { id: "inv006", description: "SPP Bulan Agustus 2024", amount: 250000, dueDate: "2024-08-30", status: "Sudah Dibayar" }
        ];

        // --- UI Functions & Elements ---
        const tableBody = document.getElementById('invoice-table-body');
        const notifEl = document.getElementById('notifikasi');
        const notifMsgEl = document.getElementById('notifikasi-pesan');
        
        const paymentMethodModal = document.getElementById('paymentMethodModal');
        const transferBtn = document.getElementById('transferBtn');
        const cashBtn = document.getElementById('cashBtn');
        const cancelMethodBtn = document.getElementById('cancelMethodBtn');

        const uploadModal = document.getElementById('uploadModal');
        const buktiTransferFile = document.getElementById('buktiTransferFile');
        const uploadBtn = document.getElementById('uploadBtn');
        const cancelUploadBtn = document.getElementById('cancelUploadBtn');

        let selectedInvoiceId = null;

        function showNotification(message, isError = false) {
            notifMsgEl.textContent = message;
            notifEl.classList.remove('hidden', 'bg-green-100', 'border-green-500', 'text-green-700', 'bg-red-100', 'border-red-500', 'text-red-700');
            
            if (isError) {
                notifEl.classList.add('bg-red-100', 'border-red-500', 'text-red-700');
            } else {
                notifEl.classList.add('bg-green-100', 'border-green-500', 'text-green-700');
            }
            notifEl.classList.remove('hidden');
            setTimeout(() => notifEl.classList.add('hidden'), 5000);
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        function renderInvoices() {
            tableBody.innerHTML = '';
            if (invoices.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada tagihan ditemukan.</td></tr>`;
                return;
            }
            invoices.forEach(invoice => {
                const row = document.createElement('tr');
                let buttonHtml = '';
                if (invoice.status === "Belum Dibayar") {
                    buttonHtml = `<button class="pay-btn bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-200" data-id="${invoice.id}">Bayar</button>`;
                } else if (invoice.status === "Menunggu Konfirmasi") {
                    buttonHtml = `<span class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg shadow-md">Menunggu</span>`;
                } else {
                    buttonHtml = `<span class="text-gray-500">Dibayar</span>`;
                }

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${invoice.description}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatCurrency(invoice.amount)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${invoice.dueDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold ${invoice.status === "Belum Dibayar" ? 'text-red-500' : invoice.status === "Menunggu Konfirmasi" ? 'text-yellow-500' : 'text-green-500'}">${invoice.status}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${buttonHtml}</td>
                `;
                tableBody.appendChild(row);
            });

            document.querySelectorAll('.pay-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    selectedInvoiceId = e.target.dataset.id;
                    paymentMethodModal.classList.remove('hidden');
                });
            });
        }

        cancelMethodBtn.addEventListener('click', () => {
            paymentMethodModal.classList.add('hidden');
        });

        cancelUploadBtn.addEventListener('click', () => {
            uploadModal.classList.add('hidden');
            paymentMethodModal.classList.add('hidden');
        });

        transferBtn.addEventListener('click', () => {
            paymentMethodModal.classList.add('hidden');
            uploadModal.classList.remove('hidden');
        });

        cashBtn.addEventListener('click', () => {
            paymentMethodModal.classList.add('hidden');
            showNotification("Pembayaran tunai akan dikonfirmasi manual oleh bendahara.");
        });

        uploadBtn.addEventListener('click', () => {
            const file = buktiTransferFile.files[0];
            if (!file) {
                showNotification("Silakan pilih file bukti transfer.", true);
                return;
            }

            const invoiceIndex = invoices.findIndex(inv => inv.id === selectedInvoiceId);
            if (invoiceIndex !== -1) {
                invoices[invoiceIndex].status = "Menunggu Konfirmasi";
                renderInvoices();
                uploadModal.classList.add('hidden');
                showNotification("Bukti transfer berhasil diunggah. Tagihan akan dikonfirmasi.");
            } else {
                showNotification("Gagal memproses pembayaran. Tagihan tidak ditemukan.", true);
            }
        });

        window.onload = renderInvoices;
    </script>
</body>
</html>
