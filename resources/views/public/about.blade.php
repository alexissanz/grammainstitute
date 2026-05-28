@extends('layouts.public')

@section('meta-title', $about->t('founder_title') . ' — ' . config('app.name'))

@push('styles')
<style>
    /* ============================================================
       ABOUT PAGE — Didot, parchment + ink, sectioned with side nav
       ============================================================ */

    /* ---- Hero ---- */
    .about-hero {
        position: relative;
        background:
            linear-gradient(135deg, rgba(0,0,0,.82) 0%, rgba(0,0,0,.55) 55%, rgba(0,0,0,.88) 100%),
            radial-gradient(circle at 18% 30%, rgba(0,0,0,.32), transparent 55%),
            #000000;
        color: var(--ivory);
        padding: 7rem 0 5rem;
        overflow: hidden;
    }
    .about-hero::before {
        content: 'Γράμμα';
        position: absolute;
        top: -2.5rem; right: -3rem;
        font-family: 'Bodoni Moda','Didot',serif;
        font-size: clamp(8rem, 18vw, 18rem);
        color: rgba(255,255,255,.06);
        font-weight: 700;
        pointer-events: none;
        line-height: 1;
    }
    .about-hero .container { position: relative; z-index: 2; }
    .about-eyebrow {
        font-family: 'Cormorant SC', serif;
        font-size: .82rem;
        letter-spacing: .42em;
        text-transform: uppercase;
        color: var(--gold-light);
        margin-bottom: 1rem;
    }
    .about-hero h1 {
        font-family: 'Bodoni Moda','Didot',serif;
        font-weight: 500;
        font-size: clamp(2.5rem, 5vw, 4rem);
        line-height: 1.1;
        letter-spacing: .015em;
        color: var(--ivory);
        margin-bottom: 1.5rem;
    }

    /* Opening quote in hero */
    .about-quote {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: clamp(1.3rem, 2vw, 1.75rem);
        line-height: 1.6;
        color: rgba(250,246,236,.9);
        max-width: 780px;
        border-left: 2px solid var(--gold);
        padding-left: 1.6rem;
        margin: 1.5rem 0 1rem;
    }
    .about-quote-author {
        font-family: 'Cormorant SC', serif;
        font-size: .78rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--gold-light);
    }
    .about-quote-author::before { content: '— '; }

    /* ---- Body layout: sticky side-nav + sections ---- */
    .about-body { background: var(--ivory); padding: 5.5rem 0 6rem; position: relative; }
    .about-body::before {
        content: 'λόγος';
        position: absolute;
        bottom: 2rem; right: -1.5rem;
        font-family: 'Bodoni Moda','Didot',serif;
        font-size: clamp(7rem, 14vw, 14rem);
        color: rgba(0,0,0,.05);
        font-weight: 700;
        pointer-events: none;
    }
    .about-body > .container { position: relative; z-index: 1; }

    .about-nav {
        position: sticky;
        top: 90px;
        padding: 1.25rem 0;
        border-left: 1px solid var(--line);
    }
    .about-nav a {
        display: block;
        padding: .55rem 1.25rem;
        margin-left: -1px;
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .28em;
        text-transform: uppercase;
        color: var(--stone);
        text-decoration: none;
        border-left: 2px solid transparent;
        transition: color .2s, border-color .2s, background .2s;
    }
    .about-nav a:hover { color: var(--bronze-dark); }
    .about-nav a.is-current { color: var(--ink); border-left-color: var(--bronze); background: rgba(0,0,0,.05); }

    .about-section { padding: 2.5rem 0; scroll-margin-top: 100px; }
    .about-section + .about-section { border-top: 1px solid var(--line); }
    .about-section h2 {
        font-family: 'Bodoni Moda','Didot',serif;
        font-weight: 500;
        font-size: clamp(1.8rem, 3vw, 2.6rem);
        line-height: 1.18;
        letter-spacing: .015em;
        color: var(--ink);
        margin-bottom: 1.25rem;
    }
    .about-section .lead-p {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.18rem;
        line-height: 1.75;
        color: var(--ink-soft);
        margin-bottom: 1.2rem;
    }
    .about-section .lead-p:first-of-type::first-letter {
        font-family: 'Bodoni Moda','Didot',serif;
        font-size: 3.4rem;
        float: left;
        line-height: .9;
        padding-right: .6rem;
        padding-top: .3rem;
        color: var(--bronze-dark);
    }
    [dir="rtl"] .about-section .lead-p:first-of-type::first-letter { float: right; padding-right: 0; padding-left: .6rem; }
    .about-ornament {
        display: flex; align-items: center; gap: 1rem;
        margin-bottom: 1.5rem; color: var(--bronze);
    }
    .about-ornament::before, .about-ornament::after {
        content: ''; flex: 0 0 48px; height: 1px;
        background: linear-gradient(90deg, transparent, var(--bronze), transparent);
    }
    .about-ornament i { font-size: .85rem; }

    /* ---- Expertise grid ---- */
    .expertise-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: .9rem 1.5rem;
        margin-top: 1.25rem;
    }
    .expertise-item {
        display: flex; align-items: baseline; gap: .85rem;
        padding: .85rem 1rem;
        background: #fff;
        border: 1px solid var(--line);
        border-left: 3px solid var(--bronze);
        font-family: 'Bodoni Moda','Didot',serif;
        font-size: 1.05rem;
        color: var(--ink);
        transition: border-color .25s, transform .25s, box-shadow .25s;
    }
    .expertise-item:hover {
        border-left-color: var(--gold);
        transform: translateX(3px);
        box-shadow: 0 6px 18px rgba(0,0,0,.06);
    }
    .expertise-item .num {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem;
        letter-spacing: .2em;
        color: var(--bronze);
        min-width: 1.6rem;
    }

    /* ---- Mission + Closing as accented cards ---- */
    .accent-card {
        background: var(--ink);
        color: var(--ivory);
        padding: 2.5rem 2.2rem;
        border-top: 2px solid var(--gold);
        position: relative;
    }
    .accent-card h2 { color: var(--ivory) !important; }
    .accent-card p {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.2rem;
        line-height: 1.7;
        color: rgba(250,246,236,.9);
        margin: 0;
    }
    .accent-card p::first-letter { color: var(--gold-light) !important; }

    @media (max-width: 991px) {
        .about-nav { position: static; border-left: 0; padding: 0 0 1.5rem; margin-bottom: 1.5rem; display:flex; flex-wrap:wrap; gap:.5rem; border-bottom:1px solid var(--line); }
        .about-nav a { padding:.4rem .8rem; border-left:0; border:1px solid transparent; border-radius:999px; font-size:.62rem; letter-spacing:.22em; }
        .about-nav a.is-current { border-color: var(--bronze); background: rgba(0,0,0,.08); }
    }
    @media (max-width: 575px) {
        .about-hero { padding: 4.5rem 0 3.5rem; }
        .about-body { padding: 3.5rem 0; }
        .expertise-grid { grid-template-columns: 1fr; }
        .accent-card { padding: 1.75rem 1.4rem; }
    }
