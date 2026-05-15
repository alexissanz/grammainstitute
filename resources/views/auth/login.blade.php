<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('auth.login_title') }} — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans', sans-serif; }
        .brand-color { color: #1a3a5c; }
        .login-box { margin: 7% auto !important; }
        .login-logo a { color: #1a3a5c; font-weight: 700; font-size: 1.8rem; letter-spacing: -0.5px; }
        .login-card-body { border-top: 3px solid #1a3a5c; }
        .btn-primary { background-color: #1a3a5c; border-color: #1a3a5c; }
        .btn-primary:hover { background-color: #0f2540; border-color: #0f2540; }
    </style>
</head>
<body class="hold-transition login-page" style="background: linear-gradient(135deg, #1a3a5c 0%, #2d6a9f 100%);">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('home') }}"><b>Gramma</b> Institute</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('auth.login_title') }}</p>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="{{ __('auth.email') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ __('auth.password') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">{{ __('auth.remember_me') }}</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('auth.login') }}
                        </button>
                    </div>
                </div>
            </form>

            @if (Route::has('password.request'))
                <p class="mb-1 mt-3 text-center">
                    <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                </p>
            @endif

            <div class="mt-3 text-center">
                <small>
                    <a href="{{ route('home') }}">← {{ __('site.nav_home') }}</a>
                    &nbsp;|&nbsp;
                    @foreach(['pt_BR','en','es'] as $loc)
                        <a href="{{ route('locale.switch', $loc) }}">{{ strtoupper($loc) }}</a>&nbsp;
                    @endforeach
                </small>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
