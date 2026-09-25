@extends('layouts.app')
@section('title', 'Catat Penerimaan Bahan')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ route('stok-masuk.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Bahan Baku</label>
                    <select name="bahan_id" class="form-select" required>
                        @foreach ($bahan as $b)
                            <option value="{{ $b->id }}">{{ $b->nama }} — stok saat ini {{ number_format($b->stok, 3) }} {{ $b->satuan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select">
                        <option value="">— tanpa supplier —</option>
                        @foreach ($supplier as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" step="0.001" min="0.001" name="jumlah" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Harga Satuan (Rp)</label>
                        <input type="number" step="0.01" min="0" name="harga_satuan" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', today()->toDateString()) }}" class="form-control" required>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('stok-masuk.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
