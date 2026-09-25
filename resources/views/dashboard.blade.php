@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-3 mb-4">
        @php $kartu = [
            ['Sekolah Aktif', $jumlahSekolah, 'bi-school', 'primary'],
            ['Penerima Aktif', $jumlahPenerima, 'bi-person-check', 'success'],
            ['Jenis Bahan Baku', $jumlahBahan, 'bi-basket', 'warning'],
            ['Jadwal Hari Ini', $jadwalHariIni->count(), 'bi-calendar-week', 'info'],
        ]; @endphp
        @foreach ($kartu as [$label, $angka, $ikon, $warna])
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-3 bg-{{ $warna }} bg-opacity-10 text-{{ $warna }} p-3 me-3">
                            <i class="bi {{ $ikon }} fs-4"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $angka }}</div>
                            <div class="text-muted small">{{ $label }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Bahan Baku Stok Rendah</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr><th>Bahan</th><th>Stok</th><th>Minimum</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($bahanRendah as $b)
                                <tr>
                                    <td>{{ $b->nama }}</td>
                                    <td>{{ number_format($b->stok, 2) }} {{ $b->satuan }}</td>
                                    <td>{{ number_format($b->stok_minimum, 2) }} {{ $b->satuan }}</td>
                                    <td><span class="badge bg-danger">Segera restock</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Semua stok aman ✅</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold"><i class="bi bi-calendar-week text-primary me-2"></i>Perencanaan Menu Hari Ini ({{ today()->translatedFormat('d F Y') }})</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr><th>Menu</th><th>Porsi</th><th>Status</th><th>Produksi</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwalHariIni as $j)
                                <tr>
                                    <td>{{ $j->menu->nama_menu }}<br><span class="text-muted small">{{ $j->menu->kategori_waktu }}</span></td>
                                    <td>{{ number_format($j->jumlah_porsi, 0, ',', '.') }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $j->status }}</span></td>
                                    <td>
                                        @if ($j->produksi)
                                            {{ $j->produksi->porsi_realisasi }} porsi — {{ $j->produksi->status }}
                                        @else
                                            <span class="text-muted">belum ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada jadwal menu hari ini</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
