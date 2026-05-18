@extends('layouts.public')

@section('meta-title', $settings->meta_title ?? 'Gramma Institute — ' . __('site.subtitulo_site'))

@push('styles')
<style>
    /* ============================================================
       HERO — CLASSICAL / MANUSCRIPT
       ============================================================ */
    .hero-classical {
        position: relative;
        min-height: 92vh;
        display: flex;
        align-items: center;
        background:
            linear-gradient(135deg, rgba(26,22,18,.78) 0%, rgba(26,22,18,.55) 55%, rgba(26,22,18,.85) 100%),
            url('https://images.unsplash.com/photo-1518780664697-55e3ad937233?auto=format&fit=crop&w=2400&q=85') center/cover no-repeat;
        color: var(--ivory);
        overflow: hidden;
    }
    .hero-classical::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 18% 22%, rgba(200,164,75,.18), transparent 35%),
            radial-gradient(circle at 84% 80%, rgba(168,120,65,.18), transparent 40%);
        pointer-events: none;
    }
    .hero-classical .hero-greek {
        position: absolute;
        top: 8%;
        right: -2%;
        font-family: 'Cinzel', serif;
        font-size: clamp(8rem, 22vw, 22rem);
        line-height: 1;
        color: rgba(250,246,236,.05);
        font-weight: 700;
        letter-spacing: .05em;
        pointer-events: none;
        user-select: none;
    }
    .hero-classical .container { position: relative; z-index: 2; padding-top: 4rem; padding-bottom: 4rem; }
    .hero-eyebrow {
        font-family: 'Cormorant SC', serif;
        font-size: .9rem;
        font-weight: 600;
        letter-spacing: .42em;
        color: var(--gold-light);
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .hero-headline {
        font-family: 'Cinzel', serif;
        font-weight: 600;
        font-size: clamp(2.6rem, 6vw, 5rem);
        line-height: 1.06;
        letter-spacing: .015em;
        color: var(--ivory);
        margin-bottom: 1.5rem;
    }
    .hero-headline em {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-weight: 400;
        color: var(--gold-light);
        letter-spacing: 0;
    }
    .hero-lede {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.35rem;
        line-height: 1.7;
        color: rgba(250,246,236,.86);
        max-width: 620px;
        margin-bottom: 2.5rem;
    }
    .hero-cta-row { display: flex; flex-wrap: wrap; gap: 1rem; }
    .hero-langs-strip {
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(250,246,236,.15);
        display: flex;
        flex-wrap: wrap;
        gap: 2.5rem 3rem;
        align-items: center;
    }
    .hero-langs-strip .lang-item {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: .95rem;
        letter-spacing: .22em;
        color: rgba(250,246,236,.78);
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: .65rem;
    }
    .hero-langs-strip .lang-glyph {
        font-family: 'Cinzel', serif;
        font-size: 1.5rem;
        color: var(--gold-light);
        line-height: 1;
    }

    /* ============================================================
       PROMISE STRIP (under hero)
       ============================================================ */
    .promise-strip {
        background: var(--ink);
        color: var(--ivory);
        border-top: 1px solid rgba(250,246,236,.08);
        border-bottom: 1px solid rgba(250,246,236,.08);
        padding: 1.6rem 0;
    }
    .promise-strip .item {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-family: 'Cormorant SC', serif;
        font-size: .85rem;
        font-weight: 500;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: rgba(250,246,236,.85);
    }
    .promise-strip .item i { color: var(--gold-light); font-size: 1.3rem; }

    /* ============================================================
       MANIFESTO / INTRO
       ============================================================ */
    .manifesto {
        background: var(--ivory);
        padding: 7rem 0;
        position: relative;
        overflow: hidden;
    }
    .manifesto::before {
        content: 'Λόγος';
        position: absolute;
        bottom: -3rem; right: -1rem;
        font-family: 'Cinzel', serif;
        font-size: clamp(8rem, 18vw, 16rem);
        font-weight: 700;
        color: rgba(168,120,65,.05);
        pointer-events: none;
    }
    .manifesto .lede-quote {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-weight: 400;
        font-size: clamp(1.5rem, 2.5vw, 2.1rem);
        line-height: 1.55;
        color: var(--ink-soft);
        border-left: 2px solid var(--bronze);
        padding-left: 1.8rem;
    }
    [dir="rtl"] .manifesto .lede-quote { border-left: 0; border-right: 2px solid var(--bronze); padding-left:0; padding-right: 1.8rem; }
    .manifesto .lede-quote::first-letter {
        font-family: 'Cinzel', serif;
        font-size: 4rem;
        float: left;
        line-height: .9;
        padding-right: .8rem;
        padding-top: .5rem;
        color: var(--bronze-dark);
        font-style: normal;
    }
    [dir="rtl"] .manifesto .lede-quote::first-letter { float: right; padding-right: 0; padding-left: .8rem; }
    .signature {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.05rem;
        color: var(--stone);
        margin-top: 1.5rem;
    }
    .signature::before { content: '— '; }

    /* ============================================================
       LANGUAGE OFFERINGS — TALL CARDS WITH IMAGES
       ============================================================ */
    .lang-offerings { background: var(--parchment); padding: 7rem 0; }
    .lang-card {
        position: relative;
        height: 460px;
        overflow: hidden;
        background: var(--ink);
        cursor: pointer;
        transition: transform .35s;
    }
    .lang-card:hover { transform: translateY(-6px); }
    .lang-card .bg {
        position: absolute; inset: 0;
        background-size: cover;
        background-position: center;
        filter: grayscale(.4) brightness(.7);
        transition: filter .45s, transform .55s;
    }
    .lang-card:hover .bg { filter: grayscale(0) brightness(.75); transform: scale(1.05); }
    .lang-card::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(26,22,18,0) 35%, rgba(26,22,18,.55) 65%, rgba(26,22,18,.95) 100%);
    }
    .lang-card .content {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 2rem 1.8rem;
        color: var(--ivory);
        z-index: 2;
    }
    .lang-card .glyph {
        font-family: 'Cinzel', serif;
        font-size: 3rem;
        font-weight: 700;
        color: var(--gold-light);
        line-height: 1;
        margin-bottom: .25rem;
    }
    .lang-card .name {
        font-family: 'Cinzel', serif;
        font-size: 1.35rem;
        font-weight: 600;
        letter-spacing: .18em;
        text-transform: uppercase;
        margin-bottom: .6rem;
    }
    .lang-card .meta {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1rem;
        color: rgba(250,246,236,.78);
        margin-bottom: 1rem;
    }
    .lang-card .more {
        font-family: 'Inter', sans-serif;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .25em;
        text-transform: uppercase;
        color: var(--gold-light);
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        text-decoration: none;
        transition: gap .25s;
    }
    .lang-card .more:hover { gap: .9rem; color: var(--ivory); }

    /* ============================================================
       PILLARS / METHODOLOGY
       ============================================================ */
    .pillars { background: var(--ivory); padding: 7rem 0; }
    .pillar {
        border: 1px solid var(--line);
        padding: 2.5rem 2rem;
        height: 100%;
        background: #fff;
        transition: border-color .25s, transform .25s, box-shadow .25s;
        position: relative;
    }
    .pillar:hover {
        border-color: var(--bronze);
        transform: translateY(-4px);
        box-shadow: 0 14px 40px rgba(26,22,18,.08);
    }
    .pillar .roman {
        font-family: 'Cinzel', serif;
        font-size: .9rem;
        font-weight: 600;
        letter-spacing: .25em;
        color: var(--bronze);
        margin-bottom: 1rem;
        display: inline-block;
        padding-bottom: .5rem;
        border-bottom: 1px solid var(--bronze);
    }
    .pillar h4 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: 1.2rem;
        letter-spacing: .08em;
        color: var(--ink);
        margin-bottom: 1rem;
        line-height: 1.3;
        text-transform: uppercase;
    }
    .pillar p {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.08rem;
        line-height: 1.65;
        color: var(--ink-soft);
        margin-bottom: 0;
    }

    /* ============================================================
       FEATURED / MANUSCRIPT BANNER
       ============================================================ */
    .manuscript-banner {
        position: relative;
        background:
            linear-gradient(135deg, rgba(26,22,18,.88) 0%, rgba(26,22,18,.55) 100%),
            url('https://images.unsplash.com/photo-1532153975070-2e9ab71f1b14?auto=format&fit=crop&w=2400&q=85') center/cover no-repeat;
        color: var(--ivory);
        padding: 8rem 0;
    }
    .manuscript-banner h2 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(2rem, 4vw, 3.2rem);
        line-height: 1.18;
        letter-spacing: .015em;
        margin-bottom: 1.5rem;
    }
    .manuscript-banner h2 em { font-family: 'Cormorant Garamond', serif; font-style: italic; font-weight: 400; color: var(--gold-light); }
    .manuscript-banner .lede {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        line-height: 1.7;
        color: rgba(250,246,236,.85);
        max-width: 640px;
        margin-bottom: 2.5rem;
    }

    /* ============================================================
       TESTIMONIALS (REVIEWS)
       ============================================================ */
    .reviews { background: var(--parchment); padding: 7rem 0; }
    .review-card {
        background: #fff;
        padding: 2.5rem;
        position: relative;
        height: 100%;
        border-top: 2px solid var(--bronze);
        box-shadow: 0 4px 22px rgba(26,22,18,.06);
    }
    .review-card .stars { color: var(--gold); letter-spacing: .12em; margin-bottom: 1rem; }
    .review-card blockquote {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.15rem;
        line-height: 1.65;
        color: var(--ink-soft);
        margin: 0 0 1.5rem;
    }
    .review-card blockquote::before { content: '"'; font-family: 'Cinzel', serif; font-size: 3rem; color: var(--bronze); line-height: 0; vertical-align: -.4em; margin-right: .15em; }
    .review-card .author-row { display: flex; align-items: center; gap: .9rem; padding-top: 1rem; border-top: 1px solid var(--line); }
    .review-card .avatar {
        width: 46px; height: 46px;
        background: var(--ink);
        color: var(--gold-light);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Cinzel', serif;
        font-weight: 600;
    }
    .review-card .author-name { font-family: 'Cinzel', serif; font-size: .85rem; font-weight: 500; letter-spacing: .14em; color: var(--ink); text-transform: uppercase; }
    .review-card .author-meta { font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: .95rem; color: var(--stone); }

    /* ============================================================
       CTA FOOTER BAND
       ============================================================ */
    .cta-band {
        background:
            linear-gradient(135deg, rgba(26,22,18,.92) 0%, rgba(26,22,18,.75) 100%),
            url('https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&w=2400&q=85') center/cover no-repeat;
        background-attachment: fixed;
        color: var(--ivory);
        padding: 7rem 0;
        text-align: center;
        position: relative;
    }
    .cta-band h2 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(2rem, 4.5vw, 3.4rem);
        letter-spacing: .04em;
        margin-bottom: 1.5rem;
        line-height: 1.18;
    }
    .cta-band p {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        font-style: italic;
        color: rgba(250,246,236,.85);
        max-width: 640px;
        margin: 0 auto 2.5rem;
    }

    /* HERO video / slides keep working (legacy) */
    .hero-carousel, .hero-video-section, .hero-section { display:none; }
    .hero-carousel.show, .hero-video-section.show, .hero-section.show { display:flex; }
    .hero-carousel { position:relative; width:100%; min-height:92vh; overflow:hidden; }
    .hero-carousel .carousel-inner { height:100%; }
    .hero-carousel .carousel-item {
        min-height: 92vh;
        display: flex;
        align-items: center;
        background: var(--ink);
        position: relative;
    }
    .hero-carousel .carousel-item-bg {
        position:absolute; inset:0;
        background-size:cover; background-position:center;
        filter: brightness(.5);
    }
    .hero-carousel .carousel-item-content {
        position:relative; z-index:2;
        width:100%; padding: 5rem 0 4rem;
    }
    .hero-video-section { position:relative; min-height:92vh; align-items:center; overflow:hidden; }
    .hero-video-bg { position:absolute; inset:0; object-fit:cover; width:100%; height:100%; }
    .hero-video-overlay { position:absolute; inset:0; background:rgba(26,22,18,0.7); }
    .hero-video-content { position:relative; z-index:2; padding:5rem 0 4rem; }

    @media (max-width: 767px) {
        .hero-classical { min-height: auto; padding: 5rem 0; }
        .hero-langs-strip { gap: 1.5rem 2rem; margin-top: 2.5rem; }
        .lang-card { height: 380px; }
        .manifesto, .lang-offerings, .pillars, .reviews, .manuscript-banner, .cta-band { padding: 4rem 0; }
    }
