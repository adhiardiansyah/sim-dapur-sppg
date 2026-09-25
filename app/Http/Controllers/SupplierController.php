<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        return view('supplier.index', [
            'supplier' => Supplier::orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('supplier.form', ['supplier' => new Supplier()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Supplier::create($this->validasi($request));

        return redirect()->route('supplier.index')->with('sukses', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier): View
    {
        return view('supplier.form', ['supplier' => $supplier]);
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($this->validasi($request));

        return redirect()->route('supplier.index')->with('sukses', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('supplier.index')->with('sukses', 'Supplier berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
        ], ['required' => ':attribute wajib diisi.']);
    }
}
