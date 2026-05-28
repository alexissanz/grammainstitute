{{-- Shared Resources page styles (Didot + parchment, classical) --}}
<style>
    .resource-group-title {
        font-family: 'Bodoni Moda','Didot',serif;
        font-weight: 500;
        font-size: clamp(1.2rem, 2.2vw, 1.6rem);
        letter-spacing: .02em;
        color: var(--ink);
        margin: 2.2rem 0 .9rem;
        padding-bottom: .4rem;
        border-bottom: 1px solid var(--line);
    }
    .resource-group-title:first-child { margin-top: 0; }
    .resources-hero {
        position: relative;
        background:
            linear-gradient(135deg, rgba(26,22,18,.82) 0%, rgba(26,22,18,.58) 55%, rgba(26,22,18,.88) 100%),
            radial-gradient(circle at 20% 60%, rgba(168,120,65,.32), transparent 55%),
            #1a1612;
        color: var(--ivory);
        padding: 5.5rem 0 4rem;
        overflow: hidden;
    }
    .resources-hero::before {
        content: '\f02d';   /* fa book */
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 10%; right: -1rem;
        font-size: clamp(7rem, 14vw, 14rem);
        color: rgba(231,200,115,.06);
        pointer-events: none;
    }
    .resources-hero .container { position: relative; z-index: 2; }
    .resources-hero .eyebrow {
        font-family: 'Cormorant SC', serif;
        font-size: .82rem;
        letter-spacing: .42em;
        text-transform: uppercase;
        color: var(--gold-light);
        margin-bottom: 1rem;
    }
    .resources-hero h1,
    .resources-hero .lede,
    .resources-hero p {
        color: #ffffff !important;
    }
    .resources-hero h1 {
        font-family: 'Bodoni Moda','Didot',serif;
        font-weight: 500;
        font-size: clamp(2.4rem, 5vw, 3.8rem);
        margin-bottom: 1.25rem;
    }
    .resources-hero .lede {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.18rem;
        max-width: 760px;
    }

    .resources-body { background: var(--ivory); padding: 5rem 0 6rem; }

    /* Index grid: 5 category cards */
    .resource-cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-top: 2.5rem;
    }
    .resource-cat-card {
        background: #fff;
        border: 1px solid var(--line);
        padding: 2rem 1.75rem;
        text-decoration: none;
        color: var(--ink);
        display: flex; flex-direction: column;
        position: relative;
        transition: transform .25s, box-shadow .25s, border-color .25s;
    }
    .resource-cat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(26,22,18,.08);
        border-color: var(--bronze);
        color: var(--ink);
    }
    .resource-cat-card .ico {
        width: 48px; height: 48px;
        display: flex; align-items: center; justify-content: center;
        border: 1.5px solid var(--bronze);
        border-radius: 50%;
        color: var(--bronze-dark);
        margin-bottom: 1rem;
    }
    .resource-cat-card h3 {
        font-family: 'Bodoni Moda','Didot',serif;
        font-weight: 500;
        font-size: 1.35rem;
        letter-spacing: .015em;
        margin-bottom: .5rem;
    }
    .resource-cat-card .desc {
        font-family: 'Cormorant Garamond', serif;
        color: var(--ink-soft);
        font-size: 1.02rem;
        line-height: 1.55;
        margin: 0 0 1rem;
        flex: 1;
    }
    .resource-cat-card .more {
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .25em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        display: inline-flex; align-items: center; gap: .45rem;
    }
    .resource-cat-card .count {
        position: absolute;
        top: 1rem; right: 1.2rem;
        font-family: 'Cormorant SC', serif;
        font-size: .7rem;
        letter-spacing: .2em;
        color: var(--stone);
    }

    /* Category page: sidenav + links list */
    .resource-side-nav {
        position: sticky;
        top: 90px;
        padding: 1rem 0;
        border-left: 1px solid var(--line);
    }
    .resource-side-nav a {
        display: block;
        padding: .55rem 1.2rem;
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
    .resource-side-nav a:hover { color: var(--bronze-dark); }
    .resource-side-nav a.is-current {
        color: var(--ink);
        border-left-color: var(--bronze);
        background: rgba(168,120,65,.05);
    }

    .resource-section h2 {
        font-family: 'Bodoni Moda','Didot',serif;
        font-weight: 500;
        font-size: clamp(1.85rem, 3vw, 2.6rem);
        letter-spacing: .015em;
        color: var(--ink);
        margin-bottom: 1rem;
    }
    .resource-section .lede {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.15rem;
        line-height: 1.7;
        color: var(--ink-soft);
        margin-bottom: 2rem;
    }

    .resource-link-list {
        display: flex;
        flex-direction: column;
        gap: .85rem;
        margin: 1.5rem 0 2rem;
    }
    .resource-link {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1.1rem 1.4rem;
        background: #fff;
        border: 1px solid var(--line);
        border-left: 3px solid var(--bronze);
        text-decoration: none;
        color: var(--ink);
        transition: border-color .25s, transform .25s, box-shadow .25s;
    }
    .resource-link:hover {
        border-left-color: var(--gold);
        transform: translateX(3px);
        box-shadow: 0 8px 20px rgba(26,22,18,.06);
        color: var(--ink);
    }
    .resource-link .body { flex: 1; min-width: 0; }
    .resource-link .title {
        font-family: 'Bodoni Moda','Didot',serif;
        font-size: 1.08rem;
        font-weight: 500;
        margin-bottom: .15rem;
    }
    .resource-link .desc {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: .95rem;
        color: var(--stone);
        margin: 0;
    }
    .resource-link .open {
        font-family: 'Cormorant SC', serif;
        font-size: .68rem;
        letter-spacing: .25em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        display: inline-flex; align-items: center; gap: .4rem;
        flex-shrink: 0;
    }

    .resources-empty {
        text-align: center;
        padding: 2.5rem 1rem;
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        background: #fff;
        border: 1px dashed var(--line);
    }

    @media (max-width: 991px) {
        .resource-side-nav {
            position: static;
            border-left: 0; padding: 0 0 1.25rem;
            display: flex; flex-wrap: wrap; gap: .5rem;
            border-bottom: 1px solid var(--line); margin-bottom: 1.5rem;
        }
        .resource-side-nav a {
            border-left: 0; border: 1px solid transparent; border-radius: 999px;
            padding: .4rem .8rem; font-size: .62rem; letter-spacing: .22em;
        }
        .resource-side-nav a.is-current { border-color: var(--bronze); background: rgba(168,120,65,.08); }
    }
    @media (max-width: 575px) {
        .resources-hero { padding: 4rem 0 3rem; }
        .resources-body { padding: 3.5rem 0; }
        .resource-link { padding: 1rem; flex-direction: column; align-items: flex-start; gap: .5rem; }
    }
</style>
