<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Cetak Laporan {{ $jenisLabel }}</title>
<style>
    @page { size: A4; margin: 1.5cm; }
    body { font-family: 'Times New Roman', serif; font-size: 12pt; color: #000; }
    .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 16px; }
    .kop h1 { font-size: 16pt; margin: 0; letter-spacing: 1px; }
    .kop p { margin: 2px 0 0; font-size: 11pt; }
    h2.judul { text-align: center; font-size: 13pt; text-decoration: underline; margin: 0 0 4px; }
    .info { font-size: 11pt; margin: 0 0 12px; }
    table { border-collapse: collapse; width: 100%; font-size: 11pt; }
    th, td { border: 1px solid #000; padding: 4px 6px; vertical-align: top; }
    thead { display: table-header-group; }
    th { background: #e8e8e8; text-align: left; }
    .kosong { text-align: center; font-style: italic; }
    .ringkas { margin-top: 10px; }
    .ringkas td { border: none; padding: 2px 6px; }
    .ringkas .angka { font-weight: bold; }
    .ttd { margin-top: 34px; width: 100%; }
    .ttd td { border: none; text-align: center; width: 50%; }
    .ttd .nama { margin-top: 64px; text-decoration: underline; font-weight: bold; }
    @media print { .no-print { display: none; } }
</style>
</head>
<body>
    <div class="kop">
        <h1>SIM DAPUR SPPG</h1>
        <p>Sistem Informasi Manajemen Produksi &amp; Distribusi Dapur Satuan Pelayanan Pemenuhan Gizi</p>
        <p>Program Makan Bergizi Gratis</p>
    </div>

    <h2 class="judul">LAPORAN {{ strtoupper($jenisLabel) }}</h2>
    <p class="info">
        @if ($jenis !== 'stok')
            Periode: {{ $dari->translatedFormat('d F Y') }} s.d. {{ $sampai->translatedFormat('d F Y') }}<br>
        @else
            Kondisi persediaan per: {{ now()->translatedFormat('d F Y') }}<br>
        @endif
        Dicetak: {{ now()->translatedFormat('d F Y H:i') }} WIB — {{ auth()->user()->name }} ({{ auth()->user()->roleLabel() }})
    </p>

    @if ($jenis === 'produksi')
        <table>
            <thead><tr><th style="width:18%">Tanggal</th><th>Menu</th><th style="width:15%">Porsi Rencana</th><th style="width:15%">Porsi Realisasi</th><th style="width:13%">Status</th></tr></thead>
            <tbody>
                @forelse ($produksi as $p)
                    <tr>
                        <td>{{ $p->tanggal->translatedFormat('d/m/Y') }}</td>
                        <td>{{ $p->jadwal->menu->nama_menu }}</td>
                        <td>{{ number_format($p->jadwal->jumlah_porsi, 0, ',', '.') }}</td>
                        <td>{{ number_format($p->porsi_realisasi, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($p->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="kosong">Tidak ada data pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    @elseif ($jenis === 'distribusi')
        <table>
            <thead><tr><th style="width:15%">Tanggal</th><th>Menu</th><th>Sekolah Tujuan</th><th style="width:12%">Porsi</th><th style="width:17%">Jam</th><th style="width:13%">Status</th></tr></thead>
            <tbody>
                @forelse ($distribusi as $d)
                    <tr>
                        <td>{{ $d->produksi->tanggal->translatedFormat('d/m/Y') }}</td>
                        <td>{{ $d->produksi->jadwal->menu->nama_menu }}</td>
                        <td>{{ $d->sekolah->nama }}</td>
                        <td>{{ number_format($d->jumlah_porsi, 0, ',', '.') }}</td>
                        <td>{{ $d->jam_berangkat ? substr($d->jam_berangkat, 0, 5) : '-' }} / {{ $d->jam_tiba ? substr($d->jam_tiba, 0, 5) : '-' }}</td>
                        <td>{{ ucfirst($d->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="kosong">Tidak ada data pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    @elseif ($jenis === 'stok')
        <table>
            <thead><tr><th>No</th><th>Bahan Baku</th><th style="width:12%">Satuan</th><th style="width:15%">Stok</th><th style="width:15%">Stok Minimum</th><th style="width:16%">Keterangan</th></tr></thead>
            <tbody>
                @forelse ($bahan as $i => $b)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $b->nama }}</td>
                        <td>{{ $b->satuan }}</td>
                        <td>{{ number_format($b->stok, 3) }}</td>
                        <td>{{ number_format($b->stok_minimum, 3) }}</td>
                        <td>{{ $b->stok_rendah ? 'Di bawah minimum' : 'Aman' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="kosong">Belum ada bahan baku.</td></tr>
                @endforelse
            </tbody>
        </table>
    @else
        <table>
            <thead><tr><th style="width:15%">Tanggal</th><th>Bahan</th><th style="width:16%">Jumlah</th><th style="width:18%">Harga Satuan</th><th style="width:18%">Total</th></tr></thead>
            <tbody>
                @forelse ($pengadaan as $s)
                    <tr>
                        <td>{{ $s->tanggal->translatedFormat('d/m/Y') }}</td>
                        <td>{{ $s->bahan->nama }}</td>
                        <td>{{ number_format($s->jumlah, 3) }} {{ $s->bahan->satuan }}</td>
                        <td>{{ $s->harga_satuan ? 'Rp ' . number_format($s->harga_satuan, 0, ',', '.') : '-' }}</td>
                        <td>{{ $s->harga_satuan ? 'Rp ' . number_format($s->jumlah * $s->harga_satuan, 0, ',', '.') : '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="kosong">Tidak ada pengadaan pada periode ini.</td></tr>
                @endforelse
                <tr>
                    <th colspan="4" style="text-align:right">Total Pengadaan</th>
                    <th>Rp {{ number_format($totalPengadaan, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
        <table class="ringkas">
            <tr><td>Total Porsi Produksi</td><td class="angka">: {{ number_format($totalPorsi, 0, ',', '.') }} porsi</td></tr>
            <tr><td>Biaya Pengadaan per Porsi</td><td class="angka">: Rp {{ number_format($totalPorsi > 0 ? $totalPengadaan / $totalPorsi : 0, 0, ',', '.') }}</td></tr>
        </table>
    @endif

    <table class="ttd">
        <tr>
            <td>
                Dibuat oleh,<br>{{ auth()->user()->roleLabel() }}
                <div class="nama">{{ auth()->user()->name }}</div>
            </td>
            <td>
                Mengetahui,<br>Kepala SPPG
                <div class="nama">( .......................................... )</div>
            </td>
        </tr>
    </table>

    <p class="no-print" style="text-align:center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 6px 14px;">🖨️ Cetak</button>
    </p>
    <script>window.addEventListener('load', () => window.print());</script>
</body>
</html>
