<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — SIM Dapur SPPG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-dark-subtle d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow" style="width: 26rem;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="bi bi-egg-fried fs-1 text-primary"></i>
                <h4 class="mt-2 mb-0">SIM Dapur SPPG</h4>
                <p class="text-muted small mb-0">Sistem Informasi Manajemen Produksi & Distribusi<br>Program Makan Bergizi Gratis</p>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="ingat" id="ingat">
                    <label class="form-check-label" for="ingat">Ingat saya</label>
                </div>
                <button class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-1"></i>Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
