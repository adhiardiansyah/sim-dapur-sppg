@extends('layouts.app')
@section('title', 'Supplier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Data pemasok bahan baku</h6>
        <a href="{{ route('supplier.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Supplier</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Nama</th><th>Kontak</th><th>Alamat</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($supplier as $s)
                        <tr>
                            <td class="fw-semibold">{{ $s->nama }}</td>
                            <td>{{ $s->kontak ?: '-' }}</td>
                            <td>{{ $s->alamat ?: '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('supplier.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('supplier.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus supplier ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada supplier</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
