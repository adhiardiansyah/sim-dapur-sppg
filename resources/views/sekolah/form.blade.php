@extends('layouts.app')
@section('title', $sekolah->exists ? 'Edit Sekolah' : 'Tambah Sekolah')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ $sekolah->exists ? route('sekolah.update', $sekolah) : route('sekolah.store') }}">
                @csrf
                @if ($sekolah->exists) @method('PUT') @endif
                <div class="mb-3">
                    <label class="form-label">Nama Sekolah / Lokasi</label>
                    <input name="nama" value="{{ old('nama', $sekolah->nama) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-control" required>{{ old('alamat', $sekolah->alamat) }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kontak</label>
                        <input name="kontak" value="{{ old('kontak', $sekolah->kontak) }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Koordinat (opsional)</label>
                        <input name="koordinat" value="{{ old('koordinat', $sekolah->koordinat) }}" class="form-control" placeholder="-10.17, 123.60">
                    </div>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="aktif" value="1" id="aktif" {{ old('aktif', $sekolah->aktif ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="aktif">Aktif</label>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('sekolah.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
