<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('dashboard.title')) — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700&family=Noto+Sans+Hebrew:wght@300;400;600&family=Noto+Sans+Greek:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <style>
        :root { --gramma-blue: #1a3a5c; --gramma-blue-light: #2d6a9f; }
        body { font-family: 'Noto Sans', sans-serif; }
        .main-sidebar { background: var(--gramma-blue) !important; }
        .brand-link { background: rgba(0,0,0,0.2) !important; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand-link .brand-text { font-weight: 700; color: #fff !important; }
        .nav-sidebar .nav-item .nav-link { color: rgba(255,255,255,0.8); }
        .nav-sidebar .nav-item .nav-link:hover,
        .nav-sidebar .nav-item .nav-link.active { color: #fff; background: rgba(255,255,255,0.15); }
        .nav-sidebar .nav-item .nav-link .nav-icon { color: rgba(255,255,255,0.6); }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active { background: var(--gramma-blue-light); }
        .content-wrapper { background: #f4f6f9; }
        .card-header { border-bottom: 2px solid var(--gramma-blue); }
        .btn-gramma { background: var(--gramma-blue); border-color: var(--gramma-blue); color: #fff; }
        .btn-gramma:hover { background: var(--gramma-blue-light); border-color: var(--gramma-blue-light); color: #fff; }
        .main-footer { font-size: 0.85rem; }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('dashboard') }}" class="nav-link">{{ __('dashboard.menu_dashboard') }}</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i> {{ __('site.nav_home') }}
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            {{-- Language switcher --}}
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-globe"></i> {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach(['pt_BR' => 'PT-BR', 'en' => 'EN', 'es' => 'ES', 'he' => 'HE', 'el' => 'EL'] as $code => $label)
                        <a class="dropdown-item {{ app()->getLocale() === $code ? 'active' : '' }}"
                           href="{{ route('locale.switch', $code) }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </li>
            {{-- User menu --}}
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> {{ __('dashboard.menu_profile') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> {{ __('dashboard.menu_logout') }}
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i class="fas fa-graduation-cap ml-2 mr-1" style="color: #fff; font-size:1.4rem;"></i>
            <span class="brand-text font-weight-bold">Gramma Institute</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" style="width:34px;height:34px;">
                        <i class="fas fa-user text-secondary"></i>
                    </div>
                </div>
                <div class="info">
                    <a href="{{ route('profile.edit') }}" class="d-block text-white">
                        {{ auth()->user()->name }}
                    </a>
                    <small class="text-light opacity-75">
                        {{ auth()->user()->isAdmin() ? __('dashboard.profile_role_admin') : __('dashboard.profile_role_user') }}
                    </small>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{{ __('dashboard.menu_dashboard') }}</p>
                        </a>
                    </li>
                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>{{ __('dashboard.menu_settings') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.email-test.index') }}" class="nav-link {{ request()->routeIs('admin.email-test.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>{{ __('dashboard.menu_email_test') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.languages.index') }}" class="nav-link {{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-language"></i>
                            <p>{{ __('dashboard.menu_languages') }}</p>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>{{ __('dashboard.menu_profile') }}</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    {{-- Content Wrapper --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', __('dashboard.title'))</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.menu_dashboard') }}</a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline-block">
            <b>Laravel</b> {{ app()->version() }} &nbsp;|&nbsp; <b>AdminLTE</b> 3
        </div>
        <strong>Gramma Institute</strong> &copy; {{ date('Y') }}. {{ __('site.footer_rights') }}
    </footer>

</div>

<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('scripts')
</body>
</html>
