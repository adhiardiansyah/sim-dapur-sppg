@extends('layouts.app')
@section('title', 'Pengguna')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-muted">Kelola akun pengguna sistem</h6>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Pengguna</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Nama</th><th>Email</th><th>Peran</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr>
                            <td class="fw-semibold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td><span class="badge bg-secondary">{{ $roles[$u->role] }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" {{ $u->id === auth()->id() ? 'disabled' : '' }}><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pengguna</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
