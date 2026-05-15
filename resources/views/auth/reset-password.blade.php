<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('auth.reset_password') }} — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans', sans-serif; }
        .login-box { margin: 7% auto !important; }
        .login-logo a { color: #1a3a5c; font-weight: 700; font-size: 1.8rem; }
        .login-card-body { border-top: 3px solid #1a3a5c; }
        .btn-primary { background-color: #1a3a5c; border-color: #1a3a5c; }
    </style>
</head>
<body class="hold-transition login-page" style="background: linear-gradient(135deg, #1a3a5c 0%, #2d6a9f 100%);">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('home') }}"><b>Gramma</b> Institute</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('auth.reset_password') }}</p>
            <form action="{{ route('password.store') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="input-group mb-3">
                    <input type="email" name="email" value="{{ old('email', $request->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="{{ __('auth.email') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ __('auth.new_password') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="{{ __('auth.confirm_password') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('auth.reset_password') }}
                        </button>
                    </div>
                </div>
            </form>
            <p class="mt-3 mb-1 text-center">
                <a href="{{ route('login') }}">← {{ __('auth.back_to_login') }}</a>
            </p>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
