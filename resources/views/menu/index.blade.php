@extends('layouts.app')
@section('title', 'Menu')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Daftar menu makanan beserta kategori waktu penyajian</h6>
        <a href="{{ route('menu.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Menu</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Nama Menu</th><th>Kategori</th><th>Jumlah Bahan</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($menu as $m)
                        <tr>
                            <td class="fw-semibold">{{ $m->nama_menu }}</td>
                            <td>{{ str_replace('_', ' ', $m->kategori_waktu) }}</td>
                            <td>{{ $m->menu_bahan_count }} bahan</td>
                            <td><span class="badge {{ $m->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $m->status }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('menu.show', $m) }}" class="btn btn-sm btn-outline-secondary" title="Komposisi bahan"><i class="bi bi-list-check"></i></a>
                                <a href="{{ route('menu.edit', $m) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('menu.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada menu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
