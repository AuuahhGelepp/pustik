<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisiController extends Controller
{
    public function index()
    {
        $divisi = Divisi::withCount('anggota')->get();
        return response()->json([
            'status' => 'success',
            'data' => $divisi
        ]);
    }

    public function show($id)
    {
        $divisi = Divisi::withCount('anggota')->find($id);
        
        if (!$divisi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $divisi
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:divisi,nama'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $divisi = Divisi::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil ditambahkan',
            'data' => $divisi
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $divisi = Divisi::find($id);
        
        if (!$divisi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:divisi,nama,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $divisi->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil diperbarui',
            'data' => $divisi
        ]);
    }

    public function destroy($id)
    {
        $divisi = Divisi::find($id);
        
        if (!$divisi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak ditemukan'
            ], 404);
        }

        // Check if division has members
        if ($divisi->anggota()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak dapat dihapus karena masih memiliki anggota'
            ], 422);
        }

        $divisi->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil dihapus'
        ]);
    }

    public function members($id)
    {
        $divisi = Divisi::with('anggota')->find($id);
        
        if (!$divisi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'divisi' => $divisi->nama,
                'anggota' => $divisi->anggota
            ]
        ]);
    }
} 