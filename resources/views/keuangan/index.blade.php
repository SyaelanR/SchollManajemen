@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Keuangan Sekolah</h2>
    <p>Pilih menu di bawah untuk melihat data:</p>
    <ul>
        <li><a href="{{ route('keuangan.pemasukan') }}">💰 Pemasukan</a></li>
        <li><a href="{{ route('keuangan.pengeluaran') }}">📉 Pengeluaran</a></li>
    </ul>
</div>
@endsection
