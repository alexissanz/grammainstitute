{{-- Shared About-page styles: Didot + parchment, classical hero, side-nav, accent cards. --}}
<style>
    .about-hero {
        position: relative;
        background:
            linear-gradient(135deg, rgba(26,22,18,.82) 0%, rgba(26,22,18,.58) 55%, rgba(26,22,18,.88) 100%),
            radial-gradient(circle at 18% 30%, rgba(168,120,65,.32), transparent 55%),
            #1a1612;
        color: var(--ivory);
        padding: 6rem 0 4.5rem;
        overflow: hidden;
    }
    .about-hero::before {
        content: 'Γράμμα';
        position: absolute;
        top: -2.5rem; right: -3rem;
        font-family: 'Bodoni Moda','Didot',serif;
        font-size: clamp(8rem, 18vw, 18rem);
        color: rgba(231,200,115,.06);
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
        font-size: clamp(2.4rem, 5vw, 3.8rem);
        line-height: 1.12;
        letter-spacing: .015em;
        color: var(--ivory);
        margin-bottom: 1.5rem;
    }
    .about-hero .lede,
    .about-hero p,
    .about-hero blockquote {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.25rem;
        line-height: 1.7;
        color: #ffffff !important;     /* always white over the brown/ink hero */
        max-width: 720px;
    }
    .about-hero .about-eyebrow { color: var(--gold-light) !important; }
    .about-hero h1 { color: #ffffff !important; }

    .about-body { background: var(--ivory); padding: 5rem 0 6rem; position: relative; }
    .about-body::before {
        content: 'λόγος';
        position: absolute;
        bottom: 2rem; left: -1.5rem;
        font-family: 'Bodoni Moda','Didot',serif;
        font-size: clamp(7rem, 14vw, 14rem);
        color: rgba(168,120,65,.05);
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
        padding: .65rem 1.25rem;
        margin-left: -1px;
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .26em;
        text-transform: uppercase;
        color: var(--stone);
        text-decoration: none;
        border-left: 2px solid transparent;
        transition: color .2s, border-color .2s, background .2s;
    }
    .about-nav a:hover { color: var(--bronze-dark); }
    .about-nav a.is-current {
        color: var(--ink);
        border-left-color: var(--bronze);
        background: rgba(168,120,65,.06);
    }

    .about-content h2 {
        font-family: 'Bodoni Moda','Didot',serif;
        font-weight: 500;
        font-size: clamp(1.8rem, 3vw, 2.6rem);
        letter-spacing: .015em;
        color: var(--ink);
        margin-bottom: 1.25rem;
    }
    .about-content .lead-p {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.18rem;
        line-height: 1.8;
        color: var(--ink-soft);
        margin-bottom: 1.25rem;
    }
    .about-content .lead-p:first-of-type::first-letter {
        font-family: 'Bodoni Moda','Didot',serif;
        font-size: 3.4rem;
        float: left;
        line-height: .9;
        padding-right: .6rem;
        padding-top: .3rem;
        color: var(--bronze-dark);
    }
    [dir="rtl"] .about-content .lead-p:first-of-type::first-letter { float: right; padding-right: 0; padding-left: .6rem; }

    .about-ornament {
        display: flex; align-items: center; gap: 1rem;
        margin-bottom: 1.5rem; color: var(--bronze);
    }
    .about-ornament::before, .about-ornament::after {
        content: ''; flex: 0 0 48px; height: 1px;
        background: linear-gradient(90deg, transparent, var(--bronze), transparent);
    }
    .about-ornament i { font-size: .85rem; }

    .about-quote {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: clamp(1.2rem, 1.8vw, 1.55rem);
        line-height: 1.6;
        color: var(--ink-soft);
        border-left: 2px solid var(--bronze);
        padding: .25rem 0 .25rem 1.6rem;
        margin: 2rem 0 1rem;
    }
    .about-quote-author {
        font-family: 'Cormorant SC', serif;
        font-size: .75rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--bronze-dark);
    }
    .about-quote-author::before { content: '— '; }

    .accent-card {
        background: var(--ink);
        color: #ffffff;
        padding: 2.5rem 2.2rem;
        border-top: 2px solid var(--gold);
        position: relative;
    }
    .accent-card h2,
    .accent-card h3,
    .accent-card p,
    .accent-card blockquote { color: #ffffff !important; }
    .accent-card p {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.2rem;
        line-height: 1.7;
        margin: 0;
    }

    .expertise-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: .9rem 1.5rem;
        margin-top: 1.5rem;
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
        box-shadow: 0 6px 18px rgba(26,22,18,.06);
    }
    .expertise-item .num {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem;
        letter-spacing: .2em;
        color: var(--bronze);
        min-width: 1.6rem;
    }

    .about-section-nav {
        display: flex; justify-content: space-between; align-items: center;
        gap: 1rem; flex-wrap: wrap;
        margin-top: 4rem; padding-top: 2rem;
        border-top: 1px solid var(--line);
    }
    .about-section-nav a {
        display: inline-flex; align-items: center; gap: .65rem;
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .24em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        text-decoration: none;
        padding: .5rem 0;
        transition: color .2s;
    }
    .about-section-nav a:hover { color: var(--ink); }
    .about-section-nav a.is-back i { margin-right: .25rem; }
    .about-section-nav a.is-next i { margin-left: .25rem; }
    .about-section-nav .spacer { flex: 1; }

    .about-index-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-top: 2.5rem;
    }
    .about-index-card {
        background: #fff;
        border: 1px solid var(--line);
        padding: 2rem 1.75rem;
        text-decoration: none;
        color: var(--ink);
        display: flex; flex-direction: column;
        position: relative;
        transition: transform .25s, box-shadow .25s, border-color .25s;
    }
    .about-index-card::before {
        content: ''; position: absolute; inset: 0;
        border-top: 3px solid var(--bronze);
        pointer-events: none;
        opacity: 0; transition: opacity .25s;
    }
    .about-index-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(26,22,18,.08);
        border-color: var(--bronze);
        color: var(--ink);
    }
    .about-index-card:hover::before { opacity: 1; }
    .about-index-card .ico {
        width: 48px; height: 48px;
        display: flex; align-items: center; justify-content: center;
        border: 1.5px solid var(--bronze);
        border-radius: 50%;
        color: var(--bronze-dark);
        margin-bottom: 1rem;
    }
    .about-index-card h3 {
        font-family: 'Bodoni Moda','Didot',serif;
        font-weight: 500;
        font-size: 1.35rem;
        letter-spacing: .015em;
        margin-bottom: .5rem;
    }
    .about-index-card .lede {
        font-family: 'Cormorant Garamond', serif;
        color: var(--ink-soft);
        font-size: 1.02rem;
        line-height: 1.5;
        margin: 0 0 1rem;
        flex: 1;
    }
    .about-index-card .more {
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .25em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        display: inline-flex; align-items: center; gap: .45rem;
    }

    @media (max-width: 991px) {
        .about-nav {
            position: static;
            border-left: 0;
            padding: 0 0 1.5rem;
            margin-bottom: 1.5rem;
            display: flex; flex-wrap: wrap; gap: .5rem;
            border-bottom: 1px solid var(--line);
        }
        .about-nav a {
            padding: .4rem .8rem;
            border-left: 0;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: .62rem;
            letter-spacing: .22em;
        }
        .about-nav a.is-current { border-color: var(--bronze); background: rgba(168,120,65,.08); }
    }
    @media (max-width: 575px) {
        .about-hero { padding: 4rem 0 3rem; }
        .about-body { padding: 3.5rem 0; }
        .expertise-grid { grid-template-columns: 1fr; }
        .accent-card { padding: 1.75rem 1.4rem; }
    }
</style>