</style>
@endpush

@section('content')

@php
    $heroTipo = $settings->hero_tipo ?? 'imagem';
    $heroImg  = $settings->imagem_hero ? Storage::url($settings->imagem_hero) : null;

    // Use real courses from DB instead of hardcoded list
    $coursesForHero = $courses ?? collect();
@endphp

{{-- =========================================================
     HERO — IMAGEM, SLIDES OU VÍDEO
     ========================================================= --}}
@if($heroTipo === 'slides' && count($heroSlides) > 0)
<section class="hero-carousel show" id="heroCarousel">
    <div id="heroSlideCarousel" class="carousel slide carousel-fade w-100" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-indicators">
            @foreach($heroSlides as $i => $slide)
                <button type="button" data-bs-target="#heroSlideCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner h-100">
            @foreach($heroSlides as $i => $slide)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                @if($slide->imagem)
                    <div class="carousel-item-bg" style="background-image:url('{{ Storage::url($slide->imagem) }}');"></div>
                @endif
                <div class="carousel-item-content">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-9">
                                <div class="hero-eyebrow">{{ __('site.about_subtitle') }}</div>
                                <h1 class="hero-headline">{{ $slide->getTitulo() }}</h1>
                                @if($slide->getSubtitulo())
                                    <p class="hero-lede">{{ $slide->getSubtitulo() }}</p>
                                @endif
                                <div class="hero-cta-row">
                                    <a href="{{ route('courses') }}" class="btn-classical">{{ __('site.hero_cta') }} <i class="fas fa-arrow-right"></i></a>
                                    <a href="{{ route('about') }}" class="btn-classical-outline">{{ __('site.hero_cta2') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@elseif($heroTipo === 'video' && $settings->hero_video)
<section class="hero-video-section show">
    <video class="hero-video-bg" autoplay muted loop playsinline>
        <source src="{{ Storage::url($settings->hero_video) }}" type="video/mp4">
    </video>
    <div class="hero-video-overlay"></div>
    <div class="hero-video-content w-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="hero-eyebrow">{{ __('site.about_subtitle') }}</div>
                    <h1 class="hero-headline">{{ __('site.hero_title') }}</h1>
                    <p class="hero-lede">{{ __('site.hero_subtitle') }}</p>
                    <div class="hero-cta-row">
                        <a href="{{ route('courses') }}" class="btn-classical">{{ __('site.hero_cta') }} <i class="fas fa-arrow-right"></i></a>
                        <a href="{{ route('about') }}" class="btn-classical-outline">{{ __('site.hero_cta2') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@else
{{-- DEFAULT: classical hero with parchment/Greek vibe --}}
<section class="hero-classical" @if($heroImg) style="background-image: linear-gradient(135deg, rgba(26,22,18,.78) 0%, rgba(26,22,18,.55) 55%, rgba(26,22,18,.85) 100%), url('{{ $heroImg }}');" @endif>
    <span class="hero-greek" aria-hidden="true">Γράμμα</span>
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="hero-eyebrow">{{ __('site.about_subtitle') }}</div>
                <h1 class="hero-headline">
                    {{ __('site.hero_title') }}<br>
                    <em>{{ $settings->subtitulo_site ?? 'γνῶθι σεαυτόν' }}</em>
                </h1>
                <p class="hero-lede">{{ __('site.hero_subtitle') }}</p>
                <div class="hero-cta-row">
                    <a href="{{ route('courses') }}" class="btn-classical">{{ __('site.hero_cta') }} <i class="fas fa-arrow-right"></i></a>
                    <a href="{{ route('about') }}" class="btn-classical-outline">{{ __('site.hero_cta2') }}</a>
                </div>

                <div class="hero-langs-strip">
                    <div class="lang-item"><span class="lang-glyph">Ελ</span> {{ __('site.course_greek') }}</div>
                    <div class="lang-item"><span class="lang-glyph">אב</span> {{ __('site.course_hebrew') }}</div>
                    <div class="lang-item"><span class="lang-glyph">En</span> {{ __('site.course_english') }}</div>
                    <div class="lang-item"><span class="lang-glyph">Es</span> {{ __('site.course_spanish') }}</div>
                    <div class="lang-item"><span class="lang-glyph">Pt</span> {{ __('site.course_portuguese') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- =========================================================
     PROMISE STRIP
     ========================================================= --}}
<section class="promise-strip">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-3 col-6 mb-3 mb-md-0">
                <div class="item justify-content-center justify-content-md-start">
                    <i class="fas fa-feather-alt"></i>
                    <span>{{ __('site.advantage_1_title') }}</span>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3 mb-md-0">
                <div class="item justify-content-center justify-content-md-start">
                    <i class="fas fa-scroll"></i>
                    <span>{{ __('site.advantage_2_title') }}</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="item justify-content-center justify-content-md-start">
                    <i class="fas fa-globe-europe"></i>
                    <span>{{ __('site.advantage_3_title') }}</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="item justify-content-center justify-content-md-start">
                    <i class="fas fa-award"></i>
                    <span>{{ __('site.advantage_4_title') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     MANIFESTO / INTRO
     ========================================================= --}}
<section class="manifesto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <div style="position: relative;">
                    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=1100&q=85"
                         alt="Manuscritos clássicos"
                         style="width:100%; height: 540px; object-fit: cover; filter: sepia(.12) contrast(1.02);">
                    <div style="position:absolute; bottom:-24px; right:-24px; background: var(--ink); color: var(--gold-light); padding: 1.5rem 2rem; font-family: 'Cinzel', serif; letter-spacing: .14em; text-transform: uppercase; font-size: .8rem;">
                        <div style="font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 2.2rem; color: var(--ivory); text-transform: none; letter-spacing: 0; line-height:1;">
                            Anno {{ now()->year }}
                        </div>
                        <div style="margin-top: .35rem;">Quinta Geração</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5">
                <div class="eyebrow">{{ __('site.about_title') }}</div>
                <h2 class="section-title-classical">
                    {{ __('site.about_subtitle') }}.
                </h2>
                <div class="ornament">
                    <i class="fas fa-feather"></i>
                </div>
                <p class="lede-quote">
                    {{ __('site.hero_subtitle') }}
                    Tratamos cada idioma como aquilo que verdadeiramente é — uma chave para uma civilização, um modo de pensar, um património.
                    Do <em>grego clássico</em> que moldou a filosofia ocidental ao <em>hebraico</em> em que foram escritas as Escrituras,
                    o Gramma reúne professores nativos, pequenos grupos e uma metodologia que respeita a profundidade da palavra.
                </p>
                <p class="signature">{{ $settings->nome_site ?? 'Gramma Institute' }} · {{ $settings->cidade ?? 'Direção académica' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     LANGUAGE OFFERINGS
     ========================================================= --}}
<section class="lang-offerings">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">{{ __('site.courses_subtitle') }}</div>
            <h2 class="section-title-classical">{{ __('site.courses_title') }}</h2>
            <div class="ornament"><i class="fas fa-quote-right"></i></div>
        </div>

        <div class="row g-4">
            @foreach($coursesForHero as $idx => $course)
                <div class="col-lg-{{ $idx < 2 ? '6' : '4' }} col-md-6">
                    <a href="{{ route('courses.show', $course->slug) }}" style="text-decoration: none;">
                        <div class="lang-card">
                            @if($course->imagemCapaUrl())
                                <div class="bg" style="background-image: url('{{ $course->imagemCapaUrl() }}');"></div>
                            @endif
                            <div class="content">
                                <div class="glyph" style="color: {{ $course->cor_destaque }};">{{ $course->glifo }}</div>
                                <div class="name">{{ $course->t('nome') }}</div>
                                <div class="meta">{{ $course->t('subtitulo') }}</div>
                                <span class="more">{{ __('site.course_learn_more') }} <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('courses') }}" class="btn-classical-dark">{{ __('site.see_all_courses') }} <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

{{-- =========================================================
     MANUSCRIPT / TEACHING BANNER
     ========================================================= --}}
<section class="manuscript-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="eyebrow light">{{ __('site.methodology_title') }}</div>
                <h2>
                    {{ __('site.methodology_subtitle') }}<br>
                    <em>verba volant, scripta manent</em>.
                </h2>
                <p class="lede">
                    Lemos pergaminhos, comentamos textos, traduzimos passagens.
                    A nossa metodologia une rigor académico e prática conversacional — porque uma língua só vive quando a habitamos.
                </p>
                <a href="{{ route('methodology') }}" class="btn-classical">{{ __('site.hero_cta2') }} <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     UPCOMING EVENTS
     ========================================================= --}}
