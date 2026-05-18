<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('dashboard.title')) — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700&family=Noto+Sans+Hebrew:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    <style>
        :root { --gramma-blue: #1a3a5c; --gramma-blue-light: #2d6a9f; --gramma-gold: #c8a951; }

        body { font-family: 'Noto Sans', sans-serif; }

        /* === SIDEBAR === */
        .main-sidebar { background: #0f2540 !important; }
        .brand-link {
            background: rgba(0,0,0,0.25) !important;
            border-bottom: 1px solid rgba(255,255,255,0.08) !important;
            padding: 1rem 1rem !important;
        }
        .brand-link .brand-text { font-weight: 700; color: #fff !important; letter-spacing: -.3px; }
        .brand-link .brand-icon { font-size: 1.3rem; color: var(--gramma-gold) !important; }
        .sidebar { padding-bottom: 2rem; }
        .nav-sidebar .nav-item .nav-link {
            color: rgba(255,255,255,0.72);
            border-radius: 8px;
            margin: 1px 8px;
            transition: all .15s;
            font-size: .875rem;
        }
        .nav-sidebar .nav-item .nav-link:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .nav-sidebar .nav-item .nav-link.active { color: #fff; background: var(--gramma-blue-light); }
        .nav-sidebar .nav-item .nav-link .nav-icon { color: rgba(255,255,255,0.5); font-size: .9rem; }
        .nav-sidebar .nav-item .nav-link.active .nav-icon { color: rgba(255,255,255,0.9); }
        .nav-header {
            font-size: .65rem !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: rgba(255,255,255,0.3) !important;
            padding: 1rem 1rem .3rem !important;
        }
        .user-panel { border-bottom: 1px solid rgba(255,255,255,0.08); }
        .user-panel .info a { color: rgba(255,255,255,0.9) !important; font-size: .875rem; font-weight: 500; }

        /* === TOPBAR === */
        .main-header { box-shadow: 0 1px 8px rgba(0,0,0,0.08); border-bottom: 1px solid #f0f0f0; }
        .main-header .nav-link { color: #374151; font-size: .875rem; }
        .main-header .nav-link:hover { color: var(--gramma-blue); }

        /* === CONTENT AREA === */
        .content-wrapper { background: #f4f6f9; }
        .content-header h1 { font-size: 1.35rem; font-weight: 700; color: #1a3a5c; }
        .breadcrumb { font-size: .8rem; }

        /* === CARDS === */
        .card-header { border-bottom: 2px solid var(--gramma-blue); }

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
                    'pt_BR' => ['flag' => 'br', 'name' => 'Português',  'native' => 'Português (BR)'],
                    'en'    => ['flag' => 'gb', 'name' => 'English',     'native' => 'English'],
                    'es'    => ['flag' => 'es', 'name' => 'Español',    'native' => 'Español'],
                    'he'    => ['flag' => 'il', 'name' => 'Hebrew',     'native' => 'עברית'],
                    'el'    => ['flag' => 'gr', 'name' => 'Greek',      'native' => 'Ελληνικά'],
                    'la'    => ['flag' => 'va', 'name' => 'Latin',      'native' => 'Latīna'],
                ];
                $currentAdminLang = $adminLangs[app()->getLocale()] ?? $adminLangs['pt_BR'];
            @endphp
            <li class="nav-item">
                <button type="button" id="adminLangBtn" class="admin-lang-globe" aria-label="Idioma">
                    <i class="fas fa-globe"></i>
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
                        <div style="font-size:.75rem; color:#9ca3af;">{{ auth()->user()->isAdmin() ? 'Administrador' : 'Utilizador' }}</div>
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
        <a href="{{ route('dashboard') }}" class="brand-link d-flex align-items-center">
            <i class="fas fa-graduation-cap brand-icon mr-2"></i>
            <span class="brand-text">Gramma <span style="font-weight:400; opacity:.7; font-size:.9em;">Admin</span></span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image d-flex align-items-center justify-content-center" style="width:34px;height:34px;background:var(--gramma-blue-light);border-radius:50%;flex-shrink:0;">
                    <span style="color:#fff;font-size:.8rem;font-weight:700;">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="info ml-2">
                    <a href="{{ route('profile.edit') }}" class="d-block">{{ auth()->user()->name }}</a>
                    <small style="color:rgba(255,255,255,0.45); font-size:.72rem;">
                        {{ auth()->user()->isAdmin() ? '★ Administrador' : 'Utilizador' }}
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
                    <li class="nav-header">Conteúdo</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.hero-slides.index') }}" class="nav-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Hero Slides</p>
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
                            <p>Glossário</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>Eventos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.promotions.index') }}" class="nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-percent"></i>
                            <p>Promoções</p>
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
                            <p>Idiomas & Traduções</p>
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
                            <p>Ver Site Público</p>
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
                        <strong><i class="fas fa-exclamation-triangle mr-1"></i> Erros de validação:</strong>
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
            <h6><i class="fas fa-globe me-2"></i>Idioma</h6>
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

<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
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
