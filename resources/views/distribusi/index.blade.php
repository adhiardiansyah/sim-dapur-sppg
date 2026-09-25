@extends('layouts.app')
@section('title', 'Distribusi')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Jadwal & status pengiriman makanan ke sekolah</h6>
        @if ($bolehKelola)
            <a href="{{ route('distribusi.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Jadwal</a>
        @endif
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Tanggal Produksi</th><th>Menu</th><th>Sekolah</th><th>Porsi</th><th>Jam</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($distribusi as $d)
                        <tr>
                            <td>{{ $d->produksi->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="fw-semibold">{{ $d->produksi->jadwal->menu->nama_menu }}</td>
                            <td>{{ $d->sekolah->nama }}</td>
                            <td>{{ number_format($d->jumlah_porsi, 0, ',', '.') }}</td>
                            <td class="small">
                                @if ($d->jam_berangkat) berangkat: {{ substr($d->jam_berangkat, 0, 5) }} @endif
                                @if ($d->jam_tiba) · tiba: {{ substr($d->jam_tiba, 0, 5) }} @endif
                                @if (!$d->jam_berangkat && !$d->jam_tiba) - @endif
                            </td>
                            <td>
                                @if ($d->status === 'dijadwalkan')
                                    <span class="badge bg-secondary">dijadwalkan</span>
                                @elseif ($d->status === 'dikirim')
                                    <span class="badge bg-primary">dikirim</span>
                                @else
                                    <span class="badge bg-success">diterima</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($bolehKirim && $d->status === 'dijadwalkan')
                                    <form action="{{ route('distribusi.kirim', $d) }}" method="POST" class="d-inline">@csrf
                                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-send me-1"></i>Kirim</button></form>
                                @endif
                                @if ($bolehKirim && $d->status === 'dikirim')
                                    <form action="{{ route('distribusi.terima', $d) }}" method="POST" class="d-inline">@csrf
                                        <button class="btn btn-sm btn-outline-success"><i class="bi bi-check2 me-1"></i>Diterima</button></form>
                                @endif
                                @if ($bolehKelola && $d->status === 'dijadwalkan')
                                    <form action="{{ route('distribusi.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus jadwal distribusi?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                                @if (!($bolehKirim && in_array($d->status, ['dijadwalkan', 'dikirim'])) && !($bolehKelola && $d->status === 'dijadwalkan'))
                                    <span class="text-muted small">— tidak ada tindakan —</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada jadwal distribusi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $distribusi->links() }}</div>
    </div>
@endsection