@if(isset($upcomingEvents) && $upcomingEvents->count())
<section class="section section-cream">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">{{ __('site.events_eyebrow') }}</div>
            <h2 class="section-title-classical">{{ __('site.events_upcoming_title') }}</h2>
            <div class="ornament"><i class="fas fa-calendar-alt"></i></div>
        </div>

        <div class="row g-4">
            @foreach($upcomingEvents as $event)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('events.show', $event->slug) }}"
                       style="display:flex; flex-direction:column; height:100%; text-decoration:none; color:var(--ink); background:#fff; border-top: 3px solid {{ $event->cor_destaque }}; box-shadow:0 4px 22px rgba(26,22,18,.06); transition:transform .25s, box-shadow .25s;"
                       onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 18px 50px rgba(26,22,18,.12)';"
                       onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 22px rgba(26,22,18,.06)';">
                        @if($event->imagemUrl())
                            <div style="height:160px; background-image:url('{{ $event->imagemUrl() }}'); background-size:cover; background-position:center; position:relative;">
                                <div style="position:absolute; top:1rem; left:1rem; background: {{ $event->cor_destaque }}; color:#fff; padding:.5rem .75rem; min-width: 64px; text-align:center;">
                                    <div style="font-family:'Cormorant SC',serif; font-size:.65rem; letter-spacing:.2em; text-transform:uppercase;">
                                        {{ strtoupper($event->data_inicio->translatedFormat('M')) }}
                                    </div>
                                    <div style="font-family:'Cinzel',serif; font-size:1.7rem; font-weight:700; line-height:1;">
                                        {{ $event->data_inicio->format('d') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div style="padding:1.75rem 1.5rem; flex-grow:1; display:flex; flex-direction:column;">
                            <div style="display:flex; gap:.4rem; margin-bottom:.75rem; flex-wrap:wrap;">
                                @if($event->gratuito)
                                    <span style="font-family:'Cormorant SC',serif; font-size:.65rem; letter-spacing:.22em; text-transform:uppercase; padding:.2rem .55rem; background:#e8f5ed; color:#1f6e3b;">{{ __('site.event_free') }}</span>
                                @else
                                    <span style="font-family:'Cormorant SC',serif; font-size:.65rem; letter-spacing:.22em; text-transform:uppercase; padding:.2rem .55rem; background:#fff6e0; color:#8a5a00;">{{ __('site.event_paid') }}</span>
                                @endif
                                <span style="font-family:'Cormorant SC',serif; font-size:.65rem; letter-spacing:.22em; text-transform:uppercase; padding:.2rem .55rem; background:#e9eef9; color:#1f3a8a;">
                                    @if($event->formato === 'online') Online @elseif($event->formato === 'hibrido') Híbrido @else Presencial @endif
                                </span>
                            </div>
                            <div style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.25em; color: var(--stone); text-transform:uppercase; margin-bottom:.5rem;">
                                {{ $event->data_inicio->format('H:i') }}
                                @if($event->data_fim) — {{ $event->data_fim->format('H:i') }} @endif
                            </div>
                            <h4 style="font-family:'Cinzel',serif; font-weight:500; font-size:1.2rem; letter-spacing:.04em; color:var(--ink); margin-bottom:.5rem; line-height:1.3;">
                                {{ $event->t('titulo') }}
                            </h4>
                            <p style="font-family:'Cormorant Garamond',serif; font-style:italic; color: var(--stone); font-size:1rem; flex-grow:1;">
                                {{ Str::limit($event->t('subtitulo'), 90) }}
                            </p>
                            <span style="font-family:'Cormorant SC',serif; font-size:.72rem; letter-spacing:.3em; text-transform:uppercase; color: {{ $event->cor_destaque }}; margin-top:1rem;">
                                {{ __('site.event_details') }} <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('events.index') }}" class="btn-classical-dark">
                {{ __('site.events_title') }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- =========================================================
     PROMOTIONS BANNER
     ========================================================= --}}
