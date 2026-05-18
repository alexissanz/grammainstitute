<!DOCTYPE html>
@php
    $settings = \App\Models\SiteSetting::current();
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="ngrok-skip-browser-warning" content="true">
    <meta name="theme-color" content="#1a1612">
    <title>{{ __('auth.login_title') }} — {{ $settings->nome_site ?? config('app.name') }}</title>

    @if($settings->favicon)
        <link rel="icon" href="{{ \Illuminate\Support\Facades\Storage::url($settings->favicon) }}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=GFS+Didot&family=Bodoni+Moda:ital,opsz,wght@0,6..96,400;0,6..96,600;0,6..96,700;1,6..96,400&family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Cormorant+SC:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --parchment:   #f5efe1;
            --parchment-2: #ece2c8;
            --ivory:       #faf6ec;
            --ink:         #1a1612;
            --ink-soft:    #322a20;
            --bronze:      #a87841;
            --bronze-dark: #7e5223;
            --gold:        #c8a44b;
            --gold-light:  #e7c873;
            --stone:       #8a7e66;
            --burgundy:    #6c1f1f;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }
        body {
            font-family: '"Didot","GFS Didot","Bodoni Moda","Cormorant Garamond",Georgia,serif';
            background: var(--ink);
            color: var(--ivory);
            overflow: hidden;
            position: relative;
        }

        /* ===== ANIMATED CLASSICAL BACKDROP =====
           Parchment-warm gradients + drifting Greek letters + light orbs */
        .bg-stage {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(circle at 22% 18%, rgba(200,164,75,.16), transparent 45%),
                radial-gradient(circle at 78% 82%, rgba(168,120,65,.18), transparent 55%),
                linear-gradient(135deg, #14110d 0%, #221a13 55%, #14110d 100%);
            overflow: hidden;
        }
        .bg-stage::before, .bg-stage::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .35;
        }
        .bg-stage::before {
            width: 50vw; height: 50vw;
            top: -10%; left: -10%;
            background: radial-gradient(circle, rgba(200,164,75,.55), transparent 70%);
            animation: drift 22s ease-in-out infinite alternate;
        }
        .bg-stage::after {
            width: 45vw; height: 45vw;
            bottom: -15%; right: -10%;
            background: radial-gradient(circle, rgba(168,120,65,.5), transparent 70%);
            animation: drift 28s ease-in-out infinite alternate-reverse;
        }
        @keyframes drift {
            0%   { transform: translate(0,0)    scale(1);   }
            50%  { transform: translate(8vw,4vh)scale(1.15);}
            100% { transform: translate(-4vw,6vh)scale(.95);}
        }

        /* Drifting Greek/Hebrew glyphs */
        .glyphs { position: absolute; inset: 0; overflow: hidden; }
        .glyph {
            position: absolute;
            font-family: 'Cinzel', serif;
            font-weight: 600;
            color: rgba(200,164,75,.08);
            user-select: none;
            white-space: nowrap;
            animation: float 30s linear infinite;
        }
        .glyph.g1 { top: 10%;  left: 6%;  font-size: 18vw; animation-duration: 38s; }
        .glyph.g2 { top: 55%;  right: 4%; font-size: 14vw; animation-duration: 44s; animation-direction: reverse; color: rgba(168,120,65,.07); }
        .glyph.g3 { bottom: 8%; left: 30%; font-size: 9vw; animation-duration: 50s; color: rgba(231,200,115,.07); }
        @keyframes float {
            0%   { transform: translate(0,0) rotate(0deg); opacity:.7; }
            50%  { transform: translate(2vw,-3vh) rotate(2deg); opacity:1; }
            100% { transform: translate(0,0) rotate(0deg); opacity:.7; }
        }

        /* Falling gold particles like ink dust */
        .ink-dust { position: absolute; inset: 0; }
        .dust {
            position: absolute;
            width: 3px; height: 3px;
            background: var(--gold-light);
            border-radius: 50%;
            opacity: .35;
            animation: fall linear infinite;
            box-shadow: 0 0 6px rgba(231,200,115,.6);
        }
        @keyframes fall {
            0%   { transform: translateY(-10vh); opacity: 0; }
            10%  { opacity: .8; }
            90%  { opacity: .8; }
            100% { transform: translateY(110vh) translateX(20px); opacity: 0; }
        }

        /* ===== LAYOUT ===== */
        .page {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }
        @media (max-width: 991px) {
            .page { grid-template-columns: 1fr; }
            .panel-poetic { display: none; }
        }

        /* ===== LEFT PANEL (poetic) ===== */
        .panel-poetic {
            display: flex; flex-direction: column;
            padding: 4rem 5rem;
            justify-content: space-between;
            border-right: 1px solid rgba(200,164,75,.18);
            position: relative;
        }
        .panel-poetic::after {
            content:'';
            position: absolute; right: -1px; top: 18%; bottom: 18%;
            width: 1px;
            background: linear-gradient(to bottom, transparent, var(--gold), transparent);
        }
        .brand-mark {
            display: inline-flex; align-items: center; gap: 1rem;
            font-family: 'Cinzel', serif;
            font-size: 1.55rem;
            letter-spacing: .22em;
            color: var(--gold-light);
            text-transform: uppercase;
        }
        .brand-mark .seal {
            width: 56px; height: 56px;
            border-radius: 50%;
            border: 1.5px solid var(--gold);
            display: inline-flex; align-items: center; justify-content: center;
            color: var(--gold-light);
            font-size: 1.55rem;
            animation: sealPulse 4s ease-in-out infinite;
        }
        @keyframes sealPulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(200,164,75,.5); }
            50%     { box-shadow: 0 0 0 18px rgba(200,164,75,0); }
        }
        .brand-mark small {
            display: block;
            font-family: 'Cormorant SC', serif;
            font-size: .55rem;
            letter-spacing: .35em;
            color: var(--stone);
            margin-top: 4px;
            font-weight: 400;
        }

        .poetic-headline {
            font-family: '"Bodoni Moda","Didot","GFS Didot",Georgia,serif';
            font-size: clamp(2.4rem, 4vw, 4rem);
            line-height: 1.05;
            color: var(--ivory);
            font-weight: 600;
            letter-spacing: .01em;
            margin: 0 0 1.5rem;
        }
        .poetic-headline em {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 400;
            color: var(--gold-light);
        }
        .poetic-lede {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.25rem;
            color: rgba(250,246,236,.78);
            max-width: 540px;
            line-height: 1.7;
        }

        .ornament-row {
            display: inline-flex; align-items: center; gap: 1rem;
            color: var(--gold);
            margin: 1.5rem 0;
        }
        .ornament-row::before,
        .ornament-row::after {
            content:'';
            flex: 0 0 56px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .poetic-strip {
            display: flex; gap: 2.5rem; flex-wrap: wrap;
            color: rgba(231,200,115,.7);
            font-family: 'Cinzel', serif;
            font-size: .85rem;
            letter-spacing: .22em;
            text-transform: uppercase;
        }
        .poetic-strip .ps-item { display: inline-flex; align-items: center; gap: .5rem; }
        .poetic-strip .ps-glyph { font-size: 1.3rem; color: var(--gold-light); }

        .poetic-footer {
            font-family: 'Cormorant SC', serif;
            font-size: .7rem;
            letter-spacing: .28em;
            color: var(--stone);
            text-transform: uppercase;
        }

        /* ===== RIGHT PANEL (form) ===== */
        .panel-form {
            display: flex; align-items: center; justify-content: center;
            padding: 4rem 2rem;
        }
        .login-card {
            width: 100%;
            max-width: 460px;
            background: rgba(245,239,225,.06);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(200,164,75,.22);
            border-radius: 2px;
            padding: 3.25rem 2.75rem;
            color: var(--ivory);
            position: relative;
            box-shadow:
                0 30px 80px rgba(0,0,0,.45),
                inset 0 1px 0 rgba(255,255,255,.06);
            animation: cardIn .8s cubic-bezier(.2,.8,.2,1) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .login-card::before,
        .login-card::after {
            content: '';
            position: absolute;
            width: 18px; height: 18px;
            border: 1.5px solid var(--gold);
        }
        .login-card::before { top: 14px; left: 14px;   border-right:0; border-bottom:0; }
        .login-card::after  { bottom: 14px; right: 14px; border-left:0;  border-top:0; }

        .login-eyebrow {
            font-family: 'Cormorant SC', serif;
            font-size: .8rem;
            letter-spacing: .42em;
            color: var(--gold-light);
            text-transform: uppercase;
            text-align: center;
            margin-bottom: .85rem;
        }
        .login-title {
            font-family: '"Bodoni Moda","Didot","GFS Didot",Georgia,serif';
            font-size: 2.4rem;
            font-weight: 600;
            color: var(--ivory);
            text-align: center;
            margin: 0 0 .25rem;
            letter-spacing: .01em;
        }
        .login-title em {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 400;
            color: var(--gold-light);
        }
        .login-sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            text-align: center;
            color: rgba(250,246,236,.7);
            font-size: 1.05rem;
            margin: 0 0 2rem;
        }

        .field { position: relative; margin-bottom: 1.4rem; }
        .field input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid rgba(200,164,75,.35);
            color: var(--ivory);
            font-family: '"GFS Didot","Bodoni Moda","Cormorant Garamond",serif';
            font-size: 1.05rem;
            padding: 1.55rem 2.2rem .55rem 0;
            outline: none;
            transition: border-color .25s, box-shadow .25s;
        }
        .field input::placeholder { color: transparent; }
        .field label {
            position: absolute;
            left: 0; top: 1.55rem;
            font-family: 'Cormorant SC', serif;
            font-size: .82rem;
            letter-spacing: .26em;
            color: rgba(231,200,115,.55);
            text-transform: uppercase;
            transition: all .25s;
            pointer-events: none;
        }
        .field input:focus,
        .field input:not(:placeholder-shown) {
            border-bottom-color: var(--gold-light);
        }
        .field input:focus + label,
        .field input:not(:placeholder-shown) + label {
            top: .25rem;
            font-size: .65rem;
            letter-spacing: .32em;
            color: var(--gold-light);
        }
        .field i.field-icon {
            position: absolute;
            right: 0; bottom: .75rem;
            color: var(--gold);
            font-size: 1rem;
            opacity: .75;
        }
        .field .invalid-msg {
            font-family: 'Cormorant Garamond', serif;
            color: #f3a3a3;
            font-size: .92rem;
            font-style: italic;
            margin-top: .35rem;
            display: block;
        }

        .row-flex {
            display: flex; justify-content: space-between; align-items: center;
            margin: .5rem 0 1.5rem;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
        }
        .check-classical {
            display: inline-flex; align-items: center; gap: .55rem;
            color: rgba(250,246,236,.78);
            cursor: pointer; user-select: none;
        }
        .check-classical input {
            appearance: none; -webkit-appearance: none;
            width: 16px; height: 16px;
            border: 1.5px solid var(--gold);
            background: transparent;
            border-radius: 2px;
            cursor: pointer;
            position: relative;
            transition: all .15s;
        }
        .check-classical input:checked {
            background: var(--gold);
        }
        .check-classical input:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--ink);
            font-size: .65rem;
            position: absolute;
            top: 50%; left: 50%; transform: translate(-50%,-50%);
        }
        .row-flex a {
            color: var(--gold-light);
            text-decoration: none;
            font-style: italic;
            border-bottom: 1px solid transparent;
            transition: border-color .2s;
        }
        .row-flex a:hover { border-bottom-color: var(--gold-light); }

        .btn-ingress {
            display: inline-flex; width: 100%; justify-content: center; align-items: center; gap: .7rem;
            font-family: 'Cinzel', serif;
            font-size: .9rem;
            font-weight: 600;
            letter-spacing: .26em;
            text-transform: uppercase;
            padding: 1rem 1.5rem;
            border: 1.5px solid var(--gold);
            background: var(--gold);
            color: var(--ink);
            cursor: pointer;
            transition: all .25s;
            position: relative;
            overflow: hidden;
        }
        .btn-ingress::before {
            content:'';
            position: absolute; inset: 0;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,.4), transparent);
            transform: translateX(-150%);
            transition: transform .8s;
        }
        .btn-ingress:hover { background: var(--ink); color: var(--gold-light); }
        .btn-ingress:hover::before { transform: translateX(150%); }
        .btn-ingress i { font-size: .85rem; }

        .login-foot {
            margin-top: 1.75rem;
            display: flex; flex-direction: column; gap: .9rem;
            align-items: center;
            color: rgba(250,246,236,.65);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
        }
        .login-foot a {
            color: var(--gold-light);
            text-decoration: none;
            font-style: italic;
        }
        .login-foot a:hover { border-bottom: 1px solid var(--gold-light); }
        .lang-strip {
            display: flex; gap: .7rem; align-items: center;
            font-family: 'Cinzel', serif;
            font-size: .68rem;
            letter-spacing: .25em;
            color: rgba(231,200,115,.55);
            text-transform: uppercase;
        }
        .lang-strip a {
            color: rgba(231,200,115,.55);
            font-style: normal;
            border-bottom: 1px solid transparent;
            padding-bottom: 2px;
            transition: all .15s;
        }
        .lang-strip a.active { color: var(--gold-light); border-bottom-color: var(--gold); }
        .lang-strip a:hover { color: var(--gold-light); }
        .lang-strip .sep { opacity: .35; }

        .alert-classical {
            background: rgba(108,31,31,.18);
            border: 1px solid rgba(108,31,31,.45);
            color: #f5d6d6;
            padding: .85rem 1rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            margin-bottom: 1.2rem;
        }
        .alert-success-classical {
            background: rgba(79,91,53,.18);
            border: 1px solid rgba(79,91,53,.45);
            color: #d8e1bf;
            padding: .85rem 1rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            margin-bottom: 1.2rem;
        }

        /* iOS autofill colors */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--ivory) !important;
            -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
            transition: background-color 9999s ease-in-out 0s;
            caret-color: var(--gold-light);
        }

        @media (max-width: 991px) {
            .panel-form { padding: 3rem 1.25rem; }
            .login-card { padding: 2.5rem 1.75rem; }
            .login-title { font-size: 2rem; }
        }
        @media (max-width: 480px) {
            .login-card { padding: 2.25rem 1.25rem; }
            .login-title { font-size: 1.75rem; }
        }
    </style>
