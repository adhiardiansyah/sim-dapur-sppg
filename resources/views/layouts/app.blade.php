<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — SIM Dapur SPPG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .sidebar { width: 250px; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar .nav-link { color: rgba(255,255,255,.75); border-radius: .375rem; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.12); }
        .content { margin-left: 250px; }
        @media (max-width: 991px) { .sidebar { display: none; } .content { margin-left: 0; } }
    </style>
</head>
<body class="bg-light">
    <nav class="sidebar bg-dark d-flex flex-column p-3">
        <span class="text-white fs-5 fw-bold mb-1 px-2"><i class="bi bi-egg-fried me-2"></i>SIM Dapur SPPG</span>
        <span class="text-secondary small px-2 mb-4">Program Makan Bergizi Gratis</span>
        <ul class="nav nav-pills flex-column mb-auto">
            @php
                $nav = [
                    ['dashboard', 'Dashboard', 'bi-speedometer2', null],
                    ['users.index', 'Pengguna', 'bi-people', ['kepala_sppg']],
                    ['sekolah.index', 'Sekolah & Penerima', 'bi-school', ['kepala_sppg']],
                    ['bahan.index', 'Bahan Baku', 'bi-basket', ['ahli_gizi']],
                    ['supplier.index', 'Supplier', 'bi-truck', ['kepala_dapur']],
                    ['menu.index', 'Menu', 'bi-journal-richtext', ['ahli_gizi']],
                    ['jadwal.index', 'Perencanaan Menu', 'bi-calendar-week', ['ahli_gizi']],
                    ['stok-masuk.index', 'Stok Masuk', 'bi-box-arrow-in-down', ['kepala_dapur']],
                    ['produksi.index', 'Produksi', 'bi-fire', ['kepala_dapur']],
                    ['distribusi.index', 'Distribusi', 'bi-bicycle', null],
                    ['laporan.index', 'Laporan', 'bi-file-earmark-bar-graph', null],
                ];
            @endphp
            @foreach ($nav as [$route, $label, $icon, $roles])
                @if (Route::has($route) && ($roles === null || in_array(auth()->user()->role, $roles)))
                    <li class="nav-item">
                        <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}">
                            <i class="bi {{ $icon }} me-2"></i>{{ $label }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>

    <main class="content">
        <div class="bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small">
                    {{ auth()->user()->name }} · <span class="badge bg-secondary">{{ auth()->user()->roleLabel() }}</span>
                </span>
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i>Keluar</button>
                </form>
            </div>
        </div>
        <div class="p-4">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">{!! implode('', array_map(fn ($e) => '<li>'.$e.'</li>', $errors->all())) !!}</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('sukses'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('sukses') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