@if(isset($homePromotions) && $homePromotions->count())
@foreach($homePromotions as $promo)
<section style="padding: 4rem 0; background: {{ $promo->cor_fundo }}; color: {{ $promo->cor_texto }}; position: relative; overflow: hidden;">
    @if($promo->imagemUrl())
        <div style="position:absolute; inset:0; background-image: linear-gradient({{ $promo->cor_fundo }}f0, {{ $promo->cor_fundo }}cc), url('{{ $promo->imagemUrl() }}'); background-size:cover; background-position:center;"></div>
    @endif
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                @if($promo->t('badge_texto'))
                    <div style="display:inline-block; font-family:'Cormorant SC',serif; font-size:.75rem; font-weight:600; letter-spacing:.32em; text-transform:uppercase; color: {{ $promo->cor_destaque }}; padding:.3rem .8rem; border:1px solid {{ $promo->cor_destaque }}; margin-bottom: 1rem;">
                        {{ $promo->t('badge_texto') }}
                    </div>
                @endif
                <h2 style="font-family:'Cinzel',serif; font-weight:500; font-size:clamp(1.8rem,4vw,2.8rem); color: {{ $promo->cor_texto }}; letter-spacing:.02em; line-height:1.18; margin-bottom:1rem;">
                    {{ $promo->t('titulo') }}
                </h2>
                @if($promo->t('subtitulo'))
                    <p style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.25rem; color: {{ $promo->cor_texto }}; opacity:.85; margin-bottom: 1.5rem; max-width: 620px;">
                        {{ $promo->t('subtitulo') }}
                    </p>
                @endif
                @if($promo->codigo_promo)
                    <div style="display:inline-flex; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
                        <span style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.3em; text-transform:uppercase; opacity:.7;">{{ __('site.promo_code') }}</span>
                        <span style="font-family:'Cinzel',serif; font-size:1.1rem; letter-spacing:.18em; padding:.5rem 1rem; background: {{ $promo->cor_destaque }}; color: {{ $promo->cor_fundo }};">
                            {{ $promo->codigo_promo }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="col-lg-4 text-lg-end">
                @if($promo->desconto)
                    <div style="font-family:'Cinzel',serif; font-size: clamp(2.5rem, 6vw, 4rem); font-weight:700; color: {{ $promo->cor_destaque }}; line-height:1; margin-bottom: 1rem;">
                        {{ $promo->desconto }}
                    </div>
                @endif
                @if($promo->cta_url)
                    <a href="{{ $promo->cta_url }}" class="btn-classical" style="background: {{ $promo->cor_destaque }}; color: {{ $promo->cor_fundo }}; border-color: {{ $promo->cor_destaque }};">
                        {{ $promo->t('cta_texto') ?: __('site.hero_cta') }} <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endforeach
@endif

{{-- =========================================================
     FOUNDER BLOCK
     ========================================================= --}}
@php
    $founderImg = $settings->founder_foto
        ? Storage::url($settings->founder_foto)
        : 'https://images.unsplash.com/photo-1559548331-f9cb98001426?auto=format&fit=crop&w=900&q=85';
    $founderName = $settings->founder_nome ?: 'Prof. Aléxios Konstantínou';
    $founderRole = $settings->founder_titulo ?: 'Fundador e Diretor Académico';
    $founderQuote = $settings->founder_citacao_curta ?: 'Cada língua é uma janela. Estudá-la é abrir uma porta para o mundo que a moldou.';
@endphp
<section class="section section-ink" style="padding: 6rem 0;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 text-center mb-4 mb-lg-0">
                <div style="position:relative; display:inline-block; width:100%; max-width: 320px;">
                    <div style="position:relative; aspect-ratio: 3/4; width:100%;">
                        <div style="position:absolute; inset:8px; background-image:url('{{ $founderImg }}'); background-size:cover; background-position:center; border-radius: 50%; filter: sepia(.05) contrast(1.04);"></div>
                        <div style="position:absolute; inset:0; border:1.5px solid var(--gold-light); border-radius: 50%; transform: scaleY(1.05); pointer-events:none;"></div>
                        <div style="position:absolute; inset:-14px; border:1px solid rgba(231,200,115,.3); border-radius:50%; pointer-events:none;"></div>
                        <span style="position:absolute; top:-2%; left:6%; font-family:'Cinzel',serif; color: var(--gold-light); font-size:1.3rem; background: var(--ink); padding:.35rem .55rem; border:1px solid rgba(231,200,115,.4); border-radius:50%; width:46px; height:46px; display:flex; align-items:center; justify-content:center; z-index:2;">Γ</span>
                        <span style="position:absolute; bottom:0%; right:6%; font-family:'Cinzel',serif; color: var(--gold-light); font-size:1.3rem; background: var(--ink); padding:.35rem .55rem; border:1px solid rgba(231,200,115,.4); border-radius:50%; width:46px; height:46px; display:flex; align-items:center; justify-content:center; z-index:2;">Α</span>
                        <span style="position:absolute; top:14%; right:-4%; font-family:'Noto Sans Hebrew',serif; color: var(--gold-light); font-size:1.3rem; background: var(--ink); padding:.35rem .55rem; border:1px solid rgba(231,200,115,.4); border-radius:50%; width:46px; height:46px; display:flex; align-items:center; justify-content:center; z-index:2;">א</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="eyebrow light">{{ __('site.founder_eyebrow') }}</div>
                <h2 class="section-title-classical" style="color: var(--ivory);">{{ __('site.founder_section_title') }}</h2>
                <div class="ornament light" style="justify-content: flex-start;"><i class="fas fa-feather"></i></div>
                <blockquote style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size: 1.4rem; line-height:1.6; color: rgba(250,246,236,.92); border-left: 2px solid var(--gold-light); padding-left: 1.5rem; margin: 1rem 0 2rem;">
                    "{{ $founderQuote }}"
                </blockquote>
                <p style="font-family:'Cormorant Garamond',serif; font-size:1.18rem; line-height:1.75; color: rgba(250,246,236,.78); margin-bottom: 2rem;">
                    {{ $settings->founder_bio ?? '' }}
                </p>
                <div style="display:flex; align-items:center; gap:1.25rem; flex-wrap: wrap;">
                    <div>
                        <div style="font-family:'Cinzel',serif; font-size:1rem; letter-spacing:.18em; text-transform:uppercase; color: var(--ivory);">{{ $founderName }}</div>
                        <div style="font-family:'Cormorant Garamond',serif; font-style:italic; color: var(--gold-light); font-size:.95rem;">{{ $founderRole }}</div>
                    </div>
                    <a href="{{ route('founder') }}" class="btn-classical">{{ __('site.founder_read_letter') }} <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     GLOSSARY TEASER (if any featured terms)
     ========================================================= --}}
