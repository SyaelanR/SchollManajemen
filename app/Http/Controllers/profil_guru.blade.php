<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Guru - {{ $guru->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .profile-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            margin-bottom: 20px;
            gap: 1.5rem;
        }
        .profile-header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #e7e7e7;
        }
        .profile-header-info h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 2.25em;
            font-weight: 700;
        }
        .profile-header-info p {
            margin: 5px 0 0;
            color: #7f8c8d;
            font-size: 1.1em;
            text-transform: capitalize;
        }
        .profile-section {
            margin-bottom: 25px;
        }
        .profile-section h2 {
            color: #4f46e5; /* Indigo */
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-size: 1.5em;
            font-weight: 600;
        }
        .profile-section ul {
            list-style-type: none;
            padding: 0;
        }
        .profile-section ul li {
            background: #f8fafc;
            margin-bottom: 8px;
            padding: 12px;
            border-radius: 5px;
            border-left: 4px solid #6366f1; /* Indigo lighter */
        }
        .contact-info p {
            margin: 5px 0;
        }
        .contact-info strong {
            display: inline-block;
            width: 90px;
            font-weight: 500;
            color: #4b5563;
        }
    </style>
</head>
<body class="flex">
    {{-- Sidebar bisa ditambahkan di sini jika diperlukan, atau biarkan seperti ini untuk halaman mandiri --}}
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Profil Guru</h1>
            <a href="{{ url()->previous() }}" class="text-indigo-600 hover:underline">
                <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
            </a>
        </header>

        <main class="p-6 md:p-8">
            <div class="container">
                <header class="profile-header">
                    <img src="{{ $guru->foto_profil }}" alt="Foto Profil {{ $guru->name }}">
                    <div class="profile-header-info">
                        <h1>{{ $guru->name }}</h1>
                        <p>{{ $guru->role }}</p>
                    </div>
                </header>

                <main>
                    <section class="profile-section">
                        <h2>Tentang Saya</h2>
                        <p>{{ $guru->biografi }}</p>
                    </section>

                    <section class="profile-section">
                        <h2>Mata Pelajaran yang Diampu</h2>
                        @if($mata_pelajaran->isNotEmpty())
                            <ul>
                                @foreach ($mata_pelajaran as $mapel)
                                    <li>{{ $mapel }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Belum ada mata pelajaran yang diampu.</p>
                        @endif
                    </section>

                    <section class="profile-section">
                        <h2>Riwayat Pendidikan</h2>
                        <ul>
                            @forelse ($pendidikan as $edu)
                                <li>{{ $edu }}</li>
                            @empty
                                <li>Data pendidikan belum ditambahkan.</li>
                            @endforelse
                        </ul>
                    </section>

                    <section class="profile-section contact-info">
                        <h2>Kontak</h2>
                        <p><strong>Email:</strong> <a href="mailto:{{ $guru->email }}" class="text-indigo-600 hover:underline">{{ $guru->email }}</a></p>
                        <p><strong>Telepon:</strong> {{ $guru->no_telp ?? '-' }}</p>
                    </section>
                </main>
            </div>
        </main>
    </div>
</body>
</html>
