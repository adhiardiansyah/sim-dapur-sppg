@extends('layouts.app')
@section('title', 'Catat Produksi')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('produksi.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Jadwal Menu (berstatus direncanakan)</label>
                    <select name="jadwal_id" class="form-select" required>
                        <option value="">— pilih jadwal —</option>
                        @foreach ($jadwalTersedia as $j)
                            <option value="{{ $j->id }}" {{ old('jadwal_id', $terpilih) == $j->id ? 'selected' : '' }}>
                                {{ $j->tanggal->translatedFormat('d M Y') }} — {{ $j->menu->nama_menu }} ({{ number_format($j->jumlah_porsi, 0, ',', '.') }} porsi)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Porsi Realisasi</label>
                    <input type="number" min="1" name="porsi_realisasi" value="{{ old('porsi_realisasi') }}" class="form-control" required>
                    <div class="form-text">Stok bahan akan dipotong sesuai komposisi menu × porsi realisasi.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan (opsional)</label>
                    <textarea name="catatan" rows="2" class="form-control">{{ old('catatan') }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan Produksi</button>
                    <a href="{{ route('produksi.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
