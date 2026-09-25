@extends('layouts.app')
@section('title', 'Penerima Manfaat')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex gap-2">
            <select name="sekolah_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua sekolah</option>
                @foreach ($sekolah as $s)
                    <option value="{{ $s->id }}" {{ $filterSekolah === $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('penerima.create', $filterSekolah ? ['sekolah_id' => $filterSekolah] : []) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Penerima</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Nama</th><th>Sekolah/Lokasi</th><th>Kategori</th><th>Kelas</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($penerima as $p)
                        <tr>
                            <td class="fw-semibold">{{ $p->nama }}</td>
                            <td>{{ $p->sekolah->nama }}</td>
                            <td>{{ str_replace('_', ' ', $p->kategori) }}</td>
                            <td>{{ $p->kelas ?: '-' }}</td>
                            <td><span class="badge {{ $p->aktif ? 'bg-success' : 'bg-secondary' }}">{{ $p->aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('penerima.edit', $p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('penerima.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus penerima ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada penerima manfaat</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $penerima->links() }}</div>
    </div>
@endsection
