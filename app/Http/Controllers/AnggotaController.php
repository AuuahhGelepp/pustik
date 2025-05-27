<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Divisi;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::with('divisi')->get();
        return view('anggota.index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisi = Divisi::all();
        return view('anggota.create', compact('divisi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $path = $foto->store('anggota-foto', 'public');
            $data['foto'] = $path;
        }

        Anggota::create($data);
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {
        $divisi = Divisi::all();
        return view('anggota.edit', compact('anggota', 'divisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            
            $foto = $request->file('foto');
            $path = $foto->store('anggota-foto', 'public');
            $data['foto'] = $path;
        }

        $anggota->update($data);
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        if ($anggota->foto) {
            Storage::disk('public')->delete($anggota->foto);
        }
        
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus');
    }
}
