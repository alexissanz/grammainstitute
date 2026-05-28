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

    {{-- Premium typography:
         GFS Didot (Didot revival — primary global font),
         Bodoni Moda (Didot-style display fallback),
         Cormorant Garamond (italics + small caps support),
         Cinzel (monumental display caps),
         Noto Sans Hebrew (RTL), Noto Serif (fallback) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=GFS+Didot&family=Bodoni+Moda:ital,opsz,wght@0,6..96,400;0,6..96,500;0,6..96,600;0,6..96,700;0,6..96,800;0,6..96,900;1,6..96,400;1,6..96,500;1,6..96,600;1,6..96,700&family=Cinzel:wght@400;500;600;700;800;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Cormorant+SC:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Hebrew:wght@300;400;500;600;700&family=Noto+Serif:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    @if($isRtl)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @endif

    <style>
        :root {
            /* Monochrome palette */
            --parchment:      #ffffff;
            --parchment-2:    #f2f2f2;
            --ivory:          #ffffff;
            --ink:            #000000;
            --ink-soft:       #1a1a1a;
            --bronze:         #000000;
            --bronze-dark:    #000000;
            --gold:           #000000;
            --gold-light:     #000000;
            --burgundy:       #000000;
            --olive:          #000000;
            --stone:          #4d4d4d;
            --line:           rgba(0,0,0,.12);

            /* legacy aliases (kept so admin views that import from public CSS still work) */
            --gramma-blue:    #1a1612;
            --gramma-blue-2:  #322a20;
            --gramma-blue-3:  #4f5b35;
            --gramma-gold:    #c8a44b;
            --gramma-light:   #f5efe1;
            --gramma-text:    #1a1612;
        }

        @php
            // === DIDOT IS THE GLOBAL FONT ===
            // Stack: real "Didot" if installed → GFS Didot (Google web) → Bodoni Moda (Didot-cousin) → Cormorant → serif
            $didotStack = '"Didot","GFS Didot","Bodoni Moda","Bodoni 72","Cormorant Garamond","Noto Serif",Georgia,serif';

            $bodyStack = $locale === 'he'
                ? "'Noto Sans Hebrew',$didotStack"
                : $didotStack;
            // Display headlines: monumental Bodoni/Didot (uppercase-friendly), Cinzel as backup
            $displayStack = '"Bodoni Moda","Didot","GFS Didot","Cinzel",Georgia,serif';
            // Small-caps eyebrows — keep Cormorant SC (it has real petite caps)
            $smallCapsStack = '"Cormorant SC","Cinzel",Georgia,serif';
            // Sans for tiny UI labels only (badges, top-bar)
            $sansStack = "'Inter',system-ui,-apple-system,'Segoe UI',sans-serif";
        @endphp

        @php
            $fontMap = [
                'didot' => $didotStack,
                'bodoni' => '"Bodoni Moda","Didot","GFS Didot","Cinzel",Georgia,serif',
                'cinzel' => '"Cinzel","Bodoni Moda","Didot","GFS Didot",Georgia,serif',
                'cormorant' => '"Cormorant Garamond","GFS Didot","Bodoni Moda","Noto Serif",Georgia,serif',
                'inter' => $sansStack,
                'noto' => '"Noto Serif","Cormorant Garamond",Georgia,serif',
            ];

            $bodyStack = $fontMap[$settings->font_body_family ?: 'didot'] ?? $bodyStack;
            $displayStack = $fontMap[$settings->font_display_family ?: 'bodoni'] ?? $displayStack;
            $menuStack = $fontMap[$settings->font_menu_family ?: 'didot'] ?? $didotStack;
            $courseStack = $fontMap[$settings->font_course_family ?: 'cinzel'] ?? $displayStack;
            $footerStack = $fontMap[$settings->font_footer_family ?: 'didot'] ?? $didotStack;

            if ($locale === 'he' && ! str_contains($bodyStack, 'Noto Sans Hebrew')) {
                $bodyStack = "'Noto Sans Hebrew'," . $bodyStack;
            }

            $fontBodySize = max(14, min(24, (int) ($settings->font_body_size ?: 18)));
            $fontMenuSize = max(12, min(28, (int) ($settings->font_menu_size ?: 14)));
            $fontCourseSize = max(16, min(48, (int) ($settings->font_course_size ?: 22)));
            $fontTitleSize = max(24, min(72, (int) ($settings->font_title_size ?: 38)));
            $fontFooterSize = max(12, min(24, (int) ($settings->font_footer_size ?: 16)));
            $fontHeroIntroSize = max(28, min(120, (int) ($settings->font_hero_intro_size ?: 70)));
            $fontHeroSlideSize = max(24, min(120, (int) ($settings->font_hero_slide_size ?: 64)));
        @endphp

        :root {
            --font-site-body: {!! $bodyStack !!};
            --font-site-display: {!! $displayStack !!};
            --font-site-menu: {!! $menuStack !!};
            --font-site-course: {!! $courseStack !!};
            --font-site-footer: {!! $footerStack !!};
            --font-site-smallcaps: {!! $smallCapsStack !!};
            --font-site-sans: {!! $sansStack !!};
            --font-size-body: {{ $fontBodySize }}px;
            --font-size-menu: {{ $fontMenuSize }}px;
            --font-size-course: {{ $fontCourseSize }}px;
            --font-size-title: {{ $fontTitleSize }}px;
            --font-size-footer: {{ $fontFooterSize }}px;
            --font-size-hero-intro: {{ $fontHeroIntroSize }}px;
            --font-size-hero-slide: {{ $fontHeroSlideSize }}px;
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font-site-body);
            font-size: var(--font-size-body);
            line-height: 1.75;
            color: var(--ink);
            background: var(--ivory);
            background-image: none;
            background-attachment: fixed;
            overflow-x: hidden;
        }

        h1,h2,h3,h4,h5 { font-family: var(--font-site-display); color: var(--ink); letter-spacing: .02em; }
        .display-serif { font-family: var(--font-site-display); }
        .small-caps { font-family: var(--font-site-smallcaps); text-transform: uppercase; letter-spacing: .22em; font-weight: 600; }
        .sans { font-family: var(--font-site-sans); }

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
            display: none !important;
        }
        .top-bar a { color: rgba(245,239,225,.78); text-decoration: none; }
        .top-bar a:hover { color: var(--gold-light); }
        .top-bar .sep { opacity: .35; margin: 0 .75rem; }

        /* ====== NAVBAR (Pill / Floating layout) ====== */
        .gramma-navbar {
            background: transparent;
            border-bottom: 0;
            padding: 1.2rem 0;
            position: sticky;
            top: 0;
            z-index: 1050;
            transition: padding .25s, background .25s;
        }
        .gramma-navbar.scrolled {
            padding: .65rem 0;
            background: rgba(250,246,236,.92);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .gramma-navbar > .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            flex-wrap: nowrap;
        }
        .gramma-navbar .navbar-brand {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: .14em;
            color: var(--ink);
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-shrink: 0;
            margin: 0;
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
            font-size: .5rem;
            font-weight: 500;
            letter-spacing: .35em;
            color: var(--stone);
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* The pill that holds nav items */
        .nav-pill {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 999px;
            box-shadow: 0 6px 28px rgba(26,22,18,.07);
            padding: .35rem .6rem;
            display: inline-flex;
            align-items: center;
            gap: .15rem;
        }
        .gramma-navbar.scrolled .nav-pill {
            box-shadow: 0 4px 18px rgba(26,22,18,.08);
        }
        .nav-pill .nav-link {
            font-family: var(--font-site-menu);
            color: var(--ink);
            font-size: var(--font-size-menu);
            font-weight: 500;
            letter-spacing: .03em;
            text-transform: lowercase;
            padding: .55rem 1rem !important;
            border-radius: 999px;
            line-height: 1;
            white-space: nowrap;
            transition: background .2s, color .2s;
            text-decoration: none;
        }
        .nav-pill .nav-link:hover { background: var(--parchment); color: var(--bronze-dark); }
        .nav-pill .nav-link.is-current,
        .nav-pill .nav-link.active {
            background: var(--ink);
            color: var(--ivory);
        }
        .nav-pill .nav-link.is-current:hover { background: var(--bronze-dark); color: var(--ivory); }

        /* Outside-the-pill actions (right side) */
        .nav-actions {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            flex-shrink: 0;
        }
        .gramma-navbar .btn-nav-cta {
            font-family: {!! $sansStack !!};
            background: var(--ink);
            color: var(--ivory);
            border-radius: 999px;
            padding: .65rem 1.4rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .06em;
            border: 1.5px solid var(--ink);
            transition: all .2s;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            line-height: 1;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(26,22,18,.12);
        }
        .gramma-navbar .btn-nav-cta:hover {
            background: var(--bronze-dark);
            border-color: var(--bronze-dark);
            color: var(--ivory);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(126,82,35,.25);
        }

        /* Tight desktop: shrink pill a bit */
        @media (min-width: 992px) and (max-width: 1199px) {
            .nav-pill .nav-link { padding: .5rem .7rem !important; font-size: var(--font-size-menu); }
            .gramma-navbar .btn-nav-cta { padding: .55rem 1.1rem; font-size: .72rem; }
            .gramma-navbar .navbar-brand small { display: none; }
        }
        /* ====== MOBILE NAV ACTIONS ====== */
        .mobile-globe.lang-globe-btn {
            padding: .55rem .7rem;
            min-width: 44px; min-height: 44px;
        }
        .mobile-cta {
            padding: .55rem .85rem !important;
            font-size: .72rem !important;
            min-height: 44px;
            min-width: 44px;
            justify-content: center;
            text-decoration: none;
        }
        @media (max-width: 360px) {
            .mobile-cta { padding: .55rem .65rem !important; font-size: .68rem !important; }
            .mobile-cta span { display: none; }
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
            -webkit-tap-highlight-color: rgba(168,120,65,.18);
            touch-action: manipulation;     /* avoid double-tap zoom on iOS */
            position: relative;
            z-index: 2;
        }
        /* Children must not eat the click on iOS Safari */
        .lang-globe-btn > * { pointer-events: none; }
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
                bottom: 0;                                /* anchor at viewport bottom */
                right: 0; left: 0;
                width: 100%;
                max-width: 100%;
                height: auto;
                max-height: 80vh;
                border-radius: 20px 20px 0 0;
                transform: translateY(100%);
                box-shadow: 0 -18px 60px rgba(0,0,0,.25);
                padding-bottom: env(safe-area-inset-bottom);
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
            background: #ffffff;
            color: #000000;
            border: 1.5px solid #ffffff;
            border-radius: 0;
            text-decoration: none;
            transition: all .25s;
        }
        .btn-classical:hover { background: transparent; color: #ffffff; border-color: #ffffff; }
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
            font-family: var(--font-site-display);
            font-weight: 600;
            font-size: clamp(1.85rem, 3.2vw, var(--font-size-title));
            line-height: 1.18;
            letter-spacing: .01em;
            color: var(--ink);
            margin-bottom: .5rem;
        }
        .section-dark .section-title-classical,
        .section-ink .section-title-classical { color: var(--ivory); }

        /* legacy aliases used by inner pages */
        .section-title { font-family: var(--font-site-display); font-weight: 600; color: var(--ink); font-size: clamp(1.6rem, 3vw, var(--font-size-title)); }
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
            color: #ffffff;
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
            color: #ffffff;
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .26em;
            text-transform: uppercase;
            margin-bottom: 1.4rem;
        }
        .gramma-footer p { font-size: 1rem; line-height: 1.7; color: #ffffff; }
        .gramma-footer a {
            color: #ffffff;
            text-decoration: none;
            transition: color .2s;
            font-size: 1rem;
        }
        .gramma-footer a:hover { color: #ffffff; }
        .gramma-footer ul.list-unstyled li { margin-bottom: .55rem; }
        .gramma-footer .footer-divider {
            border: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(250,246,236,.18), transparent);
            margin: 3rem 0 1.5rem;
        }
        .gramma-footer .footer-bottom {
            font-family: var(--font-site-footer);
            font-size: var(--font-size-footer);
            letter-spacing: .04em;
            text-transform: none;
            color: #ffffff;
        }
        .footer-meta-stack {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            text-align: center;
        }
        .gramma-footer .footer-divider + .row {
            justify-content: center;
            text-align: center;
            row-gap: .65rem;
        }
        .gramma-footer .footer-divider + .row > [class*="col-"] {
            flex: 0 0 100%;
            max-width: 100%;
            text-align: center !important;
        }
        .gramma-footer .footer-divider + .row > .col-md-auto.text-center.text-md-end {
            order: 2;
        }
        .gramma-footer .footer-divider + .row > .col-md.footer-bottom.text-center {
            order: 3;
        }
        .footer-brand {
            font-family: 'Cinzel', serif;
            font-size: 1.6rem;
            letter-spacing: .14em;
            color: var(--ivory);
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .footer-brand-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .footer-brand-text {
            color: #ffffff;
            font-style: normal;
            font-family: var(--font-site-footer);
            font-size: var(--font-size-footer);
            text-align: center;
            margin: 0 auto;
            max-width: 420px;
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
                padding: .65rem 0;
                background: rgba(255,255,255,.96);
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
                border-bottom: 1px solid rgba(0,0,0,.08);
            }
            .gramma-navbar .navbar-brand { font-size: 1.05rem; letter-spacing: .08em; gap: .4rem; }
            .gramma-navbar .navbar-brand .brand-mark { width:32px; height:32px; font-size:.85rem; }
            .gramma-navbar .navbar-brand small { font-size: .45rem; letter-spacing: .22em; }
            .gramma-navbar .container { display: flex; align-items: center; flex-wrap: nowrap; }

            /* Slide-down mobile menu becomes full panel */
            #navMain {
                position: fixed;
                top: 72px; left: 12px; right: 12px;
                background: var(--ivory);
                max-height: calc(100vh - 88px);
                overflow-y: auto;
                border: 1px solid rgba(0,0,0,.08);
                border-radius: 26px;
                box-shadow: 0 18px 48px rgba(0,0,0,.14);
                padding: 1.1rem 1rem 1.5rem;
                z-index: 1051;        /* above everything else when open */
                -webkit-overflow-scrolling: touch;
            }
            #navMain .navbar-nav { gap: .35rem; }
            #navMain .nav-link {
                font-size: .92rem !important;
                padding: 1rem 1rem !important;
                min-height: 54px;     /* iOS tap target */
                display: flex;
                align-items: center;
                border: 1px solid rgba(0,0,0,.06);
                border-radius: 16px;
                background: #fff;
                letter-spacing: .12em;
            }
            #navMain .nav-link.is-current::after { display: none; }
            #navMain .nav-link.is-current {
                color: #ffffff !important;
                background: #000000;
                border-color: #000000;
            }
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
                padding: 1rem 1rem !important;
                min-height: 52px;
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
            .container { padding-left: 1rem; padding-right: 1rem; }
            #navMain {
                left: 10px;
                right: 10px;
                top: 68px;
                max-height: calc(100vh - 82px);
                border-radius: 22px;
                padding: .9rem .85rem 1.25rem;
            }
            #navMain .nav-link {
                min-height: 52px;
                font-size: .86rem !important;
                padding: .95rem .95rem !important;
                letter-spacing: .1em;
            }

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
            .gramma-footer .row.g-4 {
                row-gap: 1rem !important;
            }
            .gramma-footer .row.g-4 > [class*="col-"] {
                background: #050505;
                border: 1px solid rgba(255,255,255,.08);
                border-radius: 22px;
                padding: 1.4rem 1.2rem;
                margin-bottom: 0 !important;
            }
            .gramma-footer .footer-social { justify-content: center; display: flex; }
            .gramma-footer p { font-size: 1rem; }
            .gramma-footer ul { margin-bottom: 0; }
            .gramma-footer li + li { margin-top: .45rem; }

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
            .nav-pill .nav-link,
            .footer-login-btn,
            .footer-credit-link {
                min-height: 48px;
            }
            .gramma-footer .row.g-4 > [class*="col-"] {
                border-radius: 18px;
                padding: 1.15rem 1rem;
            }
        }

        @media (hover: none) and (pointer: coarse) {
            .course-card:hover,
            .cl-card:hover,
            .lang-card:hover,
            .review-card:hover,
            .testimonial-card:hover {
                transform: none !important;
                box-shadow: inherit !important;
            }
        }

        /* ============================================================
           NAV DROPDOWNS — About Us (simple list) + Resources (mega)
           ============================================================ */
        .nav-pill .nav-dd { position: relative; display: inline-flex; }
        .nav-pill .nav-dd-toggle {
            background: transparent;
            border: 0;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            font: inherit;
            font-family: var(--font-site-menu);
            font-size: var(--font-size-menu);
            color: inherit;
            text-transform: lowercase;
        }
        .nav-pill .nav-dd-toggle .nav-dd-chev {
            display: inline-block !important;
            font-style: normal;
            font-size: .78rem;
            line-height: 1;
            opacity: .85;
        }
        .nav-pill .nav-dd-toggle.is-current,
        .nav-pill .is-current-parent .nav-dd-toggle {
            background: var(--ink) !important;
            color: var(--ivory) !important;
        }

        .nav-pill .nav-dd-panel {
            position: absolute;
            top: calc(100% + 14px);
            left: 50%;
            transform: translateX(-50%) translateY(8px);
            background: #fff;
            border: 1px solid var(--line);
            border-top: 2px solid var(--bronze);
            box-shadow: 0 22px 50px rgba(26,22,18,.16);
            min-width: 280px;
            padding: .5rem 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity .18s, transform .18s;
            z-index: 1060;
        }
        .nav-pill .nav-dd.is-open .nav-dd-panel {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(-50%) translateY(0);
        }
        .nav-pill .nav-dd-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .65rem 1.1rem;
            font-family: var(--font-site-menu);
            font-size: var(--font-size-menu);
            color: var(--ink);
            text-transform: lowercase;
            text-decoration: none;
            white-space: nowrap;
            transition: background .15s, color .15s;
        }
        .nav-pill .nav-dd-item:hover { background: var(--parchment); color: var(--bronze-dark); }
        .nav-pill .nav-dd-item i { display: none !important; }
        .nav-pill .nav-dd-sep { height: 1px; background: var(--line); margin: .35rem .75rem; }

        /* Mega menu (Resources) — nested accordion: category headers expand inline */
        .nav-pill .nav-dd-mega-panel {
            min-width: 360px;
            max-width: 90vw;
            padding: .35rem 0;
        }
        .nav-pill .nav-dd-cat { border-bottom: 1px solid var(--line); }
        .nav-pill .nav-dd-cat:last-child { border-bottom: 0; }
        .nav-pill .nav-dd-cat-toggle {
            display: flex;
            align-items: center;
            gap: .75rem;
            width: 100%;
            padding: .8rem 1.1rem;
            background: transparent;
            border: 0;
            cursor: pointer;
            text-align: left;
            font-family: var(--font-site-menu);
            font-size: var(--font-size-menu);
            font-weight: 500;
            color: var(--ink);
            transition: background .15s, color .15s;
        }
        .nav-pill .nav-dd-cat-toggle:hover {
            background: var(--parchment);
            color: var(--bronze-dark);
        }
        .nav-pill .nav-dd-cat-ico { display: none !important; }
        .nav-pill .nav-dd-cat-title { flex: 1; text-transform: lowercase; }
        .nav-pill .nav-dd-cat-count {
            font-family: 'Cormorant SC', serif;
            font-size: .65rem;
            letter-spacing: .2em;
            color: var(--stone);
            background: var(--parchment);
            padding: .15rem .5rem;
            border-radius: 999px;
        }
        .nav-pill .nav-dd-cat-chev { display: none !important; }

        .nav-pill .nav-dd-cat-links {
            display: none;
            background: var(--parchment);
            padding: .5rem 0 .85rem;
            border-top: 1px solid var(--line);
        }
        .nav-pill .nav-dd-cat.is-cat-open .nav-dd-cat-links { display: block; }
        .nav-pill .nav-dd-cat-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .5rem 1.1rem .5rem 3.2rem;
            font-family: var(--font-site-menu);
            font-size: var(--font-size-menu);
            color: var(--ink) !important;          /* dark text on cream parchment */
            text-transform: lowercase;
            text-decoration: none;
            transition: background .15s, color .15s;
        }
        .nav-pill .nav-dd-cat-link:hover {
            background: rgba(168,120,65,.12);
            color: var(--bronze-dark) !important;
        }
        .nav-pill .nav-dd-cat-link i { display: none !important; }
        .nav-pill .nav-dd-cat-empty {
            display: block;
            padding: .55rem 1.1rem .55rem 3.2rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: .85rem;
            color: var(--stone);
        }

        /* Nested mobile sub (category accordion inside Resources accordion) */
        .nav-mobile-cat { margin: .25rem 0; }
        .nav-mobile-cat-toggle {
            display: flex !important;
            align-items: center;
            gap: .55rem;
            width: 100%;
            padding: .55rem .5rem;
            background: transparent;
            border: 0;
            cursor: pointer;
            font-family: var(--font-site-menu);
            font-size: var(--font-size-menu);
            color: var(--ink);
            text-transform: lowercase;
            text-align: left;
        }
        .nav-mobile-cat-toggle i { display: none !important; }
        .nav-mobile-cat-links {
            padding: .25rem 0 .25rem 1.25rem;
            border-left: 2px solid var(--bronze);
            margin-left: 1rem;
        }
        .nav-mobile-cat-links a {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem 0 .5rem .5rem;
            font-family: var(--font-site-menu);
            font-size: var(--font-size-menu);
            color: var(--ink);
            text-transform: lowercase;
            text-decoration: none;
        }
        .nav-mobile-cat-links a i { display: none !important; }
        .nav-mobile-empty {
            display: block;
            padding: .5rem 0 .5rem .5rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: .82rem;
            color: var(--stone);
        }

        /* Mobile accordion sub-menu (About + Resources) */
        .nav-mobile-group { display: flex; flex-direction: column; }
        .nav-mobile-toggle {
            background: transparent;
            border: 0;
            text-align: left;
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            cursor: pointer;
            font-family: var(--font-site-menu);
            font-size: var(--font-size-menu);
            color: inherit;
            text-transform: lowercase;
        }
        .nav-mobile-toggle i {
            display: inline-block !important;
            font-style: normal;
            font-size: .78rem;
            line-height: 1;
            opacity: .85;
        }
        .nav-mobile-sub {
            display: none;
            padding: .25rem 0 .5rem .75rem;
            border-left: 2px solid var(--bronze);
            margin-left: .25rem;
            margin-bottom: .5rem;
        }
        .nav-mobile-group.is-open .nav-mobile-sub { display: block; }
        .nav-mobile-sub a {
            display: block;
            padding: .55rem 0 .55rem 1rem;
            font-family: var(--font-site-menu);
            font-size: var(--font-size-menu);
            color: var(--ink);
            text-transform: lowercase;
            text-decoration: none;
        }
        .nav-mobile-sub a:hover { color: var(--bronze-dark); }

        .nav-pill .nav-link,
        .nav-pill .nav-dd-toggle,
        .nav-pill .nav-dd-item,
        .nav-pill .nav-dd-cat-toggle,
        .nav-pill .nav-dd-cat-link,
        .nav-mobile-toggle,
        .nav-mobile-sub a,
        .nav-mobile-cat-toggle,
        .nav-mobile-cat-links a {
            font-family: var(--font-site-menu) !important;
            font-size: var(--font-size-menu) !important;
            font-weight: 500 !important;
            letter-spacing: .03em !important;
            line-height: 1.1 !important;
            text-transform: lowercase !important;
        }

        /* Reduced motion respect */
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }

        /* ============================================================
           TYPOGRAPHIC LOGO — /gil/ | GRAMMA INSTITUTE
           Pure HTML/CSS, no images, no SVG, no effects.
           ============================================================ */
        .gil-logo {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            color: #000;
            font-family: "Bodoni Moda","Didot","GFS Didot","Cormorant Garamond","Noto Serif",Georgia,serif;
            line-height: 1;
            text-decoration: none;
            white-space: nowrap;
        }
        .gil-logo:hover { color: #000; text-decoration: none; }

        .gil-logo__left {
            font-family: "Bodoni Moda","Didot","GFS Didot","Cormorant Garamond",Georgia,serif;
            font-size: 2.6rem;
            font-weight: 400;
            letter-spacing: -0.005em;
            line-height: 1;
            text-transform: lowercase;     /* keep "gil" lowercase even inside navbar */
        }
        .gil-logo__left .gil-slash {
            /* slashes inherit the same weight as the rest of /gil/ — back to normal */
            display: inline-block;
            padding: 0 0.02em;
        }

        .gil-logo__divider {
            align-self: stretch;
            width: 1px;
            background: currentColor;
        }

        .gil-logo__right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;          /* centre the three lines horizontally */
            gap: 0.25rem;
            text-align: center;
        }

        .gil-logo__main {
            font-family: "Bodoni Moda","Didot","GFS Didot",Georgia,serif;
            font-size: 0.92rem;
            font-weight: 500;
            letter-spacing: 0.34em;
            text-transform: uppercase;
        }

        .gil-logo__mid {
            font-family: "Bodoni Moda","Didot","GFS Didot",Georgia,serif;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.22em;
            text-transform: uppercase;
        }
        .gil-logo__mid .gil-of {
            font-style: italic;
            font-weight: 400;
            font-size: 0.78em;
            letter-spacing: 0;
            text-transform: lowercase;
            padding-right: 0.25em;
            font-family: "Cormorant Garamond","Bodoni Moda",Georgia,serif;
        }

        .gil-logo__bottom {
            font-family: "Bodoni Moda","Didot","GFS Didot",Georgia,serif;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.42em;
            text-transform: uppercase;
        }

        /* Light variant — for dark backgrounds (footer) */
        .gil-logo--light,
        .gil-logo--light:hover { color: #faf6ec; }

        /* Compact variant — for the navbar bar */
        .gil-logo--nav .gil-logo__left   { font-size: 2rem; }
        .gil-logo--nav .gil-logo__main   { font-size: 0.72rem; letter-spacing: 0.3em; }
        .gil-logo--nav .gil-logo__mid    { font-size: 0.62rem; letter-spacing: 0.18em; }
        .gil-logo--nav .gil-logo__bottom { font-size: 0.5rem;  letter-spacing: 0.34em; }
        .gil-logo--nav { gap: 0.7rem; }

        /* Navbar on tablet/mobile — show ONLY /gil/ so the Entrar/Painel button never gets pushed off.
           Footer logo keeps the full stacked version (handled below).                                */
        @media (max-width: 991px) {
            .gil-logo--nav .gil-logo__divider,
            .gil-logo--nav .gil-logo__right { display: none; }
            .gil-logo--nav { gap: 0; }
            .gil-logo--nav .gil-logo__left { font-size: 1.7rem; }
        }
        @media (max-width: 414px) {
            .gil-logo--nav .gil-logo__left { font-size: 1.45rem; }
        }

        /* Footer logo on small screens — stack elegantly */
        @media (max-width: 575px) {
            .gil-logo--light {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }
            .gil-logo--light .gil-logo__divider {
                align-self: auto;
                width: 56px;
                height: 1px;
            }
            .gil-logo--light .gil-logo__right { text-align: center; align-items: center; }
        }

        /* Footer login / dashboard pill */
        .gramma-footer .footer-login-btn,
        .gramma-footer a.footer-login-btn {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            font-family: {!! $didotStack !!};
            font-size: .92rem;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: lowercase;
            color: #ffffff !important;
            background: transparent;
            border: 1.5px solid rgba(250,246,236,.35);
            border-radius: 999px;
            padding: .65rem 1.4rem;
            text-decoration: none;
            cursor: pointer;
            position: relative;
            z-index: 1030;                 /* above the WhatsApp fab (1020) */
            pointer-events: auto;
            transition: background .2s, border-color .2s, color .2s;
        }
        .gramma-footer .footer-login-btn:hover {
            background: #ffffff;
            border-color: #ffffff;
            color: #000000 !important;
        }
        .gramma-footer .footer-login-btn i { font-size: .9rem; }

        /* Contact column — clickable rows with icon + label, aligned */
        .footer-contact-list { margin: 0; padding: 0; }
        .footer-contact-list li { margin-bottom: .55rem; }
        .footer-contact-list a,
        .footer-contact-list .footer-contact-static {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            font-size: 1rem;
            line-height: 1.4;
            color: rgba(250,246,236,.78);
            text-decoration: none;
            transition: color .2s;
        }
        .footer-contact-list a:hover { color: var(--gold-light); }
        .footer-contact-list i {
            width: 16px;
            text-align: center;
            font-size: .9rem;
            flex-shrink: 0;
        }

        /* Author credit — full text is the link, with a LinkedIn icon to make
           clickability obvious. Forced specificity over `.gramma-footer a`. */
        .gramma-footer .footer-credit-link,
        .gramma-footer a.footer-credit-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            font-family: var(--font-site-footer);
            font-style: normal;
            font-size: var(--font-size-footer);
            letter-spacing: .03em;
            color: #ffffff !important;
            text-decoration: none;
            cursor: pointer;
            padding: .15rem 0;
            border-radius: 0;
            position: relative;
            z-index: 2;
            min-height: auto;
            pointer-events: auto;
            touch-action: manipulation;
            -webkit-tap-highlight-color: rgba(255,255,255,.16);
            transition: color .2s, background .2s;
            text-align: center;
            white-space: nowrap;
        }
        .gramma-footer .footer-credit-link .fab {
            font-size: .95rem;
            line-height: 1;
        }
        .gramma-footer .footer-credit-link:hover {
            color: #ffffff !important;
            background: transparent;
        }
        @media (max-width: 575px) {
            .gramma-footer .footer-credit-link,
            .gramma-footer a.footer-credit-link {
                display: inline-flex;
                justify-content: center;
                width: auto;
                margin: .25rem auto 0;
                padding: .35rem .5rem;
                min-height: auto;
                white-space: nowrap;
            }
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
            @if($settings->telefone)
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
@php
    $langs = [
        'pt_BR' => ['flag' => 'br', 'name' => 'Portuguese', 'native' => 'Portuguese (Brazil)'],
        'en'    => ['flag' => 'us', 'name' => 'English',     'native' => 'English'],
        'es'    => ['flag' => 'es', 'name' => 'Spanish',    'native' => 'Spanish'],
    ];
    $currentLang = $langs[app()->getLocale()] ?? $langs['en'];

    // About Us — 5 sub-sections
    $aboutMenu = [
        'who-is'             => ['founder_title',   __('site.nav_about'),                   'fa-user'],
        'the-institute'      => ['institute_title', 'The Gramma Institute of Linguistics', 'fa-landmark'],
        'mission'            => ['mission_title',   'Mission',                              'fa-compass'],
        'areas-of-expertise' => ['expertise_title', 'Areas of Expertise',                   'fa-scroll'],
        'closing-statement'  => ['closing_title',   'Closing Statement',                    'fa-quote-right'],
    ];
    $aboutData = \App\Models\AboutPage::current();

    // Resources — categories WITH their active links (for the nested mega-menu)
    $resourceMenu = \App\Models\ResourceCategory::where('ativo', true)
        ->with(['activeLinks' => fn ($q) => $q->orderBy('ordem')])
        ->orderBy('ordem')->orderBy('id')
        ->get();
@endphp
<nav class="gramma-navbar" id="grammaNavbar">
    <div class="container">

        {{-- LEFT: BRAND — typographic logo (pure HTML/CSS) --}}
        <a class="navbar-brand gil-logo gil-logo--nav" href="{{ route('home') }}" aria-label="Gramma Institute of Linguistics">
            <span class="gil-logo__left"><span class="gil-slash">/</span>gil<span class="gil-slash">/</span></span>
            <span class="gil-logo__divider" aria-hidden="true"></span>
            <span class="gil-logo__right">
                <span class="gil-logo__main">Gramma Institute</span>
                <span class="gil-logo__mid"><span class="gil-of">of</span> Linguistics</span>
            </span>
        </a>

        {{-- CENTER: PILL with nav links (desktop only) --}}
        <div class="d-none d-lg-flex">
            <div class="nav-pill">
                <a class="nav-link {{ request()->routeIs('home') ? 'is-current' : '' }}" href="{{ route('home') }}">{{ __('site.nav_home') }}</a>

                {{-- About Us dropdown --}}
                <div class="nav-dd {{ request()->routeIs('about*') ? 'is-current-parent' : '' }}" data-dd>
                    <button type="button" class="nav-link nav-dd-toggle {{ request()->routeIs('about*') ? 'is-current' : '' }}" data-dd-toggle aria-expanded="false">{{ __('site.nav_about') }} <span class="nav-dd-chev">▾</span></button>
                    <div class="nav-dd-panel nav-dd-simple">
                        <a class="nav-dd-item" href="{{ route('about') }}">{{ __('site.about_overview') }}</a>
                        <div class="nav-dd-sep"></div>
                        @foreach($aboutMenu as $slug => [$field, $fallback, $icon])
                            <a class="nav-dd-item" href="{{ route('about.section', $slug) }}">{{ $aboutData->t($field) ?: $fallback }}</a>
                        @endforeach
                    </div>
                </div>

                {{-- Resources mega-menu (nested: category toggles → external links) --}}
                @if($resourceMenu->isNotEmpty())
                <div class="nav-dd nav-dd-mega {{ request()->routeIs('resources*') ? 'is-current-parent' : '' }}" data-dd>
                    <button type="button" class="nav-link nav-dd-toggle {{ request()->routeIs('resources*') ? 'is-current' : '' }}" data-dd-toggle aria-expanded="false">{{ __('site.nav_resources') }} <span class="nav-dd-chev">▾</span></button>
                    <div class="nav-dd-panel nav-dd-mega-panel">
                        @foreach($resourceMenu as $cat)
                            <div class="nav-dd-cat" data-cat>
                                <button type="button" class="nav-dd-cat-toggle" data-cat-toggle aria-expanded="false">
                                    <span class="nav-dd-cat-title">{{ $cat->t('title') }}</span>
                                    <span class="nav-dd-cat-count">{{ $cat->activeLinks->count() }}</span>
                                </button>
                                <div class="nav-dd-cat-links">
                                    @forelse($cat->activeLinks as $link)
                                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="nav-dd-cat-link"><span>{{ $link->t('title') ?: $link->url }}</span></a>
                                    @empty
                                        <span class="nav-dd-cat-empty">No links yet.</span>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <a class="nav-link {{ request()->routeIs('glossary*') ? 'is-current' : '' }}" href="{{ route('glossary.index') }}">{{ __('site.nav_glossary') }}</a>
                <a class="nav-link {{ request()->routeIs('partners') ? 'is-current' : '' }}" href="{{ route('partners') }}">{{ __('site.nav_partners') }}</a>
                <a class="nav-link {{ request()->routeIs('contact') ? 'is-current' : '' }}" href="{{ route('contact') }}">{{ __('site.nav_contact') }}</a>
            </div>
        </div>

        {{-- RIGHT: actions --}}
        <div class="nav-actions">
            {{-- Desktop globe --}}
            <button type="button" class="lang-globe-btn d-none d-lg-inline-flex" id="langGlobeBtn" aria-label="{{ __('site.language_select') }}" aria-expanded="false">
                <span class="lang-globe-flag fi fi-{{ $currentLang['flag'] }}"></span>
                <i class="fas fa-chevron-down lang-globe-chevron"></i>
            </button>

            {{-- Mobile-only: globe + hamburger --}}
            <button type="button" class="lang-globe-btn mobile-globe d-inline-flex d-lg-none" id="langGlobeBtnMobile" aria-label="{{ __('site.language_select') }}" aria-expanded="false">
                <span class="lang-globe-flag fi fi-{{ $currentLang['flag'] }}"></span>
            </button>
            <button class="navbar-toggler d-inline-flex d-lg-none" type="button" id="navToggler" aria-label="Menu" aria-controls="navMain" aria-expanded="false" style="border:none; background:transparent;">
                <i class="fas fa-bars" id="navTogglerIcon" style="color:var(--ink); font-size:1.3rem;"></i>
            </button>
        </div>
    </div>

    {{-- Mobile slide-down menu --}}
    <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'is-current' : '' }}" href="{{ route('home') }}">{{ __('site.nav_home') }}</a></li>

            {{-- About Us (accordion) --}}
            <li class="nav-item nav-mobile-group" data-mobile-group>
                <button class="nav-link nav-mobile-toggle" type="button" data-mobile-toggle>{{ __('site.nav_about') }} <i>▾</i></button>
                <div class="nav-mobile-sub">
                    <a href="{{ route('about') }}">{{ __('site.about_overview') }}</a>
                    @foreach($aboutMenu as $slug => [$field, $fallback, $icon])
                        <a href="{{ route('about.section', $slug) }}">{{ $aboutData->t($field) ?: $fallback }}</a>
                    @endforeach
                </div>
            </li>

            {{-- Resources (3-level accordion: Resources → category → links) --}}
            @if($resourceMenu->isNotEmpty())
                <li class="nav-item nav-mobile-group" data-mobile-group>
                    <button class="nav-link nav-mobile-toggle" type="button" data-mobile-toggle>{{ __('site.nav_resources') }} <i>▾</i></button>
                    <div class="nav-mobile-sub">
                        @foreach($resourceMenu as $cat)
                            <div class="nav-mobile-cat" data-mobile-group>
                                <button type="button" class="nav-mobile-cat-toggle" data-mobile-toggle><span>{{ $cat->t('title') }}</span></button>
                                <div class="nav-mobile-cat-links nav-mobile-sub">
                                    @forelse($cat->activeLinks as $link)
                                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer">{{ $link->t('title') ?: $link->url }}</a>
                                    @empty
                                        <span class="nav-mobile-empty">No links yet.</span>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </li>
            @endif

            <li class="nav-item"><a class="nav-link {{ request()->routeIs('glossary*') ? 'is-current' : '' }}" href="{{ route('glossary.index') }}">{{ __('site.nav_glossary') }}</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('partners') ? 'is-current' : '' }}" href="{{ route('partners') }}">{{ __('site.nav_partners') }}</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'is-current' : '' }}" href="{{ route('contact') }}">{{ __('site.nav_contact') }}</a></li>
        </ul>
    </div>
