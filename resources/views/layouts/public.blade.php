<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $isRtl = $locale === 'he';
    $dir = $isRtl ? 'rtl' : 'ltr';
@endphp
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta-title', $settings->meta_title ?? config('app.name'))</title>
    <meta name="description" content="@yield('meta-description', $settings->meta_description ?? '')">

    {{-- Preconnect fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Noto+Sans+Hebrew:wght@300;400;500;600;700&family=Noto+Sans+Display:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap from CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @if($isRtl)
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @endif

    <style>
        :root {
            --gramma-blue: #1a3a5c;
            --gramma-blue-2: #2d6a9f;
            --gramma-blue-3: #3d8bcd;
            --gramma-gold: #c8a951;
            --gramma-light: #f8f9fb;
            --gramma-text: #2c3e50;
        }

        body {
            font-family: @if($locale === 'he') 'Noto Sans Hebrew', @elseif($locale === 'el') 'Noto Sans', @endif 'Noto Sans', sans-serif;
            color: var(--gramma-text);
            line-height: 1.7;
        }

        /* ====== NAVBAR ====== */
        .gramma-navbar {
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .gramma-navbar .navbar-brand {
            font-family: 'Noto Sans Display', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--gramma-blue);
            letter-spacing: -0.5px;
        }
        .gramma-navbar .navbar-brand span { color: var(--gramma-gold); }
        .gramma-navbar .nav-link { color: var(--gramma-text); font-weight: 500; transition: color .2s; }
        .gramma-navbar .nav-link:hover { color: var(--gramma-blue-2); }
        .gramma-navbar .btn-nav-cta { background: var(--gramma-blue); color: #fff; border-radius: 6px; padding: .4rem 1rem; font-weight: 600; }
        .gramma-navbar .btn-nav-cta:hover { background: var(--gramma-blue-2); color: #fff; }

        /* ====== HERO ====== */
        .hero-section {
            background: linear-gradient(135deg, var(--gramma-blue) 0%, var(--gramma-blue-2) 60%, var(--gramma-blue-3) 100%);
            min-height: 92vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 600px; height: 600px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -5%;
            width: 400px; height: 400px;
            background: rgba(200,169,81,0.08);
            border-radius: 50%;
        }
        .hero-section .hero-title {
            font-family: 'Noto Sans Display', sans-serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.15;
            color: #fff;
            margin-bottom: 1.2rem;
        }
        .hero-section .hero-subtitle {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.88);
            margin-bottom: 2rem;
            max-width: 560px;
        }
        .hero-section .btn-hero-primary {
            background: var(--gramma-gold);
            color: #1a1a2e;
            font-weight: 700;
            padding: .75rem 2rem;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            transition: all .2s;
            margin-right: .75rem;
            text-decoration: none;
            display: inline-block;
        }
        .hero-section .btn-hero-primary:hover { background: #d4b458; transform: translateY(-2px); }
        .hero-section .btn-hero-outline {
            background: transparent;
            color: #fff;
            font-weight: 600;
            padding: .75rem 2rem;
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.5);
            text-decoration: none;
            display: inline-block;
            transition: all .2s;
        }
        .hero-section .btn-hero-outline:hover { border-color: #fff; background: rgba(255,255,255,0.1); color: #fff; }
        .hero-languages { display: flex; gap: .5rem; flex-wrap: wrap; margin-top: 2.5rem; }
        .hero-lang-badge {
            background: rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.9);
            border: 1px solid rgba(255,255,255,0.2);
            padding: .3rem .75rem;
            border-radius: 20px;
            font-size: .85rem;
            font-weight: 500;
        }

        /* ====== SECTIONS ====== */
        .section { padding: 5rem 0; }
        .section-light { background: var(--gramma-light); }
        .section-dark { background: var(--gramma-blue); color: #fff; }
        .section-title {
            font-family: 'Noto Sans Display', sans-serif;
            font-weight: 700;
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            color: var(--gramma-blue);
            margin-bottom: .5rem;
        }
        .section-dark .section-title { color: #fff; }
        .section-subtitle { color: #6c757d; font-size: 1.05rem; margin-bottom: 3rem; }
        .section-dark .section-subtitle { color: rgba(255,255,255,0.75); }
        .divider-gold {
            width: 50px; height: 3px;
            background: var(--gramma-gold);
            margin: .75rem 0 1.5rem;
        }

        /* ====== CARDS ====== */
        .course-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
            transition: transform .25s, box-shadow .25s;
            overflow: hidden;
        }
        .course-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        .course-card .card-header {
            font-weight: 700;
            font-size: 1.1rem;
            padding: 1.2rem 1.5rem;
            border-bottom: none;
        }
        .advantage-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, var(--gramma-blue), var(--gramma-blue-2));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .testimonial-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
            padding: 2rem;
            position: relative;
        }
        .testimonial-card::before {
            content: '"';
            font-size: 5rem;
            color: var(--gramma-gold);
            line-height: 1;
            position: absolute;
            top: .5rem;
            left: 1.5rem;
            font-family: Georgia, serif;
            opacity: .6;
        }

        /* ====== FOOTER ====== */
        .gramma-footer {
            background: var(--gramma-blue);
            color: rgba(255,255,255,0.8);
            padding: 3rem 0 1rem;
        }
        .gramma-footer h5 { color: #fff; font-weight: 700; margin-bottom: 1rem; }
        .gramma-footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: color .2s; }
        .gramma-footer a:hover { color: var(--gramma-gold); }
        .gramma-footer .footer-divider { border-color: rgba(255,255,255,0.1); }
        .gramma-footer .footer-bottom { font-size: .85rem; color: rgba(255,255,255,0.5); }

        /* ====== LANGUAGE SWITCHER ====== */
        .lang-switcher .dropdown-toggle { font-size: .85rem; }
        .lang-switcher .dropdown-item.active { background-color: var(--gramma-blue); }

        /* ====== RTL ADJUSTMENTS ====== */
        [dir="rtl"] .hero-section .btn-hero-primary { margin-right: 0; margin-left: .75rem; }
    </style>
    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="gramma-navbar navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span>G</span>ramma <span style="font-weight:400; font-size:.9em; color: #555;">Institute</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'text-primary fw-600' : '' }}" href="{{ route('home') }}">{{ __('site.nav_home') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'text-primary fw-600' : '' }}" href="{{ route('about') }}">{{ __('site.nav_about') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('courses') ? 'text-primary fw-600' : '' }}" href="{{ route('courses') }}">{{ __('site.nav_courses') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('methodology') ? 'text-primary fw-600' : '' }}" href="{{ route('methodology') }}">{{ __('site.nav_methodology') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'text-primary fw-600' : '' }}" href="{{ route('contact') }}">{{ __('site.nav_contact') }}</a></li>

                {{-- Language Switcher --}}
                <li class="nav-item dropdown lang-switcher ms-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-globe"></i> {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach(['pt_BR' => '🇧🇷 PT-BR', 'en' => '🇬🇧 EN', 'es' => '🇪🇸 ES', 'he' => '🇮🇱 HE', 'el' => '🇬🇷 EL'] as $code => $label)
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === $code ? 'active' : '' }}"
                                   href="{{ route('locale.switch', $code) }}">{{ $label }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item ms-2">
                    @auth
                        <a class="btn btn-nav-cta" href="{{ route('dashboard') }}">{{ __('site.nav_dashboard') }}</a>
                    @else
                        <a class="btn btn-nav-cta" href="{{ route('login') }}">{{ __('site.nav_login') }}</a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- PAGE CONTENT --}}
@yield('content')

{{-- FOOTER --}}
<footer class="gramma-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Gramma Institute</h5>
                <p>{{ $settings->descricao_site ?? __('site.hero_subtitle') }}</p>
                <div class="d-flex gap-2 mt-3">
                    @if($settings->facebook) <a href="{{ $settings->facebook }}" target="_blank"><i class="fab fa-facebook fa-lg"></i></a> @endif
                    @if($settings->instagram) <a href="{{ $settings->instagram }}" target="_blank"><i class="fab fa-instagram fa-lg"></i></a> @endif
                    @if($settings->linkedin) <a href="{{ $settings->linkedin }}" target="_blank"><i class="fab fa-linkedin fa-lg"></i></a> @endif
                    @if($settings->youtube) <a href="{{ $settings->youtube }}" target="_blank"><i class="fab fa-youtube fa-lg"></i></a> @endif
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <h5>{{ __('site.nav_courses') }}</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('courses') }}">{{ __('site.course_portuguese') }}</a></li>
                    <li><a href="{{ route('courses') }}">{{ __('site.course_english') }}</a></li>
                    <li><a href="{{ route('courses') }}">{{ __('site.course_spanish') }}</a></li>
                    <li><a href="{{ route('courses') }}">{{ __('site.course_hebrew') }}</a></li>
                    <li><a href="{{ route('courses') }}">{{ __('site.course_greek') }}</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>{{ __('site.nav_contact') }}</h5>
                @if($settings->email_institucional)
                    <p><i class="fas fa-envelope me-2"></i> {{ $settings->email_institucional }}</p>
                @endif
                @if($settings->telefone)
                    <p><i class="fas fa-phone me-2"></i> {{ $settings->telefone }}</p>
                @endif
                @if($settings->cidade)
                    <p><i class="fas fa-map-marker-alt me-2"></i> {{ $settings->cidade }}{{ $settings->pais ? ', ' . $settings->pais : '' }}</p>
                @endif
            </div>
            <div class="col-md-2 mb-4">
                <h5>Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about') }}">{{ __('site.nav_about') }}</a></li>
                    <li><a href="{{ route('privacy') }}">{{ __('site.footer_privacy') }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ __('site.footer_terms') }}</a></li>
                </ul>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row">
            <div class="col footer-bottom text-center">
                {{ $settings->texto_rodape ?? ('© ' . date('Y') . ' Gramma Institute. ' . __('site.footer_rights')) }}
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
