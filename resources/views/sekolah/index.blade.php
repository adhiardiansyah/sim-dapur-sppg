@extends('layouts.app')
@section('title', 'Sekolah & Penerima')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Data sekolah / lokasi sasaran penerima manfaat</h6>
        <a href="{{ route('sekolah.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Sekolah</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Nama Sekolah</th><th>Alamat</th><th>Kontak</th><th>Penerima</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($sekolah as $s)
                        <tr>
                            <td class="fw-semibold">{{ $s->nama }}</td>
                            <td>{{ $s->alamat }}</td>
                            <td>{{ $s->kontak ?: '-' }}</td>
                            <td>{{ $s->penerima_count }}</td>
                            <td><span class="badge {{ $s->aktif ? 'bg-success' : 'bg-secondary' }}">{{ $s->aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('penerima.index', ['sekolah_id' => $s->id]) }}" class="btn btn-sm btn-outline-secondary" title="Penerima"><i class="bi bi-people"></i></a>
                                <a href="{{ route('sekolah.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('sekolah.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus sekolah ini beserta datanya?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada sekolah</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