</head>
<body>

<div class="bg-stage" aria-hidden="true">
    <div class="glyphs">
        <span class="glyph g1">Γράμμα</span>
        <span class="glyph g2">Λόγος</span>
        <span class="glyph g3">Σοφία</span>
    </div>
    <div class="ink-dust" id="dust"></div>
</div>

<div class="page">

    {{-- LEFT PANEL — poetic --}}
    <aside class="panel-poetic">
        <div>
            <a href="{{ route('home') }}" class="brand-mark" style="text-decoration:none;">
                <span class="seal">Γ</span>
                <span>
                    {{ $settings->nome_site ?? 'Gramma' }}
                    <small>Institute of Languages</small>
                </span>
            </a>
        </div>

        <div>
            <h1 class="poetic-headline">
                Verba volant, <em>scripta manent.</em>
            </h1>
            <div class="ornament-row"><i class="fas fa-feather"></i></div>
            <p class="poetic-lede">
                As palavras voam, mas o que é escrito permanece. Entre na casa onde
                as línguas vivem — Latina, Graeca, Hebraica, Anglica, Hispanica, Lusitana.
            </p>
            <div class="poetic-strip mt-4">
                <span class="ps-item"><span class="ps-glyph">Γ</span> Greek</span>
                <span class="ps-item"><span class="ps-glyph">א</span> Hebrew</span>
                <span class="ps-item"><span class="ps-glyph">Λ</span> Latin</span>
            </div>
        </div>

        <div class="poetic-footer">
            · {{ $settings->nome_site ?? 'Gramma Institute' }} · {{ now()->year }} ·
        </div>
    </aside>

    {{-- RIGHT PANEL — form --}}
    <main class="panel-form">
        <form action="{{ route('login') }}" method="post" class="login-card" novalidate>
            @csrf
            <div class="login-eyebrow">{{ __('auth.login_title') }}</div>
            <h2 class="login-title">{{ __('site.nav_login') }} <em>—</em></h2>
            <p class="login-sub">{{ __('site.hero_cta2') }}</p>

            @if (session('status'))
                <div class="alert-success-classical">{{ session('status') }}</div>
            @endif

            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="alert-classical">{{ $errors->first() }}</div>
            @endif

            <div class="field">
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder=" " required autofocus autocomplete="email">
                <label for="email">{{ __('auth.email') }}</label>
                <i class="fas fa-envelope field-icon"></i>
                @error('email') <span class="invalid-msg">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <input type="password" id="password" name="password"
                       placeholder=" " required autocomplete="current-password">
                <label for="password">{{ __('auth.password') }}</label>
                <i class="fas fa-lock field-icon"></i>
                @error('password') <span class="invalid-msg">{{ $message }}</span> @enderror
            </div>

            <div class="row-flex">
                <label class="check-classical">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>{{ __('auth.remember_me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                @endif
            </div>

            <button type="submit" class="btn-ingress">
                {{ __('auth.login') }} <i class="fas fa-arrow-right"></i>
            </button>

            <div class="login-foot">
                <a href="{{ route('home') }}">← {{ __('site.go_home') }}</a>
                <div class="lang-strip">
                    @php
                        $locales = [
                            'pt_BR' => 'PT',
                            'en'    => 'EN',
                            'es'    => 'ES',
                            'he'    => 'HE',
                            'el'    => 'EL',
                            'la'    => 'LA',
                        ];
                    @endphp
                    @foreach($locales as $code => $label)
                        <a href="{{ route('locale.switch', $code) }}"
                           class="{{ app()->getLocale() === $code ? 'active' : '' }}">{{ $label }}</a>
                        @if(!$loop->last)<span class="sep">·</span>@endif
                    @endforeach
                </div>
            </div>
        </form>
    </main>
</div>

<script>
    // Generate falling ink-dust particles
    (function() {
        var stage = document.getElementById('dust');
        if (!stage) return;
        for (var i = 0; i < 28; i++) {
            var d = document.createElement('span');
            d.className = 'dust';
            var dur   = (8 + Math.random() * 18).toFixed(2);
            var delay = (Math.random() * -20).toFixed(2);
            var left  = (Math.random() * 100).toFixed(2);
            var size  = (1 + Math.random() * 3).toFixed(1);
            d.style.cssText =
                'left:' + left + 'vw;' +
                'animation-duration:' + dur + 's;' +
                'animation-delay:' + delay + 's;' +
                'width:'  + size + 'px;' +
                'height:' + size + 'px;' +
                'opacity:' + (.2 + Math.random() * .5).toFixed(2) + ';';
            stage.appendChild(d);
        }
    })();
</script>
</body>
</html>
