@extends('layouts.app')
@section('title', 'Stok Masuk')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Riwayat penerimaan bahan baku dari supplier (stok bertambah otomatis)</h6>
        <a href="{{ route('stok-masuk.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Catat Penerimaan</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Tanggal</th><th>Bahan</th><th>Supplier</th><th>Jumlah</th><th>Harga Satuan</th><th>Dicatat Oleh</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($stokMasuk as $s)
                        <tr>
                            <td>{{ $s->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="fw-semibold">{{ $s->bahan->nama }}</td>
                            <td>{{ $s->supplier?->nama ?? '-' }}</td>
                            <td>+{{ number_format($s->jumlah, 3) }} {{ $s->bahan->satuan }}</td>
                            <td>{{ $s->harga_satuan ? 'Rp' . number_format($s->harga_satuan, 0, ',', '.') : '-' }}</td>
                            <td>{{ $s->pencatat?->name ?? '-' }}</td>
                            <td class="text-end">
                                <form action="{{ route('stok-masuk.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus catatan ini? Stok akan dikembalikan.')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada penerimaan bahan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $stokMasuk->links() }}</div>
    </div>
@endsection
