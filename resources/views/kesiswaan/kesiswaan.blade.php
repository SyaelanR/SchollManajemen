<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Halaman Sanksi Kesiswaan</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                transition: background-color 0.3s ease, color 0.3s ease;
            }
            .light-mode {
                background-color: #f3f4f6;
                color: #1f2937;
            }
            .dark-mode {
                background-color: #1f2937;
                color: #f3f4f6;
            }
        </style>
    </head>
    <body
        class="light-mode font-sans antialiased flex flex-col items-center justify-start min-h-screen py-10"
    >
        <div
            class="w-full max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 space-y-8"
        >
            <!-- Mode Toggle -->
            <div class="flex space-x-4 justify-end mb-6">
                <button
                    id="lightModeBtn"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-sm transition-colors duration-300"
                >
                    Mode Terang
                </button>
                <button
                    id="darkModeBtn"
                    class="bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors duration-300"
                >
                    Mode Gelap
                </button>
            </div>

            <!-- Login -->
            <div id="loginForm" class="p-6 rounded-2xl">
                <h1 class="text-3xl font-bold mb-6 text-center">
                    Masuk ke Sistem Sanksi
                </h1>
                <div class="space-y-4">
                    <input
                        id="usernameInput"
                        type="text"
                        placeholder="Masukkan Nama Anda (Budi, Ibu Siti, atau Pak Admin)"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100 dark:bg-gray-700 dark:text-gray-200"
                    />
                    <select
                        id="roleSelect"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100 dark:bg-gray-700 dark:text-gray-200"
                    >
                        <option value="">Pilih Peran</option>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                        <option value="admin">Admin</option>
                    </select>
                    <p
                        id="statusMessage"
                        class="text-center text-sm font-medium h-4"
                    ></p>
                    <button
                        id="loginButton"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition-all duration-300 transform active:scale-95"
                    >
                        Masuk
                    </button>
                </div>
            </div>

            <!-- Dashboard -->
            <div id="dashboard" class="hidden">
                <div class="flex justify-between items-center mb-6">
                    <h1 id="dashboardTitle" class="text-3xl font-bold">
                        Dasbor Sanksi
                    </h1>
                    <button
                        id="logoutButton"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-all duration-300"
                    >
                        Keluar
                    </button>
                </div>

                <!-- Tambah Catatan -->
                <button
                    id="addRecordBtn"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-all duration-300 mb-6 hidden"
                >
                    + Tambah Catatan Sanksi
                </button>

                <!-- Catatan -->
                <section
                    class="bg-gray-100 dark:bg-gray-700 p-6 rounded-xl shadow-md"
                >
                    <h2
                        class="text-2xl font-bold mb-4 border-b-2 pb-2 border-gray-300 dark:border-gray-600"
                    >
                        Catatan Pelanggaran
                    </h2>
                    <div
                        id="recordsList"
                        class="space-y-4 text-gray-700 dark:text-gray-300"
                    ></div>
                </section>
            </div>
        </div>

        <script>
            const body = document.body;
            const lightModeBtn = document.getElementById("lightModeBtn");
            const darkModeBtn = document.getElementById("darkModeBtn");
            const loginForm = document.getElementById("loginForm");
            const dashboard = document.getElementById("dashboard");
            const usernameInput = document.getElementById("usernameInput");
            const roleSelect = document.getElementById("roleSelect");
            const loginButton = document.getElementById("loginButton");
            const logoutButton = document.getElementById("logoutButton");
            const statusMessage = document.getElementById("statusMessage");
            const dashboardTitle = document.getElementById("dashboardTitle");
            const addRecordBtn = document.getElementById("addRecordBtn");
            const recordsList = document.getElementById("recordsList");

            // "database" user
            const userDatabase = {
                budi: "siswa",
                "ibu siti": "guru",
                "pak admin": "admin",
            };

            // data sanksi contoh
            const sanctionsData = [
                {
                    id: 1,
                    nama: "Budi",
                    pelanggaran: "Terlambat Masuk Kelas",
                    sanksi: "Peringatan lisan",
                    tanggal: "2024-05-20",
                },
                {
                    id: 2,
                    nama: "Andi",
                    pelanggaran: "Tidak Mengenakan Seragam",
                    sanksi: "Teguran",
                    tanggal: "2024-05-18",
                },
                {
                    id: 3,
                    nama: "Budi",
                    pelanggaran: "Membuang Sampah Sembarangan",
                    sanksi: "Membersihkan Area",
                    tanggal: "2024-05-15",
                },
                {
                    id: 4,
                    nama: "Siska",
                    pelanggaran: "Berkelahi Ringan",
                    sanksi: "Panggilan Orang Tua",
                    tanggal: "2024-05-10",
                },
            ];

            // =========================
            // Mode terang/gelap
            // =========================
            const activateDarkMode = () => {
                body.classList.replace("light-mode", "dark-mode");
            };
            const activateLightMode = () => {
                body.classList.replace("dark-mode", "light-mode");
            };

            darkModeBtn.addEventListener("click", activateDarkMode);
            lightModeBtn.addEventListener("click", activateLightMode);
            activateLightMode(); // default

            // =========================
            // Render catatan
            // =========================
            const renderRecords = (role, username) => {
                recordsList.innerHTML = "";
                let filteredRecords = sanctionsData;
                if (role === "siswa") {
                    filteredRecords = sanctionsData.filter(
                        (r) => r.nama.toLowerCase() === username
                    );
                }
                if (filteredRecords.length === 0) {
                    recordsList.innerHTML =
                        '<p class="text-center text-gray-500 dark:text-gray-400">Tidak ada catatan sanksi.</p>';
                    return;
                }
                filteredRecords.forEach((r) => {
                    const div = document.createElement("div");
                    div.className =
                        "bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm";
                    div.innerHTML = `
          <h3 class="font-bold text-lg mb-1">${r.nama}</h3>
          <p class="text-sm"><strong>Pelanggaran:</strong> ${r.pelanggaran}</p>
          <p class="text-sm"><strong>Sanksi:</strong> ${r.sanksi}</p>
          <p class="text-sm"><strong>Tanggal:</strong> ${r.tanggal}</p>`;
                    recordsList.appendChild(div);
                });
            };

            // =========================
            // Session state
            // =========================
            let currentUser = null; // simpan user login

            // =========================
            // Router sederhana pakai hash
            // =========================
            const routes = {
                "#/login": loginForm,
                "#/dashboard": dashboard,
            };

            function navigate() {
                const hash = window.location.hash || "#/login";

                // Proteksi route dashboard: kalau belum login → redirect ke login
                if (hash === "#/dashboard" && !currentUser) {
                    window.location.hash = "#/login";
                    return;
                }

                // sembunyikan semua
                Object.values(routes).forEach((el) =>
                    el.classList.add("hidden")
                );
                // tampilkan sesuai route
                if (routes[hash]) {
                    routes[hash].classList.remove("hidden");
                } else {
                    routes["#/login"].classList.remove("hidden");
                }
            }

            window.addEventListener("load", navigate);
            window.addEventListener("hashchange", navigate);

            // =========================
            // Login / Logout
            // =========================
            const handleLogin = () => {
                const username = usernameInput.value.trim().toLowerCase();
                const role = roleSelect.value;
                if (userDatabase[username] && userDatabase[username] === role) {
                    currentUser = {
                        name: usernameInput.value.trim(),
                        role: role,
                    };

                    statusMessage.textContent = "Login berhasil!";
                    statusMessage.className =
                        "text-center text-green-500 text-sm font-medium h-4";

                    // pindah ke dashboard
                    window.location.hash = "#/dashboard";

                    // Set UI
                    dashboardTitle.textContent = `Selamat Datang, ${currentUser.name}!`;
                    role === "siswa"
                        ? addRecordBtn.classList.add("hidden")
                        : addRecordBtn.classList.remove("hidden");
                    renderRecords(role, username);
                } else {
                    statusMessage.textContent = "Nama atau Peran salah.";
                    statusMessage.className =
                        "text-center text-red-500 text-sm font-medium h-4";
                }
            };

            const handleLogout = () => {
                currentUser = null;
                usernameInput.value = "";
                roleSelect.value = "";
                statusMessage.textContent = "";
                window.location.hash = "#/login"; // balik ke login
            };

            loginButton.addEventListener("click", handleLogin);
            [usernameInput, roleSelect].forEach((el) =>
                el.addEventListener("keydown", (e) => {
                    if (e.key === "Enter") handleLogin();
                })
            );
            logoutButton.addEventListener("click", handleLogout);
        </script>
    </body>
</html>
