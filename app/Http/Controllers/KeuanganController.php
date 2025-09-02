<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    // ================== Daftar Transaksi & Saldo ==================
    public function index()
    {
        $transaksi = Keuangan::orderBy('tanggal', 'asc')->get();
        $totalPemasukan = Keuangan::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Data untuk chart
        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        // Ambil tanggal unik dari transaksi
        $dates = $transaksi->pluck('tanggal')->unique()->sort();

        foreach ($dates as $date) {
            $chartLabels[] = Carbon::parse($date)->format('d-m-Y');
            $chartPemasukan[] = $transaksi
                ->where('tanggal', $date)
                ->where('jenis', 'pemasukan')
                ->sum('jumlah');
            $chartPengeluaran[] = $transaksi
                ->where('tanggal', $date)
                ->where('jenis', 'pengeluaran')
                ->sum('jumlah');
        }

        return view('keuangan.index', [
            'transaksi'        => $transaksi,
            'totalPemasukan'   => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo'            => $saldo,
            'chartLabels'      => $chartLabels,
            'chartPemasukan'   => $chartPemasukan,
            'chartPengeluaran' => $chartPengeluaran,
        ]);
    }

    // ================== Pemasukan ==================
    public function createPemasukan()
    {
        return view('keuangan.createPemasukan');
    }

    public function storePemasukan(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah'    => 'required|numeric|min:0',
        ]);

        Keuangan::create([
            'tanggal'   => $request->tanggal,
            'jenis'     => 'pemasukan',
            'deskripsi' => $request->deskripsi,
            'jumlah'    => $request->jumlah,
        ]);

        return redirect()->route('keuangan.index')
                         ->with('success', 'Pemasukan berhasil ditambahkan!');
    }

    // ================== Pengeluaran ==================
    public function createPengeluaran()
    {
        return view('keuangan.createPengeluaran');
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah'    => 'required|numeric|min:0',
        ]);

        Keuangan::create([
            'tanggal'   => $request->tanggal,
            'jenis'     => 'pengeluaran',
            'deskripsi' => $request->deskripsi,
            'jumlah'    => $request->jumlah,
        ]);

        return redirect()->route('keuangan.index')
                         ->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    // ================== Tagihan Siswa ==================
    public function tagihan()
    {
        $tagihan = Keuangan::where('jenis', 'tagihan')->orderBy('created_at', 'desc')->get();
        $totalTagihan = Keuangan::where('jenis', 'tagihan')->sum('jumlah');

        return view('keuangan.tagihan', compact('tagihan', 'totalTagihan'));
    }

    public function createTagihan()
    {
        return view('keuangan.createTagihan');
    }

    public function storeTagihan(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'nis'       => 'required|string|max:20',
            'siswa'     => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'jumlah'    => 'required|numeric|min:0',
        ]);

        Keuangan::create([
            'tanggal'   => $request->tanggal,
            'jenis'     => 'tagihan',
            'deskripsi' => $request->deskripsi . ' (NIS: ' . $request->nis . ', Siswa: ' . $request->siswa . ')',
            'jumlah'    => $request->jumlah,
        ]);

        return redirect()->route('keuangan.tagihan')
                         ->with('success', 'Tagihan siswa berhasil ditambahkan!');
    }

    public function editTagihan($id)
    {
        $tagihan = Keuangan::findOrFail($id);
        return view('keuangan.editTagihan', compact('tagihan'));
    }

    public function updateTagihan(Request $request, $id)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'nis'       => 'required|string|max:20',
            'siswa'     => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'jumlah'    => 'required|numeric|min:0',
        ]);

        $tagihan = Keuangan::findOrFail($id);
        $tagihan->update([
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi . ' (NIS: ' . $request->nis . ', Siswa: ' . $request->siswa . ')',
            'jumlah'    => $request->jumlah,
        ]);

        return redirect()->route('keuangan.tagihan')
                         ->with('success', 'Tagihan siswa berhasil diperbarui!');
    }

    public function destroyTagihan($id)
    {
        $tagihan = Keuangan::findOrFail($id);
        $tagihan->delete();

        return redirect()->route('keuangan.tagihan')
                         ->with('success', 'Tagihan siswa berhasil dihapus!');
    }

    // ================== Edit & Hapus Transaksi Umum ==================
    public function edit($id)
    {
        $transaksi = Keuangan::findOrFail($id);
        return view('keuangan.editTransaksi', compact('transaksi')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah'    => 'required|numeric|min:0',
            'jenis'     => 'required|in:pemasukan,pengeluaran',
        ]);

        $transaksi = Keuangan::findOrFail($id);
        $transaksi->update([
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'jumlah'    => $request->jumlah,
            'jenis'     => $request->jenis,
        ]);

        return redirect()->route('keuangan.index')
                         ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = Keuangan::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('keuangan.index')
                         ->with('success', 'Transaksi berhasil dihapus!');
    }
}
