<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use App\Models\Sekolah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenerimaController extends Controller
{
    public const KATEGORI = ['siswa', 'ibu_hamil', 'ibu_menyusui', 'balita'];

    public function index(Request $request): View
    {
        $query = Penerima::with('sekolah')->orderBy('nama');
        if ($request->filled('sekolah_id')) {
            $query->where('sekolah_id', $request->integer('sekolah_id'));
        }

        return view('penerima.index', [
            'penerima' => $query->paginate(20)->withQueryString(),
            'sekolah' => Sekolah::orderBy('nama')->get(),
            'kategori' => self::KATEGORI,
            'filterSekolah' => $request->integer('sekolah_id'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('penerima.form', [
            'penerima' => new Penerima(['sekolah_id' => $request->integer('sekolah_id')]),
            'sekolah' => Sekolah::orderBy('nama')->get(),
            'kategori' => self::KATEGORI,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Penerima::create($this->validasi($request));

        return redirect()->route('penerima.index', ['sekolah_id' => $request->integer('sekolah_id')])
            ->with('sukses', 'Penerima manfaat berhasil ditambahkan.');
    }

    public function edit(Penerima $penerima): View
    {
        return view('penerima.form', [
            'penerima' => $penerima,
            'sekolah' => Sekolah::orderBy('nama')->get(),
            'kategori' => self::KATEGORI,
        ]);
    }

    public function update(Request $request, Penerima $penerima): RedirectResponse
    {
        $penerima->update($this->validasi($request));

        return redirect()->route('penerima.index', ['sekolah_id' => $penerima->sekolah_id])
            ->with('sukses', 'Penerima manfaat berhasil diperbarui.');
    }

    public function destroy(Penerima $penerima): RedirectResponse
    {
        $penerima->delete();

        return back()->with('sukses', 'Penerima manfaat berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'sekolah_id' => ['required', 'exists:sekolah,id'],
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'in:' . implode(',', self::KATEGORI)],
            'kelas' => ['nullable', 'string', 'max:50'],
            'aktif' => ['nullable', 'boolean'],
        ], ['required' => ':attribute wajib diisi.']);
    }
}
