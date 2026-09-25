<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use App\Models\JadwalMenu;
use App\Models\Menu;
use App\Models\MenuBahan;
use App\Models\Penerima;
use App\Models\Sekolah;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Akun pengguna (kata sandi semua: password) =====
        $akun = [
            ['name' => 'Administrator SPPG', 'email' => 'kepala@sppg.test', 'role' => 'kepala_sppg'],
            ['name' => 'Ahli Gizi', 'email' => 'ahli@sppg.test', 'role' => 'ahli_gizi'],
            ['name' => 'Kepala Dapur', 'email' => 'dapur@sppg.test', 'role' => 'kepala_dapur'],
            ['name' => 'Petugas Distribusi', 'email' => 'petugas@sppg.test', 'role' => 'petugas'],
        ];
        foreach ($akun as $a) {
            User::updateOrCreate(['email' => $a['email']], $a + ['password' => 'password']);
        }
        $ahli = User::where('role', 'ahli_gizi')->first();

        // ===== Sekolah & penerima =====
        $sd = Sekolah::updateOrCreate(['nama' => 'SD Negeri 1 Harapan Bangsa'], [
            'alamat' => 'Jl. Pendidikan No. 1', 'kontak' => '0812-1111-0001', 'aktif' => true,
        ]);
        $smp = Sekolah::updateOrCreate(['nama' => 'SMP Negeri 3 Maju Jaya'], [
            'alamat' => 'Jl. Melati No. 10', 'kontak' => '0812-1111-0002', 'aktif' => true,
        ]);
        Penerima::updateOrCreate(['sekolah_id' => $sd->id, 'nama' => 'Contoh Siswa SD 1'], ['kategori' => 'siswa', 'kelas' => 'V-A']);
        Penerima::updateOrCreate(['sekolah_id' => $smp->id, 'nama' => 'Contoh Siswa SMP 3'], ['kategori' => 'siswa', 'kelas' => 'VIII-B']);

        // ===== Bahan baku (gizi per 100 g/ml) =====
        $bahan = [
            ['nama' => 'Beras', 'satuan' => 'kg', 'stok' => 500, 'stok_minimum' => 100, 'kalori' => 360, 'protein' => 6.8, 'karbohidrat' => 78.9, 'lemak' => 0.7, 'harga_referensi' => 13000],
            ['nama' => 'Ayam Fillet', 'satuan' => 'kg', 'stok' => 40, 'stok_minimum' => 20, 'kalori' => 190, 'protein' => 27, 'karbohidrat' => 0, 'lemak' => 8, 'harga_referensi' => 38000],
            ['nama' => 'Telur Ayam', 'satuan' => 'kg', 'stok' => 30, 'stok_minimum' => 10, 'kalori' => 154, 'protein' => 13, 'karbohidrat' => 1.1, 'lemak' => 11, 'harga_referensi' => 28000],
            ['nama' => 'Sayur Bayam', 'satuan' => 'kg', 'stok' => 8, 'stok_minimum' => 10, 'kalori' => 23, 'protein' => 2.9, 'karbohidrat' => 3.6, 'lemak' => 0.4, 'harga_referensi' => 8000],
            ['nama' => 'Wortel', 'satuan' => 'kg', 'stok' => 25, 'stok_minimum' => 10, 'kalori' => 41, 'protein' => 0.9, 'karbohidrat' => 9.6, 'lemak' => 0.2, 'harga_referensi' => 12000],
            ['nama' => 'Minyak Goreng', 'satuan' => 'liter', 'stok' => 60, 'stok_minimum' => 20, 'kalori' => 884, 'protein' => 0, 'karbohidrat' => 0, 'lemak' => 100, 'harga_referensi' => 17000],
            ['nama' => 'Tahu Putih', 'satuan' => 'kg', 'stok' => 15, 'stok_minimum' => 5, 'kalori' => 80, 'protein' => 10, 'karbohidrat' => 1.9, 'lemak' => 4.7, 'harga_referensi' => 10000],
            ['nama' => 'Susu UHT', 'satuan' => 'liter', 'stok' => 12, 'stok_minimum' => 24, 'kalori' => 61, 'protein' => 3.2, 'karbohidrat' => 4.8, 'lemak' => 3.3, 'harga_referensi' => 18000],
            ['nama' => 'Roti Tawar', 'satuan' => 'kg', 'stok' => 5, 'stok_minimum' => 5, 'kalori' => 265, 'protein' => 9, 'karbohidrat' => 49, 'lemak' => 3.2, 'harga_referensi' => 22000],
            ['nama' => 'Bawang Merah', 'satuan' => 'kg', 'stok' => 10, 'stok_minimum' => 3, 'kalori' => 40, 'protein' => 1.1, 'karbohidrat' => 9.3, 'lemak' => 0.1, 'harga_referensi' => 32000],
        ];
        $b = [];
        foreach ($bahan as $row) {
            $b[$row['nama']] = BahanBaku::updateOrCreate(['nama' => $row['nama']], $row);
        }

        // ===== Supplier =====
        Supplier::updateOrCreate(['nama' => 'UD Sumber Pangan'], ['kontak' => '0813-2222-0001', 'alamat' => 'Jl. Pasar Induk Blok A']);
        Supplier::updateOrCreate(['nama' => 'CV Sehat Makmur'], ['kontak' => '0813-2222-0002', 'alamat' => 'Jl. Industri Raya No. 5']);

        // ===== Menu & komposisi =====
        $m1 = Menu::updateOrCreate(['nama_menu' => 'Nasi + Ayam Goreng + Sayur'], ['kategori_waktu' => 'makan_siang', 'status' => 'aktif']);
        $m2 = Menu::updateOrCreate(['nama_menu' => 'Bubur Ayam Telur'], ['kategori_waktu' => 'sarapan', 'status' => 'aktif']);
        $m3 = Menu::updateOrCreate(['nama_menu' => 'Susu + Roti'], ['kategori_waktu' => 'snack', 'status' => 'aktif']);

        $resep = [
            $m1->id => [['Beras', 0.2], ['Ayam Fillet', 0.1], ['Sayur Bayam', 0.08], ['Minyak Goreng', 0.015]],
            $m2->id => [['Beras', 0.15], ['Ayam Fillet', 0.08], ['Telur Ayam', 0.05]],
            $m3->id => [['Susu UHT', 0.2], ['Roti Tawar', 0.08]],
        ];
        foreach ($resep as $menuId => $items) {
            foreach ($items as [$namaBahan, $jml]) {
                $bahanModel = $b[$namaBahan];
                MenuBahan::updateOrCreate(
                    ['menu_id' => $menuId, 'bahan_id' => $bahanModel->id],
                    ['jumlah_per_porsi' => $jml, 'satuan' => $bahanModel->satuan]
                );
            }
        }

        // ===== Contoh jadwal hari ini =====
        JadwalMenu::updateOrCreate(
            ['tanggal' => today(), 'menu_id' => $m1->id],
            ['jumlah_porsi' => 300, 'status' => 'direncanakan', 'dibuat_oleh' => $ahli?->id]
        );
    }
}