@if(isset($featuredTerms) && $featuredTerms->count())
<section class="section section-light">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">{{ __('site.glossary_eyebrow') }}</div>
            <h2 class="section-title-classical">{{ __('site.glossary_title') }}</h2>
            <div class="ornament"><i class="fas fa-feather"></i></div>
            <p style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.2rem; color: var(--ink-soft); max-width: 640px; margin: 0 auto;">
                {{ __('site.glossary_subtitle') }}
            </p>
        </div>
        <div class="row g-4">
            @foreach($featuredTerms as $t)
                <div class="col-md-4">
                    <a href="{{ route('glossary.show', $t->slug) }}" style="text-decoration:none; display:block; background:#fff; padding:2.2rem 1.8rem; height:100%; border-top: 2px solid var(--bronze); color: var(--ink); transition: transform .25s, box-shadow .25s;"
                       onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 14px 40px rgba(26,22,18,.1)';"
                       onmouseout="this.style.transform=''; this.style.boxShadow='';">
                        <div style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.3em; text-transform:uppercase; color: var(--bronze-dark); margin-bottom:.75rem;">
                            {{ App\Models\GlossaryTerm::linguaLabel($t->lingua) }}
                        </div>
                        <div style="font-family:{{ $t->lingua === 'he' ? "'Noto Sans Hebrew',serif" : "'Cinzel',serif" }}; font-size: 2.4rem; font-weight: 600; color: var(--ink); line-height:1; margin-bottom:.25rem;">
                            {{ $t->termo }}
                        </div>
                        <div style="font-family:'Cormorant Garamond',serif; font-style:italic; color: var(--stone); margin-bottom:1rem;">
                            {{ $t->transliteracao }}
                        </div>
                        <p style="font-family:'Cormorant Garamond',serif; font-size:1.08rem; line-height:1.65; color: var(--ink-soft);">
                            {{ Str::limit($t->t('significado'), 140) }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('glossary.index') }}" class="btn-classical-dark">{{ __('site.see_glossary') }} <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
