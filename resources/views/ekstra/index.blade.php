<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler - EduSys</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Custom styles */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        /* Sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
            <div class="p-6">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">EduSys</span>
                </a>
            </div>
            <nav class="mt-6">
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Guru</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                    <span>Jadwal Pelajaran</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-book w-6 h-6 mr-3"></i>
                    <span>Mata Pelajaran</span>
                </a>
                 <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-baseball-bat-ball w-6 h-6 mr-3"></i>
                    <span>Ekstrakurikuler</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                    <span>Keuangan</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-cog w-6 h-6 mr-3"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Ekstrakurikuler</h1>
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
                <!-- Control Panel -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8 flex flex-col md:flex-row items-center justify-between">
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                        <div class="relative w-full md:w-64">
                            <input type="text" id="search-input" placeholder="Cari ekstrakurikuler..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-300">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <select id="filter-select" class="w-full md:w-48 py-2 px-4 rounded-lg border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-300">
                            <option value="all">Semua Kategori</option>
                            <option value="olahraga">Olahraga</option>
                            <option value="seni">Seni</option>
                            <option value="sains">Sains</option>
                            <option value="bahasa">Bahasa</option>
                        </select>
                    </div>
                    <button id="add-button" class="mt-4 md:mt-0 bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 w-full md:w-auto">
                        <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Ekstrakurikuler
                    </button>
                </div>

                <!-- Extracurricular List -->
                <div id="extracurricular-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <!-- Cards for each extracurricular will be generated here -->
                </div>
            </main>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-[100] hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform transition-transform duration-300 scale-95 md:scale-100">
            <h2 id="modal-title" class="text-2xl font-bold text-gray-800 mb-6">Tambah Ekstrakurikuler Baru</h2>
            <form id="extracurricular-form" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Ekstrakurikuler</label>
                    <input type="text" id="name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="category" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Kategori</option>
                        <option value="olahraga">Olahraga</option>
                        <option value="seni">Seni</option>
                        <option value="sains">Sains</option>
                        <option value="bahasa">Bahasa</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="description" rows="3" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <div>
                    <label for="instructor" class="block text-sm font-medium text-gray-700">Pembimbing</label>
                    <input type="text" id="instructor" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="schedule" class="block text-sm font-medium text-gray-700">Jadwal</label>
                    <input type="text" id="schedule" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" id="close-modal" class="py-2 px-4 rounded-lg text-gray-600 bg-gray-200 hover:bg-gray-300 transition duration-300 font-semibold">Batal</button>
                    <button type="submit" id="submit-button" class="py-2 px-4 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition duration-300">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const addExtracurricularButton = document.getElementById('add-button');
        const modal = document.getElementById('modal');
        const closeModalButton = document.getElementById('close-modal');
        const extracurricularForm = document.getElementById('extracurricular-form');
        const extracurricularList = document.getElementById('extracurricular-list');
        const searchInput = document.getElementById('search-input');
        const filterSelect = document.getElementById('filter-select');
        const modalTitle = document.getElementById('modal-title');
        const submitButton = document.getElementById('submit-button');
        
        // Mock data for demonstration
        let extracurriculars = [
            { id: 1, name: 'Futsal', category: 'olahraga', description: 'Mengembangkan keterampilan bermain futsal dan kerjasama tim.', instructor: 'Bapak Budi', schedule: 'Setiap Selasa dan Kamis, 15:00 - 17:00' },
            { id: 2, name: 'Paduan Suara', category: 'seni', description: 'Melatih kemampuan vokal dan harmoni dalam kelompok.', instructor: 'Ibu Santi', schedule: 'Setiap Rabu, 14:00 - 16:00' },
            { id: 3, name: 'Klub Sains', category: 'sains', description: 'Eksperimen seru dan penelitian ilmiah.', instructor: 'Bapak Roni', schedule: 'Setiap Jumat, 14:30 - 16:30' },
            { id: 4, name: 'Bahasa Inggris', category: 'bahasa', description: 'Meningkatkan kemampuan berbicara dan menulis bahasa Inggris.', instructor: 'Miss Jane', schedule: 'Setiap Senin, 15:30 - 17:00' },
            { id: 5, name: 'Basket', category: 'olahraga', description: 'Mengasah teknik dribble, shooting, dan strategi permainan.', instructor: 'Bapak Doni', schedule: 'Setiap Senin dan Jumat, 15:00 - 17:00' },
            { id: 6, name: 'Tari Tradisional', category: 'seni', description: 'Mengenal dan melestarikan tarian-tarian dari berbagai daerah.', instructor: 'Ibu Maya', schedule: 'Setiap Kamis, 14:30 - 16:30' },
            { id: 7, name: 'Robotika', category: 'sains', description: 'Merakit dan memprogram robot untuk kompetisi.', instructor: 'Bapak Junaedi', schedule: 'Setiap Sabtu, 09:00 - 12:00' },
            { id: 8, name: 'Seni Lukis', category: 'seni', description: 'Menjelajahi kreativitas melalui media lukis.', instructor: 'Ibu Kartika', schedule: 'Setiap Senin, 15:00 - 16:30' },
        ];
        
        let editingId = null;

        // Function to toggle sidebar
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Function to open modal
        const openModal = (extracurricular = null) => {
            if (extracurricular) {
                editingId = extracurricular.id;
                modalTitle.textContent = 'Edit Ekstrakurikuler';
                submitButton.textContent = 'Update';
                document.getElementById('name').value = extracurricular.name;
                document.getElementById('category').value = extracurricular.category;
                document.getElementById('description').value = extracurricular.description;
                document.getElementById('instructor').value = extracurricular.instructor;
                document.getElementById('schedule').value = extracurricular.schedule;
            } else {
                editingId = null;
                modalTitle.textContent = 'Tambah Ekstrakurikuler Baru';
                submitButton.textContent = 'Simpan';
                extracurricularForm.reset();
            }
            modal.classList.remove('hidden');
        };

        // Function to close modal
        const closeModal = () => {
            modal.classList.add('hidden');
            extracurricularForm.reset();
        };

        // Function to render extracurricular cards
        const renderExtracurriculars = (data) => {
            extracurricularList.innerHTML = '';
            data.forEach(extracurricular => {
                const card = document.createElement('div');
                card.classList.add('bg-white', 'p-6', 'rounded-xl', 'shadow-md', 'flex', 'flex-col', 'justify-between', 'transform', 'hover:scale-105', 'transition-transform', 'duration-300');
                
                let iconClass = 'fa-solid fa-star';
                let categoryColor = 'text-gray-500';
                switch(extracurricular.category) {
                    case 'olahraga':
                        iconClass = 'fa-solid fa-volleyball';
                        categoryColor = 'text-green-500';
                        break;
                    case 'seni':
                        iconClass = 'fa-solid fa-palette';
                        categoryColor = 'text-purple-500';
                        break;
                    case 'sains':
                        iconClass = 'fa-solid fa-atom';
                        categoryColor = 'text-blue-500';
                        break;
                    case 'bahasa':
                        iconClass = 'fa-solid fa-language';
                        categoryColor = 'text-red-500';
                        break;
                    default:
                        iconClass = 'fa-solid fa-star';
                        categoryColor = 'text-gray-500';
                        break;
                }
                
                card.innerHTML = `
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800">${extracurricular.name}</h3>
                            <i class="${iconClass} text-2xl ${categoryColor}"></i>
                        </div>
                        <p class="text-sm text-gray-500 mb-2 font-medium">${extracurricular.category.charAt(0).toUpperCase() + extracurricular.category.slice(1)}</p>
                        <p class="text-gray-600 mb-4 text-sm">${extracurricular.description}</p>
                        <div class="space-y-2 text-sm text-gray-700">
                            <p><i class="fa-solid fa-user-tie text-indigo-500 w-5 mr-2"></i> ${extracurricular.instructor}</p>
                            <p><i class="fa-solid fa-clock text-indigo-500 w-5 mr-2"></i> ${extracurricular.schedule}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2 mt-4">
                        <button class="edit-button flex-1 py-2 px-4 rounded-lg bg-teal-500 text-white font-semibold hover:bg-teal-600 transition duration-300" data-id="${extracurricular.id}">
                            <i class="fa-solid fa-edit mr-2"></i> Edit
                        </button>
                        <button class="delete-button flex-1 py-2 px-4 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600 transition duration-300" data-id="${extracurricular.id}">
                            <i class="fa-solid fa-trash-alt mr-2"></i> Hapus
                        </button>
                    </div>
                `;
                
                extracurricularList.appendChild(card);
            });

            // Add event listeners for edit and delete buttons after rendering
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = parseInt(event.currentTarget.dataset.id);
                    const itemToEdit = extracurriculars.find(item => item.id === id);
                    if (itemToEdit) {
                        openModal(itemToEdit);
                    }
                });
            });

            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = parseInt(event.currentTarget.dataset.id);
                    if (confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini?')) {
                        extracurriculars = extracurriculars.filter(item => item.id !== id);
                        renderExtracurriculars(extracurriculars);
                    }
                });
            });
        };

        // Function to filter and search
        const filterAndSearch = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const filterCategory = filterSelect.value;
            
            let filteredData = extracurriculars;

            if (filterCategory !== 'all') {
                filteredData = filteredData.filter(item => item.category === filterCategory);
            }

            if (searchTerm) {
                filteredData = filteredData.filter(item => 
                    item.name.toLowerCase().includes(searchTerm) || 
                    item.description.toLowerCase().includes(searchTerm) || 
                    item.instructor.toLowerCase().includes(searchTerm)
                );
            }
            
            renderExtracurriculars(filteredData);
        };

        // Event listeners
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        addExtracurricularButton.addEventListener('click', () => openModal());
        closeModalButton.addEventListener('click', closeModal);
        searchInput.addEventListener('input', filterAndSearch);
        filterSelect.addEventListener('change', filterAndSearch);

        extracurricularForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const newExtracurricular = {
                name: document.getElementById('name').value,
                category: document.getElementById('category').value,
                description: document.getElementById('description').value,
                instructor: document.getElementById('instructor').value,
                schedule: document.getElementById('schedule').value
            };
            
            if (editingId) {
                const index = extracurriculars.findIndex(item => item.id === editingId);
                if (index !== -1) {
                    extracurriculars[index] = { ...extracurriculars[index], ...newExtracurricular };
                }
            } else {
                newExtracurricular.id = Date.now(); // Simple unique ID
                extracurriculars.push(newExtracurricular);
            }
            
            closeModal();
            filterAndSearch(); // Re-render with new data
        });

        // Initial render
        renderExtracurriculars(extracurriculars);
    </script>

</body>
</html>
