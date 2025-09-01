<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <nav class="bg-blue-500 p-4 text-white">
        <a href="{{ route('keuangan.index') }}" class="mr-4">Keuangan</a>
        <a href="{{ route('keuangan.tagihan') }}">Tagihan</a>
    </nav>

    <div class="p-6">
        @yield('content')
    </div>

</body>
</html>
