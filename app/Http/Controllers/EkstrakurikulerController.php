<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        // Ambil data dari session, kalau kosong isi default
        $ekskul = session()->get('ekskul', [
            [
                'id' => 1,
                'nama' => 'Futsal',
                'pembina' => 'Bapak Budi',
                'jadwal' => 'Selasa, 15:00 - 17:00',
                'kategori' => 'Olahraga',
                'deskripsi' => 'Latihan futsal rutin untuk siswa.',
                'siswa' => []
            ],
            [
                'id' => 2,
                'nama' => 'Pramuka',
                'pembina' => 'Ibu Siti',
                'jadwal' => 'Jumat, 14:00 - 16:00',
                'kategori' => 'Sains',
                'deskripsi' => 'Kegiatan pramuka mingguan.',
                'siswa' => []
            ],
        ]);

        return view('ekskul.index', compact('ekskul'));
    }

    public function create()
    {
        return view('ekskul.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'pembina' => 'required|string|max:100',
            'jadwal' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $ekskul = session()->get('ekskul', []);

        $new = [
            'id' => count($ekskul) + 1,
            'nama' => $request->nama,
            'pembina' => $request->pembina,
            'jadwal' => $request->jadwal,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'siswa' => []
        ];

        $ekskul[] = $new;
        session()->put('ekskul', $ekskul);

        return redirect()->route('ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ekskul = session()->get('ekskul', []);
        $ekskul = collect($ekskul)->firstWhere('id', $id);

        if (!$ekskul) {
            abort(404, 'Ekstrakurikuler tidak ditemukan');
        }

        return view('ekskul.edit', compact('ekskul'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'pembina' => 'required|string|max:100',
            'jadwal' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $ekskul = session()->get('ekskul', []);

        foreach ($ekskul as &$item) {
            if ($item['id'] == $id) {
                $item['nama'] = $request->nama;
                $item['pembina'] = $request->pembina;
                $item['jadwal'] = $request->jadwal;
                $item['kategori'] = $request->kategori;
                $item['deskripsi'] = $request->deskripsi;
            }
        }

        session()->put('ekskul', $ekskul);

        return redirect()->route('ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ekskul = session()->get('ekskul', []);
        $ekskul = array_filter($ekskul, fn($item) => $item['id'] != $id);

        session()->put('ekskul', $ekskul);

        return redirect()->route('ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil dihapus!');
    }

    public function show($id)
    {
        $allEkskul = session()->get('ekskul', []);
        $ekskul = collect($allEkskul)->firstWhere('id', $id);

        if (!$ekskul) {
            abort(404, 'Ekstrakurikuler tidak ditemukan');
        }

        if (!isset($ekskul['siswa'])) {
            $ekskul['siswa'] = [];
        }

        return view('ekskul.show', compact('ekskul'));
    }

    public function addSiswa(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
        ]);

        $ekskul = session()->get('ekskul', []);

        foreach ($ekskul as $key => $item) {
            if ($item['id'] == $id) {
                if (!isset($ekskul[$key]['siswa'])) {
                    $ekskul[$key]['siswa'] = [];
                }
                $ekskul[$key]['siswa'][] = [
                    'nama' => $request->nama,
                    'kelas' => $request->kelas,
                ];
                break;
            }
        }

        session()->put('ekskul', $ekskul);

        return redirect()->route('ekskul.show', $id)
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function removeSiswa($id, $siswaId)
    {
        $ekskul = session()->get('ekskul', []);

        foreach ($ekskul as $key => $item) {
            if ($item['id'] == $id && isset($ekskul[$key]['siswa'][$siswaId])) {
                unset($ekskul[$key]['siswa'][$siswaId]);
                $ekskul[$key]['siswa'] = array_values($ekskul[$key]['siswa']);
                break;
            }
        }

        session()->put('ekskul', $ekskul);

        return redirect()->route('ekskul.show', $id)
            ->with('success', 'Siswa berhasil dihapus!');
    }
    public function siswa($id)
{
    $allEkskul = session()->get('ekskul', []);
    $ekskul = collect($allEkskul)->firstWhere('id', $id);

    if (!$ekskul) {
        abort(404, 'Ekstrakurikuler tidak ditemukan');
    }

    return view('ekskul.siswa', compact('ekskul'));
}
}
