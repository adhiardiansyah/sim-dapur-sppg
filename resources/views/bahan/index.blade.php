@extends('layouts.app')
@section('title', 'Bahan Baku')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Data bahan baku beserta kandungan gizi (per 100 g/ml)</h6>
        <a href="{{ route('bahan.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Bahan</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Nama</th><th>Stok</th><th>Minimum</th><th>Kalori</th><th>Protein</th><th>Karbo</th><th>Lemak</th><th>Harga Acuan</th><th class="text-end">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($bahan as $b)
                        <tr class="{{ $b->stok_rendah ? 'table-warning' : '' }}">
                            <td class="fw-semibold">{{ $b->nama }} @if($b->stok_rendah)<span class="badge bg-danger">rendah</span>@endif</td>
                            <td>{{ number_format($b->stok, 2) }} {{ $b->satuan }}</td>
                            <td>{{ number_format($b->stok_minimum, 2) }} {{ $b->satuan }}</td>
                            <td>{{ $b->kalori }}</td>
                            <td>{{ $b->protein }}</td>
                            <td>{{ $b->karbohidrat }}</td>
                            <td>{{ $b->lemak }}</td>
                            <td>{{ $b->harga_referensi ? 'Rp' . number_format($b->harga_referensi, 0, ',', '.') : '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('bahan.edit', $b) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('bahan.destroy', $b) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus bahan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">Belum ada bahan baku</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
