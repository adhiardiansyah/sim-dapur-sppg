@extends('layouts.app')
@section('title', 'Kebutuhan Bahan — ' . $jadwal->menu->nama_menu)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="mb-0 fw-semibold">Kalkulasi Kebutuhan Bahan (F-09)</h6>
            <span class="text-muted small">
                {{ $jadwal->tanggal->translatedFormat('d F Y') }} · {{ $jadwal->menu->nama_menu }} ·
                <strong>{{ number_format($jadwal->jumlah_porsi, 0, ',', '.') }} porsi</strong>
            </span>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer me-1"></i>Cetak</button>
            <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>

    <div class="alert {{ $semuaCukup ? 'alert-success' : 'alert-warning' }} d-flex align-items-center">
        <i class="bi {{ $semuaCukup ? 'bi-check-circle' : 'bi-exclamation-triangle' }} me-2 fs-5"></i>
        @if ($semuaCukup)
            Seluruh stok bahan <strong>&nbsp;cukup&nbsp;</strong> untuk memproduksi {{ number_format($jadwal->jumlah_porsi, 0, ',', '.') }} porsi.
        @else
            Terdapat bahan yang <strong>&nbsp;stoknya kurang&nbsp;</strong> — perlu pengadaan sebelum produksi (lihat baris merah).
        @endif
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Bahan</th><th>Per Porsi</th><th>Kebutuhan Total</th><th>Stok Tersedia</th><th>Sisa Setelah Produksi</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach ($butuh as $b)
                        <tr class="{{ $b->cukup ? '' : 'table-danger' }}">
                            <td class="fw-semibold">{{ $b->bahan->nama }}</td>
                            <td>{{ number_format($b->per_porsi, 3) }} {{ $b->bahan->satuan }}</td>
                            <td class="fw-bold">{{ number_format($b->total, 3) }} {{ $b->bahan->satuan }}</td>
                            <td>{{ number_format($b->stok, 3) }} {{ $b->bahan->satuan }}</td>
                            <td>{{ number_format($b->sisa_setelah_produksi, 3) }} {{ $b->bahan->satuan }}</td>
                            <td>
                                @if ($b->cukup)
                                    <span class="badge bg-success">Cukup</span>
                                @else
                                    <span class="badge bg-danger">Kurang {{ number_format(abs($b->sisa_setelah_produksi), 3) }} {{ $b->bahan->satuan }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white text-muted small">
            Rumus: kebutuhan total = jumlah per porsi × {{ number_format($jadwal->jumlah_porsi, 0, ',', '.') }} porsi.
        </div>
    </div>
@endsection
