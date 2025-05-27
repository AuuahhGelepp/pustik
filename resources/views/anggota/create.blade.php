@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Tambah Anggota</h3>
                        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="divisi_id">Divisi</label>
                            <select class="form-control @error('divisi_id') is-invalid @enderror" 
                                id="divisi_id" name="divisi_id" required>
                                <option value="">Pilih Divisi</option>
                                @foreach($divisi as $div)
                                    <option value="{{ $div->id }}" {{ old('divisi_id') == $div->id ? 'selected' : '' }}>
                                        {{ $div->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('divisi_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_telp">Nomor Telepon</label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                                id="no_telp" name="no_telp" value="{{ old('no_telp') }}">
                            @error('no_telp')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                id="foto" name="foto" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG (Max. 2MB)</small>
                            @error('foto')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection