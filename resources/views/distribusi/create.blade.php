@extends('layouts.app')
@section('title', 'Tambah Jadwal Distribusi')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ route('distribusi.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Produksi (berjalan)</label>
                    <select name="produksi_id" class="form-select" required>
                        <option value="">— pilih produksi —</option>
                        @foreach ($produksi as $p)
                            <option value="{{ $p->id }}">{{ $p->tanggal->translatedFormat('d M Y') }} — {{ $p->jadwal->menu->nama_menu }} ({{ number_format($p->porsi_realisasi, 0, ',', '.') }} porsi · {{ $p->status }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sekolah Tujuan</label>
                    <select name="sekolah_id" class="form-select" required>
                        @foreach ($sekolah as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Porsi</label>
                    <input type="number" min="1" name="jumlah_porsi" class="form-control" required>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('distribusi.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
