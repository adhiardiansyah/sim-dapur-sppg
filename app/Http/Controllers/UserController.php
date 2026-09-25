<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index', [
            'users' => User::orderBy('name')->get(),
            'roles' => User::ROLES,
        ]);
    }

    public function create(): View
    {
        return view('users.form', ['user' => new User(), 'roles' => User::ROLES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', Rules\Password::min(6)],
            'role' => ['required', 'in:' . implode(',', array_keys(User::ROLES))],
        ], [
            'required' => ':attribute wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        User::create($data);

        return redirect()->route('users.index')->with('sukses', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('users.form', ['user' => $user, 'roles' => User::ROLES]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'password' => ['nullable', Rules\Password::min(6)],
            'role' => ['required', 'in:' . implode(',', array_keys(User::ROLES))],
        ]);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user->update($data);

        return redirect()->route('users.index')->with('sukses', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('sukses', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $user->delete();

        return redirect()->route('users.index')->with('sukses', 'Pengguna berhasil dihapus.');
    }
}
