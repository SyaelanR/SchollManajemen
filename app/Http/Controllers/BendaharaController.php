<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BendaharaController extends Controller
{
    // ----- DASHBOARD & LAPORAN -----
    public function dashboard()
    {
        return view('bendahara.dashboard');
    }

    public function review()
    {
        return view('bendahara.laporan');
    }

    // ----- PEMBELIAN (Periksa & Setujui) -----
    public function pembelianIndex()
    {
        // Data dummy – ganti query DB bila tersedia
        $pembelian = [
            [
                'id'       => 1,
                'tanggal'  => '2025-09-18',
                'supplier' => 'PT Sukses Makmur',
                'produk'   => [
                    ['nama' => 'Kertas A4',     'qty' => 10, 'harga' => 35000],
                    ['nama' => 'Tinta Printer', 'qty' =>  2, 'harga' =>120000],
                ],
                'pajak'    => 10000,
                'diskon'   => 5000,
                'coa'      => 'Persediaan ATK',
                'total'    => 350000,
                'status'   => 'pending',
            ],
        ];

        return view('bendahara.pembelian', compact('pembelian'));
    }

    public function pembelianApprove($id, Request $request)
    {
        $request->validate(['alasan' => 'required|string']);
        // contoh update DB:
        // Purchase::find($id)->update(['status'=>'approved','catatan'=>$request->alasan]);
        return back()->with('success', "Pembelian ID {$id} disetujui. Alasan: {$request->alasan}");
    }

    public function pembelianReject($id, Request $request)
    {
        $request->validate(['alasan' => 'required|string']);
        // contoh update DB:
        // Purchase::find($id)->update(['status'=>'rejected','catatan'=>$request->alasan]);
        return back()->with('error', "Pembelian ID {$id} ditolak. Alasan: {$request->alasan}");
    }

    // ----- MENU TAMBAHAN BENDAHARA -----
    public function pembelian()
{
    return $this->pembelianIndex();
}

    public function persetujuan()
    {
        return view('bendahara.persetujuan');
    }

    public function pembayaran()
    {
        return view('bendahara.pembayaran');
    }


     public function penjualan()
    {
        return view('bendahara.penjualan');
    }

    public function supplier()
    {
        return view('bendahara.supplier');
    }

////////


    public function pelanggan()
    {
        return view('bendahara.pelanggan');
    }

    public function coa()
    {
        return view('bendahara.coa');
    }

    public function laporan()
    {
        return view('bendahara.laporan');
    }
    public function laporanNeraca()
    {
        return view('bendahara.neraca');
    }

    public function laporanLabaRugi()
    {
        return view('bendahara.laba-rugi');
    }

   // ubah dari index() menjadi jurnal()
    public function jurnal()
    {
        // arahkan ke resources/views/bendahara/jurnal.blade.php
        return view('bendahara.jurnal');
    }

//////////////////////// TAGIHAN SISWA  /////////////////////////////////////
 public function tagihan()
    {
        // View: resources/views/bendahara/tagihan.blade.php
        return view('bendahara.tagihan');
    }

    /**
     * Endpoint untuk menambahkan tagihan (jika mau menambah lewat form Laravel)
     * NOTE: Saat ini form JS langsung simpan ke Firebase, 
     * jadi fungsi ini opsional.
     */
    public function simpanTagihan(Request $request)
    {
        // Validasi sederhana (opsional jika nanti pakai DB Laravel)
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'dueDate'     => 'required|date',
        ]);

        // Contoh jika ingin simpan ke database Laravel (table 'tagihans')
        // Tagihan::create($validated);

        // Sementara hanya return sukses (karena data disimpan di Firebase via JS)
        return response()->json([
            'success' => true,
            'message' => 'Tagihan berhasil disimpan (dummy, Firebase handle).',
            'data'    => $validated
        ]);
    }


}
