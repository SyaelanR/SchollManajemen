<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Supplier & Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .tab-link.active {
            background-color: rgb(31 41 55); /* bg-gray-800 */
            color: white;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 24px;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #10B981; /* bg-emerald-500 */
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 2000;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .toast.show {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen">

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

        <!-- Supplier Section -->
        <div id="suppliers-content" class="content-section">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-4xl font-extrabold text-gray-900">Daftar Supplier</h1>
                <a href="#" class="flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-200" onclick="showModal('add-supplier')">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Tambah Supplier Baru</span>
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Supplier Saat Ini</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Supplier</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rekening Bank</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="suppliers-table-body">
                            <!-- Supplier rows will be dynamically inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer Section -->
        <div id="customers-content" class="content-section hidden">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-4xl font-extrabold text-gray-900">Daftar Pelanggan</h1>
                <a href="#" class="flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-200" onclick="showModal('add-customer')">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Tambah Pelanggan Baru</span>
                </a>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Pelanggan Saat Ini</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Piutang</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="customers-table-body">
                            <!-- Customer rows will be dynamically inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Modal for Supplier Actions -->
    <div id="supplier-modal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modal-title-supplier" class="text-2xl font-bold"></h2>
                <span class="text-gray-500 text-3xl cursor-pointer" onclick="closeModal('supplier-modal')">&times;</span>
            </div>
            <div id="modal-body-supplier"></div>
        </div>
    </div>

    <!-- Modal for Customer Actions -->
    <div id="customer-modal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modal-title-customer" class="text-2xl font-bold"></h2>
                <span class="text-gray-500 text-3xl cursor-pointer" onclick="closeModal('customer-modal')">&times;</span>
            </div>
            <div id="modal-body-customer"></div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50"></div>

    <script>
        // Dummy data to simulate a database
        const suppliers = [
            { id: 'supp1', nama: 'PT. Maju Bersama', rekening: '1234567890 (BCA)', history: [{ date: '2023-10-25', amount: 5000000 }, { date: '2023-09-15', amount: 7500000 }] },
            { id: 'supp2', nama: 'CV. Karya Abadi', rekening: '0987654321 (Mandiri)', history: [{ date: '2023-11-01', amount: 3200000 }, { date: '2023-10-10', amount: 1500000 }] },
            { id: 'supp3', nama: 'UD. Jaya Sentosa', rekening: '1122334455 (BNI)', history: [{ date: '2023-11-05', amount: 980000 }] }
        ];

        const customers = [
            { id: 'cust1', nama: 'Andi Nugroho', piutang: 250000, history: [{ date: '2023-10-20', amount: 250000, status: 'Lunas' }, { date: '2023-09-01', amount: 500000, status: 'Lunas' }] },
            { id: 'cust2', nama: 'Budi Santoso', piutang: 75000, history: [{ date: '2023-11-02', amount: 75000, status: 'Belum Lunas' }] },
            { id: 'cust3', nama: 'Citra Dewi', piutang: 0, history: [{ date: '2023-10-28', amount: 150000, status: 'Lunas' }] }
        ];

        // Function to show a toast notification
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast bg-emerald-500 text-white p-4 rounded-lg shadow-md mb-2 transition-opacity`;
            toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${message}`;

            if (type === 'error') {
                toast.classList.remove('bg-emerald-500');
                toast.classList.add('bg-red-500');
                toast.innerHTML = `<i class="fas fa-times-circle mr-2"></i> ${message}`;
            }

            toastContainer.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 3000);
        }

        // Function to render supplier table rows
        function renderSuppliers() {
            const tableBody = document.getElementById('suppliers-table-body');
            tableBody.innerHTML = '';
            suppliers.forEach(supplier => {
                const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${supplier.nama}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${supplier.rekening}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4" onclick="viewSupplierHistory('${supplier.id}')">
                                <i class="fa-solid fa-history"></i>
                                <span class="ml-1 hidden md:inline">Riwayat</span>
                            </a>
                            <a href="#" class="text-blue-600 hover:text-blue-900 mr-4" onclick="editSupplier('${supplier.id}')">
                                <i class="fa-solid fa-edit"></i>
                                <span class="ml-1 hidden md:inline">Edit Rek.</span>
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        // Function to render customer table rows
        function renderCustomers() {
            const tableBody = document.getElementById('customers-table-body');
            tableBody.innerHTML = '';
            customers.forEach(customer => {
                const piutangClass = customer.piutang > 0 ? 'text-red-500 font-semibold' : 'text-green-500';
                const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${customer.nama}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm ${piutangClass}">Rp ${customer.piutang.toLocaleString('id-ID')}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4" onclick="viewCustomerHistory('${customer.id}')">
                                <i class="fa-solid fa-history"></i>
                                <span class="ml-1 hidden md:inline">Riwayat</span>
                            </a>
                            ${customer.piutang > 0 ? `<a href="#" class="text-green-600 hover:text-green-900" onclick="sendReminder('${customer.id}')">
                                <i class="fa-solid fa-bell"></i>
                                <span class="ml-1 hidden md:inline">Ingatkan</span>
                            </a>` : ''}
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        // Function to switch between tabs
        function switchTab(tabName) {
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.add('hidden');
            });
            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.remove('active');
            });

            document.getElementById(`${tabName}-content`).classList.remove('hidden');
            document.getElementById(`${tabName}-link`).classList.add('active');
        }

        // Modal functions
        function showModal(action, data = {}) {
            const modal = document.getElementById(action.includes('supplier') ? 'supplier-modal' : 'customer-modal');
            const modalTitle = document.getElementById(action.includes('supplier') ? 'modal-title-supplier' : 'modal-title-customer');
            const modalBody = document.getElementById(action.includes('supplier') ? 'modal-body-supplier' : 'modal-body-customer');

            if (action === 'add-supplier') {
                modalTitle.textContent = 'Tambah Supplier';
                modalBody.innerHTML = `
                    <form onsubmit="event.preventDefault(); saveSupplier(this);">
                        <div class="mb-4">
                            <label for="nama_supplier" class="block text-sm font-medium text-gray-700">Nama Supplier</label>
                            <input type="text" id="nama_supplier" name="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="rekening_supplier" class="block text-sm font-medium text-gray-700">Rekening Bank</label>
                            <input type="text" id="rekening_supplier" name="rekening" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 mr-2" onclick="closeModal('supplier-modal')">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
                        </div>
                    </form>
                `;
                modal.style.display = 'block';
            } else if (action === 'add-customer') {
                modalTitle.textContent = 'Tambah Pelanggan';
                modalBody.innerHTML = `
                    <form onsubmit="event.preventDefault(); saveCustomer(this);">
                        <div class="mb-4">
                            <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                            <input type="text" id="nama_pelanggan" name="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 mr-2" onclick="closeModal('customer-modal')">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
                        </div>
                    </form>
                `;
                modal.style.display = 'block';
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // New function to save a new supplier
        function saveSupplier(form) {
            const formData = new FormData(form);
            const newSupplier = {
                id: `supp${suppliers.length + 1}`,
                nama: formData.get('nama'),
                rekening: formData.get('rekening'),
                history: []
            };
            suppliers.push(newSupplier);
            renderSuppliers();
            closeModal('supplier-modal');
            showToast('Supplier berhasil ditambahkan!');
        }

        // New function to save a new customer
        function saveCustomer(form) {
            const formData = new FormData(form);
            const newCustomer = {
                id: `cust${customers.length + 1}`,
                nama: formData.get('nama'),
                piutang: 0,
                history: []
            };
            customers.push(newCustomer);
            renderCustomers();
            closeModal('customer-modal');
            showToast('Pelanggan berhasil ditambahkan!');
        }


        function viewSupplierHistory(id) {
            const supplier = suppliers.find(s => s.id === id);
            const modalTitle = document.getElementById('modal-title-supplier');
            const modalBody = document.getElementById('modal-body-supplier');
            modalTitle.textContent = `Riwayat Pembayaran: ${supplier.nama}`;
            modalBody.innerHTML = `
                <div class="p-4 bg-gray-100 rounded-lg">
                    <p class="mb-2"><span class="font-semibold">Rekening:</span> ${supplier.rekening}</p>
                    <h3 class="font-bold mt-4 mb-2">Riwayat Pembayaran</h3>
                    <ul class="list-disc list-inside">
                        ${supplier.history.map(item => `<li><span class="font-medium">Rp ${item.amount.toLocaleString('id-ID')}</span> pada ${item.date}</li>`).join('')}
                    </ul>
                </div>
                <div class="flex justify-end mt-4">
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300" onclick="closeModal('supplier-modal')">Tutup</button>
                </div>
            `;
            document.getElementById('supplier-modal').style.display = 'block';
        }

        function editSupplier(id) {
            const supplier = suppliers.find(s => s.id === id);
            const modalTitle = document.getElementById('modal-title-supplier');
            const modalBody = document.getElementById('modal-body-supplier');
            modalTitle.textContent = `Edit Rekening: ${supplier.nama}`;
            modalBody.innerHTML = `
                <form onsubmit="event.preventDefault(); updateSupplier('${id}', this);">
                    <div class="mb-4">
                        <label for="rekening_baru" class="block text-sm font-medium text-gray-700">Rekening Baru</label>
                        <input type="text" id="rekening_baru" name="rekening" value="${supplier.rekening}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 mr-2" onclick="closeModal('supplier-modal')">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            `;
            document.getElementById('supplier-modal').style.display = 'block';
        }

        function updateSupplier(id, form) {
            const newRekening = form.rekening.value;
            const supplierIndex = suppliers.findIndex(s => s.id === id);
            if (supplierIndex !== -1) {
                suppliers[supplierIndex].rekening = newRekening;
                renderSuppliers();
                closeModal('supplier-modal');
                showToast('Rekening supplier berhasil diperbarui!');
            }
        }

        function viewCustomerHistory(id) {
            const customer = customers.find(c => c.id === id);
            const modalTitle = document.getElementById('modal-title-customer');
            const modalBody = document.getElementById('modal-body-customer');
            modalTitle.textContent = `Riwayat Piutang: ${customer.nama}`;
            modalBody.innerHTML = `
                <div class="p-4 bg-gray-100 rounded-lg">
                    <p class="mb-2"><span class="font-semibold">Total Piutang:</span> Rp ${customer.piutang.toLocaleString('id-ID')}</p>
                    <h3 class="font-bold mt-4 mb-2">Riwayat Pembayaran</h3>
                    <ul class="list-disc list-inside">
                        ${customer.history.map(item => `<li><span class="font-medium">Rp ${item.amount.toLocaleString('id-ID')}</span> pada ${item.date} (${item.status})</li>`).join('')}
                    </ul>
                </div>
                <div class="flex justify-end mt-4">
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300" onclick="closeModal('customer-modal')">Tutup</button>
                </div>
            `;
            document.getElementById('customer-modal').style.display = 'block';
        }

        function sendReminder(id) {
            const customer = customers.find(c => c.id === id);
            closeModal('customer-modal');
            showToast(`Pengingat jatuh tempo berhasil dikirim ke ${customer.nama}!`);
        }

        // Event listeners for tab switching
        document.querySelectorAll('.tab-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetTab = e.currentTarget.dataset.target;
                switchTab(targetTab);
            });
        });

        // Initial render on page load
        document.addEventListener('DOMContentLoaded', () => {
            renderSuppliers();
            renderCustomers();
            switchTab('suppliers'); // Set the default tab
        });
    </script>
</body>
</html>
