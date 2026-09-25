@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Jenis Laporan</label>
                    <select name="jenis" class="form-select">
                        @foreach (\App\Http\Controllers\LaporanController::JENIS as $nilai => $label)
                            <option value="{{ $nilai }}" {{ $jenis === $nilai ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Dari Tanggal</label>
                    <input type="date" name="dari" value="{{ $dari->toDateString() }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Sampai Tanggal</label>
                    <input type="date" name="sampai" value="{{ $sampai->toDateString() }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100"><i class="bi bi-funnel me-1"></i>Tampilkan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Laporan {{ $jenisLabel }} ({{ $dari->translatedFormat('d M Y') }} — {{ $sampai->translatedFormat('d M Y') }})</span>
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer me-1"></i>Cetak</button>
        </div>
        <div class="card-body p-0">
            @if ($jenis === 'produksi')
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Tanggal</th><th>Menu</th><th>Porsi Rencana</th><th>Porsi Realisasi</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($produksi as $p)
                            <tr>
                                <td>{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                                <td class="fw-semibold">{{ $p->jadwal->menu->nama_menu }}</td>
                                <td>{{ number_format($p->jadwal->jumlah_porsi, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->porsi_realisasi, 0, ',', '.') }}</td>
                                <td><span class="badge {{ $p->status === 'selesai' ? 'bg-success' : 'bg-primary' }}">{{ $p->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data pada periode ini</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif ($jenis === 'distribusi')
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Tanggal</th><th>Menu</th><th>Sekolah</th><th>Porsi</th><th>Status</th><th>Petugas</th></tr></thead>
                    <tbody>
                        @forelse ($distribusi as $d)
                            <tr>
                                <td>{{ $d->produksi->tanggal->translatedFormat('d M Y') }}</td>
                                <td class="fw-semibold">{{ $d->produksi->jadwal->menu->nama_menu }}</td>
                                <td>{{ $d->sekolah->nama }}</td>
                                <td>{{ number_format($d->jumlah_porsi, 0, ',', '.') }}</td>
                                <td><span class="badge {{ $d->status === 'diterima' ? 'bg-success' : ($d->status === 'dikirim' ? 'bg-primary' : 'bg-secondary') }}">{{ $d->status }}</span></td>
                                <td>{{ $d->petugas?->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data pada periode ini</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif ($jenis === 'stok')
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Bahan</th><th>Satuan</th><th>Stok Saat Ini</th><th>Stok Minimum</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($bahan as $b)
                            <tr class="{{ $b->stok_rendah ? 'table-warning' : '' }}">
                                <td class="fw-semibold">{{ $b->nama }}</td>
                                <td>{{ $b->satuan }}</td>
                                <td>{{ number_format($b->stok, 3) }}</td>
                                <td>{{ number_format($b->stok_minimum, 3) }}</td>
                                <td>
                                    @if ($b->stok_rendah)
                                        <span class="badge bg-danger">Di bawah minimum</span>
                                    @else
                                        <span class="badge bg-success">Aman</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada bahan baku</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Tanggal</th><th>Bahan</th><th>Jumlah</th><th>Harga Satuan</th><th>Total</th></tr></thead>
                    <tbody>
                        @forelse ($pengadaan as $s)
                            <tr>
                                <td>{{ $s->tanggal->translatedFormat('d M Y') }}</td>
                                <td class="fw-semibold">{{ $s->bahan->nama }}</td>
                                <td>{{ number_format($s->jumlah, 3) }} {{ $s->bahan->satuan }}</td>
                                <td>{{ $s->harga_satuan ? 'Rp' . number_format($s->harga_satuan, 0, ',', '.') : '-' }}</td>
                                <td>{{ $s->harga_satuan ? 'Rp' . number_format($s->jumlah * $s->harga_satuan, 0, ',', '.') : '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada pengadaan pada periode ini</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
        @if ($jenis === 'anggaran')
            <div class="card-footer bg-white">
                <div class="row text-center">
                    <div class="col">
                        <div class="fw-bold fs-5">Rp {{ number_format($totalPengadaan, 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Pengadaan</div>
                    </div>
                    <div class="col">
                        <div class="fw-bold fs-5">{{ number_format($totalPorsi, 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Porsi Produksi</div>
                    </div>
                    <div class="col">
                        <div class="fw-bold fs-5">
                            Rp {{ number_format($totalPorsi > 0 ? $totalPengadaan / $totalPorsi : 0, 0, ',', '.') }}
                        </div>
                        <div class="text-muted small">Biaya Pengadaan per Porsi</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
