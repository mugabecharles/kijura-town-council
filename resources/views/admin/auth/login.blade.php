<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login — Kijura Town Council</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #1a1a2e 0%, #1a6b3a 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #fff; border-radius: 12px; padding: 2.5rem; max-width: 400px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,.3); }
        .login-brand { text-align: center; margin-bottom: 1.5rem; }
        .login-brand .brand-icon { width: 64px; height: 64px; background: #1a6b3a; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto .8rem; }
        .login-brand h5 { font-weight: 700; color: #1a1a2e; margin: 0; }
        .login-brand small { color: #888; }
        .form-control:focus { border-color: #1a6b3a; box-shadow: 0 0 0 .2rem rgba(26,107,58,.15); }
        .btn-login { background: #1a6b3a; border-color: #1a6b3a; color: #fff; font-weight: 600; padding: .7rem; }
        .btn-login:hover { background: #134d2b; border-color: #134d2b; color: #fff; }
    </style>
</head>
<body>
<div class="container px-3">
    <div class="login-card mx-auto">
        <div class="login-brand">
            <div class="brand-icon"><i class="bi bi-building-fill text-white fs-3"></i></div>
            <h5>Kijura Town Council</h5>
            <small>Staff Administration Portal</small>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-sm mb-3 py-2"><i class="bi bi-exclamation-circle me-1"></i>{{ session('error') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger mb-3 py-2">
            @foreach($errors->all() as $error)<div class="small">{{ $error }}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small">Email Address</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required autocomplete="email" placeholder="your@email.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small">Password</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    required autocomplete="current-password" placeholder="••••••••">
            </div>
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Remember me</label>
                </div>
            </div>
            <button type="submit" class="btn btn-login w-100"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="small text-muted text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Back to Public Website</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
