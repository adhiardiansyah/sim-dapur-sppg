# Catatan Pengujian End-to-End

Pengujian dilakukan melalui permintaan HTTP nyata (multi-akun sesuai peran) terhadap aplikasi yang berjalan, mencakup alur kerja lengkap operasional dapur SPPG.

## Skenario & Hasil

| No | Skenario | Peran | Hasil Diharapkan | Status |
|----|----------|-------|------------------|--------|
| 1 | Login 4 peran & akses halaman per modul | Semua | Halaman 200 untuk peran berwenang; 403 untuk yang tidak | ✅ |
| 2 | Catat penerimaan Sayur Bayam +50 kg | Kepala Dapur | Stok 8 → 58 | ✅ |
| 3 | Produksi 300 porsi (Nasi + Ayam Goreng + Sayur) | Kepala Dapur | Stok terpotong sesuai komposisi: Beras 500→440, Ayam 40→10, Bayam 58→34, Minyak 60→55,5; jadwal → diproduksi | ✅ |
| 4 | Produksi dengan stok kurang (Susu + Roti, 100 porsi; susu butuh 20, stok 12) | Kepala Dapur | Produksi **ditolak** dengan pesan kekurangan bahan | ✅ |
| 5 | Tandai produksi selesai | Kepala Dapur | Status produksi & jadwal → selesai | ✅ |
| 6 | Jadwalkan distribusi 150 porsi ke sekolah | Kepala SPPG | Baris distribusi berstatus dijadwalkan | ✅ |
| 7 | Kirim lalu terima distribusi | Petugas | Status dikirim → diterima; jam berangkat & tiba tercatat | ✅ |
| 8 | Laporan produksi, distribusi, stok, realisasi anggaran | Kepala SPPG | Keempat laporan menampilkan data periode berjalan | ✅ |

## Kesimpulan

Seluruh kebutuhan fungsional (F-01 s.d. F-15) berfungsi sesuai rancangan, termasuk aturan bisnis kunci: pemotongan stok otomatis saat produksi dan penolakan produksi bila stok tidak mencukupi.
