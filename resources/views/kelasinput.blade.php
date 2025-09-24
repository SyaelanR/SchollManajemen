<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSys - Input Nilai</title>
    <!-- Tailwind CSS CDN untuk styling yang cepat dan responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter untuk tipografi yang bersih -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk ikon-ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Gaya kustom untuk scrollbar dan transisi sidebar */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .table-input th, .table-input td {
            border: 1px solid #e2e8f0;
            padding: 1rem;
            text-align: left;
        }
        /* Custom modal styles */
        .modal {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .notification.show {
            opacity: 1;
        }
        /* Style for grade input */
        .grade-input {
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Notifikasi berhasil disimpan (tersembunyi secara default) -->
    <div id="notification-success" class="fixed top-5 left-1/2 -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-full shadow-lg z-[100] transform transition-opacity duration-300 opacity-0 hidden">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-check-circle text-lg"></i>
            <span class="font-medium">Nilai berhasil disimpan!</span>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden bg-gray-50">
        <!-- Sidebar - Navigasi Samping -->
        <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-2xl fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="p-6 border-b border-gray-100">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">EduSys</span>
                </a>
            </div>
            <nav class="mt-6">
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" id="link-nilai" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Input Nilai</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-puzzle-piece mr-3"></i>
                    <span>Ekstrakulikuler</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-user-plus mr-3"></i>
                    <span>Tambah Siswa</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Overlay untuk menu mobile -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Header Halaman -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 id="header-title" class="text-xl md:text-2xl font-bold text-gray-800">Input Nilai</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Tampilan "Input Nilai" (sekarang menjadi satu-satunya tampilan) -->
            <main class="p-6 md:p-8 flex-1">
                <div id="grade-input-view">
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                            <h3 id="grade-input-title" class="text-2xl font-bold text-gray-800"></h3>
                            <div class="flex flex-wrap gap-4">
                                <button onclick="showGradeTypeModal()" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-indigo-700 transition duration-300">
                                    <i class="fa-solid fa-list-ul mr-2"></i> Atur Jenis Nilai
                                </button>
                            </div>
                        </div>
                        <form onsubmit="saveGrades(event)">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse table-input">
                                    <thead id="grade-table-head" class="bg-gray-100">
                                        <!-- Header tabel akan dibuat secara dinamis -->
                                    </thead>
                                    <tbody id="nilai-table-body" class="text-gray-600 text-sm font-light">
                                        <!-- Baris nilai siswa akan dibuat secara dinamis -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:bg-green-700 transition duration-300">
                                    <i class="fa-solid fa-save mr-2"></i> Simpan Nilai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal untuk Atur Jenis Nilai -->
    <div id="grade-type-modal" class="modal fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Konten Modal -->
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white p-6">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <h3 class="text-xl leading-6 font-bold text-gray-900">Atur Jenis Nilai</h3>
                        <button onclick="closeGradeTypeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-lg font-semibold text-gray-700">Jenis Nilai Saat Ini</h4>
                        <ul id="grade-types-list" class="mt-2 space-y-2">
                            <!-- Daftar jenis nilai akan dirender di sini -->
                        </ul>
                    </div>
                    <div class="mt-6 border-t pt-4 border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-700">Tambah Jenis Nilai Baru</h4>
                        <div class="flex mt-2">
                            <input type="text" id="new-grade-type-input" placeholder="Contoh: Nilai Harian" class="flex-1 rounded-l-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <button type="button" onclick="addGradeType()" class="bg-indigo-600 text-white font-semibold rounded-r-lg px-4 py-2 hover:bg-indigo-700 transition duration-300">
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, doc, setDoc, onSnapshot, collection, query } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";
        import { setLogLevel } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

        // Set Firebase debug logging
        setLogLevel('Debug');

        // Global variables for Firebase configuration
        const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
        const firebaseConfig = JSON.parse(typeof __firebase_config !== 'undefined' ? __firebase_config : '{}');
        const initialAuthToken = typeof __initial_auth_token !== 'undefined' ? __initial_auth_token : null;
        let db, auth, userId = 'loading';

        // Data dummy untuk siswa
        const students = {
            '10A': ['Siswa 1', 'Siswa 2', 'Siswa 3', 'Siswa 4', 'Siswa 5', 'Siswa 6', 'Siswa 7', 'Siswa 8', 'Siswa 9', 'Siswa 10'],
            '10B': ['Siswa 11', 'Siswa 12', 'Siswa 13', 'Siswa 14', 'Siswa 15'],
            '11A': ['Siswa 16', 'Siswa 17', 'Siswa 18', 'Siswa 19', 'Siswa 20'],
            '11B': ['Siswa 21', 'Siswa 22', 'Siswa 23', 'Siswa 24', 'Siswa 25'],
        };
        
        // Data untuk jenis nilai, bisa diubah dan ditambah
        let gradeTypes = ['Nilai Tugas', 'Nilai UTS', 'Nilai UAS'];
        
        // Ambil elemen HTML
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const gradeInputView = document.getElementById('grade-input-view');
        const headerTitle = document.getElementById('header-title');
        const gradeInputTitle = document.getElementById('grade-input-title');
        const gradeTableHead = document.getElementById('grade-table-head');
        const gradeTableBody = document.getElementById('nilai-table-body');
        
        // Elemen modal
        const gradeTypeModal = document.getElementById('grade-type-modal');
        const gradeTypesList = document.getElementById('grade-types-list');
        const newGradeTypeInput = document.getElementById('new-grade-type-input');

        // Elemen notifikasi
        const notificationSuccess = document.getElementById('notification-success');

        let currentClass = '10A'; // Mengatur kelas default

        // Fungsi untuk menampilkan tampilan input yang sesuai (nilai)
        function showInputView(className) {
            currentClass = className;
            gradeInputView.classList.remove('hidden');
            headerTitle.textContent = `Input Nilai - Kelas ${className}`;
            gradeInputTitle.textContent = `Input Nilai - Kelas ${className}`;
            listenForGrades(className);
        }

        // Fungsi untuk menghitung dan menampilkan rata-rata untuk satu baris
        function calculateAndDisplayAverage(input) {
            const row = input.closest('tr');
            if (!row) return;

            const inputs = row.querySelectorAll('input[type="number"]');
            let total = 0;
            let count = 0;
            
            inputs.forEach(input => {
                const value = parseFloat(input.value);
                if (!isNaN(value)) {
                    total += value;
                    count++;
                }
            });

            const average = count > 0 ? (total / count).toFixed(2) : 'N/A';
            const averageSpan = row.querySelector('.average-grade');
            if (averageSpan) {
                averageSpan.textContent = average;
            }
        }

        // Fungsi untuk membuat baris dan header tabel nilai secara dinamis
        function renderGradeTable(className, studentData) {
            // Render header tabel
            const headerRow = `
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left whitespace-nowrap">No</th>
                    <th class="py-3 px-6 text-left whitespace-nowrap">Nama Siswa</th>
                    ${gradeTypes.map(type => `<th class="py-3 px-6 text-left whitespace-nowrap">${type}</th>`).join('')}
                    <th class="py-3 px-6 text-left whitespace-nowrap">Rata-rata</th>
                </tr>
            `;
            gradeTableHead.innerHTML = headerRow;

            // Render isi tabel
            const studentList = students[className] || [];
            gradeTableBody.innerHTML = studentList.map((student, index) => {
                const gradeInputs = gradeTypes.map(type => {
                    const grade = studentData[student] && studentData[student][type] !== undefined ? studentData[student][type] : '';
                    return `
                        <td class="py-3 px-6">
                            <input type="number" oninput="calculateAndDisplayAverage(this)" name="grades[${student}][${type}]" value="${grade}" class="grade-input w-20 px-2 py-1 text-center rounded-lg border border-gray-300">
                        </td>
                    `;
                }).join('');

                const initialGrades = studentData[student] || {};
                let total = 0;
                let count = 0;
                for (const type of gradeTypes) {
                    if (initialGrades[type] !== undefined && !isNaN(initialGrades[type])) {
                        total += parseFloat(initialGrades[type]);
                        count++;
                    }
                }
                const initialAverage = count > 0 ? (total / count).toFixed(2) : 'N/A';
                
                return `
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-6 text-left whitespace-nowrap">${index + 1}</td>
                        <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-900">${student}</td>
                        ${gradeInputs}
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <span class="average-grade font-semibold">${initialAverage}</span>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Fungsi untuk menangani penyimpanan nilai ke Firestore
        async function saveGrades(event) {
            event.preventDefault();

            if (!currentClass || !userId) {
                console.error("Kelas atau ID pengguna tidak tersedia.");
                alert("Simpan gagal. Anda tidak terhubung.");
                return;
            }

            const studentList = students[currentClass] || [];
            const form = event.target;
            
            try {
                for (const student of studentList) {
                    const studentGrades = {};
                    let hasValidGrade = false;

                    for (const type of gradeTypes) {
                        const inputName = `grades[${student}][${type}]`;
                        const inputElement = form.querySelector(`[name="${inputName}"]`);
                        if (inputElement) {
                            const value = parseFloat(inputElement.value);
                            if (!isNaN(value)) {
                                studentGrades[type] = value;
                                hasValidGrade = true;
                            }
                        }
                    }

                    if (hasValidGrade) {
                        const gradesRef = doc(db, `/artifacts/${appId}/users/${userId}/classes/${currentClass}/students`, student);
                        await setDoc(gradesRef, studentGrades, { merge: true });
                    }
                }
                
                // Tampilkan notifikasi berhasil
                showSuccessNotification();
            } catch (error) {
                console.error("Gagal menyimpan nilai:", error);
            }
        }

        // Fungsi untuk memuat nilai dari Firestore secara real-time
        function listenForGrades(className) {
            // Jika tidak terhubung ke Firebase, gunakan data dummy
            if (!db || !userId || userId === 'loading') {
                console.warn("Firebase tidak terhubung. Menggunakan data dummy.");
                renderGradeTable(className, {});
                return;
            }

            const gradesCollectionRef = collection(db, `/artifacts/${appId}/users/${userId}/classes/${className}/students`);
            
            onSnapshot(gradesCollectionRef, (querySnapshot) => {
                const studentData = {};
                querySnapshot.forEach(doc => {
                    studentData[doc.id] = doc.data();
                });
                renderGradeTable(className, studentData);
            }, (error) => {
                console.error("Gagal memuat data nilai:", error);
            });
        }

        // Fungsi untuk menampilkan notifikasi berhasil
        function showSuccessNotification() {
            notificationSuccess.classList.remove('hidden');
            setTimeout(() => {
                notificationSuccess.style.opacity = '1';
            }, 10);
            setTimeout(() => {
                notificationSuccess.style.opacity = '0';
                setTimeout(() => {
                    notificationSuccess.classList.add('hidden');
                }, 300);
            }, 3000);
        }

        // Fungsi untuk menampilkan modal jenis nilai
        function showGradeTypeModal() {
            gradeTypeModal.classList.remove('hidden');
            renderGradeTypeList();
        }

        // Fungsi untuk menutup modal jenis nilai
        function closeGradeTypeModal() {
            gradeTypeModal.classList.add('hidden');
        }

        // Fungsi untuk merender daftar jenis nilai di modal
        function renderGradeTypeList() {
            gradeTypesList.innerHTML = gradeTypes.map((type, index) => `
                <li class="flex items-center justify-between bg-gray-100 p-3 rounded-lg">
                    <span>${type}</span>
                    <button type="button" onclick="deleteGradeType(${index})" class="text-red-500 hover:text-red-700 transition duration-200">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </li>
            `).join('');
        }

        // Fungsi untuk menambah jenis nilai
        function addGradeType() {
            const newType = newGradeTypeInput.value.trim();
            if (newType && !gradeTypes.includes(newType)) {
                gradeTypes.push(newType);
                newGradeTypeInput.value = '';
                renderGradeTypeList();
                if (currentClass) {
                    renderGradeTable(currentClass, {}); // Perbarui tabel utama dengan data kosong
                }
            } else if (gradeTypes.includes(newType)) {
                console.warn('Jenis nilai sudah ada.');
            }
        }

        // Fungsi untuk menghapus jenis nilai
        function deleteGradeType(index) {
            gradeTypes.splice(index, 1);
            renderGradeTypeList();
            if (currentClass) {
                renderGradeTable(currentClass, {}); // Perbarui tabel utama
            }
        }

        // Fungsi untuk mengaktifkan/menonaktifkan sidebar pada perangkat mobile
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Tambahkan event listener untuk tombol menu, overlay, dan tautan sidebar
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Inisialisasi Firebase dan tampilan awal
        document.addEventListener('DOMContentLoaded', async () => {
            if (Object.keys(firebaseConfig).length > 0) {
                const app = initializeApp(firebaseConfig);
                db = getFirestore(app);
                auth = getAuth(app);

                onAuthStateChanged(auth, async (user) => {
                    if (user) {
                        userId = user.uid;
                        console.log("User authenticated:", userId);
                        showInputView(currentClass); 
                    } else {
                        console.log("No user authenticated. Signing in anonymously.");
                        try {
                            if (initialAuthToken) {
                                await signInWithCustomToken(auth, initialAuthToken);
                            } else {
                                await signInAnonymously(auth);
                            }
                        } catch (error) {
                            console.error("Authentication error:", error);
                        }
                    }
                });
            } else {
                console.error("Firebase config is empty. The app will run in offline mode with dummy data.");
                // Render the view directly with dummy data
                showInputView(currentClass);
            }
        });
    </script>
</body>
</html>
