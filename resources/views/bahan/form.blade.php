@extends('layouts.app')
@section('title', $bahan->exists ? 'Edit Bahan Baku' : 'Tambah Bahan Baku')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 760px;">
        <div class="card-body">
            <form method="POST" action="{{ $bahan->exists ? route('bahan.update', $bahan) : route('bahan.store') }}">
                @csrf
                @if ($bahan->exists) @method('PUT') @endif
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Bahan</label>
                        <input name="nama" value="{{ old('nama', $bahan->nama) }}" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Satuan</label>
                        <input name="satuan" value="{{ old('satuan', $bahan->satuan) }}" class="form-control" placeholder="kg / liter" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stok Minimum</label>
                        <input type="number" step="0.001" name="stok_minimum" value="{{ old('stok_minimum', $bahan->stok_minimum ?? 0) }}" class="form-control" required>
                    </div>
                </div>
                @unless ($bahan->exists)
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stok Awal</label>
                            <input type="number" step="0.001" name="stok" value="{{ old('stok', 0) }}" class="form-control">
                            <div class="form-text">Perubahan stok berikutnya melalui menu Stok Masuk & Produksi.</div>
                        </div>
                    </div>
                @endunless
                <label class="form-label fw-semibold">Kandungan Gizi (per 100 g/ml)</label>
                <div class="row">
                    <div class="col-md-3 mb-3"><label class="form-label small">Kalori</label><input type="number" step="0.01" name="kalori" value="{{ old('kalori', $bahan->kalori) }}" class="form-control"></div>
                    <div class="col-md-3 mb-3"><label class="form-label small">Protein (g)</label><input type="number" step="0.01" name="protein" value="{{ old('protein', $bahan->protein) }}" class="form-control"></div>
                    <div class="col-md-3 mb-3"><label class="form-label small">Karbohidrat (g)</label><input type="number" step="0.01" name="karbohidrat" value="{{ old('karbohidrat', $bahan->karbohidrat) }}" class="form-control"></div>
                    <div class="col-md-3 mb-3"><label class="form-label small">Lemak (g)</label><input type="number" step="0.01" name="lemak" value="{{ old('lemak', $bahan->lemak) }}" class="form-control"></div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Harga Acuan (Rp)</label>
                        <input type="number" step="0.01" name="harga_referensi" value="{{ old('harga_referensi', $bahan->harga_referensi) }}" class="form-control">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('bahan.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
