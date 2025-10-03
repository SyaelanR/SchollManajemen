<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Acara Sekolah - EduSys</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 CDN untuk Notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom styles */
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        /* Override untuk memastikan card selalu full width di container grid satu kolom */
        .event-card > div {
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="/dashboard" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-calendar-check w-6 h-6 mr-3"></i>
                <span>Daftar Acara</span>
            </a>
        </nav>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        
        <!-- Header Sesuai Permintaan User -->
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Data Siswa</h1> 
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-bell"></i> 
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            {{-- Session Messages Handling --}}
            @if(session('success'))
                <div id="session-success" data-message="{{ session('success') }}" class="hidden"></div>
            @endif

            <!-- START: Content Header/Intro (Dikembalikan ke Acara) -->
            <header class="mb-8 bg-indigo-600 p-8 rounded-2xl shadow-lg text-white">
                <h2 class="text-3xl font-bold mb-2">Manajemen Acara</h2>
                <p class="text-indigo-200">Kelola semua kegiatan, jadwal, dan acara penting sekolah.</p>
            </header>
            <!-- END: Content Header/Intro -->

            <div class="bg-white p-6 rounded-xl shadow-md">
                <!-- Action Bar (Dikembalikan ke Acara) -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Acara</h2>
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="relative w-full md:w-64">
                            <!-- Placeholder dikembalikan ke Acara -->
                            <input type="text" placeholder="Cari acara..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <!-- Tombol dikembalikan ke Tambah Acara dan memanggil showModal() -->
                        <button onclick="showModal()" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap shadow-md hover:shadow-lg">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Tambah Acara
                        </button>
                    </div>
                </div>
                
                <!-- Card View Acara (Layout Satu Kolom) -->
                <div class="grid grid-cols-1 gap-6" id="event-list-container">
                    
                    <!-- Card Acara Contoh 1: Acara Mendatang -->
                    @forelse($daftarAcara ?? [] as $acara)
                        @if(\Carbon\Carbon::parse($acara->tanggal_selesai)->lt(\Carbon\Carbon::now()))
                            {{-- Card Acara Sudah Lewat --}}
                            <div class="event-card" data-event-id="{{ $acara->id_daftar_acara }}">
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden opacity-80 border-t-4 border-gray-400 w-full">
                                    <div class="p-5">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="text-xl font-bold text-gray-800 leading-snug">{{ $acara->judul_acara }}</h3>
                                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-100 text-gray-600 whitespace-nowrap">
                                                <i class="fa-solid fa-check mr-1"></i> Selesai
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 mb-4">{{ $acara->deskripsi }}</p>

                                        <div class="space-y-2 text-sm text-gray-700 mb-5">
                                            @if(\Carbon\Carbon::parse($acara->tanggal_mulai)->isSameDay($acara->tanggal_selesai))
                                                <p><i class="fa-solid fa-calendar-day w-5 mr-2 text-gray-500"></i> {{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('d M Y') }}</p>
                                            @else
                                                <p><i class="fa-solid fa-calendar-day w-5 mr-2 text-gray-500"></i> {{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($acara->tanggal_selesai)->format('d M Y') }}</p>
                                            @endif
                                            <p><i class="fa-solid fa-clock w-5 mr-2 text-gray-500"></i> {{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($acara->tanggal_selesai)->format('H:i') }}</p>
                                            <p><i class="fa-solid fa-location-dot w-5 mr-2 text-gray-500"></i> {{ $acara->lokasi }}</p>
                                        </div>
                                        
                                        <div class="flex justify-between items-center border-t pt-4">
                                            <span class="text-xs font-medium text-gray-500">
                                                <i class="fa-solid fa-user-group mr-1"></i> {{ $acara->peserta }}
                                            </span>
                                            <div>
                                                <button class="edit-btn text-indigo-600 hover:text-indigo-900 mx-1 p-1 transition" title="Edit Acara"
                                                    data-id="{{ $acara->id_daftar_acara }}"
                                                    data-judul_acara="{{ $acara->judul_acara }}"
                                                    data-deskripsi="{{ $acara->deskripsi }}"
                                                    data-tanggal_mulai="{{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('Y-m-d\TH:i') }}"
                                                    data-tanggal_selesai="{{ \Carbon\Carbon::parse($acara->tanggal_selesai)->format('Y-m-d\TH:i') }}"
                                                    data-lokasi="{{ $acara->lokasi }}"
                                                    data-peserta="{{ $acara->peserta }}">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <button data-id="{{ $acara->id_daftar_acara }}" data-title="{{ $acara->judul_acara }}" class="delete-btn text-red-600 hover:text-red-900 mx-1 p-1 transition" title="Hapus Acara">
                                                    <i class="fa-solid fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Card Acara Mendatang --}}
                            <div class="event-card" data-event-id="{{ $acara->id_daftar_acara }}">
                                <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition duration-300 border-t-4 border-indigo-500 w-full">
                                    <div class="p-5">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="text-xl font-bold text-gray-800 leading-snug">{{ $acara->judul_acara }}</h3>
                                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-800 whitespace-nowrap">
                                                <i class="fa-solid fa-user-tie mr-1"></i> Mendatang
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 mb-4">{{ $acara->deskripsi }}</p>

                                        <div class="space-y-2 text-sm text-gray-700 mb-5">
                                            @if(\Carbon\Carbon::parse($acara->tanggal_mulai)->isSameDay($acara->tanggal_selesai))
                                                <p><i class="fa-solid fa-calendar-day w-5 mr-2 text-indigo-500"></i> {{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('d M Y') }}</p>
                                            @else
                                                <p><i class="fa-solid fa-calendar-day w-5 mr-2 text-indigo-500"></i> {{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($acara->tanggal_selesai)->format('d M Y') }}</p>
                                            @endif
                                            <p><i class="fa-solid fa-clock w-5 mr-2 text-indigo-500"></i> {{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($acara->tanggal_selesai)->format('H:i') }}</p>
                                            <p><i class="fa-solid fa-location-dot w-5 mr-2 text-indigo-500"></i> {{ $acara->lokasi }}</p>
                                        </div>
                                        
                                        <div class="flex justify-between items-center border-t pt-4">
                                            <span class="text-xs font-medium text-gray-500">
                                                <i class="fa-solid fa-user-group mr-1"></i> {{ $acara->peserta }}
                                            </span>
                                            <div>
                                                <button class="edit-btn text-indigo-600 hover:text-indigo-900 mx-1 p-1 transition" title="Edit Acara"
                                                    data-id="{{ $acara->id_daftar_acara }}"
                                                    data-judul_acara="{{ $acara->judul_acara }}"
                                                    data-deskripsi="{{ $acara->deskripsi }}"
                                                    data-tanggal_mulai="{{ \Carbon\Carbon::parse($acara->tanggal_mulai)->format('Y-m-d\TH:i') }}"
                                                    data-tanggal_selesai="{{ \Carbon\Carbon::parse($acara->tanggal_selesai)->format('Y-m-d\TH:i') }}"
                                                    data-lokasi="{{ $acara->lokasi }}"
                                                    data-peserta="{{ $acara->peserta }}">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <button data-id="{{ $acara->id_daftar_acara }}" data-title="{{ $acara->judul_acara }}" class="delete-btn text-red-600 hover:text-red-900 mx-1 p-1 transition" title="Hapus Acara">
                                                    <i class="fa-solid fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="w-full flex flex-col items-center justify-center text-center p-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <i class="fa-solid fa-calendar-xmark text-5xl text-gray-400 mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-600">Belum ada acara</h3>
                            <p class="text-sm text-gray-500 mt-1">Silakan tambahkan acara baru agar muncul di daftar.</p>
                            <a href="#" 
                            class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg shadow hover:bg-indigo-700 transition">
                                <i class="fa-solid fa-plus mr-1"></i> Tambah Acara
                            </a>
                        </div>
                    @endforelse


                    
                </div>
            </div>
        </main>
    </div>

<!-- Modal for Add/Edit New Event (POPUP FORM) -->
<div id="event-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex justify-center items-center p-4" aria-modal="true" role="dialog">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all">
        <!-- Modal Header -->
        <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white z-10">
            <h3 class="text-2xl font-bold text-gray-800" id="modal-title">
                <i class="fa-solid fa-calendar-plus mr-2 text-indigo-600"></i> Tambah Acara Baru
            </h3>
            <button id="close-modal-button" class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100">
                <i class="fa-solid fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body (Form) -->
        <form id="event-form" action="{{ route('admin.acara.store') }}" method="POST" class="p-6 space-y-6">
            <!-- Hidden ID field for editing -->
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" id="event_id" name="event_id"> 
            
            <!-- Judul Acara -->
            <div>
                <label for="judul_acara" class="block text-sm font-medium text-gray-700 mb-1">Judul Acara <span class="text-red-500">*</span></label>
                <input type="text" id="judul_acara" name="judul_acara" placeholder="Contoh: Lomba Sains Nasional" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            </div>

            <!-- Tanggal dan Waktu Acara (Dipisah: Mulai dan Berakhir) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu Mulai <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
                <div>
                    <label for="waktu_berakhir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu Berakhir <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="waktu_berakhir" name="waktu_berakhir" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
            </div>

            <!-- Lokasi -->
            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" id="lokasi" name="lokasi" placeholder="Contoh: Aula Serbaguna Lantai 2" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            </div>

            <!-- Peserta Target (Manual Input) -->
            <div>
                <label for="peserta_target" class="block text-sm font-medium text-gray-700 mb-1">Peserta Target <span class="text-red-500">*</span></label>
                <input type="text" id="peserta_target" name="peserta_target" placeholder="Contoh: Siswa Kelas X-XII, Guru Mapel Fisika, dll." required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            </div>

            <!-- Deskripsi Acara -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan secara singkat tujuan dan rangkaian acara." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"></textarea>
            </div>

            <!-- Modal Footer (Tombol Aksi) -->
            <div class="flex justify-end pt-4 border-t sticky bottom-0 bg-white">
                <button type="button" id="cancel-button" class="px-5 py-2 mr-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition duration-300">
                    Batal
                </button>
                <button type="submit" id="save-button" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-[1.02]">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Acara
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // --- LOGIKA UTAMA APLIKASI ---
    let isEditing = false;
    let currentEventId = null;

    // Logika Sidebar dan Overlay
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    const toggleSidebar = () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    };

    menuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Logika Modal Tambah/Edit Acara (Popup)
    const closeModalButton = document.getElementById('close-modal-button');
    const cancelButton = document.getElementById('cancel-button');
    const eventModal = document.getElementById('event-modal');
    const form = eventModal.querySelector('form');
    const modalTitle = document.getElementById('modal-title');
    const saveButton = document.getElementById('save-button');
    const eventIdInput = document.getElementById('event_id');

    const showModal = () => {
        eventModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Mencegah scrolling di background
    };

    const hideModal = () => {
        eventModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        form.reset(); // Pastikan form di-reset saat ditutup
        isEditing = false;
        currentEventId = null;
        // Reset judul modal ke "Tambah Acara Baru"
        modalTitle.innerHTML = '<i class="fa-solid fa-calendar-plus mr-2 text-indigo-600"></i> Tambah Acara Baru';
        saveButton.innerHTML = '<i class="fa-solid fa-save mr-2"></i> Simpan Acara';
    };

    // Event Listeners Modal
    closeModalButton.addEventListener('click', hideModal);
    cancelButton.addEventListener('click', hideModal);

    // Tutup modal ketika mengklik di luar form (overlay)
    eventModal.addEventListener('click', (e) => {
        if (e.target === eventModal) {
            hideModal();
        }
    });

    // Handle form submission (menggunakan SweetAlert2)
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        // Kirim form ke server
        e.target.submit();
    });

    // --- LOGIKA Aksi Card (Edit/Hapus) ---

    const eventListContainer = document.getElementById('event-list-container');

    eventListContainer.addEventListener('click', (e) => {
        const editBtn = e.target.closest('.edit-btn');
        const deleteBtn = e.target.closest('.delete-btn');

        if (editBtn) {
            const data = editBtn.dataset;
            
            // 1. Set state ke mode edit
            isEditing = true;
            currentEventId = data.id;
            
            // 2. Set judul modal
            modalTitle.innerHTML = `<i class="fa-solid fa-edit mr-2 text-indigo-600"></i> Edit Acara`;
            saveButton.innerHTML = '<i class="fa-solid fa-save mr-2"></i> Update Acara';

            // 3. Isi form dengan data dari atribut data-*
            document.getElementById('event_id').value = data.id;
            document.getElementById('judul_acara').value = data.judul_acara;
            document.getElementById('waktu_mulai').value = data.tanggal_mulai;
            document.getElementById('waktu_berakhir').value = data.tanggal_selesai;
            document.getElementById('lokasi').value = data.lokasi;
            document.getElementById('peserta_target').value = data.peserta;
            document.getElementById('deskripsi').value = data.deskripsi;

            // 4. Update action form dan method
            form.action = `{{ url('manajemen-acara/acara-sekolah') }}/${data.id}`;
            document.getElementById('form-method').value = 'PUT';

            // 5. Tampilkan modal
            showModal();

            
        }

        if (deleteBtn) {
            const id = deleteBtn.getAttribute('data-id');
            const title = deleteBtn.getAttribute('data-title');

            // Ganti custom confirmation modal dengan SweetAlert2
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Anda yakin ingin menghapus acara "${title}"? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // red-600
                cancelButtonColor: '#6b7280', // gray-500
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dinamis untuk mengirim request DELETE
                    const deleteForm = document.createElement('form');
                    deleteForm.action = `{{ url('manajemen-acara/acara-sekolah') }}/${id}`;
                    deleteForm.method = 'POST'; // Method tetap POST, tapi di-spoof dengan _method
                    deleteForm.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            });
        }
    });

    // Inisialisasi: Menerapkan logika pemeriksaan pesan flash (session-success)
    window.onload = () => {
        const successMessage = document.getElementById('session-success');
        
        // Logika sesuai permintaan user untuk pesan sukses setelah redirect/load
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage.dataset.message,
                timer: 2500,
                showConfirmButton: false
            });
        } else {
            // Tampilkan pesan selamat datang default jika tidak ada pesan flash
        }
    }
</script>
</body>
</html>
