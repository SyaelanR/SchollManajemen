<?php

namespace App\Http\Controllers\ekskul\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ekskul1\guru\Ekskul;

class EkskulController extends Controller
{
    public function index()
    {
        $ekskuls = Ekskul::all();
        return view('ekskul.guru.index', compact('ekskuls'));
    }

    public function create()
    {
        return view('ekskul.guru.create');
    }

    public function store(Request $request)
    {
        Ekskul::create($request->only(['nama','kategori','deskripsi','pembimbing','jadwal','pembina_id']));
        return redirect()->route('guru.ekskul.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ekskul = Ekskul::findOrFail($id);
        return view('ekskul.guru.edit', compact('ekskul'));
    }

    public function update(Request $request, $id)
    {
        $ekskul = Ekskul::findOrFail($id);
        $ekskul->update($request->only(['nama','kategori','deskripsi','pembimbing','jadwal','pembina_id']));
        return redirect()->route('guru.ekskul.index')->with('success', 'Ekstrakurikuler berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ekskul = Ekskul::findOrFail($id);
        $ekskul->delete();
        return redirect()->route('guru.ekskul.index')->with('success', 'Ekstrakurikuler berhasil dihapus!');
    }

    public function show($id)
    {
        $ekskul = Ekskul::findOrFail($id);
        return view('ekskul.guru.show', compact('ekskul'));
    }
}
