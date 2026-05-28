<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('dashboard.title')) - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=GFS+Didot&family=Bodoni+Moda:ital,opsz,wght@0,6..96,400;0,6..96,500;0,6..96,600;0,6..96,700;0,6..96,800;1,6..96,400&family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Cormorant+SC:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    <style>
        :root {
            /* Classical palette — matches the public site */
            --parchment:    #f5efe1;
            --ivory:        #faf6ec;
            --ink:          #1a1612;
            --ink-soft:     #322a20;
            --bronze:       #a87841;
            --bronze-dark:  #7e5223;
            --gold:         #c8a44b;
            --gold-light:   #e7c873;
            --burgundy:     #6c1f1f;
            --stone:        #8a7e66;
            --line:         rgba(26,22,18,.10);

            /* Legacy aliases (kept so old admin views don't break) */
            --gramma-blue:        #1a1612;
            --gramma-blue-light:  #7e5223;
            --gramma-gold:        #c8a44b;
        }

        /* === DIDOT GLOBAL — same stack as the public site === */
        body {
            font-family: "Didot","GFS Didot","Bodoni Moda","Cormorant Garamond","Noto Serif",Georgia,serif;
            font-size: 15px;
            background: var(--ivory);
            color: var(--ink);
        }
        h1,h2,h3,h4,h5,h6,
        .brand-text,
        .nav-header,
        .breadcrumb,
        .card-title,
        .card-header h6,
        .content-header h1,
        .small-caps {
            font-family: "Bodoni Moda","Didot","GFS Didot","Cinzel",Georgia,serif;
            letter-spacing: .02em;
        }
        /* Forms/tables keep Inter for legibility on small text */
        .form-control,
        .table,
        .badge,
        .dropdown-menu,
        small,
        .small,
        button,
        .btn { font-family: "Inter",system-ui,-apple-system,"Segoe UI",sans-serif; }

        /* === SIDEBAR === */
        .main-sidebar {
            background: linear-gradient(180deg, #1a1612 0%, #0d0a08 100%) !important;
        }
        .brand-link {
            background: rgba(0,0,0,0.35) !important;
            border-bottom: 1px solid rgba(231,200,115,0.18) !important;
            padding: 1.1rem 1rem !important;
        }

        /* === TYPOGRAPHIC LOGO (/gil/ | Gramma Institute) — admin sidebar ===
           Sized to fit comfortably inside the AdminLTE sidebar (~250px wide):
              total content ≈ /gil/ (~42px) + gap+divider+gap (~17px) + text (~145px)
            - sidebar collapsed → only /gil/ centered
            - mobile slide-out  → full logo
           ================================================================ */
        .brand-link.gil-logo {
            display: flex !important;
            align-items: center;
            justify-content: flex-start;
            gap: 0.5rem;
            padding: 0.9rem 0.85rem !important;
            color: var(--ivory) !important;
            font-family: "Bodoni Moda","Didot","GFS Didot",Georgia,serif;
            line-height: 1;
            text-decoration: none;
            box-sizing: border-box;
        }
        .brand-link.gil-logo:hover {
            color: var(--gold-light) !important;
            text-decoration: none;
        }
        .brand-link.gil-logo .gil-logo__left {
            font-size: 1.4rem;
            font-weight: 400;
            letter-spacing: -.005em;
            text-transform: lowercase;
            flex-shrink: 0;
            line-height: 1;
        }
        .brand-link.gil-logo .gil-logo__left .gil-slash {
            display: inline-block;
            padding: 0 0.02em;
        }
        .brand-link.gil-logo .gil-logo__divider {
            width: 1px;
            height: 32px;
            background: currentColor;
            opacity: .5;
            flex-shrink: 0;
        }
        .brand-link.gil-logo .gil-logo__right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 0.2rem;
            text-align: center;
            min-width: 0;
            flex: 1 1 auto;
        }
        .brand-link.gil-logo .gil-logo__main {
            font-size: 0.5rem;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .brand-link.gil-logo .gil-logo__mid {
            font-size: 0.45rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .brand-link.gil-logo .gil-logo__mid .gil-of {
            font-style: italic;
            font-weight: 400;
            font-size: 0.95em;
            letter-spacing: 0;
            text-transform: lowercase;
            padding-right: 0.22em;
            font-family: "Cormorant Garamond",Georgia,serif;
        }

        /* When sidebar is collapsed to mini (~4.6rem), only show /gil/ */
        .sidebar-collapse .brand-link.gil-logo {
            padding: 0.85rem 0.5rem !important;
            gap: 0;
            justify-content: center;
        }
        .sidebar-collapse .brand-link.gil-logo .gil-logo__divider,
        .sidebar-collapse .brand-link.gil-logo .gil-logo__right { display: none !important; }
        .sidebar-collapse .brand-link.gil-logo .gil-logo__left {
            font-size: 1.5rem;
        }
        /* Mobile: sidebar slides out at ~250px — full logo shows */
        @media (max-width: 991.98px) {
            .brand-link.gil-logo { padding: 0.85rem 0.85rem !important; }
        }
        .sidebar { padding-bottom: 2rem; }
        .nav-sidebar .nav-item .nav-link {
            color: rgba(245,239,225,.78);
            border-radius: 8px;
            margin: 2px 10px;
            transition: all .18s;
            font-size: .85rem;
            letter-spacing: .02em;
        }
        .nav-sidebar .nav-item .nav-link:hover {
            color: var(--gold-light);
            background: rgba(231,200,115,.08);
        }
        .nav-sidebar .nav-item .nav-link.active {
            color: var(--ink);
            background: var(--gold-light);
            font-weight: 600;
        }
        .nav-sidebar .nav-item .nav-link .nav-icon { color: rgba(245,239,225,.5); font-size: .9rem; }
        .nav-sidebar .nav-item .nav-link.active .nav-icon { color: var(--ink); }
        .nav-header {
            font-family: 'Cormorant SC', serif !important;
            font-size: .72rem !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            letter-spacing: .28em;
            color: var(--gold-light) !important;
            padding: 1.4rem 1.25rem .4rem !important;
            opacity: .72;
        }
        .user-panel {
            border-bottom: 1px solid rgba(231,200,115,.18);
            padding-left: .5rem;
        }
        .user-panel .info a { color: var(--ivory) !important; font-size: .9rem; font-weight: 500; font-family: 'Bodoni Moda', serif; }

        /* === TOPBAR === */
        .main-header {
            box-shadow: 0 2px 10px rgba(26,22,18,0.06);
            border-bottom: 1px solid var(--line);
            background: #fff !important;
        }
        .main-header .nav-link { color: var(--ink-soft); font-size: .9rem; }
        .main-header .nav-link:hover { color: var(--bronze-dark); }

        /* === CONTENT AREA === */
        .content-wrapper { background: var(--ivory); }
        .content-header { padding: 1.25rem .75rem .5rem; }
        .content-header h1 {
            font-family: 'Bodoni Moda', serif;
            font-size: 1.65rem;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: .015em;
        }
        .breadcrumb { font-size: .78rem; font-family: 'Cormorant SC', serif; letter-spacing: .14em; text-transform: uppercase; }
        .breadcrumb a { color: var(--bronze-dark); }
        .breadcrumb-item.active { color: var(--stone); }

        /* === CARDS === */
        .card {
            border: 1px solid var(--line) !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 12px rgba(26,22,18,0.05);
            background: #fff;
        }
        .card-header {
            border-bottom: 1px solid var(--line);
            background: transparent;
        }
        .card-header h6, .card-title {
            font-family: 'Bodoni Moda', serif;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: .02em;
        }

        /* === FOOTER === */
        .main-footer { font-size: .82rem; color: #9ca3af; border-top: 1px solid #e5e7eb; }

        /* === ALERTS === */
        .alert { border-radius: 10px; }

        /* === FORMS === */
        .form-control { border-radius: 8px; }
        .btn { border-radius: 8px; }
        .input-group .input-group-text { border-radius: 8px 0 0 8px; background: #f9fafb; }
        .input-group .form-control { border-radius: 0 8px 8px 0; }

        /* === ADMIN LANG GLOBE === */
        .admin-lang-globe {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .4rem .85rem;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .08em;
            color: #374151;
            cursor: pointer;
            margin: 0 .5rem;
            transition: all .15s;
        }
        .admin-lang-globe:hover { background: #fff; border-color: var(--gramma-blue); color: var(--gramma-blue); }
        .admin-lang-globe .fi { width: 22px; height: 16px; border-radius: 2px; box-shadow: 0 1px 2px rgba(0,0,0,.15); }
        .admin-lang-backdrop {
            position: fixed; inset: 0;
            background: rgba(15,37,64,.45);
            z-index: 1090;
            opacity: 0; pointer-events: none;
            transition: opacity .2s;
        }
        .admin-lang-backdrop.is-open { opacity: 1; pointer-events: auto; }
        .admin-lang-panel {
            position: fixed;
            top: 0; right: 0;
            width: 320px; max-width: 90vw;
            height: 100vh;
            background: #fff;
            box-shadow: -18px 0 60px rgba(0,0,0,.2);
            z-index: 1100;
            transform: translateX(100%);
            transition: transform .25s cubic-bezier(.2,.8,.2,1);
            display: flex; flex-direction: column;
        }
        .admin-lang-panel.is-open { transform: translateX(0); }
        .admin-lang-panel-header {
            background: var(--gramma-blue);
            color: #fff;
            padding: 1.25rem 1.5rem;
            display: flex; justify-content: space-between; align-items: center;
        }
        .admin-lang-panel-header h6 {
            margin: 0;
            color: var(--gramma-gold);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .26em;
            text-transform: uppercase;
        }
        .admin-lang-panel-close {
            background: transparent;
            border: 1px solid rgba(255,255,255,.25);
            color: #fff;
            width: 32px; height: 32px;
            border-radius: 50%;
            cursor: pointer;
        }
        .admin-lang-panel-close:hover { background: var(--gramma-gold); border-color: var(--gramma-gold); color: var(--gramma-blue); }
        .admin-lang-panel-list { flex: 1; overflow-y: auto; padding: .5rem 0; }
        .admin-lang-panel-item {
            display: flex; align-items: center; gap: 1rem;
            padding: .9rem 1.5rem;
            text-decoration: none;
            color: #374151;
            border-left: 3px solid transparent;
            transition: background .15s;
        }
        .admin-lang-panel-item:hover { background: #f9fafb; color: #374151; }
        .admin-lang-panel-item.is-active { background: #eef3ff; border-left-color: var(--gramma-blue); }
        .admin-lang-panel-item .fi { width: 36px; height: 26px; border-radius: 3px; box-shadow: 0 1px 4px rgba(0,0,0,.15); flex-shrink: 0; }
        .admin-lang-panel-item-native { font-weight: 600; font-size: .95rem; color: #1f2937; }
        .admin-lang-panel-item-name { font-size: .78rem; color: #6b7280; }

        /* === RESPONSIVE === */
        @media (max-width: 576px) {
            .content-wrapper { padding: 0; }
            .content { padding: .75rem; }
            .content-header { padding: .75rem .75rem 0; }
            .admin-lang-flag { padding: .25rem .35rem; }
            .admin-lang-flag .lang-short { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('dashboard') }}" class="nav-link fw-500">{{ __('dashboard.menu_dashboard') }}</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            {{-- Globe language opener --}}
            @php
                $adminLangs = [
                    'pt_BR' => ['flag' => 'br', 'name' => "Portugu\u{00EA}s",  'native' => "Portugu\u{00EA}s (BR)"],
                    'en'    => ['flag' => 'gb', 'name' => 'English',     'native' => 'English'],
                    'es'    => ['flag' => 'es', 'name' => "Espa\u{00F1}ol",    'native' => "Espa\u{00F1}ol"],
                    'he'    => ['flag' => 'il', 'name' => 'Hebrew',     'native' => "\u{05E2}\u{05D1}\u{05E8}\u{05D9}\u{05EA}"],
                    'el'    => ['flag' => 'gr', 'name' => 'Greek',      'native' => "\u{0395}\u{03BB}\u{03BB}\u{03B7}\u{03BD}\u{03B9}\u{03BA}\u{03AC}"],
                    'la'    => ['flag' => 'va', 'name' => 'Latin',      'native' => "Lat\u{012B}na"],
                ];
                $currentAdminLang = $adminLangs[app()->getLocale()] ?? $adminLangs['pt_BR'];
            @endphp
            <li class="nav-item">
                <button type="button" id="adminLangBtn" class="admin-lang-globe" aria-label="Idioma">
                    <span class="fi fi-{{ $currentAdminLang['flag'] }}"></span>
                    <span class="d-none d-sm-inline">{{ strtoupper(str_replace('_','-',app()->getLocale())) }}</span>
                </button>
            </li>
            {{-- Site link --}}
            <li class="nav-item d-none d-md-inline-block">
                <a href="{{ route('home') }}" class="nav-link" target="_blank" style="font-size:.85rem;">
                    <i class="fas fa-external-link-alt mr-1"></i>Ver Site
                </a>
            </li>
            {{-- User menu --}}
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mr-1" style="width:28px;height:28px;background:var(--gramma-blue) !important;">
                        <span style="color:#fff;font-size:.7rem;font-weight:700;">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <span class="d-none d-sm-inline" style="font-size:.875rem;">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="border-radius:10px; box-shadow:0 4px 20px rgba(0,0,0,0.12); border:1px solid #e5e7eb;">
                    <div class="px-3 py-2 border-bottom">
                        <div style="font-size:.8rem; color:#6b7280;">{{ auth()->user()->email }}</div>
                        {{ auth()->user()->isAdmin() ? 'Administrador' : 'Utilizador' }}
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item" style="font-size:.875rem;">
                        <i class="fas fa-user mr-2 text-muted"></i> {{ __('dashboard.menu_profile') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger" style="font-size:.875rem;">
                            <i class="fas fa-sign-out-alt mr-2"></i> {{ __('dashboard.menu_logout') }}
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-2">
        <a href="{{ route('dashboard') }}" class="brand-link gil-logo" aria-label="Gramma Institute of Linguistics - Admin">
            <span class="gil-logo__left"><span class="gil-slash">/</span>gil<span class="gil-slash">/</span></span>
            <span class="gil-logo__divider" aria-hidden="true"></span>
            <span class="gil-logo__right">
                <span class="gil-logo__main">Gramma Institute</span>
                <span class="gil-logo__mid"><span class="gil-of">of</span> Linguistics</span>
            </span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image d-flex align-items-center justify-content-center" style="width:34px;height:34px;background:var(--gramma-blue-light);border-radius:50%;flex-shrink:0;">
                    <span style="color:#fff;font-size:.8rem;font-weight:700;">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="info ml-2">
                    <a href="{{ route('profile.edit') }}" class="d-block">{{ auth()->user()->name }}</a>
                    <small style="color:rgba(255,255,255,0.45); font-size:.72rem;">
                        {{ auth()->user()->isAdmin() ? 'Administrador' : 'Utilizador' }}
                    </small>
                </div>
            </div>

            <nav class="mt-1">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    {{-- Main --}}
                    <li class="nav-header">Principal</li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{{ __('dashboard.menu_dashboard') }}</p>
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    {{-- Content --}}
                    <li class="nav-header">Conte&uacute;do</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.hero-slides.index') }}" class="nav-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Hero Slides</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.about.edit') }}" class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-feather-pointed"></i>
                            <p>Sobre &middot; About Us</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.partners.index') }}" class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>Parceiros &middot; Partners</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.resources.index') }}" class="nav-link {{ request()->routeIs('admin.resources.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Recursos &middot; Resources</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.courses.index') }}" class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Cursos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.glossary.index') }}" class="nav-link {{ request()->routeIs('admin.glossary.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-feather-alt"></i>
                            <p>Gloss&aacute;rio</p>
                        </a>
                    </li>

                    {{-- System --}}
                    <li class="nav-header">Sistema</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>{{ __('dashboard.menu_settings') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.languages.index') }}" class="nav-link {{ request()->routeIs('admin.languages.*') || request()->routeIs('admin.translations.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-language"></i>
                            <p>Idiomas &amp; Tradu&ccedil;&otilde;es</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.email-test.index') }}" class="nav-link {{ request()->routeIs('admin.email-test.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-paper-plane"></i>
                            <p>{{ __('dashboard.menu_email_test') }}</p>
                        </a>
                    </li>
                    @endif

                    {{-- Account --}}
                    <li class="nav-header">Conta</li>
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>{{ __('dashboard.menu_profile') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('home') }}" target="_blank" class="nav-link">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>Ver Site P&uacute;blico</p>
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
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', __('dashboard.title'))</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right" style="background:transparent; padding:0;">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" style="color:var(--gramma-blue);">{{ __('dashboard.menu_dashboard') }}</a>
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
                    <div class="alert alert-success alert-dismissible fade show" style="border-left:4px solid #16a34a;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" style="border-left:4px solid #dc2626;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" style="border-left:4px solid #dc2626;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="fas fa-exclamation-triangle mr-1"></i> Erros de valida&ccedil;&atilde;o:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li style="font-size:.875rem;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    {{-- Lang panel (admin) --}}
    <div class="admin-lang-backdrop" id="adminLangBackdrop"></div>
    <aside class="admin-lang-panel" id="adminLangPanel">
        <div class="admin-lang-panel-header">
            <h6>Idioma</h6>
            <button type="button" class="admin-lang-panel-close" id="adminLangClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="admin-lang-panel-list">
            @foreach($adminLangs as $code => $l)
                <a href="{{ route('locale.switch', $code) }}"
                   class="admin-lang-panel-item {{ app()->getLocale() === $code ? 'is-active' : '' }}">
                    <span class="fi fi-{{ $l['flag'] }}"></span>
                    <div style="flex:1;">
                        <div class="admin-lang-panel-item-native">{{ $l['native'] }}</div>
                        <div class="admin-lang-panel-item-name">{{ $l['name'] }}</div>
                    </div>
                    @if(app()->getLocale() === $code)
                        <i class="fas fa-check" style="color: var(--gramma-blue);"></i>
                    @endif
                </a>
            @endforeach
        </div>
    </aside>

    {{-- Footer --}}
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Laravel</b> {{ app()->version() }} &nbsp;|&nbsp; <b>AdminLTE</b> 3
        </div>
        <strong>{{ config('app.name') }}</strong> &copy; {{ date('Y') }}
    </footer>

</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<script>
/* =============================================================
   Vanilla JS fallback for tabs + dropdowns.
   AdminLTE 3 ships BS4 which needs data-toggle="tab|dropdown".
   If any reason that JS doesn't run, the UI was dead. This
   guarantees clicks always switch tabs/dropdowns/collapses.
   ============================================================= */
(function() {
    'use strict';

    // ---- TABS ----
    document.addEventListener('click', function(e) {
        var trigger = e.target.closest('[data-toggle="tab"], [data-bs-toggle="tab"]');
        if (!trigger) return;
        e.preventDefault();

        var target = trigger.getAttribute('href') || trigger.getAttribute('data-target') || trigger.getAttribute('data-bs-target');
        if (!target || target.charAt(0) !== '#') return;
        var pane = document.querySelector(target);
        if (!pane) return;

        // Find the tab strip this trigger belongs to
        var tabStrip = trigger.closest('.nav, ul, .nav-tabs, .nav-pills, .settings-tabs');
        if (tabStrip) {
            tabStrip.querySelectorAll('[data-toggle="tab"], [data-bs-toggle="tab"]').forEach(function(t) {
                t.classList.remove('active');
            });
        }
        trigger.classList.add('active');

        // Find the tab-content this pane belongs to
        var tabContent = pane.closest('.tab-content') || pane.parentNode;
        if (tabContent) {
            tabContent.querySelectorAll('.tab-pane').forEach(function(p) {
                p.classList.remove('active', 'show', 'in');
            });
        }
        pane.classList.add('active', 'show', 'in');
    }, false);

    // ---- ADMIN LANG PANEL ----
    (function() {
        var btn = document.getElementById('adminLangBtn');
        var panel = document.getElementById('adminLangPanel');
        var backdrop = document.getElementById('adminLangBackdrop');
        var closeBtn = document.getElementById('adminLangClose');
        if (!btn || !panel) return;
        function open()  { panel.classList.add('is-open'); backdrop.classList.add('is-open'); }
        function close() { panel.classList.remove('is-open'); backdrop.classList.remove('is-open'); }
        btn.addEventListener('click', function(e) { e.preventDefault(); open(); });
        closeBtn.addEventListener('click', close);
        backdrop.addEventListener('click', close);
    })();

    // ---- DROPDOWNS ----
    document.addEventListener('click', function(e) {
        var toggle = e.target.closest('[data-toggle="dropdown"], [data-bs-toggle="dropdown"]');
        if (toggle) {
            e.preventDefault();
            var parent = toggle.closest('.dropdown, .nav-item');
            if (parent) {
                var wasOpen = parent.classList.contains('show');
                // Close all open dropdowns first
                document.querySelectorAll('.dropdown.show, .nav-item.show').forEach(function(d) {
                    d.classList.remove('show');
                    var m = d.querySelector('.dropdown-menu');
                    if (m) m.classList.remove('show');
                });
                if (!wasOpen) {
                    parent.classList.add('show');
                    var menu = parent.querySelector('.dropdown-menu');
                    if (menu) menu.classList.add('show');
                }
            }
            return;
        }
        // Click outside closes all dropdowns
        if (!e.target.closest('.dropdown, .nav-item.dropdown')) {
            document.querySelectorAll('.dropdown.show, .nav-item.show').forEach(function(d) {
                d.classList.remove('show');
                var m = d.querySelector('.dropdown-menu');
                if (m) m.classList.remove('show');
            });
        }
    }, false);
})();
</script>
@stack('scripts')
</body>
</html>

