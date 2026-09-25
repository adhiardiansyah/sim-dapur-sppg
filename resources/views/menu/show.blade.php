@extends('layouts.app')
@section('title', 'Komposisi: ' . $menu->nama_menu)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="mb-0 fw-semibold">{{ $menu->nama_menu }}</h6>
            <span class="text-muted small">{{ str_replace('_', ' ', $menu->kategori_waktu) }} · status {{ $menu->status }}</span>
        </div>
        <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">Komposisi Bahan per Porsi</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light"><tr><th>Bahan</th><th>Jumlah / Porsi</th><th>Satuan</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($menu->menuBahan as $k)
                                <tr>
                                    <td class="fw-semibold">{{ $k->bahan->nama }}</td>
                                    <td>{{ number_format($k->jumlah_per_porsi, 3) }}</td>
                                    <td>{{ $k->satuan }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('menu.komposisi.destroy', [$menu, $k]) }}" method="POST" onsubmit="return confirm('Hapus bahan dari komposisi?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada bahan. Tambahkan dari formulir di samping.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold">Tambah / Perbarui Bahan</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('menu.komposisi.store', $menu) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Bahan Baku</label>
                            <select name="bahan_id" class="form-select" required>
                                @foreach ($bahan as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama }} ({{ $b->satuan }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah per Porsi</label>
                            <input type="number" step="0.001" min="0.001" name="jumlah_per_porsi" class="form-control" required>
                            <div class="form-text">Bahan yang sudah ada akan diperbarui jumlahnya.</div>
                        </div>
                        <button class="btn btn-primary w-100">Simpan Komposisi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
