@extends('layouts.app')
@section('title', $user->exists ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}">
                @csrf
                @if ($user->exists) @method('PUT') @endif
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kata Sandi @if($user->exists)<span class="text-muted small">(kosongkan bila tidak diubah)</span>@endif</label>
                    <input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }}>
                </div>
                <div class="mb-3">
                    <label class="form-label">Peran</label>
                    <select name="role" class="form-select" required>
                        @foreach ($roles as $nilai => $label)
                            <option value="{{ $nilai }}" {{ old('role', $user->role) === $nilai ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
