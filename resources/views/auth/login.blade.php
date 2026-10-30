<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · Inventaris Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 shadow-sm p-4 p-md-5 w-100" style="max-width:440px">
        <div class="text-primary fw-bold text-uppercase small mb-2">Sistem Inventaris</div>
        <h1 class="h3 fw-bold mb-2">Masuk ke akun</h1>
        <p class="text-muted mb-4">Gunakan akun yang telah dibuat oleh administrator.</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    autocomplete="username" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password"
                    class="form-control" autocomplete="current-password" required>
            </div>
            <div class="form-check mb-4">
                <input id="remember" type="checkbox" name="remember" value="1" class="form-check-input">
                <label for="remember" class="form-check-label">Ingat saya</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>
</main>
</body>
</html>
