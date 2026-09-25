@extends('layouts.app')
@section('title', $supplier->exists ? 'Edit Supplier' : 'Tambah Supplier')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ $supplier->exists ? route('supplier.update', $supplier) : route('supplier.store') }}">
                @csrf
                @if ($supplier->exists) @method('PUT') @endif
                <div class="mb-3">
                    <label class="form-label">Nama Supplier</label>
                    <input name="nama" value="{{ old('nama', $supplier->nama) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kontak</label>
                    <input name="kontak" value="{{ old('kontak', $supplier->kontak) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-control">{{ old('alamat', $supplier->alamat) }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