</style>
@endpush

@section('content')

{{-- ============================ HERO + QUOTE ============================ --}}
<section class="about-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="about-eyebrow">{{ __('site.about_title') }}</div>
                <h1>{{ $about->t('founder_title') ?: 'Who Is Alvaro Cunha?' }}</h1>
                @if($about->t('quote_text'))
                    <blockquote class="about-quote">
                        “{{ $about->t('quote_text') }}”
                    </blockquote>
                    @if($about->quote_author)
                        <div class="about-quote-author">{{ $about->quote_author }}</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ============================ BODY ============================ --}}
<section class="about-body">
    <div class="container">
        <div class="row g-5">

            {{-- Sticky side nav --}}
            <aside class="col-lg-3">
                <nav class="about-nav" id="aboutNav">
                    <a href="#who-is"    data-anchor>Who Is</a>
                    <a href="#institute" data-anchor>The Institute</a>
                    <a href="#mission"   data-anchor>Mission</a>
                    <a href="#expertise" data-anchor>Areas of Expertise</a>
                    <a href="#closing"   data-anchor>Closing Statement</a>
                </nav>
            </aside>

            {{-- Sections --}}
            <div class="col-lg-9">

                <article id="who-is" class="about-section">
                    <div class="about-ornament"><i class="fas fa-feather"></i></div>
                    <h2>{{ $about->t('founder_title') }}</h2>
                    @foreach(preg_split("/\r\n\r\n|\n\n/", trim($about->t('founder_text'))) as $para)
                        @if(trim($para) !== '')
                            <p class="lead-p">{{ $para }}</p>
                        @endif
                    @endforeach
                </article>

                <article id="institute" class="about-section">
                    <div class="about-ornament"><i class="fas fa-landmark"></i></div>
                    <h2>{{ $about->t('institute_title') }}</h2>
                    @foreach(preg_split("/\r\n\r\n|\n\n/", trim($about->t('institute_text'))) as $para)
                        @if(trim($para) !== '')
                            <p class="lead-p">{{ $para }}</p>
                        @endif
                    @endforeach
                </article>

                <article id="mission" class="about-section">
                    <div class="accent-card">
                        <div class="about-ornament" style="color:var(--gold-light);">
                            <i class="fas fa-compass"></i>
                        </div>
                        <h2>{{ $about->t('mission_title') }}</h2>
                        <p>{{ $about->t('mission_text') }}</p>
                    </div>
                </article>

                <article id="expertise" class="about-section">
                    <div class="about-ornament"><i class="fas fa-scroll"></i></div>
                    <h2>{{ $about->t('expertise_title') }}</h2>
                    @php $list = $about->expertiseList(); @endphp
                    @if(!empty($list))
                        <div class="expertise-grid">
                            @foreach($list as $i => $item)
                                <div class="expertise-item">
                                    <span class="num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span>{{ $item }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </article>

                <article id="closing" class="about-section">
                    <div class="accent-card">
                        <div class="about-ornament" style="color:var(--gold-light);">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <h2>{{ $about->t('closing_title') }}</h2>
                        <p>{{ $about->t('closing_text') }}</p>
                    </div>
                </article>

            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Side-nav active highlight as the user scrolls past each section.
(function () {
    var links = document.querySelectorAll('#aboutNav a[data-anchor]');
    if (!links.length) return;
    var sections = Array.from(links).map(function (a) {
        return document.querySelector(a.getAttribute('href'));
    }).filter(Boolean);

    function update() {
        var y = window.scrollY + 140;
        var current = sections[0];
        for (var i = 0; i < sections.length; i++) {
            if (sections[i].offsetTop <= y) current = sections[i];
        }
        links.forEach(function (a) {
            a.classList.toggle('is-current', a.getAttribute('href') === '#' + current.id);
        });
    }
    window.addEventListener('scroll', update, { passive: true });
    update();
})();
</script>
@endpush
