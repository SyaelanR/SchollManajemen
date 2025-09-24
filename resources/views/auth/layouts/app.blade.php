<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-blue-700">
                School Dashboard
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ url('/') }}" class="block px-4 py-2 rounded hover:bg-blue-700">Dashboard</a>
                <a href="{{ url('/kesiswaan') }}" class="block px-4 py-2 rounded hover:bg-blue-700">Kesiswaan</a>
                <a href="{{ url('/login-siswa') }}" class="block px-4 py-2 rounded hover:bg-blue-700">Login Siswa</a>
                <a href="{{ url('/login-guru') }}" class="block px-4 py-2 rounded hover:bg-blue-700">Login Guru</a>
                <a href="{{ url('/login-admin') }}" class="block px-4 py-2 rounded hover:bg-blue-700">Login Admin</a>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">@yield('header', 'Dashboard')</h1>
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Logout</button>
            </header>

            <!-- Page content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
