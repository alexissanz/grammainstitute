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
            linear-gradient(135deg, rgba(0,0,0,.78) 0%, rgba(0,0,0,.55) 55%, rgba(0,0,0,.85) 100%),
            radial-gradient(circle at 30% 30%, rgba(0,0,0,.45), transparent 55%),
            radial-gradient(circle at 75% 75%, rgba(0,0,0,.35), transparent 60%),
            #000000;
        color: var(--ivory);
        overflow: hidden;
    }
    .hero-classical::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 18% 22%, rgba(0,0,0,.18), transparent 35%),
            radial-gradient(circle at 84% 80%, rgba(0,0,0,.18), transparent 40%);
        pointer-events: none;
    }
    .hero-classical .hero-greek {
        position: absolute;
        top: 8%;
        right: -2%;
        font-family: var(--font-site-display);
        font-size: clamp(8rem, 22vw, 22rem);
        line-height: 1;
        color: rgba(255,255,255,.05);
        font-weight: 700;
        letter-spacing: .05em;
        pointer-events: none;
        user-select: none;
    }
    .hero-classical .container { position: relative; z-index: 2; padding-top: 4rem; padding-bottom: 4rem; }
    .hero-eyebrow {
        font-family: var(--font-site-smallcaps);
        font-size: .9rem;
        font-weight: 600;
        letter-spacing: .42em;
        color: var(--gold-light);
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .hero-headline {
        font-family: var(--font-site-display);
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
        font-family: var(--font-site-body);
        font-size: 1.35rem;
        line-height: 1.7;
        color: rgba(255,255,255,.86);
        max-width: 620px;
        margin-bottom: 2.5rem;
    }
    .hero-cta-row { display: flex; flex-wrap: wrap; gap: 1rem; }
    .hero-langs-strip {
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,.15);
        display: flex;
        flex-wrap: wrap;
        gap: 2.5rem 3rem;
        align-items: center;
    }
    .hero-langs-strip .lang-item {
        font-family: var(--font-site-course);
        font-weight: 500;
        font-size: .95rem;
        letter-spacing: .22em;
        color: rgba(255,255,255,.78);
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: .65rem;
    }
    .hero-langs-strip .lang-glyph {
        font-family: var(--font-site-course);
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
        border-top: 1px solid rgba(255,255,255,.08);
        border-bottom: 1px solid rgba(255,255,255,.08);
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
        color: rgba(255,255,255,.85);
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
        color: rgba(0,0,0,.05);
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
    .lang-offerings { background: #fff; padding: 7rem 0; }
    .lang-card {
        display: block;
        text-decoration: none;
        color: #fff;
        position: relative;
        min-height: 360px;
        overflow: hidden;
        background: #000;
        border: 1px solid rgba(255,255,255,.12);
        box-shadow: 0 16px 42px rgba(0,0,0,.22);
        cursor: pointer;
        touch-action: manipulation;
        -webkit-tap-highlight-color: rgba(255,255,255,.18);
        transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
    }
    .lang-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,.08) 100%);
        opacity: 0;
        transition: opacity .35s ease;
        pointer-events: none;
    }
    /* Hover lift ONLY on real mouse devices — never on touch (avoids the
       "first tap = hover, second tap = open" problem on phones). */
    @media (hover: hover) and (pointer: fine) {
        .lang-card:hover {
            transform: translateY(-12px) scale(1.015);
            box-shadow: 0 28px 64px rgba(0,0,0,.3);
            border-color: rgba(255,255,255,.32);
        }
        .lang-card:hover::after { opacity: 1; }
    }
    /* /gil/ watermark on every course card */
    .lang-card::before {
        content: '/gil/';
        position: absolute;
        top: 1rem;
        right: 1.2rem;
        font-family: "Bodoni Moda","Didot","GFS Didot",Georgia,serif;
        font-size: 1.35rem;
        font-weight: 400;
        color: rgba(255,255,255,.18);
        letter-spacing: -.01em;
        z-index: 3;
        pointer-events: none;
    }
    .lang-card .content {
        position: relative;
        min-height: 360px;
        padding: 2rem 1.8rem;
        color: #fff;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-end;
        pointer-events: none;   /* let every tap fall through to the card link */
        text-align: left;
    }
    .home-course-link {
        display: block;
        height: 100%;
        position: relative;
        z-index: 4;
        touch-action: manipulation;
        -webkit-tap-highlight-color: rgba(255,255,255,.14);
    }
    /* Full-card clickable overlay — covers the WHOLE card, above all content. */
    .lang-card-link {
        position: absolute;
        inset: 0;
        z-index: 6;
        display: block;
        font-size: 0;
        text-indent: -9999px;
        cursor: pointer;
        touch-action: manipulation;
        -webkit-tap-highlight-color: rgba(255,255,255,.18);
    }
    .lang-card .name {
        font-family: var(--font-site-course);
        font-size: clamp(1.2rem, 2.6vw, var(--font-size-course));
        font-weight: 600;
        letter-spacing: .18em;
        text-transform: uppercase;
        margin-bottom: 0;
        color: #fff;
    }

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
        box-shadow: 0 14px 40px rgba(0,0,0,.08);
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
            linear-gradient(135deg, rgba(0,0,0,.88) 0%, rgba(0,0,0,.55) 100%),
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
        color: rgba(255,255,255,.85);
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
        box-shadow: 0 4px 22px rgba(0,0,0,.06);
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
            linear-gradient(135deg, rgba(0,0,0,.92) 0%, rgba(0,0,0,.75) 100%),
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
        color: rgba(255,255,255,.85);
        max-width: 640px;
        margin: 0 auto 2.5rem;
    }

    /* ===========================================================
       HERO SLIDES — custom cross-fade carousel (images + videos)
       Smooth, video-aware (advances when each clip ends),
       images timed by JS, /gil/ watermark consistent with course cards.
       =========================================================== */
    .hero-slides {
        position: relative;
        width: 100%;
        min-height: 92vh;
        overflow: hidden;
        background: var(--ink);
        color: var(--ivory);
        display: flex;
        align-items: center;
    }
    .hero-slides.is-intro .hero-slide {
        opacity: 0 !important;
        pointer-events: none !important;
    }
    .hero-slides-stage {
        position: absolute;
        inset: 0;
        z-index: 0;
    }
    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1.4s cubic-bezier(.4,0,.2,1);
        pointer-events: none;
    }
    .hero-slide.is-active {
        opacity: 1;
        pointer-events: auto;
    }
    .hero-slide__media,
    .hero-slide__media video,
    .hero-slide__image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .hero-slide__media {
        background: #000;
    }
    .hero-slide__image {
        background-size: cover;
        background-position: center;
    }
    .hero-slide__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0,0,0,.78) 0%, rgba(0,0,0,.55) 55%, rgba(0,0,0,.85) 100%);
        z-index: 1;
    }
    .hero-slide-watermark {
        position: absolute;
        top: 1.5rem;
        right: 2rem;
        font-family: var(--font-site-display);
        font-size: 3rem;
        font-weight: 400;
        color: rgba(255,255,255,.55);
        letter-spacing: -.01em;
        z-index: 4;
        pointer-events: none;
        text-shadow: 0 1px 4px rgba(0,0,0,.45);
    }
    .hero-slides-content {
        position: relative;
        z-index: 3;
        width: 100%;
        padding: 5rem 0 4rem;
    }
    .hero-copy {
        max-width: 860px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        min-height: 14rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-intro {
        color: var(--ivory);
        display: inline-grid;
        grid-template-columns: auto;
        align-items: start;
        justify-content: center;
        gap: 1.9rem;
        line-height: 1.5;
        text-align: center;
        position: absolute;
        inset: 0;
        place-content: center;
        transition: opacity .35s ease, visibility .35s ease;
    }
    .hero-intro.is-hidden,
    .hero-slide-copy.is-hidden {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }
    .hero-intro-right {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 1.15rem;
    }
    .hero-intro-main {
        font-family: var(--font-site-display);
        font-size: clamp(2.25rem, 5.5vw, var(--font-size-hero-intro));
        line-height: 1.08;
        color: #fff;
        display: inline-block;
        text-align: center;
        text-transform: uppercase;
        font-style: normal;
        letter-spacing: .12em;
        white-space: nowrap;
        word-break: keep-all;
        overflow-wrap: normal;
    }
    .hero-intro-sub {
        font-family: var(--font-site-display);
        font-size: clamp(2.25rem, 5.5vw, var(--font-size-hero-intro));
        line-height: 1.12;
        color: rgba(255,255,255,.96);
        margin-top: 0;
        display: inline-block;
        text-align: center;
        text-transform: none;
        font-style: normal;
        letter-spacing: .12em;
        white-space: nowrap;
        word-break: keep-all;
        overflow-wrap: normal;
    }
    .hero-intro-sub .hero-intro-of {
        font-style: italic;
        text-transform: lowercase;
    }
    .hero-intro-city {
        font-family: var(--font-site-display);
        font-size: clamp(1rem, 2vw, 1.45rem);
        line-height: 1.15;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: rgba(255,255,255,.88);
        margin-top: .55rem;
        text-align: center;
        font-style: normal;
        white-space: nowrap;
    }
    .hero-intro-line.is-typing::after,
    .hero-copy-title.is-typing::after,
    .hero-copy-title.is-complete::after,
    .hero-copy-subtitle.is-typing::after,
    .hero-copy-subtitle.is-complete::after {
        content: '';
        display: inline-block;
        width: 1px;
        height: .95em;
        margin-left: .14em;
        background: currentColor;
        vertical-align: -.08em;
        animation: heroCaret .85s steps(1) infinite;
        box-shadow:
            0 0 8px rgba(255,255,255,.9),
            0 0 18px rgba(255,255,255,.58);
    }
    .hero-intro-sub.is-complete::after {
        content: '';
        display: inline-block;
        width: 1px;
        height: .95em;
        margin-left: .14em;
        background: currentColor;
        vertical-align: -.08em;
        animation: heroCaret .85s steps(1) infinite;
        box-shadow:
            0 0 8px rgba(255,255,255,.9),
            0 0 18px rgba(255,255,255,.58);
    }
    .hero-intro-line.is-typing,
    .hero-copy-title.is-typing,
    .hero-copy-subtitle.is-typing {
        animation: heroGlowWrite 1.05s ease-in-out infinite alternate;
    }
    .hero-intro-line.is-complete {
        animation: heroIntroGlowLocked .35s ease-out both;
        color: #ffffff;
        opacity: 1;
    }
    .hero-copy-title.is-complete,
    .hero-copy-subtitle.is-complete {
        animation: heroWhitePulse .78s ease-in-out infinite alternate;
        color: #ffffff;
        opacity: 1;
    }
    .hero-intro-line.is-empty::after {
        display: none;
    }
    .hero-slide-copy {
        color: var(--ivory);
        padding: 1.4rem 1.8rem;
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: opacity .35s ease, visibility .35s ease;
    }
    .hero-copy-title {
        font-family: var(--font-site-display);
        font-weight: 400;
        font-size: clamp(2.6rem, 7vw, var(--font-size-hero-slide));
        line-height: 1.08;
        letter-spacing: .02em;
        color: #ffffff;
        margin-bottom: 1rem;
        min-height: 1.2em;
        display: inline-block;
        max-width: 100%;
        text-wrap: balance;
        word-break: keep-all;
        overflow-wrap: normal;
        text-shadow:
            0 0 8px rgba(255,255,255,.42),
            0 0 16px rgba(255,255,255,.34),
            0 0 28px rgba(255,255,255,.24),
            0 0 56px rgba(255,255,255,.14),
            0 2px 8px rgba(0,0,0,.42);
    }
    .hero-copy-subtitle {
        font-family: var(--font-site-body);
        font-size: clamp(1.25rem, 3.2vw, calc(var(--font-size-hero-slide) * 0.42));
        line-height: 1.7;
        color: rgba(255,255,255,.96);
        max-width: 760px;
        min-height: 3.4em;
        margin: 0 auto;
        display: block;
        white-space: pre-line;
        text-transform: uppercase;
        text-wrap: balance;
        word-break: keep-all;
        overflow-wrap: normal;
        text-shadow:
            0 0 6px rgba(255,255,255,.34),
            0 0 14px rgba(255,255,255,.24),
            0 0 26px rgba(255,255,255,.14),
            0 0 48px rgba(255,255,255,.08),
            0 2px 8px rgba(0,0,0,.38);
    }
    .hero-copy-title { text-transform: uppercase; }
    .hero-copy-title.is-typing,
    .hero-copy-subtitle.is-typing {
        animation: heroGlowWrite .48s ease-in-out infinite alternate;
    }
    .hero-copy-title.is-empty,
    .hero-copy-subtitle.is-empty {
        min-height: 0;
        margin: 0 auto;
    }
    .hero-copy-title.is-empty::after,
    .hero-copy-subtitle.is-empty::after {
        display: none;
    }
    @keyframes heroCaret {
        0%, 49% { opacity: 1; }
        50%, 100% { opacity: 0; }
    }
    @keyframes heroGlowWrite {
        0% {
            text-shadow:
                0 0 8px rgba(255,255,255,.34),
                0 0 16px rgba(255,255,255,.26),
                0 0 28px rgba(255,255,255,.16),
                0 0 52px rgba(255,255,255,.08),
                0 2px 8px rgba(0,0,0,.3);
            filter: brightness(1);
        }
        100% {
            text-shadow:
                0 0 12px rgba(255,255,255,.58),
                0 0 24px rgba(255,255,255,.46),
                0 0 40px rgba(255,255,255,.3),
                0 0 78px rgba(255,255,255,.16),
                0 2px 8px rgba(0,0,0,.42);
            filter: brightness(1.18);
        }
    }
    @keyframes heroGlowSettle {
        0% {
            text-shadow:
                0 0 14px rgba(255,255,255,.54),
                0 0 28px rgba(255,255,255,.4),
                0 0 48px rgba(255,255,255,.24),
                0 0 86px rgba(255,255,255,.12),
                0 2px 8px rgba(0,0,0,.42);
            filter: brightness(1.16);
        }
        100% {
            text-shadow:
                0 0 8px rgba(255,255,255,.4),
                0 0 18px rgba(255,255,255,.28),
                0 0 32px rgba(255,255,255,.16),
                0 0 60px rgba(255,255,255,.08),
                0 2px 8px rgba(0,0,0,.34);
            filter: brightness(1.06);
        }
    }
    @keyframes heroIntroGlowLocked {
        0% {
            color: #ffffff;
            text-shadow:
                0 0 12px rgba(255,255,255,.54),
                0 0 24px rgba(255,255,255,.38),
                0 0 42px rgba(255,255,255,.2),
                0 0 80px rgba(255,255,255,.1),
                0 2px 8px rgba(0,0,0,.34);
            filter: brightness(1.06);
            transform: none;
        }
        100% {
            color: #ffffff;
            text-shadow:
                0 0 22px rgba(255,255,255,.9),
                0 0 40px rgba(255,255,255,.72),
                0 0 68px rgba(255,255,255,.46),
                0 0 118px rgba(255,255,255,.22),
                0 2px 8px rgba(0,0,0,.38);
            filter: brightness(1.22);
            transform: none;
        }
    }
    @keyframes heroWhitePulse {
        0% {
            color: #ffffff;
            text-shadow:
                0 0 18px rgba(255,255,255,.86),
                0 0 34px rgba(255,255,255,.7),
                0 0 58px rgba(255,255,255,.46),
                0 0 104px rgba(255,255,255,.24),
                0 2px 8px rgba(0,0,0,.34);
            filter: brightness(1.18);
            opacity: 1;
            transform: translateY(0);
        }
        100% {
            color: #ffffff;
            text-shadow:
                0 0 28px rgba(255,255,255,1),
                0 0 52px rgba(255,255,255,.9),
                0 0 92px rgba(255,255,255,.68),
                0 0 156px rgba(255,255,255,.34),
                0 2px 8px rgba(0,0,0,.38);
            filter: brightness(1.42);
            opacity: 1;
            transform: translateY(-8px);
        }
    }
    @media (min-width: 768px) and (max-width: 1100px) {
        .hero-slides {
            min-height: 100svh;
        }
        .hero-slide__media,
        .hero-slide__media video,
        .hero-slide__image {
            object-position: center center;
        }
        .hero-slides-content {
            min-height: 100svh;
            padding: 5.5rem 0 4rem;
        }
        .hero-copy {
            max-width: min(86vw, 900px);
            padding: 0 1.4rem;
            min-height: 12.5rem;
        }
        .hero-slide-copy {
            padding: 1.3rem 1.5rem;
        }
        .hero-copy-title {
            font-size: clamp(2.7rem, 5vw, 4.15rem);
            line-height: 1.08;
            letter-spacing: .015em;
            margin-bottom: .85rem;
        }
        .hero-copy-subtitle {
            font-size: clamp(1.22rem, 2.15vw, 1.62rem);
            line-height: 1.52;
            max-width: min(82vw, 760px);
            min-height: 2.8em;
        }
        .hero-intro {
            gap: .8rem;
        }
        .hero-intro-main {
            font-size: clamp(1.8rem, 4vw, 2.85rem);
            letter-spacing: .06em;
        }
        .hero-intro-sub {
            font-size: clamp(1.8rem, 4vw, 2.85rem);
            letter-spacing: .06em;
        }
        .hero-intro-right {
            gap: 1rem;
        }
    }
    @media (min-width: 768px) and (max-width: 900px) {
        .hero-copy-title {
            font-size: clamp(2.35rem, 4.5vw, 3.3rem);
        }
        .hero-copy-subtitle {
            font-size: clamp(1.08rem, 1.95vw, 1.36rem);
            max-width: 78vw;
        }
        .hero-intro-main {
            font-size: clamp(1.55rem, 3.5vw, 2.2rem);
            letter-spacing: .05em;
        }
        .hero-intro-sub {
            font-size: clamp(1.55rem, 3.5vw, 2.2rem);
            letter-spacing: .05em;
        }
    }
    @media (min-width: 820px) and (max-width: 1400px) and (orientation: landscape) {
        .hero-slides {
            min-height: 100svh;
            align-items: center;
        }
        .hero-slides-content {
            min-height: 100svh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.6rem 0 2.2rem;
        }
        .hero-copy {
            max-width: min(88vw, 980px);
            padding: 0 1.1rem;
            min-height: 11rem;
        }
        .hero-slide-copy {
            padding: .9rem 1rem;
        }
        .hero-copy-title {
            font-size: clamp(2.15rem, 4.2vw, 3.25rem);
            line-height: 1.04;
            letter-spacing: 0;
            margin-bottom: .55rem;
        }
        .hero-copy-subtitle {
            font-size: clamp(1rem, 1.8vw, 1.3rem);
            line-height: 1.34;
            max-width: min(74vw, 900px);
            min-height: 2.2em;
        }
        .hero-intro {
            gap: .45rem;
            align-items: center;
        }
        .hero-intro-main {
            font-size: clamp(1.42rem, 3vw, 2.1rem);
            letter-spacing: .03em;
        }
        .hero-intro-sub {
            font-size: clamp(1.42rem, 3vw, 2.1rem);
            letter-spacing: .03em;
        }
        .hero-intro-right {
            gap: .9rem;
        }
        .hero-intro-sub.is-complete::after,
        .hero-copy-title.is-complete::after,
        .hero-copy-subtitle.is-complete::after,
        .hero-copy-title.is-typing::after,
        .hero-copy-subtitle.is-typing::after,
        .hero-intro-line.is-typing::after {
            position: static;
            right: auto;
            bottom: auto;
            margin-left: .05em;
        }
    }
    @media (max-width: 575px) {
        .hero-slides {
            min-height: 100svh;
            align-items: center;
        }
        .hero-slides-content {
            min-height: 100svh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.4rem 0;
        }
        .hero-copy {
            max-width: 100%;
            padding: 0 .65rem;
            min-height: 10.5rem;
        }
        .hero-slide-copy {
            padding: 1rem .35rem;
            border-radius: 0;
            background: transparent;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
        }
        .hero-copy-title {
            font-size: clamp(1.9rem, 8.6vw, 2.45rem);
            line-height: 1.12;
            margin-bottom: .7rem;
            letter-spacing: 0;
        }
        .hero-copy-subtitle {
            font-size: 1rem;
            line-height: 1.42;
            min-height: 0;
            max-width: 100%;
        }
        .hero-slide-watermark { top: 1rem; right: 1.2rem; font-size: 2rem; }
        .hero-intro {
            gap: .65rem;
            grid-template-columns: auto;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .hero-intro-main {
            font-size: clamp(1rem, 5.8vw, 1.28rem);
            letter-spacing: .03em;
        }
        .hero-intro-sub {
            font-size: clamp(1rem, 5.8vw, 1.28rem);
            letter-spacing: .03em;
        }
        .hero-intro-right {
            gap: .8rem;
        }
        .hero-intro-city {
            font-size: clamp(.74rem, 3.5vw, .9rem);
            letter-spacing: .12em;
        }
    }

    @media (max-width: 767px) {
        .hero-classical { min-height: auto; padding: 5rem 0; }
        .hero-langs-strip { gap: 1.5rem 2rem; margin-top: 2.5rem; }
        .lang-card,
        .lang-card .content { min-height: 330px; }
        .lang-card {
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 18px 42px rgba(0,0,0,.22);
        }
        .lang-card .content {
            padding: 1.4rem 1.25rem 1.5rem;
        }
        .lang-card .name {
            font-size: 1.05rem;
            line-height: 1.28;
        }
        .manifesto, .lang-offerings, .pillars, .reviews, .manuscript-banner, .cta-band { padding: 4rem 0; }
        .hero-intro { align-items: center; }
        .hero-intro-main { letter-spacing: .05em; }
        .hero-intro-sub,
        .hero-intro-city { letter-spacing: .06em; }
    }

    @media (max-width: 575px) {
        .lang-offerings .row.g-4 {
            row-gap: 1rem !important;
        }
        .lang-offerings .col-md-6,
        .lang-offerings .col-lg-4,
        .lang-offerings .col-lg-6 {
            width: 100%;
        }
        .home-course-link {
            display: block;
        }
    }

    @media (hover: none) and (pointer: coarse) {
        /* Touch devices: NO :hover rule at all (its mere existence makes iOS
           require a second tap). Only an instant press feedback. */
        .lang-card:active {
            transform: scale(.985);
            box-shadow: 0 10px 28px rgba(0,0,0,.28);
        }
        .lang-card, .lang-card-link { -webkit-tap-highlight-color: rgba(255,255,255,.18); }
    }
</style>
@endpush

@section('content')

@php
    $heroTipo = $settings->hero_tipo ?? 'imagem';
    // Hero image: prefer DB-uploaded, fallback to bundled classical SVG so the page
    // is never empty before the admin uploads their own photo.
    $heroImg  = $settings->imagem_hero
        ? Storage::url($settings->imagem_hero)
        : asset('images/site/hero-default.svg');
    $homeCourseImage = asset('images/site/ceu.png');

    // Use real courses from DB instead of hardcoded list
    $coursesForHero = $courses ?? collect();
@endphp

{{-- =========================================================
     HERO — IMAGEM, SLIDES OU VÍDEO
     ========================================================= --}}
@if($heroTipo === 'slides' && count($heroSlides) > 0)
<section class="hero-slides" id="heroSlides" aria-roledescription="carousel">
    <div class="hero-slides-stage" id="heroSlidesStage">
        @foreach($heroSlides as $i => $slide)
            <div class="hero-slide"
                 data-index="{{ $i }}"
                 data-type="{{ $slide->isVideo() ? 'video' : 'image' }}"
                 data-title="{{ e($slide->getTitulo()) }}"
                 data-subtitle="{{ e($slide->getSubtitulo()) }}">
                @if($slide->isVideo())
                    <video class="hero-slide__media"
                           autoplay muted playsinline webkit-playsinline preload="auto"
                           @if($slide->posterUrl()) poster="{{ $slide->posterUrl() }}" @endif>
                        <source src="{{ $slide->mediaUrl() }}" type="{{ $slide->mediaMimeType() }}">
                    </video>
                @elseif($slide->imagem)
                    <div class="hero-slide__image" style="background-image:url('{{ $slide->mediaUrl() }}');"></div>
                @endif
                <div class="hero-slide__overlay"></div>
            </div>
        @endforeach
        <span class="hero-slide-watermark" aria-hidden="true">/gil/</span>
    </div>
    <div class="hero-slides-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-copy">
                        <div class="hero-intro" id="heroIntro">
                            <div class="hero-intro-right">
                                <div class="hero-intro-main hero-intro-line" id="heroIntroMain"></div>
                                <div class="hero-intro-sub hero-intro-line" id="heroIntroSub"></div>
                                <div class="hero-intro-city hero-intro-line" id="heroIntroCity"></div>
                            </div>
                        </div>
                        <div class="hero-slide-copy is-hidden" id="heroSlideCopy">
                            <h1 class="hero-copy-title" id="heroCopyTitle"></h1>
                            <p class="hero-copy-subtitle" id="heroCopySubtitle"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@elseif($heroTipo === 'video' && $settings->hero_video)
<section class="hero-slides" id="heroSlides">
    <div class="hero-slides-stage">
        <div class="hero-slide"
             data-type="video"
             data-title="{{ e($settings->titulo_site ?: $settings->nome_site ?: 'Gramma Institute') }}"
             data-subtitle="{{ e($settings->subtitulo_site ?: $settings->descricao_site ?: '') }}">
            <video class="hero-slide__media" autoplay muted loop playsinline webkit-playsinline preload="auto">
                <source src="{{ route('media.serve', ['path' => $settings->hero_video], false) }}" type="video/mp4">
            </video>
            <div class="hero-slide__overlay"></div>
        </div>
        <span class="hero-slide-watermark" aria-hidden="true">/gil/</span>
    </div>
    <div class="hero-slides-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-copy">
                        <div class="hero-intro" id="heroIntro">
                            <div class="hero-intro-right">
                                <div class="hero-intro-main hero-intro-line" id="heroIntroMain"></div>
                                <div class="hero-intro-sub hero-intro-line" id="heroIntroSub"></div>
                                <div class="hero-intro-city hero-intro-line" id="heroIntroCity"></div>
                            </div>
                        </div>
                        <div class="hero-slide-copy is-hidden" id="heroSlideCopy">
                            <h1 class="hero-copy-title" id="heroCopyTitle"></h1>
                            <p class="hero-copy-subtitle" id="heroCopySubtitle"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@else
{{-- DEFAULT: classical hero with parchment/Greek vibe --}}
<section class="hero-classical" style="background-image: linear-gradient(135deg, rgba(0,0,0,.78) 0%, rgba(0,0,0,.55) 55%, rgba(0,0,0,.85) 100%), url('{{ $heroImg }}'); background-size: cover; background-position: center;">
    <span class="hero-greek" aria-hidden="true">Γράμμα</span>
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="hero-langs-strip">
                    <div class="lang-item"><span class="lang-glyph">Ελ</span> {{ __('site.course_greek') }}</div>
                    <div class="lang-item"><span class="lang-glyph">אב</span> {{ __('site.course_hebrew') }}</div>
                    <div class="lang-item"><span class="lang-glyph">En</span> {{ __('site.course_english') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- =========================================================
     LANGUAGE OFFERINGS
     ========================================================= --}}
<section class="lang-offerings">
    <div class="container">
        <div class="row g-4">
            @foreach($coursesForHero as $idx => $course)
            <div class="col-lg-4 col-md-6">
                {{-- The whole card IS the link — a single tap anywhere opens the course (PC + mobile). --}}
                <a href="{{ route('courses.show', $course->slug) }}" class="lang-card" aria-label="{{ $course->t('nome') }}">
                    <div class="content">
                        <div class="name">{{ $course->t('nome') }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
// HERO SLIDES — cross-fade controller. Each video advances on `ended`;
// images use a 7s timer; previous video is paused after the 1.4s fade completes.
(function () {
    var hero = document.getElementById('heroSlides');
    if (!hero) return;
    var stage = document.getElementById('heroSlidesStage') || hero.querySelector('.hero-slides-stage');
    if (!stage) return;
    var slides = Array.prototype.slice.call(stage.querySelectorAll('.hero-slide'));
    if (slides.length === 0) return;
    var introWrap = document.getElementById('heroIntro');
    var slideCopyWrap = document.getElementById('heroSlideCopy');
    var introMainEl = document.getElementById('heroIntroMain');
    var introSubEl = document.getElementById('heroIntroSub');
    var introCityEl = document.getElementById('heroIntroCity');
    var titleEl = document.getElementById('heroCopyTitle');
    var subtitleEl = document.getElementById('heroCopySubtitle');
    var IMAGE_MS  = 7000;
    var FADE_MS   = 1500;
    var current   = -1;
    var timer     = null;
    var typeRun   = 0;
    var introDone = false;
    var introLines = ['GRAMMA INSTITUTE', 'of LINGUISTICS'];

    hero.classList.add('is-intro');
    slides.forEach(function (slide) {
        slide.classList.remove('is-active');
        pauseMedia(slide);
    });

    function normalizeVideoText(text) {
        return String(text || '')
            .replace(/\r\n/g, "\n")
            .replace(/[ \t]+\n/g, "\n")
            .replace(/\n[ \t]+/g, "\n")
            .trim()
            .toUpperCase();
    }

    function applyIntroSubMarkup(el) {
        if (!el) return;
        var plain = (el.textContent || '').trim();
        if (plain.toLowerCase() === 'of linguistics') {
            el.innerHTML = '<span class="hero-intro-of">of</span> LINGUISTICS';
        }
    }

    function typeInto(el, text, cps, token, startDelay) {
        if (!el) return;
        el.classList.remove('is-complete', 'is-empty', 'is-typing');
        el.textContent = '';
        if (!text) {
            el.classList.add('is-empty');
            return;
        }
        var output = '';
        var i = 0;
        var delay = Math.max(14, Math.round(1000 / cps));
        var bootDelay = startDelay || 0;

        setTimeout(function () {
            if (token !== typeRun) return;
            el.classList.add('is-typing');

            (function step() {
                if (token !== typeRun) return;
                if (i >= text.length) {
                    el.classList.remove('is-typing');
                    el.classList.add('is-complete');
                    if (el === introSubEl) {
                        applyIntroSubMarkup(el);
                    }
                    return;
                }
                output += text.charAt(i++);
                el.textContent = output;
                setTimeout(step, delay);
            })();
        }, bootDelay);
    }

    function typeDuration(text, cps) {
        return text ? Math.max(14, Math.round(1000 / cps)) * text.length : 0;
    }

    function updateHeroCopy(slide) {
        typeRun += 1;
        var token = typeRun;
        var titleText = normalizeVideoText(slide.dataset.title || '');
        var subtitleText = normalizeVideoText(slide.dataset.subtitle || '');
        var titleMs = typeDuration(titleText, 26);

        typeInto(titleEl, titleText, 26, token, 0);
        typeInto(subtitleEl, subtitleText, 42, token, titleText ? titleMs + 140 : 0);
    }

    function startCarousel() {
        if (introDone) return;
        introDone = true;
        hero.classList.remove('is-intro');
        if (introWrap) introWrap.classList.add('is-hidden');
        if (slideCopyWrap) slideCopyWrap.classList.remove('is-hidden');

        current = 0;
        slides[current].classList.add('is-active');

        if (slides.length < 2) {
            var v0 = slides[current].querySelector('video');
            if (v0) v0.loop = true;
            updateHeroCopy(slides[current]);
            playMedia(slides[current]);
            return;
        }

        updateHeroCopy(slides[current]);
        playMedia(slides[current]);
        scheduleNext(slides[current]);
    }

    function playMedia(slide) {
        var v = slide.querySelector('video');
        if (!v) return;
        try { v.currentTime = 0; } catch (e) {}
        var p = v.play();
        if (p && typeof p.catch === 'function') p.catch(function () {});
    }
    function pauseMedia(slide) {
        var v = slide.querySelector('video');
        if (v) { try { v.pause(); } catch (e) {} }
    }
    function clearTimer() { if (timer) { clearTimeout(timer); timer = null; } }

    // Single slide — no rotation; loop the video if it's a video.
    function scheduleNext(slide) {
        clearTimer();
        var advanced = false;
        function advance() { if (!advanced) { advanced = true; goNext(); } }

        if (slide.dataset.type === 'video') {
            var v = slide.querySelector('video');
            if (v) {
                v.addEventListener('ended', advance, { once: true });
                // Safety fallback in case 'ended' never fires (codec quirks, very short clip)
                var dur = (isFinite(v.duration) && v.duration > 0 && v.duration < 60) ? v.duration : 8;
                timer = setTimeout(advance, Math.round(dur * 1000) + 400);
                return;
            }
        }
        timer = setTimeout(advance, IMAGE_MS);
    }

    function goNext() {
        clearTimer();
        var prev = slides[current];
        current = (current + 1) % slides.length;
        var next = slides[current];

        playMedia(next);                          // start before fade-in
        prev.classList.remove('is-active');
        next.classList.add('is-active');
        updateHeroCopy(next);

        setTimeout(function () { pauseMedia(prev); }, FADE_MS);
        scheduleNext(next);
    }

    typeRun += 1;
    var introToken = typeRun;
    var introOffset = 0;
    setTimeout(function () { typeInto(introMainEl, introLines[0], 22, introToken); }, introOffset);
    introOffset += typeDuration(introLines[0], 22) + 180;
    setTimeout(function () { typeInto(introSubEl, introLines[1], 24, introToken); }, introOffset);
    introOffset += typeDuration(introLines[1], 24) + 180;
    if (introCityEl) introCityEl.classList.add('is-hidden');
    introOffset += 1500;
    setTimeout(startCarousel, introOffset);

    // Save resources when tab not visible
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            clearTimer();
            pauseMedia(slides[current]);
        } else if (introDone) {
            playMedia(slides[current]);
            scheduleNext(slides[current]);
        }
    });
})();
</script>
@endpush

