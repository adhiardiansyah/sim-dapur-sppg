@extends('layouts.app')
@section('title', 'Produksi')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Realisasi produksi — stok bahan dipotong otomatis sesuai komposisi menu</h6>
        <a href="{{ route('produksi.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Catat Produksi</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Tanggal</th><th>Menu</th><th>Porsi Realisasi</th><th>Status</th><th>Catatan</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($produksi as $p)
                        <tr>
                            <td>{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="fw-semibold">{{ $p->jadwal->menu->nama_menu }}</td>
                            <td>{{ number_format($p->porsi_realisasi, 0, ',', '.') }} porsi</td>
                            <td>
                                @if ($p->status === 'berjalan')
                                    <span class="badge bg-primary">berjalan</span>
                                @else
                                    <span class="badge bg-success">selesai</span>
                                @endif
                            </td>
                            <td>{{ $p->catatan ?: '-' }}</td>
                            <td class="text-end">
                                @if ($p->status === 'berjalan')
                                    <form action="{{ route('produksi.selesai', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai produksi ini selesai?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success"><i class="bi bi-check2-circle me-1"></i>Selesai</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada produksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $produksi->links() }}</div>
    </div>
@endsection
