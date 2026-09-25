@extends('layouts.app')
@section('title', $jadwal->exists ? 'Edit Rencana Menu' : 'Tambah Rencana Menu')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ $jadwal->exists ? route('jadwal.update', $jadwal) : route('jadwal.store') }}">
                @csrf
                @if ($jadwal->exists) @method('PUT') @endif
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal?->toDateString()) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Menu</label>
                    <select name="menu_id" class="form-select" required>
                        @foreach ($menu as $m)
                            <option value="{{ $m->id }}" {{ old('menu_id', $jadwal->menu_id) == $m->id ? 'selected' : '' }}>{{ $m->nama_menu }} ({{ str_replace('_', ' ', $m->kategori_waktu) }})</option>
                        @endforeach
                    </select>
                    <div class="form-text">Pastikan menu telah memiliki komposisi bahan agar kebutuhan dapat dihitung.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Porsi</label>
                    <input type="number" min="1" name="jumlah_porsi" value="{{ old('jumlah_porsi', $jadwal->jumlah_porsi) }}" class="form-control" required>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
