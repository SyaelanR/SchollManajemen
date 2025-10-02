<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tingkat Ajaran - Sistem Manajemen Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
        .modal { transition: opacity 0.3s ease-in-out; }
        .modal-content { transition: transform 0.3s ease-in-out; }
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
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-layer-group w-6 h-6 mr-3"></i>
                <span>Manajemen Tingkat</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-book w-6 h-6 mr-3"></i>
                <span>Manajemen Mapel</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                <span>Manajemen Guru</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
             <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full text-left">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Tingkat Ajaran</h1>
            <div class="flex items-center space-x-4">
                 <button class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User Avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
             <!-- Session Messages Handling -->
            @if(session('success'))
                <div id="session-success" data-message="{{ session('success') }}" class="hidden"></div>
            @endif
            @if ($errors->any())
                <div id="validation-errors" data-errors="{{ json_encode($errors->all()) }}" class="hidden"></div>
            @endif

            <header class="mb-8 bg-indigo-600 p-8 rounded-2xl shadow-lg text-white">
                <h2 class="text-3xl font-bold mb-2">Manajemen Tingkat Ajaran</h2>
                <p class="text-indigo-200">Kelola semua tingkat ajaran yang ada di sekolah.</p>
            </header>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <!-- Action Bar -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Tingkat Ajaran</h2>
                    <button id="add-tingkat-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Tambah Tingkat
                    </button>
                </div>

                <!-- Levels Table -->
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[500px] text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Tingkat Ajaran</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                             @forelse (($tingkats ?? []) as $tingkat)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-gray-800 font-medium">{{ $tingkat->tingkat }}</td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <form action="{{ route('destroyTingkat', $tingkat->id_tingkat) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="p-3 text-center text-gray-500">
                                     <div class="text-center py-12">
                                        <i class="fa-solid fa-layer-group text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada data tingkat.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="tingkat-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4 hidden opacity-0">
    <div class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-transform duration-300 scale-95">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 id="modal-title" class="text-2xl font-semibold text-gray-800">Tambah Tingkat</h3>
            <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div class="text-center mt-4">
                <i class="fa-solid fa-layer-group text-4xl text-indigo-500 mb-4"></i>
            <p class="text-gray-600 mb-6">
                Anda akan menambahkan tingkat ajaran baru secara berurutan. 
                Tindakan ini akan membuat tingkat baru setelah tingkat tertinggi yang ada saat ini. Lanjutkan?
            </p>
        </div>
        <form id="tingkat-form" action="{{ route('storeTingkat') }}" method="POST">
            @csrf
            <input type="hidden" id="form-method" name="_method" value="POST">
            <div class="flex justify-end gap-4">
                    <button type="button" id="cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Ya, Tambahkan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Sidebar Toggle ---
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (menuButton && sidebar && overlay) {
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    }

    // --- SweetAlert2 Notifications ---
    const successMessage = document.getElementById('session-success');
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: successMessage.dataset.message,
            timer: 2500,
            showConfirmButton: false
        });
    }

    const validationErrors = document.getElementById('validation-errors');
    if (validationErrors) {
        try {
            const errorsData = validationErrors.dataset.errors;
            // Replace HTML entities that might break JSON parsing
            const sanitizedErrorsData = errorsData.replace(/&quot;/g, '"');
            const errors = JSON.parse(sanitizedErrorsData);
            let errorText = '<ul class="list-disc list-inside text-left">';
            errors.forEach(error => {
                errorText += `<li>${error}</li>`;
            });
            errorText += '</ul>';
            Swal.fire({
                icon: 'error',
                title: 'Gagal Validasi',
                html: errorText,
            });
        } catch (e) {
            // This catch block will prevent the script from breaking if JSON is invalid
        }
    }
    
    // --- Modal Control ---
    const tingkatModal = document.getElementById('tingkat-modal');
    const modalContent = tingkatModal.querySelector('.modal-content');
    const addTingkatBtn = document.getElementById('add-tingkat-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const tingkatForm = document.getElementById('tingkat-form');
    const modalTitle = document.getElementById('modal-title');
    const tingkatInput = document.getElementById('tingkat-input');
    const formMethodInput = document.getElementById('form-method');

    const openModal = () => {
        tingkatModal.classList.remove('hidden');
        setTimeout(() => {
            tingkatModal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    };

    const closeModal = () => {
        tingkatModal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        setTimeout(() => tingkatModal.classList.add('hidden'), 300);
    };

    // Add Modal
    addTingkatBtn.addEventListener('click', () => {
        tingkatForm.reset();
        modalTitle.textContent = 'Tambah Tingkat Baru';
        tingkatForm.action = '{{ route("storeTingkat") }}';
        formMethodInput.value = 'POST';
        openModal();
    });

    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    tingkatModal.addEventListener('click', (e) => {
        if (e.target === tingkatModal) closeModal();
    });

    // --- Delete Confirmation ---
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data tingkat yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});
</script>

</body>
</html>
