<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSys - Pilih Kelas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body>
    <div class="flex h-screen overflow-hidden bg-gray-50">
        <!-- Sidebar -->
        <aside class="bg-white w-64 min-h-screen flex-shrink-0 shadow-2xl">
            <div class="p-6 border-b border-gray-100">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">EduSys</span>
                </a>
            </div>
            <nav class="mt-6">
                <a href="{{ route('inputtugas') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold border-l-4 border-indigo-600">
                    <i class="fa-solid fa-pen mr-3"></i> <span>Input Nilai</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Pilih Kelas</h1>
            </header>

            <main class="p-6 md:p-8 flex-1">
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-6 text-gray-800">
                    <h2 class="text-3xl font-bold mb-2">Selamat Datang, Guru</h2>
                    <p class="text-gray-600">Silakan pilih kelas untuk menginput nilai.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kelas as $k)
                        <a href="{{ route('kelas.inputNilai', $k->id) }}" class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-shadow">
                            <h3 class="text-xl font-bold text-gray-800">{{ $k->nama_kelas }}</h3>
                            <p class="mt-4 text-gray-600">Jumlah siswa: {{ $k->siswa_count ?? '0' }}</p>
                        </a>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
</body>
</html>
