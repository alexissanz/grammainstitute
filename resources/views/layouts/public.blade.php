<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $isRtl  = $locale === 'he';
    $dir    = $isRtl ? 'rtl' : 'ltr';
    $waLink = $settings->whatsappLink();
    $topbarPromos = \App\Models\Promotion::activeForTopbar();
@endphp
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    {{-- Bypass ngrok-free browser warning on each request via XHR-style header --}}
    <meta name="ngrok-skip-browser-warning" content="true">
    <meta name="theme-color" content="#1a1612" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1612" media="(prefers-color-scheme: dark)">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('meta-title', $settings->meta_title ?? config('app.name'))</title>
    <meta name="description" content="@yield('meta-description', $settings->meta_description ?? '')">

    @if($settings->favicon)
        <link rel="icon" href="{{ Storage::url($settings->favicon) }}">
    @endif

    {{-- Premium typography: Cormorant Garamond (serif body), Cinzel (display caps),
         Cormorant SC (small-caps subtitles), Noto Sans Hebrew (RTL), Noto Serif (fallback) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Cormorant+SC:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Hebrew:wght@300;400;500;600;700&family=Noto+Serif:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    @if($isRtl)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @endif

    <style>
        :root {
            /* Classical / Mediterranean palette: parchment + ink + bronze */
            --parchment:      #f5efe1;
            --parchment-2:    #ece2c8;
            --ivory:          #faf6ec;
            --ink:            #1a1612;       /* deep ink black */
            --ink-soft:       #322a20;
            --bronze:         #a87841;
            --bronze-dark:    #7e5223;
            --gold:           #c8a44b;
            --gold-light:     #e7c873;
            --burgundy:       #6c1f1f;
            --olive:          #4f5b35;
            --stone:          #8a7e66;
            --line:           rgba(26,22,18,.12);

            /* legacy aliases (kept so admin views that import from public CSS still work) */
            --gramma-blue:    #1a1612;
            --gramma-blue-2:  #322a20;
            --gramma-blue-3:  #4f5b35;
            --gramma-gold:    #c8a44b;
            --gramma-light:   #f5efe1;
            --gramma-text:    #1a1612;
        }

        @php
            $bodyStack = $locale === 'he'
                ? "'Noto Sans Hebrew','Cormorant Garamond','Noto Serif',Georgia,serif"
                : "'Cormorant Garamond','Noto Serif',Georgia,serif";
            $displayStack = "'Cinzel','Cormorant Garamond',Georgia,serif";
            $smallCapsStack = "'Cormorant SC','Cinzel',Georgia,serif";
            $sansStack = "'Inter',system-ui,-apple-system,'Segoe UI',sans-serif";
        @endphp

        html { scroll-behavior: smooth; }
        body {
            font-family: {!! $bodyStack !!};
            font-size: 1.125rem;
            line-height: 1.75;
            color: var(--ink);
            background: var(--ivory);
            background-image:
                radial-gradient(at 12% 8%,  rgba(168,120,65,.06) 0, transparent 45%),
                radial-gradient(at 88% 92%, rgba(168,120,65,.05) 0, transparent 50%);
            background-attachment: fixed;
        }

        h1,h2,h3,h4,h5 { font-family: {!! $displayStack !!}; color: var(--ink); letter-spacing: .02em; }
        .display-serif { font-family: {!! $displayStack !!}; }
        .small-caps { font-family: {!! $smallCapsStack !!}; text-transform: uppercase; letter-spacing: .22em; font-weight: 600; }
        .sans { font-family: {!! $sansStack !!}; }

        a { color: var(--bronze-dark); }
        a:hover { color: var(--burgundy); }

        /* ====== TOP UTILITY BAR ====== */
        .top-bar {
            background: var(--ink);
            color: rgba(245,239,225,.78);
            font-family: {!! $sansStack !!};
            font-size: .78rem;
            letter-spacing: .08em;
            padding: .45rem 0;
        }
        .top-bar a { color: rgba(245,239,225,.78); text-decoration: none; }
        .top-bar a:hover { color: var(--gold-light); }
        .top-bar .sep { opacity: .35; margin: 0 .75rem; }

        /* ====== NAVBAR ====== */
        .gramma-navbar {
            background: rgba(250,246,236,.96);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--line);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1050;   /* above WA fab (was overlapping) */
            transition: padding .25s, background .25s;
        }
        .gramma-navbar.scrolled { padding: .55rem 0; background: rgba(250,246,236,.98); }
        .gramma-navbar .navbar-brand {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 1.55rem;
            letter-spacing: .14em;
            color: var(--ink);
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .gramma-navbar .navbar-brand .brand-mark {
            width: 38px; height: 38px;
            display: inline-flex; align-items: center; justify-content: center;
            border: 1.5px solid var(--bronze);
            border-radius: 50%;
            color: var(--bronze-dark);
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0;
        }
        .gramma-navbar .navbar-brand small {
            display:block;
            font-family: 'Cormorant SC', serif;
            font-size: .55rem;
            font-weight: 500;
            letter-spacing: .35em;
            color: var(--stone);
            text-transform: uppercase;
            margin-top: 2px;
        }
        .gramma-navbar .nav-link {
            font-family: {!! $sansStack !!};
            color: var(--ink);
            font-size: .78rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            padding: .5rem 1rem !important;
            position: relative;
        }
        .gramma-navbar .nav-link:hover { color: var(--bronze-dark); }
        .gramma-navbar .nav-link.active::after,
        .gramma-navbar .nav-link.is-current::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 1rem; right: 1rem;
            height: 1.5px;
            background: var(--bronze);
        }
        .gramma-navbar .btn-nav-cta {
            font-family: {!! $sansStack !!};
            background: var(--ink);
            color: var(--ivory);
            border-radius: 0;
            padding: .55rem 1.3rem;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            border: 1.5px solid var(--ink);
            transition: all .2s;
        }
        .gramma-navbar .btn-nav-cta:hover { background: var(--bronze-dark); border-color: var(--bronze-dark); color: var(--ivory); }
        /* ====== MOBILE NAV ACTIONS (always-visible row) ====== */
        .nav-mobile-actions { margin-left: auto; }
        .mobile-globe.lang-globe-btn {
            padding: .5rem .7rem;
            min-width: 44px; min-height: 44px;
        }
        .mobile-cta {
            padding: .5rem .9rem !important;
            font-size: .72rem !important;
            min-height: 44px;
            display: inline-flex !important;
            align-items: center;
        }
        @media (max-width: 360px) {
            .mobile-cta { padding: .5rem .65rem !important; font-size: .68rem !important; }
            .mobile-cta i { display: none; }
        }

        /* ====== GLOBE LANGUAGE SWITCHER ====== */
        .lang-pivot { position: relative; }
        .lang-globe-btn {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .5rem .85rem;
            background: transparent;
            border: 1.5px solid var(--line);
            border-radius: 999px;
            font-family: {!! $sansStack !!};
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .12em;
            color: var(--ink);
            cursor: pointer;
            transition: all .2s;
        }
        .lang-globe-btn:hover { border-color: var(--bronze); color: var(--bronze-dark); }
        .lang-globe-btn[aria-expanded="true"] {
            background: var(--ink);
            color: var(--ivory);
            border-color: var(--ink);
        }
        .lang-globe-icon { font-size: .9rem; opacity: .9; }
        .lang-globe-flag {
            width: 20px;
            height: 14px;
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(0,0,0,.18);
        }
        .lang-globe-chevron { font-size: .65rem; opacity: .7; transition: transform .2s; }
        .lang-globe-btn[aria-expanded="true"] .lang-globe-chevron { transform: rotate(180deg); }

        /* The panel that opens */
        .lang-panel-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(26,22,18,.45);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            z-index: 1090;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }
        .lang-panel-backdrop.is-open { opacity: 1; pointer-events: auto; }

        .lang-panel {
            position: fixed;
            top: 0; right: 0;
            width: 340px; max-width: 90vw;
            height: 100vh;
            background: var(--ivory);
            box-shadow: -18px 0 60px rgba(0,0,0,.18);
            z-index: 1100;
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform .3s cubic-bezier(.2,.8,.2,1);
            overflow: hidden;
        }
        [dir="rtl"] .lang-panel { right: auto; left: 0; transform: translateX(-100%); box-shadow: 18px 0 60px rgba(0,0,0,.18); }
        .lang-panel.is-open { transform: translateX(0); }

        .lang-panel-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid var(--line);
            background: var(--ink);
            color: var(--ivory);
        }
        .lang-panel-title {
            font-family: 'Cinzel', serif;
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .28em;
            text-transform: uppercase;
            color: var(--gold-light);
            display: flex; align-items: center; gap: .65rem;
        }
        .lang-panel-title i { font-size: 1.05rem; opacity: .9; }
        .lang-panel-close {
            background: transparent;
            border: 1px solid rgba(250,246,236,.3);
            color: var(--ivory);
            width: 36px; height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all .2s;
        }
        .lang-panel-close:hover { background: var(--gold-light); color: var(--ink); border-color: var(--gold-light); }

        .lang-panel-subtitle {
            padding: 1.5rem 1.5rem .75rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            color: var(--stone);
            font-size: 1rem;
            line-height: 1.5;
            border-bottom: 1px solid var(--line);
        }

        .lang-panel-list {
            flex: 1;
            overflow-y: auto;
            padding: .5rem 0;
        }
        .lang-panel-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            text-decoration: none;
            color: var(--ink);
            transition: background .15s;
            border-left: 3px solid transparent;
        }
        [dir="rtl"] .lang-panel-item { border-left: 0; border-right: 3px solid transparent; }
        .lang-panel-item:hover { background: rgba(168,120,65,.08); color: var(--ink); }
        .lang-panel-item.is-active {
            background: rgba(168,120,65,.12);
            border-left-color: var(--bronze);
        }
        [dir="rtl"] .lang-panel-item.is-active { border-right-color: var(--bronze); }
        .lang-panel-item .fi {
            width: 38px;
            height: 28px;
            border-radius: 3px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0,0,0,.15);
        }
        .lang-panel-item-text { flex: 1; min-width: 0; }
        .lang-panel-item-native {
            font-family: 'Cinzel', serif;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: .06em;
            color: var(--ink);
        }
        .lang-panel-item.is-active .lang-panel-item-native { color: var(--bronze-dark); }
        .lang-panel-item-name {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: .9rem;
            color: var(--stone);
            margin-top: 2px;
        }
        .lang-panel-item-check {
            color: var(--bronze);
            font-size: 1.05rem;
        }

        .lang-panel-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--line);
            font-family: 'Cormorant SC', serif;
            font-size: .68rem;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--stone);
            text-align: center;
            line-height: 1.5;
        }
        .lang-panel-footer .ornament-mini {
            font-family: 'Cinzel', serif;
            color: var(--bronze);
            font-size: 1rem;
            margin: 0 .25rem;
        }

        /* Mobile: panel becomes a bottom sheet */
        @media (max-width: 575px) {
            .lang-panel {
                top: auto;
                right: 0; left: 0;
                width: 100%;
                max-width: 100%;
                height: auto;
                max-height: 80vh;
                border-radius: 20px 20px 0 0;
                transform: translateY(100%);
                box-shadow: 0 -18px 60px rgba(0,0,0,.25);
            }
            [dir="rtl"] .lang-panel { transform: translateY(100%); }
            .lang-panel.is-open { transform: translateY(0); }
            .lang-panel::before {
                content: '';
                position: absolute;
                top: 8px; left: 50%; transform: translateX(-50%);
                width: 48px; height: 4px;
                background: rgba(26,22,18,.18);
                border-radius: 4px;
            }
            .lang-panel-header { padding-top: 1.75rem; border-radius: 20px 20px 0 0; }
            .lang-panel-item { padding: 1rem 1.25rem; }
            .lang-panel-item .fi { width: 44px; height: 32px; }
            .lang-panel-item-native { font-size: 1.05rem; }
        }

        /* ====== BUTTONS ====== */
        .btn-classical {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            font-family: {!! $sansStack !!};
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .22em;
            text-transform: uppercase;
            padding: .95rem 2rem;
            background: var(--gold);
            color: var(--ink);
            border: 1.5px solid var(--gold);
            border-radius: 0;
            text-decoration: none;
            transition: all .25s;
        }
        .btn-classical:hover { background: transparent; color: var(--ivory); border-color: var(--ivory); }
        .btn-classical-outline {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            font-family: {!! $sansStack !!};
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .22em;
            text-transform: uppercase;
            padding: .95rem 2rem;
            background: transparent;
            color: var(--ivory);
            border: 1.5px solid rgba(250,246,236,.6);
            border-radius: 0;
            text-decoration: none;
            transition: all .25s;
        }
        .btn-classical-outline:hover { background: var(--ivory); color: var(--ink); border-color: var(--ivory); }
        .btn-classical-dark {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            font-family: {!! $sansStack !!};
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .22em;
            text-transform: uppercase;
            padding: .95rem 2rem;
            background: var(--ink);
            color: var(--ivory);
            border: 1.5px solid var(--ink);
            border-radius: 0;
            text-decoration: none;
            transition: all .25s;
        }
        .btn-classical-dark:hover { background: var(--bronze-dark); border-color: var(--bronze-dark); color: var(--ivory); }

        /* ====== ORNAMENT ====== */
        .ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 1rem 0 1.75rem;
            color: var(--bronze);
        }
        .ornament::before, .ornament::after {
            content: '';
            flex: 0 0 64px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--bronze), transparent);
        }
        .ornament i { font-size: .9rem; }
        .ornament.light { color: var(--gold-light); }
        .ornament.light::before, .ornament.light::after { background: linear-gradient(90deg, transparent, var(--gold-light), transparent); }

        /* ====== SECTION TITLES ====== */
        .eyebrow {
            font-family: {!! $smallCapsStack !!};
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .32em;
            color: var(--bronze-dark);
            text-transform: uppercase;
            margin-bottom: .5rem;
        }
        .eyebrow.light { color: var(--gold-light); }
        .section-title-classical {
            font-family: {!! $displayStack !!};
            font-weight: 600;
            font-size: clamp(1.85rem, 3.2vw, 2.85rem);
            line-height: 1.18;
            letter-spacing: .01em;
            color: var(--ink);
            margin-bottom: .5rem;
        }
        .section-dark .section-title-classical,
        .section-ink .section-title-classical { color: var(--ivory); }

        /* legacy aliases used by inner pages */
        .section-title { font-family: {!! $displayStack !!}; font-weight: 600; color: var(--ink); font-size: clamp(1.6rem, 3vw, 2.4rem); }
        .section-subtitle { color: var(--ink-soft); font-size: 1.1rem; }
        .divider-gold { width: 60px; height: 2px; background: var(--bronze); margin: .75rem 0 1.5rem; }

        .section { padding: 6rem 0; }
        .section-light { background: var(--parchment); }
        .section-cream { background: var(--ivory); }
        .section-ink {
            background: var(--ink);
            color: var(--ivory);
            position: relative;
        }
        .section-ink::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(circle at 20% 20%, rgba(200,164,75,.08), transparent 50%),
                              radial-gradient(circle at 80% 80%, rgba(168,120,65,.07), transparent 55%);
            pointer-events: none;
        }
        .section-ink > .container { position: relative; z-index: 1; }
        .section-dark { background: var(--ink); color: var(--ivory); }
        .section-dark .section-title { color: var(--ivory); }
        .section-dark .section-subtitle { color: rgba(250,246,236,.75); }

        /* ====== FOOTER ====== */
        .gramma-footer {
            background: var(--ink);
            color: rgba(250,246,236,.72);
            padding: 5rem 0 1.5rem;
            position: relative;
        }
        .gramma-footer::before {
            content: '';
            position: absolute;
            top: 0; left: 50%;
            transform: translateX(-50%);
            width: 80%; max-width: 1100px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--bronze), transparent);
        }
        .gramma-footer h5 {
            font-family: 'Cinzel', serif;
            color: var(--gold-light);
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .26em;
            text-transform: uppercase;
            margin-bottom: 1.4rem;
        }
        .gramma-footer p { font-size: 1rem; line-height: 1.7; }
        .gramma-footer a {
            color: rgba(250,246,236,.72);
            text-decoration: none;
            transition: color .2s;
            font-size: 1rem;
        }
        .gramma-footer a:hover { color: var(--gold-light); }
        .gramma-footer ul.list-unstyled li { margin-bottom: .55rem; }
        .gramma-footer .footer-divider {
            border: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(250,246,236,.18), transparent);
            margin: 3rem 0 1.5rem;
        }
        .gramma-footer .footer-bottom {
            font-family: {!! $sansStack !!};
            font-size: .75rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: rgba(250,246,236,.45);
        }
        .footer-brand {
            font-family: 'Cinzel', serif;
            font-size: 1.6rem;
            letter-spacing: .14em;
            color: var(--ivory);
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .footer-social a {
            display: inline-flex;
            align-items: center; justify-content: center;
            width: 38px; height: 38px;
            border: 1px solid rgba(250,246,236,.25);
            border-radius: 50%;
            margin-right: .5rem;
            transition: all .25s;
        }
        .footer-social a:hover {
            background: var(--bronze-dark);
            border-color: var(--bronze-dark);
            color: var(--ivory);
        }

        /* ====== WHATSAPP FLOATING WIDGET ====== */
        .wa-fab {
            position: fixed;
            bottom: 24px;
            z-index: 1020;       /* below sticky navbar (was 1080) */
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .wa-fab.wa-right { right: 24px; }
        .wa-fab.wa-left  { left: 24px; align-items: flex-start; }
        .wa-fab .wa-card {
            width: 320px;
            max-width: calc(100vw - 48px);
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 16px 40px rgba(0,0,0,.25);
            overflow: hidden;
            margin-bottom: 12px;
            opacity: 0;
            transform: translateY(14px) scale(.96);
            pointer-events: none;
            transition: opacity .25s, transform .25s;
            font-family: 'Inter', sans-serif;
        }
        .wa-fab.is-open .wa-card {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .wa-card-header {
            background: var(--wa-color, #25d366);
            color: #fff;
            padding: 1rem 1.1rem;
            display: flex;
            align-items: center;
            gap: .8rem;
        }
        .wa-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(255,255,255,.22);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: #fff;
            flex-shrink: 0;
            position: relative;
        }
        .wa-avatar::after {
            content: '';
            position: absolute;
            bottom: 0; right: 0;
            width: 12px; height: 12px;
            background: #4ade80;
            border: 2px solid var(--wa-color, #25d366);
            border-radius: 50%;
        }
        .wa-card-title { font-weight: 600; font-size: .95rem; line-height: 1.2; }
        .wa-card-sub { font-size: .78rem; opacity: .92; margin-top: 2px; }
        .wa-card-close {
            background: transparent; border: none; color: #fff;
            font-size: 1.1rem; cursor: pointer; opacity: .85;
            margin-left: auto; padding: 0 .25rem;
        }
        .wa-card-close:hover { opacity: 1; }
        .wa-card-body {
            background: #e5ddd5;
            background-image:
                linear-gradient(rgba(229,221,213,.94), rgba(229,221,213,.94)),
                url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='60' height='60'><circle cx='8' cy='8' r='1.5' fill='%23a89e92' opacity='.4'/></svg>");
            padding: 1rem 1rem 1.2rem;
            min-height: 90px;
        }
        .wa-bubble {
            background: #fff;
            padding: .7rem .9rem;
            border-radius: 0 10px 10px 10px;
            box-shadow: 0 1px 1px rgba(0,0,0,.08);
            font-size: .9rem;
            color: #303030;
            max-width: 90%;
            margin-bottom: .35rem;
            position: relative;
        }
        .wa-bubble::before {
            content: '';
            position: absolute;
            top: 0; left: -7px;
            width: 0; height: 0;
            border-style: solid;
            border-width: 0 7px 7px 0;
            border-color: transparent #fff transparent transparent;
        }
        .wa-bubble-name { font-size: .72rem; font-weight: 700; color: var(--wa-color, #25d366); margin-bottom: 2px; }
        .wa-bubble-time { font-size: .65rem; color: #8a8a8a; text-align: right; margin-top: 4px; }
        .wa-card-footer {
            background: #f6f6f6;
            padding: .65rem 1rem;
            display: flex;
            justify-content: flex-end;
        }
        .wa-cta {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--wa-color, #25d366);
            color: #fff !important;
            padding: .55rem 1rem;
            border-radius: 30px;
            font-size: .85rem;
            font-weight: 600;
            text-decoration: none;
            transition: filter .2s;
        }
        .wa-cta:hover { filter: brightness(1.08); color: #fff; }

        .wa-button {
            width: 60px; height: 60px;
            border-radius: 50%;
            background: var(--wa-color, #25d366);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.85rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(37,211,102,.4), 0 4px 10px rgba(0,0,0,.18);
            transition: transform .2s;
            position: relative;
        }
        .wa-button:hover { transform: scale(1.06); }
        .wa-button .wa-pulse {
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px solid var(--wa-color, #25d366);
            opacity: .55;
            animation: waPulse 2.2s ease-out infinite;
        }
        @keyframes waPulse {
            0%   { transform: scale(.9); opacity: .6; }
            70%  { transform: scale(1.4); opacity: 0; }
            100% { transform: scale(1.4); opacity: 0; }
        }

        @media (max-width: 575px) {
            .wa-fab { bottom: 16px; }
            .wa-fab.wa-right { right: 16px; }
            .wa-fab.wa-left  { left: 16px; }
            .wa-card { width: 280px; }
        }

        /* ====== UTIL ====== */
        .text-bronze { color: var(--bronze-dark); }
        .text-gold { color: var(--gold); }
        .text-ink { color: var(--ink); }
        .bg-parchment { background: var(--parchment); }
        .bg-ivory { background: var(--ivory); }
        .bg-ink { background: var(--ink); color: var(--ivory); }
        .border-bronze { border-color: var(--bronze) !important; }

        /* legacy admin/auth view aliases */
        .hero-title { font-family: {!! $displayStack !!}; font-weight: 700; color: var(--ivory); }
        .hero-subtitle { color: rgba(250,246,236,.85); }
        .btn-hero-primary { background: var(--gold); color: var(--ink); padding: .9rem 2rem; font-weight: 600; text-decoration: none; display: inline-block; letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; font-family: 'Inter',sans-serif; }
        .btn-hero-outline { background: transparent; color: var(--ivory); border: 1.5px solid var(--ivory); padding: .9rem 2rem; font-weight: 600; text-decoration: none; display: inline-block; letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; font-family: 'Inter',sans-serif; margin-left: .5rem; }
        .advantage-icon { width: 64px; height: 64px; background: var(--ink); color: var(--gold); border-radius: 50%; display:flex; align-items:center; justify-content:center; font-size:1.5rem; margin-bottom:1rem; }
        .course-card { border:none; border-radius:0; box-shadow:0 4px 24px rgba(26,22,18,.08); transition: transform .25s, box-shadow .25s; overflow:hidden; }
        .course-card:hover { transform: translateY(-4px); box-shadow:0 14px 40px rgba(26,22,18,.18); }
        .testimonial-card { background:#fff; border-radius:0; box-shadow:0 4px 22px rgba(26,22,18,.07); padding:2.5rem 2rem; position:relative; border-top: 2px solid var(--bronze); }
        .testimonial-card::before { content:'\201C'; font-family: 'Cormorant Garamond', serif; font-size:5rem; color: var(--bronze); line-height:1; position:absolute; top:0; left:1.5rem; opacity:.7; }

        [dir="rtl"] .hero-section .btn-hero-primary { margin-right: 0; margin-left: .75rem; }
        [dir="rtl"] .wa-fab.wa-right { right: auto; left: 24px; }
        [dir="rtl"] .wa-fab.wa-left { left: auto; right: 24px; }

        /* ============================================================
           IMAGE PERFORMANCE
           ============================================================ */
        img { max-width: 100%; height: auto; }

        /* ============================================================
           MOBILE — APP-LIKE FEEL
           ============================================================ */
        @media (max-width: 991px) {
            body { font-size: 1.05rem; line-height: 1.7; }
            .top-bar { display: none !important; }

            .gramma-navbar {
                padding: .55rem 0;
                background: rgba(250,246,236,.98);
            }
            .gramma-navbar .navbar-brand { font-size: 1.05rem; letter-spacing: .08em; gap: .4rem; }
            .gramma-navbar .navbar-brand .brand-mark { width:32px; height:32px; font-size:.85rem; }
            .gramma-navbar .navbar-brand small { font-size: .45rem; letter-spacing: .22em; }
            .gramma-navbar .container { display: flex; align-items: center; flex-wrap: nowrap; }

            /* Slide-down mobile menu becomes full panel */
            #navMain {
                position: fixed;
                top: 65px; left: 0; right: 0;
                background: var(--ivory);
                max-height: calc(100vh - 65px);
                overflow-y: auto;
                border-top: 1px solid var(--line);
                box-shadow: 0 10px 30px rgba(0,0,0,.08);
                padding: 1.5rem 1.25rem 2.5rem;
                z-index: 1051;        /* above everything else when open */
                -webkit-overflow-scrolling: touch;
            }
            #navMain .nav-link {
                font-size: .95rem !important;
                padding: 1rem .25rem !important;
                min-height: 48px;     /* iOS tap target */
                display: flex;
                align-items: center;
                border-bottom: 1px solid var(--line);
                letter-spacing: .12em;
            }
            #navMain .nav-link.is-current::after { display: none; }
            #navMain .nav-link.is-current { color: var(--bronze-dark) !important; }
            #navMain .nav-link.is-current::before { content: '— '; }
            /* Hamburger button needs a proper tap area */
            .navbar-toggler {
                padding: .5rem .75rem !important;
                min-width: 48px; min-height: 48px;
                display: inline-flex; align-items: center; justify-content: center;
                z-index: 1052;       /* above the mobile menu */
                position: relative;
            }
            .navbar-toggler:focus { outline: none; box-shadow: none; }

            .lang-pivot { margin: .75rem 0; }
            .lang-globe-btn { padding: .65rem 1rem; font-size: .8rem; }

            .btn-nav-cta {
                display: block;
                width: 100%;
                text-align: center;
                margin-top: 1rem;
                padding: .9rem 1rem !important;
            }
        }

        @media (max-width: 575px) {
            .section { padding: 3.5rem 0 !important; }
            .btn-classical, .btn-classical-outline, .btn-classical-dark {
                padding: .85rem 1.4rem;
                font-size: .72rem;
                letter-spacing: .18em;
            }
            .wa-fab { bottom: 16px; }
            .wa-fab.wa-right { right: 14px; }
            .wa-fab.wa-left  { left: 14px; }
            .wa-button { width: 56px; height: 56px; font-size: 1.7rem; }
            .wa-card { width: calc(100vw - 32px); }

            .gramma-footer { padding: 3.5rem 0 1.5rem; }
            .gramma-footer h5 { font-size: .75rem; }
            .footer-brand { font-size: 1.3rem; }
        }

        /* Tap targets */
        @media (hover: none) {
            a, button { -webkit-tap-highlight-color: rgba(168,120,65,.15); }
        }

        /* ============================================================
           SMARTPHONE — APP-LIKE EXPERIENCE
           ============================================================ */
        @media (max-width: 575px) {
            /* Safe-area for notched devices */
            body { padding-bottom: env(safe-area-inset-bottom); }
            .gramma-navbar { padding-top: env(safe-area-inset-top); }

            /* Tighter, mobile-first containers */
            .container { padding-left: 1.25rem; padding-right: 1.25rem; }

            /* Hero — phone-app feel */
            .hero-classical { min-height: 88vh; padding: 4rem 0 3.5rem; }
            .hero-classical .hero-greek { font-size: 12rem; top: 6%; right: -8%; opacity: .8; }
            .hero-headline { font-size: 2rem !important; line-height: 1.12; }
            .hero-lede { font-size: 1.05rem; }
            .hero-eyebrow { font-size: .72rem; letter-spacing: .32em; }
            .hero-cta-row { flex-direction: column; gap: .75rem; }
            .hero-cta-row a { width: 100%; justify-content: center; text-align: center; }
            .hero-langs-strip { margin-top: 2.5rem; gap: 1.25rem; padding-top: 1.5rem; }
            .hero-langs-strip .lang-item { font-size: .72rem; gap: .4rem; }
            .hero-langs-strip .lang-glyph { font-size: 1.15rem; }

            /* Sections */
            .section, .lang-offerings, .pillars, .reviews, .manuscript-banner, .cta-band, .manifesto {
                padding: 3rem 0 !important;
            }
            .section-title-classical, .section-title { font-size: 1.6rem !important; line-height: 1.2; }
            .ornament::before, .ornament::after { flex-basis: 36px; }

            /* Buttons — full-width app style */
            .btn-classical, .btn-classical-outline, .btn-classical-dark {
                width: 100%; justify-content: center; padding: .95rem 1.4rem;
                font-size: .75rem; letter-spacing: .2em;
            }
            .d-inline-flex.flex-wrap.gap-3 > a { width: 100%; justify-content: center; }

            /* Cards stretched edge to edge */
            .row.g-4 > [class*="col-"] { margin-bottom: .5rem; }
            .lang-card { height: 320px; }
            .lang-card .content { padding: 1.5rem 1.25rem; }
            .lang-card .glyph { font-size: 2.4rem; }
            .lang-card .name { font-size: 1.05rem; }

            /* Testimonials / reviews */
            .review-card, .testimonial-card { padding: 1.75rem 1.25rem; }
            .review-card blockquote { font-size: 1.05rem; }

            /* Course/Event/Glossary cards */
            .cl-card .body { padding: 1.5rem 1.25rem; }
            .cl-card h3 { font-size: 1.1rem; }
            .cl-card .desc { font-size: 1rem; }
            .cl-card .meta-row { flex-direction: column; gap: .5rem; }

            /* Promo topbar */
            .promo-topbar .container { padding: .5rem 1rem; gap: .5rem; flex-direction: column; align-items: flex-start; }
            .promo-topbar span { font-size: .85rem !important; }

            /* Footer */
            .gramma-footer { padding: 3rem 0 2rem; text-align: center; }
            .gramma-footer .footer-social { justify-content: center; display: flex; }
            .gramma-footer p { font-size: 1rem; }

            /* Cleaner footer brand */
            .footer-brand { justify-content: center; display: flex; }

            /* Tighten the manifest first letter so it doesn't overflow */
            .manifesto .lede-quote { padding-left: 1.2rem; font-size: 1.15rem; }
            .manifesto .lede-quote::first-letter { font-size: 3rem; padding-right: .5rem; padding-top: .3rem; }

            /* App-like sticky nav appearance */
            .gramma-navbar.scrolled { box-shadow: 0 4px 16px rgba(0,0,0,.08); }
        }

        /* ============================================================
           IPHONE/ANDROID PORTRAIT (under 415)
           ============================================================ */
        @media (max-width: 414px) {
            .gramma-navbar .navbar-brand .d-flex { display: none !important; }  /* hide text, keep glyph */
            .container { padding-left: 1rem; padding-right: 1rem; }
            .section { padding: 2.5rem 0 !important; }
            .hero-classical { min-height: 84vh; padding: 3rem 0 3rem; }
            .hero-headline { font-size: 1.7rem !important; }
            .lang-card { height: 280px; }
            .section-title-classical { font-size: 1.4rem !important; }
            .wa-fab { bottom: 14px; }
            .wa-fab.wa-right { right: 14px; }
        }

        /* Reduced motion respect */
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- PROMO TOPBAR (active promotions) --}}
@if($topbarPromos->isNotEmpty())
    @foreach($topbarPromos as $promo)
        <a href="{{ $promo->cta_url ?: '#' }}"
           class="promo-topbar d-block text-decoration-none"
           style="background: {{ $promo->cor_fundo }}; color: {{ $promo->cor_texto }};">
            <div class="container d-flex align-items-center justify-content-center flex-wrap gap-3 py-2">
                @if($promo->t('badge_texto'))
                    <span style="font-family:'Cormorant SC',serif; font-size:.72rem; letter-spacing:.3em; text-transform:uppercase; padding:.2rem .65rem; border:1px solid {{ $promo->cor_destaque }}; color: {{ $promo->cor_destaque }};">
                        {{ $promo->t('badge_texto') }}
                    </span>
                @endif
                <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.05rem;">
                    {{ $promo->t('titulo') }}
                </span>
                @if($promo->codigo_promo)
                    <span style="font-family:'Cinzel',serif; font-size:.75rem; letter-spacing:.18em; padding:.2rem .6rem; background: {{ $promo->cor_destaque }}; color: {{ $promo->cor_fundo }};">
                        {{ $promo->codigo_promo }}
                    </span>
                @endif
                <span style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.3em; text-transform:uppercase; color: {{ $promo->cor_destaque }};">
                    {{ $promo->t('cta_texto') ?: 'Ver mais' }} →
                </span>
            </div>
        </a>
    @endforeach
@endif

{{-- TOP UTILITY BAR --}}
<div class="top-bar d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <div>
            @if($settings->email_institucional)
                <a href="mailto:{{ $settings->email_institucional }}"><i class="far fa-envelope me-2"></i>{{ $settings->email_institucional }}</a>
            @endif
            @if($settings->telefone)
                <span class="sep">|</span>
                <a href="tel:{{ preg_replace('/\s+/', '', $settings->telefone) }}"><i class="fas fa-phone-alt me-2"></i>{{ $settings->telefone }}</a>
            @endif
        </div>
        <div>
            @if($settings->cidade)
                <span><i class="fas fa-map-marker-alt me-2"></i>{{ $settings->cidade }}{{ $settings->pais ? ' — ' . $settings->pais : '' }}</span>
            @endif
        </div>
    </div>
</div>

{{-- NAVBAR --}}
<nav class="gramma-navbar navbar navbar-expand-lg" id="grammaNavbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            @if($settings->logo)
                <img src="{{ Storage::url($settings->logo) }}" alt="{{ $settings->nome_site ?? 'Gramma' }}" style="height:42px; width:auto;">
            @else
                <span class="brand-mark">Γ</span>
                <span class="d-flex flex-column" style="line-height:1;">
                    <span>Gramma</span>
                    <small>Institute of Languages</small>
                </span>
            @endif
        </a>
        @php
            $langs = [
                'pt_BR' => ['flag' => 'br', 'name' => 'Português',  'native' => 'Português (BR)'],
                'en'    => ['flag' => 'gb', 'name' => 'English',     'native' => 'English'],
                'es'    => ['flag' => 'es', 'name' => 'Español',    'native' => 'Español'],
                'he'    => ['flag' => 'il', 'name' => 'Hebrew',     'native' => 'עברית'],
                'el'    => ['flag' => 'gr', 'name' => 'Greek',      'native' => 'Ελληνικά'],
                'la'    => ['flag' => 'va', 'name' => 'Latin',      'native' => 'Latīna'],
            ];
            $currentLang = $langs[app()->getLocale()] ?? $langs['pt_BR'];
        @endphp

        {{-- Always-visible actions on mobile (right side of brand, BEFORE hamburger) --}}
        <div class="nav-mobile-actions d-flex d-lg-none align-items-center gap-2">
            <button type="button" class="lang-globe-btn mobile-globe" id="langGlobeBtnMobile" aria-label="{{ __('site.language_select') }}" aria-expanded="false">
                <i class="fas fa-globe lang-globe-icon"></i>
                <span class="lang-globe-flag fi fi-{{ $currentLang['flag'] }}"></span>
            </button>
            @auth
                <a class="btn btn-nav-cta mobile-cta" href="{{ route('dashboard') }}">{{ __('site.nav_dashboard') }}</a>
            @else
                <a class="btn btn-nav-cta mobile-cta" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i>{{ __('site.nav_login') }}</a>
            @endauth
            <button class="navbar-toggler" type="button" id="navToggler" aria-label="Menu" aria-controls="navMain" aria-expanded="false" style="border:none;">
                <i class="fas fa-bars" id="navTogglerIcon" style="color:var(--ink); font-size:1.3rem;"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'is-current' : '' }}" href="{{ route('home') }}">{{ __('site.nav_home') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('courses*') ? 'is-current' : '' }}" href="{{ route('courses') }}">{{ __('site.nav_courses') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('events*') ? 'is-current' : '' }}" href="{{ route('events.index') }}">{{ __('site.nav_events') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('glossary*') ? 'is-current' : '' }}" href="{{ route('glossary.index') }}">{{ __('site.nav_glossary') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('founder') ? 'is-current' : '' }}" href="{{ route('founder') }}">{{ __('site.nav_founder') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('methodology') ? 'is-current' : '' }}" href="{{ route('methodology') }}">{{ __('site.nav_methodology') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'is-current' : '' }}" href="{{ route('contact') }}">{{ __('site.nav_contact') }}</a></li>

                {{-- Desktop globe + login (hidden on mobile because we render them outside collapse) --}}
                <li class="nav-item lang-pivot mx-lg-2 d-none d-lg-block">
                    <button type="button" class="lang-globe-btn" id="langGlobeBtn" aria-label="{{ __('site.language_select') }}" aria-expanded="false">
                        <i class="fas fa-globe lang-globe-icon"></i>
                        <span class="lang-globe-flag fi fi-{{ $currentLang['flag'] }}"></span>
                        <i class="fas fa-chevron-down lang-globe-chevron"></i>
                    </button>
                </li>
                <li class="nav-item ms-lg-2 d-none d-lg-block">
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
        <div class="row g-4">
            <div class="col-lg-4 mb-3">
                <div class="footer-brand">
                    <span style="display:inline-flex; align-items:center; gap:.7rem;">
                        <span style="display:inline-flex; width:42px; height:42px; align-items:center; justify-content:center; border:1.5px solid var(--gold-light); border-radius:50%; font-size:1.05rem;">Γ</span>
                        Gramma
                    </span>
                </div>
                <p style="color:rgba(250,246,236,.7); font-style: italic;">
                    {{ $settings->descricao_site ?? __('site.hero_subtitle') }}
                </p>
                <div class="footer-social mt-3">
                    @if($settings->facebook)  <a href="{{ $settings->facebook }}" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a> @endif
                    @if($settings->instagram) <a href="{{ $settings->instagram }}" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a> @endif
                    @if($settings->linkedin)  <a href="{{ $settings->linkedin }}" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a> @endif
                    @if($settings->youtube)   <a href="{{ $settings->youtube }}" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a> @endif
                    @if($settings->tiktok)    <a href="{{ $settings->tiktok }}" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i></a> @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-4 mb-3">
                <h5>{{ __('site.nav_courses') }}</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('courses') }}">{{ __('site.course_portuguese') }}</a></li>
                    <li><a href="{{ route('courses') }}">{{ __('site.course_english') }}</a></li>
                    <li><a href="{{ route('courses') }}">{{ __('site.course_spanish') }}</a></li>
                    <li><a href="{{ route('courses') }}">{{ __('site.course_hebrew') }}</a></li>
                    <li><a href="{{ route('courses') }}">{{ __('site.course_greek') }}</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 mb-3">
                <h5>{{ __('site.nav_contact') }}</h5>
                @if($settings->email_institucional)
                    <p><i class="far fa-envelope me-2 text-gold"></i> {{ $settings->email_institucional }}</p>
                @endif
                @if($settings->telefone)
                    <p><i class="fas fa-phone-alt me-2 text-gold"></i> {{ $settings->telefone }}</p>
                @endif
                @if($settings->cidade)
                    <p><i class="fas fa-map-marker-alt me-2 text-gold"></i> {{ $settings->cidade }}{{ $settings->pais ? ', ' . $settings->pais : '' }}</p>
                @endif
            </div>
            <div class="col-lg-2 col-md-4 mb-3">
                <h5>Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about') }}">{{ __('site.nav_about') }}</a></li>
                    <li><a href="{{ route('methodology') }}">{{ __('site.nav_methodology') }}</a></li>
                    <li><a href="{{ route('privacy') }}">{{ __('site.footer_privacy') }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ __('site.footer_terms') }}</a></li>
                </ul>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row">
            <div class="col footer-bottom text-center">
                {{ $settings->texto_rodape ?? ('© ' . date('Y') . ' Gramma Institute · ' . __('site.footer_rights')) }}
            </div>
        </div>
    </div>
</footer>

{{-- WHATSAPP FLOATING WIDGET --}}
@if($waLink)
@php
    $waPos     = $settings->whatsapp_posicao === 'left' ? 'wa-left' : 'wa-right';
    $waColor   = $settings->whatsapp_cor ?: '#25d366';
    $waTitle   = $settings->whatsapp_titulo_widget    ?: __('site.contact_title');
    $waSub     = $settings->whatsapp_subtitulo_widget ?: __('site.contact_subtitle');
    $waName    = $settings->whatsapp_atendente_nome   ?: 'Gramma Institute';
    $waCargo   = $settings->whatsapp_atendente_cargo;
    $waMsg     = $settings->whatsapp_mensagem_padrao  ?: __('site.hero_subtitle');
@endphp
<div class="wa-fab {{ $waPos }}" id="waFab" style="--wa-color: {{ $waColor }};">
    <div class="wa-card" role="dialog" aria-label="WhatsApp">
        <div class="wa-card-header">
            <div class="wa-avatar"><i class="fab fa-whatsapp"></i></div>
            <div>
                <div class="wa-card-title">{{ $waTitle }}</div>
                <div class="wa-card-sub">{{ $waSub }}</div>
            </div>
            <button type="button" class="wa-card-close" aria-label="Fechar" id="waClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="wa-card-body">
            <div class="wa-bubble">
                <div class="wa-bubble-name">{{ $waName }}@if($waCargo) <span style="color:#777; font-weight:500;"> · {{ $waCargo }}</span>@endif</div>
                <div>{{ $waMsg }}</div>
                <div class="wa-bubble-time">{{ now()->format('H:i') }}</div>
            </div>
        </div>
        <div class="wa-card-footer">
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="wa-cta">
                <i class="fab fa-whatsapp"></i> {{ __('site.contact_send') }}
            </a>
        </div>
    </div>
    <button type="button" class="wa-button" id="waToggle" aria-label="WhatsApp">
        <span class="wa-pulse"></span>
        <i class="fab fa-whatsapp"></i>
    </button>
</div>
@endif

{{-- LANGUAGE PANEL --}}
<div class="lang-panel-backdrop" id="langPanelBackdrop"></div>
<aside class="lang-panel" id="langPanel" aria-hidden="true">
    <div class="lang-panel-header">
        <div class="lang-panel-title">
            <i class="fas fa-globe"></i>
            {{ __('site.language_select') }}
        </div>
        <button type="button" class="lang-panel-close" id="langPanelClose" aria-label="Fechar">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <p class="lang-panel-subtitle">
        Escolha o idioma. As suas preferências aplicam-se a todo o site.
    </p>
    <div class="lang-panel-list">
        @foreach($langs as $code => $l)
            <a href="{{ route('locale.switch', $code) }}"
               class="lang-panel-item {{ app()->getLocale() === $code ? 'is-active' : '' }}">
                <span class="fi fi-{{ $l['flag'] }}"></span>
                <div class="lang-panel-item-text">
                    <div class="lang-panel-item-native">{{ $l['native'] }}</div>
                    <div class="lang-panel-item-name">{{ $l['name'] }}</div>
                </div>
                @if(app()->getLocale() === $code)
                    <i class="fas fa-check lang-panel-item-check"></i>
                @endif
            </a>
        @endforeach
    </div>
    <div class="lang-panel-footer">
        <span class="ornament-mini">·</span>
        Gramma Institute
        <span class="ornament-mini">·</span>
    </div>
</aside>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sticky navbar shrink on scroll
    (function() {
        var nav = document.getElementById('grammaNavbar');
        if (!nav) return;
        window.addEventListener('scroll', function() {
            nav.classList.toggle('scrolled', window.scrollY > 30);
        });
    })();

    // Language panel open/close (works for desktop globe + mobile globe)
    (function() {
        var btnDesktop = document.getElementById('langGlobeBtn');
        var btnMobile  = document.getElementById('langGlobeBtnMobile');
        var panel      = document.getElementById('langPanel');
        var backdrop   = document.getElementById('langPanelBackdrop');
        var closeBtn   = document.getElementById('langPanelClose');
        if (!panel) return;

        function open()  {
            panel.classList.add('is-open');
            backdrop.classList.add('is-open');
            if (btnDesktop) btnDesktop.setAttribute('aria-expanded', 'true');
            if (btnMobile)  btnMobile.setAttribute('aria-expanded', 'true');
            panel.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
        function close() {
            panel.classList.remove('is-open');
            backdrop.classList.remove('is-open');
            if (btnDesktop) btnDesktop.setAttribute('aria-expanded', 'false');
            if (btnMobile)  btnMobile.setAttribute('aria-expanded', 'false');
            panel.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
        function toggle(e) {
            if (e) e.preventDefault();
            panel.classList.contains('is-open') ? close() : open();
        }

        if (btnDesktop) btnDesktop.addEventListener('click', toggle);
        if (btnMobile)  btnMobile.addEventListener('click', toggle);
        if (closeBtn)   closeBtn.addEventListener('click', close);
        if (backdrop)   backdrop.addEventListener('click', close);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') close();
        });

        // Safety: if a user navigates, make sure body overflow is restored
        window.addEventListener('pageshow', function() { document.body.style.overflow = ''; });
    })();

    // Mobile hamburger: vanilla JS — no Bootstrap dependency
    (function() {
        var toggler  = document.getElementById('navToggler');
        var navMenu  = document.getElementById('navMain');
        var icon     = document.getElementById('navTogglerIcon');
        if (!toggler || !navMenu) return;

        function isMobile() { return window.matchMedia('(max-width: 991px)').matches; }

        function openMenu()  {
            navMenu.classList.add('show');
            toggler.setAttribute('aria-expanded', 'true');
            if (icon) icon.className = 'fas fa-times';
            icon.style.fontSize = '1.4rem';
        }
        function closeMenu() {
            navMenu.classList.remove('show');
            toggler.setAttribute('aria-expanded', 'false');
            if (icon) icon.className = 'fas fa-bars';
            icon.style.fontSize = '1.3rem';
        }

        toggler.addEventListener('click', function(e) {
            e.preventDefault();
            navMenu.classList.contains('show') ? closeMenu() : openMenu();
        });

        // Close when a nav link is tapped
        navMenu.querySelectorAll('a').forEach(function(a) {
            a.addEventListener('click', function() {
                if (isMobile()) closeMenu();
            });
        });

        // Close on outside tap
        document.addEventListener('click', function(e) {
            if (!isMobile()) return;
            if (!navMenu.classList.contains('show')) return;
            if (navMenu.contains(e.target) || toggler.contains(e.target)) return;
            closeMenu();
        });

        // Close on window resize back to desktop
        window.addEventListener('resize', function() {
            if (!isMobile()) closeMenu();
        });
    })();

    // WhatsApp widget toggle
    (function() {
        var fab    = document.getElementById('waFab');
        if (!fab) return;
        var toggle = document.getElementById('waToggle');
        var close  = document.getElementById('waClose');
        toggle.addEventListener('click', function() { fab.classList.toggle('is-open'); });
        close.addEventListener('click', function()  { fab.classList.remove('is-open'); });
    })();
</script>
@stack('scripts')
</body>
</html>
