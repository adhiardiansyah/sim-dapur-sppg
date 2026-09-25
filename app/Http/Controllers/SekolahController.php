<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SekolahController extends Controller
{
    public function index(): View
    {
        return view('sekolah.index', [
            'sekolah' => Sekolah::withCount('penerima')->orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('sekolah.form', ['sekolah' => new Sekolah()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validasi($request);
        Sekolah::create($data);

        return redirect()->route('sekolah.index')->with('sukses', 'Sekolah berhasil ditambahkan.');
    }

    public function edit(Sekolah $sekolah): View
    {
        return view('sekolah.form', ['sekolah' => $sekolah]);
    }

    public function update(Request $request, Sekolah $sekolah): RedirectResponse
    {
        $sekolah->update($this->validasi($request));

        return redirect()->route('sekolah.index')->with('sukses', 'Sekolah berhasil diperbarui.');
    }

    public function destroy(Sekolah $sekolah): RedirectResponse
    {
        $sekolah->delete();

        return redirect()->route('sekolah.index')->with('sukses', 'Sekolah berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'alamat' => ['required', 'string'],
            'kontak' => ['nullable', 'string', 'max:50', 'regex:/^[0-9+\\-\\s()]*$/'],
            'koordinat' => ['nullable', 'string', 'max:50'],
            'aktif' => ['nullable', 'boolean'],
        ], [
            'required' => ':attribute wajib diisi.',
            'kontak.regex' => 'Kontak hanya boleh berisi angka, tanda +, dan tanda hubung.',
        ]);
    }
}