@endif

{{-- =========================================================
     PILLARS / METHODOLOGY DETAILED
     ========================================================= --}}
<section class="pillars">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">{{ __('site.advantages_title') }}</div>
            <h2 class="section-title-classical">Os quatro pilares do Gramma</h2>
            <div class="ornament"><i class="fas fa-scroll"></i></div>
        </div>
        <div class="row g-4">
            @foreach([
                ['I',   'advantage_1'],
                ['II',  'advantage_2'],
                ['III', 'advantage_3'],
                ['IV',  'advantage_4'],
            ] as [$roman, $key])
                <div class="col-md-6 col-lg-3">
                    <div class="pillar">
                        <span class="roman">{{ $roman }}</span>
                        <h4>{{ __("site.{$key}_title") }}</h4>
                        <p>{{ __("site.{$key}_text") }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     REVIEWS / TESTIMONIALS
     ========================================================= --}}
<section class="reviews">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">{{ __('site.testimonials_title') }}</div>
            <h2 class="section-title-classical">A palavra dos nossos alunos</h2>
            <div class="ornament"><i class="fas fa-star"></i></div>
        </div>
        <div class="row g-4">
            @foreach([1,2,3] as $i)
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="stars">★ ★ ★ ★ ★</div>
                        <blockquote>{{ __("site.testimonial_{$i}_text") }}</blockquote>
                        <div class="author-row">
                            <div class="avatar">{{ mb_strtoupper(mb_substr(__("site.testimonial_{$i}_author"), 0, 1)) }}</div>
                            <div>
                                <div class="author-name">{{ __("site.testimonial_{$i}_author") }}</div>
                                <div class="author-meta">{{ __('site.course_learn_more') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     FINAL CTA BAND
     ========================================================= --}}
<section class="cta-band">
    <div class="container">
        <div class="ornament light"><i class="fas fa-feather"></i></div>
        <h2>{{ __('site.contact_title') }}</h2>
        <p>{{ __('site.contact_subtitle') }}</p>
        <div class="d-inline-flex flex-wrap gap-3 justify-content-center">
            <a href="{{ route('contact') }}" class="btn-classical">{{ __('site.contact_send') }} <i class="fas fa-arrow-right"></i></a>
            @if($settings->whatsappLink())
                <a href="{{ $settings->whatsappLink() }}" target="_blank" rel="noopener" class="btn-classical-outline">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            @endif
        </div>
    </div>
</section>

@endsection
