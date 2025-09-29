<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class KeuanganController extends Controller
{
    private $coaData;
    private $allDummyData;

    public function __construct()
    {
        // Data dummy untuk COA dan data lainnya, diinisialisasi di sini
        $this->coaData = new Collection([
            (object)['id' => 1, 'kode' => '11100', 'nama' => 'Kas', 'kategori' => 'Aset'],
            (object)['id' => 2, 'kode' => '11200', 'nama' => 'Bank', 'kategori' => 'Aset'],
            (object)['id' => 3, 'kode' => '11300', 'nama' => 'Piutang Usaha', 'kategori' => 'Aset'],
            (object)['id' => 4, 'kode' => '11400', 'nama' => 'Persediaan', 'kategori' => 'Aset'],
            (object)['id' => 5, 'kode' => '21100', 'nama' => 'Utang Usaha', 'kategori' => 'Liabilitas'],
            (object)['id' => 6, 'kode' => '31100', 'nama' => 'Modal', 'kategori' => 'Ekuitas'],
            (object)['id' => 7, 'kode' => '41100', 'nama' => 'Pendapatan SPP', 'kategori' => 'Pendapatan'],
            (object)['id' => 8, 'kode' => '51100', 'nama' => 'Beban Gaji', 'kategori' => 'Beban'],
        ]);

        $this->allDummyData = [
            'produk' => [
                ['id' => 1, 'nama' => 'Buku Paket Kelas 1', 'kategori' => 'Buku', 'harga' => 'Rp 50.000', 'stok' => 100],
                ['id' => 2, 'nama' => 'Seragam Sekolah', 'kategori' => 'Seragam', 'harga' => 'Rp 150.000', 'stok' => 50],
                ['id' => 3, 'nama' => 'Alat Tulis Set', 'kategori' => 'Alat Tulis', 'harga' => 'Rp 25.000', 'stok' => 200],
            ],
            'supplier' => [
                ['id' => 1, 'nama' => 'PT. Sumber Makmur', 'kontak' => '08123456789', 'alamat' => 'Jl. A. Yani No.1', 'rekening' => 'BCA 123456789'],
                ['id' => 2, 'nama' => 'CV. Media Sekolah', 'kontak' => '08987654321', 'alamat' => 'Jl. Merdeka No. 10', 'rekening' => 'Mandiri 987654321'],
            ],
            'pelanggan' => [
                ['id' => 1, 'nama' => 'Budi Santoso', 'kontak' => '0811223344', 'kelas' => 'VII A'],
                ['id' => 2, 'nama' => 'Siti Aminah', 'kontak' => '0855443322', 'kelas' => 'X IPS'],
            ],
            'pembelian' => [
                ['id' => 1, 'tanggal' => '2023-10-20', 'supplier' => 'PT. Sumber Makmur', 'keterangan' => 'Pembelian Buku Paket', 'harga_total' => 5000000],
                ['id' => 2, 'tanggal' => '2023-10-21', 'supplier' => 'CV. Media Sekolah', 'keterangan' => 'Pembelian Seragam', 'harga_total' => 7500000],
            ],
            'penjualan' => [
                ['id' => 1, 'tanggal' => '2023-10-25', 'pelanggan' => 'Siti Aminah', 'keterangan' => 'Pembayaran Buku Paket', 'harga_total' => 250000],
                ['id' => 2, 'tanggal' => '2023-10-26', 'pelanggan' => 'Budi Santoso', 'keterangan' => 'Pembayaran Seragam', 'harga_total' => 300000],
            ],
            'akun' => [
                ['id' => 101, 'nama' => 'Kas'],
                ['id' => 102, 'nama' => 'Persediaan'],
                ['id' => 103, 'nama' => 'Piutang Usaha'],
                ['id' => 201, 'nama' => 'Hutang Usaha'],
                ['id' => 301, 'nama' => 'Modal'],
                ['id' => 401, 'nama' => 'Pendapatan Penjualan'],
                ['id' => 501, 'nama' => 'Beban Operasional'],
            ],
            'jurnal_manual' => [
                ['tanggal' => '2023-10-27', 'keterangan' => 'Bayar listrik', 'debit_akun' => 'Beban Operasional', 'kredit_akun' => 'Kas', 'nominal' => 250000],
            ],
            'neraca' => [
                'aset_lancar' => [
                    ['akun' => 'Kas', 'saldo' => 15000000],
                    ['akun' => 'Piutang Usaha', 'saldo' => 2000000],
                    ['akun' => 'Persediaan', 'saldo' => 10000000],
                ],
                'liabilitas' => [
                    ['akun' => 'Hutang Usaha', 'saldo' => 7000000],
                ],
                'ekuitas' => [
                    ['akun' => 'Modal', 'saldo' => 15000000],
                ]
            ],
            'hutang' => [
                ['id' => 1, 'tanggal' => '2023-09-15', 'supplier' => 'PT. Sumber Makmur', 'keterangan' => 'Pembelian buku', 'jumlah' => 'Rp 2.500.000'],
                ['id' => 2, 'tanggal' => '2023-09-20', 'supplier' => 'CV. Media Sekolah', 'keterangan' => 'Pembelian seragam', 'jumlah' => 'Rp 4.000.000'],
            ],
            'piutang' => [
                ['id' => 1, 'tanggal' => '2023-10-01', 'pelanggan' => 'Budi Santoso', 'keterangan' => 'Tagihan seragam', 'jumlah' => 'Rp 300.000'],
                ['id' => 2, 'tanggal' => '2023-10-05', 'pelanggan' => 'Siti Aminah', 'keterangan' => 'Tagihan buku', 'jumlah' => 'Rp 250.000'],
            ],
        ];
    }
    
    // Method untuk menghasilkan entri jurnal dari data dummy
    private function generateJurnalEntries()
    {
        $data = $this->allDummyData;
        $jurnalEntries = [];
        
        // Jurnal dari Penjualan (Kas/Piutang pada Pendapatan)
        foreach ($data['penjualan'] as $penjualan) {
            $jurnalEntries[] = [
                'tanggal' => $penjualan['tanggal'],
                'keterangan' => 'Penjualan ke ' . $penjualan['pelanggan'],
                'debit' => 'Rp ' . number_format($penjualan['harga_total'], 0, ',', '.'),
                'kredit' => 'Rp 0',
            ];
            $jurnalEntries[] = [
                'tanggal' => $penjualan['tanggal'],
                'keterangan' => 'Pendapatan Penjualan',
                'debit' => 'Rp 0',
                'kredit' => 'Rp ' . number_format($penjualan['harga_total'], 0, ',', '.'),
            ];
        }

        // Jurnal dari Pembelian (Persediaan pada Kas/Hutang)
        foreach ($data['pembelian'] as $pembelian) {
            $jurnalEntries[] = [
                'tanggal' => $pembelian['tanggal'],
                'keterangan' => 'Pembelian dari ' . $pembelian['supplier'],
                'debit' => 'Rp ' . number_format($pembelian['harga_total'], 0, ',', '.'),
                'kredit' => 'Rp 0',
            ];
            $jurnalEntries[] = [
                'tanggal' => $pembelian['tanggal'],
                'keterangan' => 'Kas/Hutang',
                'debit' => 'Rp 0',
                'kredit' => 'Rp ' . number_format($pembelian['harga_total'], 0, ',', '.'),
            ];
        }

        // Tambahkan Jurnal Manual
        foreach ($data['jurnal_manual'] as $jurnal) {
            $jurnalEntries[] = [
                'tanggal' => $jurnal['tanggal'],
                'keterangan' => $jurnal['keterangan'],
                'debit' => 'Rp ' . number_format($jurnal['nominal'], 0, ',', '.'),
                'kredit' => 'Rp 0',
            ];
            $jurnalEntries[] = [
                'tanggal' => $jurnal['tanggal'],
                'keterangan' => $jurnal['keterangan'],
                'debit' => 'Rp 0',
                'kredit' => 'Rp ' . number_format($jurnal['nominal'], 0, ',', '.'),
            ];
        }

        // Urutkan entri berdasarkan tanggal (opsional)
        usort($jurnalEntries, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        return $jurnalEntries;
    }
    
    // Semua metode lain sekarang menggunakan $this->allDummyData
    public function dashboard()
    {
        return view('dashboard');
    }

    public function index()
    {
        return view('produk'); // daftar produk
    }

    public function create()
    {
        return view('tambahproduk'); // form tambah
    }

    public function store(Request $request)
    {
        return redirect()->route('produk.index')->with('success','Produk ditambahkan');
    }

    public function edit(Request $request)
{
    $id = $request->query('id'); // ambil ?id=...
    return view('editproduk', compact('id'));
}


    public function update(Request $request, $id)
    {
        return redirect()->route('produk.index')->with('success','Produk diperbarui');
    }

    public function createProduk()
    {
        return view('tambahproduk');
    }
     public function storeProduk(Request $request)
    {
        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function supplier()
{
    return view('supplier'); // file: resources/views/supplier.blade.php
}

public function editSupplier()
{
    return view('editsupplier'); // file: resources/views/editsupplier.blade.php
}

public function updateSupplier(Request $request)
{
    // proses update data supplier

    return redirect()->route('supplier.editsupplier')
                     ->with('success', 'Supplier berhasil diupdate');
}

    // Halaman daftar pelanggan
    public function pelanggan()
    {
        return view('pelanggan');
    }

    public function tambahpelanggan()
    {
        return view('tambahpelanggan');
    }

    // Proses simpan pelanggan baru (POST)
    public function storePelanggan(Request $request)
    {
        // Contoh validasi
        // $validated = $request->validate([
        //     'nama' => 'required',
        //     'email' => 'required|email',
        // ]);

        // Simpan ke database
        // Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')
                         ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // Form edit pelanggan
    public function editpelanggan(Request $request)
{
    $id = $request->id; // ambil dari query string
    return view('editpelanggan', compact('id'));
}

    // Proses update pelanggan (POST)
    public function updatePelanggan(Request $request, $id)
    {
        // $validated = $request->validate([...]);
        // $pelanggan = Pelanggan::findOrFail($id);
        // $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
                         ->with('success', 'Pelanggan berhasil diperbarui!');
    }


    public function pembelian()
    {
        $pembelian = collect($this->allDummyData['pembelian'])->map(function ($item) {
            $item['harga_total'] = 'Rp ' . number_format($item['harga_total'], 0, ',', '.');
            return $item;
        });

        return view('pembelian', [
            'pembelian' => $pembelian,
            'supplier' => $this->allDummyData['supplier'],
            'produk' => $this->allDummyData['produk'],
        ]);
    }

    public function storePembelian(Request $request)
    {
        return redirect('/pembelian')->with('success', 'Pembelian berhasil ditambahkan!');
    }

    public function penjualan()
{
    $penjualan = collect($this->allDummyData['penjualan'])->map(function ($item) {
        $item['harga_total'] = 'Rp ' . number_format($item['harga_total'], 0, ',', '.');
        return $item;
    });

    return view('penjualan', [
        'penjualan' => $penjualan,
        'pelanggan' => $this->allDummyData['pelanggan'],
        'produk'    => $this->allDummyData['produk'],
    ]);
}

public function storePenjualan(Request $request)
{
    // simpan data baru
    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan!');
}

public function editPenjualan(Request $request)
{
    $id = $request->query('id');   // ambil ?id=1

    $penjualan = collect($this->allDummyData['penjualan'])->firstWhere('id', $id);

    if (!$penjualan) {
        abort(404, 'Data penjualan tidak ditemukan.');
    }

    return view('editpenjualan', compact('penjualan'));
}


public function updatePenjualan(Request $request, $id)
{
    // proses update data
    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diupdate!');
}


    public function jurnal()
    {
        $jurnal = $this->generateJurnalEntries();
        $akun = $this->allDummyData['akun'];
        return view('jurnal', [
            'jurnal' => $jurnal,
            'akun' => $akun,
        ]);
    }

    public function storeJurnalManual(Request $request)
    {
        return redirect('/jurnal')->with('success', 'Jurnal berhasil ditambahkan secara manual!');
    }

     public function laporan()
    {
        return view('laporan', [
            'title'  => 'Laporan',     // beri title default
            'report' => null           // tidak menampilkan report spesifik
        ]);
    }

    // Halaman /laporan/neraca
    public function laporanNeraca()
    {
        // Ambil data neraca dari dummy data, fallback array kosong
        $neracaData = $this->allDummyData['neraca'] ?? [];

        return view('neraca', [
            'title'  => 'Laporan Neraca',
            'report' => 'neraca',
            'neraca' => $neracaData,
        ]);
    }

    // Halaman /laporan/laba-rugi
    public function laporanLabaRugi()
    {
        $totalPendapatan = collect($this->allDummyData['penjualan'])->sum('harga_total');
        $totalBeban = collect($this->allDummyData['jurnal_manual'])
                        ->where('debit_akun', 'Beban Operasional')
                        ->sum('nominal');
        $labaBersih = $totalPendapatan - $totalBeban;

        $labaRugi = [
            'pendapatan'  => $totalPendapatan,
            'beban'       => $totalBeban,
            'laba_bersih' => $labaBersih
        ];

        return view('laba-rugi', [
            'title'      => 'Laporan Laba Rugi',
            'report'     => 'laba-rugi',
            'laba_rugi'  => $labaRugi,
        ]);
    }
    
    // Metode untuk COA yang sudah diperbaiki sebelumnya
    public function coa()
    {
        return view('coa', ['coa' => $this->coaData, 'title' => 'Daftar Akun']);
    }

    public function tambahCoa()
    {
        return view('tambahcoa', ['title' => 'Tambah Akun Baru']);
    }

    public function simpanCoa(Request $request)
    {
        $validated = $request->validate([
            'kode_akun' => 'required|numeric',
            'nama_akun' => 'required|string|max:255',
            'kategori' => 'required|string|in:Aset,Liabilitas,Ekuitas,Pendapatan,Beban',
        ]);

        $newId = $this->coaData->max('id') + 1;
        $this->coaData->push((object)[
            'id' => $newId,
            'kode' => $validated['kode_akun'],
            'nama' => $validated['nama_akun'],
            'kategori' => $validated['kategori'],
        ]);
        
        return redirect('/coa')->with('success', 'Akun baru berhasil ditambahkan!');
    }
}