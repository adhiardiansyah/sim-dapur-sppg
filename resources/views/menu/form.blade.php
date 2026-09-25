@extends('layouts.app')
@section('title', $menu->exists ? 'Edit Menu' : 'Tambah Menu')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ $menu->exists ? route('menu.update', $menu) : route('menu.store') }}">
                @csrf
                @if ($menu->exists) @method('PUT') @endif
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori Waktu</label>
                        <select name="kategori_waktu" class="form-select" required>
                            @foreach (\App\Http\Controllers\MenuController::KATEGORI as $k)
                                <option value="{{ $k }}" {{ old('kategori_waktu', $menu->kategori_waktu ?? 'makan_siang') === $k ? 'selected' : '' }}>{{ str_replace('_', ' ', $k) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif" {{ old('status', $menu->status ?? 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $menu->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
