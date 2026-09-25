@extends('layouts.app')
@section('title', $penerima->exists ? 'Edit Penerima' : 'Tambah Penerima')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ $penerima->exists ? route('penerima.update', $penerima) : route('penerima.store') }}">
                @csrf
                @if ($penerima->exists) @method('PUT') @endif
                <div class="mb-3">
                    <label class="form-label">Sekolah / Lokasi</label>
                    <select name="sekolah_id" class="form-select" required>
                        @foreach ($sekolah as $s)
                            <option value="{{ $s->id }}" {{ old('sekolah_id', $penerima->sekolah_id) == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Penerima</label>
                    <input name="nama" value="{{ old('nama', $penerima->nama) }}" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            @foreach ($kategori as $k)
                                <option value="{{ $k }}" {{ old('kategori', $penerima->kategori ?? 'siswa') === $k ? 'selected' : '' }}>{{ str_replace('_', ' ', $k) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kelas (opsional)</label>
                        <input name="kelas" value="{{ old('kelas', $penerima->kelas) }}" class="form-control">
                    </div>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="aktif" value="1" id="aktif" {{ old('aktif', $penerima->aktif ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="aktif">Aktif</label>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('penerima.index', $penerima->sekolah_id ? ['sekolah_id' => $penerima->sekolah_id] : []) }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
