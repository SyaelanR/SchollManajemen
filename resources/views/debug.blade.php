<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Debug</title>
</head>
<body>
    <h1>DEBUG</h1>
    
    <pre>{{ json_encode($debug, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>

    <br>
    <br>
    @forelse ($rapors ?? [] as $rapor)
    {{-- <h2>{{$rapor->siswa->name}}</h2> --}}
    @empty
    <p>kosong</p>
    @endforelse
 
    {{-- <p>{{$daftarSiswa}}</p> --}}
</body>
</html>