@push('scripts')
<script>
// Course cards: a single tap ANYWHERE on the card opens the course on mobile.
// touchend fires immediately (no 300ms / hover-emulation double-tap), and we
// guard against scroll so a swipe doesn't navigate by accident.
(function () {
    var cards = document.querySelectorAll('.lang-card');
    cards.forEach(function (card) {
        var inner = card.matches('a[href]') ? null : card.querySelector('a[href]');
        var href = card.getAttribute('href') || (inner ? inner.getAttribute('href') : null);
        if (!href) return;

        var startX = 0, startY = 0, moved = false;
        card.addEventListener('touchstart', function (e) {
            moved = false;
            if (e.touches && e.touches[0]) { startX = e.touches[0].clientX; startY = e.touches[0].clientY; }
        }, { passive: true });
        card.addEventListener('touchmove', function (e) {
            if (e.touches && e.touches[0]) {
                if (Math.abs(e.touches[0].clientX - startX) > 10 || Math.abs(e.touches[0].clientY - startY) > 10) {
                    moved = true;
                }
            }
        }, { passive: true });
        card.addEventListener('touchend', function (e) {
            if (moved) return;            // it was a scroll/swipe
            e.preventDefault();           // stop the delayed synthetic click
            window.location.href = href;
        }, { passive: false });
    });
})();
</script>
@endpush
