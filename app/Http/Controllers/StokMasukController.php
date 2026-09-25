<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\StokMasuk;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StokMasukController extends Controller
{
    public function index(): View
    {
        return view('stok-masuk.index', [
            'stokMasuk' => StokMasuk::with(['bahan', 'supplier', 'pencatat'])
                ->orderByDesc('tanggal')->orderByDesc('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('stok-masuk.create', [
            'bahan' => BahanBaku::orderBy('nama')->get(),
            'supplier' => Supplier::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'bahan_id' => ['required', 'exists:bahan_baku,id'],
            'supplier_id' => ['nullable', 'exists:supplier,id'],
            'jumlah' => ['required', 'numeric', 'gt:0'],
            'harga_satuan' => ['nullable', 'numeric', 'min:0'],
            'tanggal' => ['required', 'date'],
        ], [
            'required' => ':attribute wajib diisi.',
            'gt' => 'Jumlah harus lebih dari nol.',
        ]);

        DB::transaction(function () use ($data) {
            $stok = StokMasuk::create($data + ['dicatat_oleh' => auth()->id()]);
            BahanBaku::whereKey($data['bahan_id'])->increment('stok', $data['jumlah']);
        });

        return redirect()->route('stok-masuk.index')->with('sukses', 'Penerimaan bahan berhasil dicatat dan stok diperbarui.');
    }

    public function destroy(StokMasuk $stokMasuk): RedirectResponse
    {
        DB::transaction(function () use ($stokMasuk) {
            BahanBaku::whereKey($stokMasuk->bahan_id)->decrement('stok', $stokMasuk->jumlah);
            $stokMasuk->delete();
        });

        return redirect()->route('stok-masuk.index')->with('sukses', 'Catatan penerimaan dihapus dan stok dikembalikan.');
    }
}
