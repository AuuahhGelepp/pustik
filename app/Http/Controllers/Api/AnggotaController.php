<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::with('divisi')->get();
        return response()->json([
            'status' => 'success',
            'data' => $anggota
        ]);
    }

    public function show($id)
    {
        $anggota = Anggota::with('divisi')->find($id);
        
        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $anggota
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $path = $foto->store('anggota-foto', 'public');
            $data['foto'] = $path;
        }

        $anggota = Anggota::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Anggota berhasil ditambahkan',
            'data' => $anggota
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::find($id);
        
        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            
            $foto = $request->file('foto');
            $path = $foto->store('anggota-foto', 'public');
            $data['foto'] = $path;
        }

        $anggota->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Anggota berhasil diperbarui',
            'data' => $anggota
        ]);
    }

    public function destroy($id)
    {
        $anggota = Anggota::find($id);
        
        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan'
            ], 404);
        }

        if ($anggota->foto) {
            Storage::disk('public')->delete($anggota->foto);
        }

        $anggota->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Anggota berhasil dihapus'
        ]);
    }
} 