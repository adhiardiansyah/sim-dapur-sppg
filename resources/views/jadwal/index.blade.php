@extends('layouts.app')
@section('title', 'Perencanaan Menu')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Rencana menu harian beserta jumlah porsi produksi</h6>
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Rencana</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Tanggal</th><th>Menu</th><th>Porsi</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($jadwal as $j)
                        <tr>
                            <td>{{ $j->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="fw-semibold">{{ $j->menu->nama_menu }}</td>
                            <td>{{ number_format($j->jumlah_porsi, 0, ',', '.') }}</td>
                            <td>
                                @if ($j->status === 'direncanakan')
                                    <span class="badge bg-warning text-dark">direncanakan</span>
                                @elseif ($j->status === 'diproduksi')
                                    <span class="badge bg-primary">diproduksi</span>
                                @else
                                    <span class="badge bg-success">selesai</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('jadwal.kebutuhan', $j) }}" class="btn btn-sm btn-outline-info" title="Kebutuhan bahan"><i class="bi bi-calculator"></i></a>
                                @if ($j->status === 'direncanakan')
                                    <a href="{{ route('jadwal.edit', $j) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('jadwal.destroy', $j) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rencana ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada perencanaan menu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $jadwal->links() }}</div>
    </div>
@endsection
