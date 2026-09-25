<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BahanBakuController extends Controller
{
    public function index(): View
    {
        return view('bahan.index', [
            'bahan' => BahanBaku::orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('bahan.form', ['bahan' => new BahanBaku()]);
    }

    public function store(Request $request): RedirectResponse
    {
        BahanBaku::create($this->validasi($request) + ['stok' => $request->numeric('stok', 0)]);

        return redirect()->route('bahan.index')->with('sukses', 'Bahan baku berhasil ditambahkan.');
    }

    public function edit(BahanBaku $bahan): View
    {
        return view('bahan.form', ['bahan' => $bahan]);
    }

    public function update(Request $request, BahanBaku $bahan): RedirectResponse
    {
        $bahan->update($this->validasi($request));

        return redirect()->route('bahan.index')->with('sukses', 'Bahan baku berhasil diperbarui.');
    }

    public function destroy(BahanBaku $bahan): RedirectResponse
    {
        $bahan->delete();

        return redirect()->route('bahan.index')->with('sukses', 'Bahan baku berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'satuan' => ['required', 'string', 'max:20'],
            'stok_minimum' => ['required', 'numeric', 'min:0'],
            'kalori' => ['nullable', 'numeric', 'min:0'],
            'protein' => ['nullable', 'numeric', 'min:0'],
            'karbohidrat' => ['nullable', 'numeric', 'min:0'],
            'lemak' => ['nullable', 'numeric', 'min:0'],
            'harga_referensi' => ['nullable', 'numeric', 'min:0'],
        ], [
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute harus berupa angka.',
        ]);
    }
}
