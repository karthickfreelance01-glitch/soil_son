<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | {{ config('site.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/uploads/sswf/favicon-256.png') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/sswf-admin.css') }}?v=1">
</head>
<body>
<div class="vv-auth">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-5 vv-auth-side d-none d-md-flex flex-column justify-content-center align-items-center text-center p-5">
                            <img src="{{ asset('assets/uploads/sswf/favicon-256.png') }}" alt="SSWF" width="120" class="mb-4">
                            <h3 class="text-white fw-bold mb-2">SSWF</h3>
                            <p class="text-white-50 mb-0">Rehabilitation Centre<br>Admin &amp; Staff Panel</p>
                        </div>
                        <div class="col-md-7 p-4 p-lg-5 bg-white">
                            <div class="text-center d-md-none mb-3">
                                <img src="{{ asset('assets/uploads/sswf/favicon-256.png') }}" alt="SSWF" width="80">
                            </div>
                            <h4 class="fw-bold mb-1">Welcome back 👋</h4>
                            <p class="text-muted mb-4">Sign in to the hospital management system and website admin.</p>

                            @if ($errors->any())
                                <div class="alert alert-danger py-2">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success py-2">{{ session('success') }}</div>
                            @endif

                            <form method="POST" action="{{ route('admin.login.submit') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="you@example.com" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password" id="pw" class="form-control" placeholder="••••••••" required>
                                        <span class="input-group-text" role="button" onclick="const p=document.getElementById('pw');p.type=p.type==='password'?'text':'password';this.firstElementChild.classList.toggle('fa-eye-slash')"><i class="fa-solid fa-eye"></i></span>
                                    </div>
                                </div>
                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                    <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                                </button>
                            </form>
                            <p class="text-center text-muted small mt-4 mb-0"><a href="{{ url('/') }}">&larr; Back to website</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