</nav>

{{-- PAGE CONTENT --}}
@yield('content')

{{-- FOOTER --}}
<footer class="gramma-footer">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 mb-3">
                <div class="footer-brand-block">
                    <div class="footer-brand">
                        <a href="{{ route('home') }}" class="gil-logo gil-logo--light" aria-label="Gramma Institute of Linguistics">
                            <span class="gil-logo__left"><span class="gil-slash">/</span>gil<span class="gil-slash">/</span></span>
                            <span class="gil-logo__divider" aria-hidden="true"></span>
                            <span class="gil-logo__right">
                                <span class="gil-logo__main">Gramma Institute</span>
                                <span class="gil-logo__mid"><span class="gil-of">of</span> Linguistics</span>
                            </span>
                        </a>
                    </div>
                    <p class="footer-brand-text">languages - education - research</p>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="footer-meta-stack">
                    <a href="https://www.linkedin.com/in/alexandre-crist%C3%B3v%C3%A3o-156073151/"
                       target="_blank" rel="noopener noreferrer"
                       class="footer-credit-link">Designed &amp; coded by Alexandre Crist&oacute;v&atilde;o <i class="fab fa-linkedin"></i></a>
                    <div class="footer-bottom">
                        {{ $settings->texto_rodape ?? ('© ' . date('Y') . ' Gramma Institute. ' . __('site.footer_rights')) }}
                    </div>
                </div>
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
            <button type="button" class="wa-card-close" aria-label="Close" id="waClose">
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
            {{ __('site.language_select') }}
        </div>
        <button type="button" class="lang-panel-close" id="langPanelClose" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
    </div>
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

    // Desktop nav dropdowns (About + Resources mega): click to toggle, close on outside / Esc.
    (function() {
        var dds = document.querySelectorAll('[data-dd]');
        if (!dds.length) return;

        function closeAll(except) {
            dds.forEach(function(d) {
                if (d === except) return;
                d.classList.remove('is-open');
                var btn = d.querySelector('[data-dd-toggle]');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            });
        }

        dds.forEach(function(d) {
            var btn = d.querySelector('[data-dd-toggle]');
            if (!btn) return;
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var open = d.classList.toggle('is-open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                closeAll(d);
            });
        });

        // Inside the Resources mega-menu: each category header toggles its own
        // link list (accordion). Multiple categories can stay open at once.
        document.querySelectorAll('[data-cat-toggle]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var cat = btn.closest('[data-cat]');
                if (!cat) return;
                var open = cat.classList.toggle('is-cat-open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('[data-dd]')) closeAll(null);
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAll(null);
        });
    })();

    // Mobile accordion groups (About + Resources in the slide-down menu)
    (function() {
        var groups = document.querySelectorAll('[data-mobile-group]');
        groups.forEach(function(g) {
            var btn = g.querySelector('[data-mobile-toggle]');
            if (!btn) return;
            btn.addEventListener('click', function() {
                g.classList.toggle('is-open');
            });
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
