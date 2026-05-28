@extends('layouts.adminlte')

@section('title', __('dashboard.menu_dashboard'))
@section('page-title', __('dashboard.title'))

@push('styles')
<style>
    /* ============================================================
       DASHBOARD — classical, animated, Gramma feel
       ============================================================ */
    .dash-hero {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        background: linear-gradient(135deg, #1a1612 0%, #322a20 55%, #1a1612 100%);
        color: var(--ivory);
        padding: 2.5rem 2.25rem;
        margin-bottom: 1.75rem;
        box-shadow: 0 12px 36px rgba(26,22,18,.18);
    }
    .dash-hero::before {
        content: 'Γράμμα';
        position: absolute;
        right: -1rem; bottom: -2.5rem;
        font-family: 'Cinzel', serif;
        font-size: clamp(6rem, 18vw, 14rem);
        font-weight: 700;
        color: rgba(231,200,115,.06);
        pointer-events: none;
        line-height: 1;
        user-select: none;
    }
    .dash-hero::after {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(circle at 20% 20%, rgba(231,200,115,.12), transparent 50%),
            radial-gradient(circle at 78% 78%, rgba(168,120,65,.12), transparent 55%);
        pointer-events: none;
    }
    .dash-hero > * { position: relative; z-index: 1; }
    .dash-hero .eyebrow {
        font-family: 'Cormorant SC', serif;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .35em;
        color: var(--gold-light);
        text-transform: uppercase;
        margin-bottom: .35rem;
        display: inline-flex;
        align-items: center;
        gap: .65rem;
    }
    .dash-hero .eyebrow::before {
        content: '';
        width: 28px; height: 1px;
        background: var(--gold-light);
    }
    .dash-hero h1 {
        font-family: 'Bodoni Moda', serif;
        font-size: clamp(1.6rem, 3.2vw, 2.4rem);
        font-weight: 500;
        margin: 0 0 .4rem;
        line-height: 1.15;
        color: var(--ivory);
    }
    .dash-hero h1 em {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-weight: 400;
        color: var(--gold-light);
    }
    .dash-hero p {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.1rem;
        margin: 0;
        color: rgba(250,246,236,.78);
    }
    .dash-hero-actions {
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
        margin-top: 1.25rem;
    }
    .dash-hero-actions .btn-classic {
        font-family: 'Inter', sans-serif;
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: .18em;
        text-transform: uppercase;
        padding: .65rem 1.2rem;
        background: var(--gold-light);
        color: var(--ink);
        border: 1.5px solid var(--gold-light);
        border-radius: 999px;
        text-decoration: none;
        transition: all .2s;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
    }
    .dash-hero-actions .btn-classic:hover {
        background: var(--ivory);
        color: var(--ink);
        border-color: var(--ivory);
        transform: translateY(-2px);
    }
    .dash-hero-actions .btn-classic.outline {
        background: transparent;
        color: var(--gold-light);
        border-color: rgba(231,200,115,.45);
    }
    .dash-hero-actions .btn-classic.outline:hover {
        background: var(--gold-light);
        color: var(--ink);
    }

    /* ===== STAT TILES ===== */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-tile {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 1.25rem 1.25rem 1rem;
        box-shadow: 0 2px 12px rgba(26,22,18,.05);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform .25s, box-shadow .25s, border-color .25s;
        animation: tileIn .55s cubic-bezier(.2,.8,.2,1) backwards;
    }
    .stat-tile:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 36px rgba(26,22,18,.12);
        border-color: var(--bronze);
        color: inherit;
        text-decoration: none;
    }
    @keyframes tileIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-tile:nth-child(1) { animation-delay: .05s; }
    .stat-tile:nth-child(2) { animation-delay: .12s; }
    .stat-tile:nth-child(3) { animation-delay: .18s; }
    .stat-tile:nth-child(4) { animation-delay: .24s; }
    .stat-tile:nth-child(5) { animation-delay: .30s; }
    .stat-tile:nth-child(6) { animation-delay: .36s; }
    .stat-tile .stat-eyebrow {
        font-family: 'Cormorant SC', serif;
        font-size: .68rem;
        letter-spacing: .28em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        margin-bottom: .35rem;
    }
    .stat-tile .stat-value {
        font-family: 'Bodoni Moda', serif;
        font-size: 2.6rem;
        font-weight: 600;
        color: var(--ink);
        line-height: 1;
        margin-bottom: .35rem;
    }
    .stat-tile .stat-label {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        font-size: .92rem;
    }
    .stat-tile .stat-decor {
        position: absolute;
        right: 1rem; top: 1rem;
        font-family: 'Cinzel', serif;
        font-size: 1.4rem;
        color: rgba(168,120,65,.12);
    }
    .stat-tile .stat-foot {
        font-size: .72rem;
        color: var(--bronze-dark);
        margin-top: .65rem;
        letter-spacing: .04em;
    }
    .stat-tile .stat-foot i { transition: transform .2s; }
    .stat-tile:hover .stat-foot i { transform: translateX(3px); }

    /* ===== SECTION CARDS ===== */
    .gramma-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(26,22,18,.05);
        overflow: hidden;
        animation: tileIn .6s .35s cubic-bezier(.2,.8,.2,1) backwards;
    }
    .gramma-card-head {
        padding: 1.25rem 1.5rem .75rem;
        border-bottom: 1px solid var(--line);
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem;
    }
    .gramma-card-head h6 {
        font-family: 'Bodoni Moda', serif;
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: var(--ink);
        letter-spacing: .015em;
        display: inline-flex;
        align-items: center;
        gap: .6rem;
    }
    .gramma-card-head h6 i { color: var(--bronze); }
    .gramma-card-body { padding: 1rem 1.5rem 1.25rem; }

    /* progress meter */
    .completion-meter {
        height: 10px;
        border-radius: 999px;
        background: var(--parchment);
        overflow: hidden;
        margin-top: .75rem;
    }
    .completion-meter > div {
        height: 100%;
        background: linear-gradient(90deg, var(--bronze) 0%, var(--gold-light) 100%);
        border-radius: 999px;
        width: 0;
        animation: fillIn 1.2s .4s cubic-bezier(.2,.8,.2,1) forwards;
    }
    @keyframes fillIn { to { width: var(--target, 0%); } }

    .section-row {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: .7rem 0;
        border-bottom: 1px solid var(--line);
    }
    .section-row:last-child { border-bottom: 0; }
    .section-row .dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .section-row .dot.ok    { background: #15803d; box-shadow: 0 0 0 4px rgba(21,128,61,.12); }
    .section-row .dot.pending { background: var(--line); }
    .section-row .label {
        flex: 1;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.02rem;
        color: var(--ink);
    }
    .section-row a {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem;
        letter-spacing: .26em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        text-decoration: none;
    }
    .section-row a:hover { color: var(--burgundy); }

    /* quick links */
    .quick-link {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: .8rem 1rem;
        border: 1px solid var(--line);
        border-radius: 12px;
        text-decoration: none;
        color: var(--ink);
        transition: all .2s;
        margin-bottom: .5rem;
        background: #fff;
    }
    .quick-link:hover {
        border-color: var(--bronze);
        background: var(--parchment);
        color: var(--ink);
        text-decoration: none;
        transform: translateX(4px);
    }
    .quick-link .ql-ic {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--parchment);
        color: var(--bronze-dark);
        flex-shrink: 0;
        font-size: 1rem;
    }
    .quick-link:hover .ql-ic { background: var(--bronze); color: #fff; }
    .quick-link .ql-text {
        flex: 1;
        font-family: 'Bodoni Moda', serif;
        font-size: .95rem;
        font-weight: 500;
        color: var(--ink);
    }
    .quick-link .ql-text small {
        display: block;
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        font-size: .82rem;
        font-weight: 400;
        margin-top: 2px;
    }
    .quick-link i.arrow { color: var(--bronze); opacity: .5; transition: all .2s; }
    .quick-link:hover i.arrow { opacity: 1; transform: translateX(3px); }

    /* info table inside cards */
    .info-table { width: 100%; }
    .info-table td {
        padding: .55rem 0;
        border-bottom: 1px solid var(--line);
        font-size: .92rem;
    }
    .info-table tr:last-child td { border-bottom: 0; }
    .info-table td.label {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--stone);
        width: 42%;
    }
    .info-table td.val {
        font-family: 'Bodoni Moda', serif;
        color: var(--ink);
        text-align: right;
    }
    .info-table td.val .pill {
        display: inline-block;
        padding: .15rem .65rem;
        background: var(--parchment);
        border: 1px solid var(--line);
        border-radius: 999px;
        font-family: 'Cormorant SC', serif;
        font-size: .68rem;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--bronze-dark);
    }

    /* social grid */
    .social-line {
        display: flex; align-items: center;
        gap: .65rem;
        padding: .55rem 0;
        border-bottom: 1px dashed var(--line);
        font-size: .92rem;
    }
    .social-line:last-child { border-bottom: 0; }
    .social-line .so-ic {
        width: 28px; height: 28px;
        border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .85rem;
        color: #fff;
    }
    .social-line .so-label { flex: 1; font-family: 'Cormorant Garamond', serif; font-style: italic; color: var(--stone); }
    .social-line .so-status { font-family: 'Cormorant SC', serif; font-size: .65rem; letter-spacing: .22em; text-transform: uppercase; }
    .social-line .so-status.on  { color: #15803d; }
    .social-line .so-status.off { color: var(--stone); opacity: .6; }

    .maintenance-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: .75rem;
    }
    .maintenance-tile {
        width: 100%;
        text-align: left;
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 12px;
        padding: .95rem 1rem;
        display: flex;
        align-items: flex-start;
        gap: .85rem;
        transition: transform .2s, box-shadow .2s, border-color .2s;
    }
    .maintenance-tile:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(26,22,18,.08);
        border-color: var(--bronze);
    }
    .maintenance-tile .mt-ic {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--parchment);
        color: var(--bronze-dark);
        flex-shrink: 0;
    }
    .maintenance-tile strong {
        display: block;
        font-family: 'Bodoni Moda', serif;
        font-size: .9rem;
        color: var(--ink);
        margin-bottom: .2rem;
    }
    .maintenance-tile span {
        display: block;
        font-family: 'Cormorant Garamond', serif;
        font-size: .9rem;
        color: var(--stone);
        line-height: 1.3;
    }
    .maintenance-meta {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    .maintenance-pill {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .35rem .75rem;
        border-radius: 999px;
        border: 1px solid var(--line);
        background: var(--parchment);
        font-family: 'Cormorant SC', serif;
        font-size: .68rem;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--bronze-dark);
    }
</style>
@endpush

@section('content')

{{-- ============ HERO HEADER ============ --}}
<div class="dash-hero">
    <div class="eyebrow"><i class="fas fa-feather-alt"></i> {{ __('dashboard.welcome') }} {{ auth()->user()->name }}</div>
    <h1>{{ $settings->nome_site ?? 'Gramma Institute' }} <em>· tabula</em></h1>
    <p>{{ $settings->descricao_site ?? 'Domus verbōrum — methodus classica, magistrī docti.' }}</p>

    <div class="dash-hero-actions">
        <a href="{{ route('home') }}" target="_blank" class="btn-classic">
            <i class="fas fa-external-link-alt"></i> Ver Site Público
        </a>
        <a href="{{ route('admin.settings.edit') }}" class="btn-classic outline">
            <i class="fas fa-cog"></i> {{ __('dashboard.menu_settings') }}
        </a>
        <a href="{{ route('admin.hero-slides.index') }}" class="btn-classic outline">
            <i class="fas fa-images"></i> Hero Slides
        </a>
    </div>
</div>

{{-- ============ STATS GRID ============ --}}
<div class="stat-grid">
    <a href="{{ route('admin.courses.index') }}" class="stat-tile">
        <span class="stat-decor">Ⅰ</span>
        <div class="stat-eyebrow">Cursūs</div>
        <div class="stat-value">{{ $stats['courses'] }}</div>
        <div class="stat-label">{{ $stats['courses_on'] }} ativos no site</div>
        <div class="stat-foot">Gerir cursos <i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="{{ route('admin.glossary.index') }}" class="stat-tile">
        <span class="stat-decor">Ⅲ</span>
        <div class="stat-eyebrow">Glossārium</div>
        <div class="stat-value">{{ $stats['glossary'] }}</div>
        <div class="stat-label">verbetes no glossário</div>
        <div class="stat-foot">Gerir verbetes <i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="{{ route('admin.hero-slides.index') }}" class="stat-tile">
        <span class="stat-decor">Ⅳ</span>
        <div class="stat-eyebrow">Slides</div>
        <div class="stat-value">{{ $stats['slides'] }}</div>
        <div class="stat-label">{{ $stats['slides_on'] }} ativos no hero</div>
        <div class="stat-foot">Gerir slides <i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="{{ route('admin.languages.index') }}" class="stat-tile">
        <span class="stat-decor">Ⅵ</span>
        <div class="stat-eyebrow">Linguae</div>
        <div class="stat-value">{{ $stats['languages'] }}</div>
        <div class="stat-label">idiomas activos no site</div>
        <div class="stat-foot">Gerir idiomas <i class="fas fa-arrow-right"></i></div>
    </a>
</div>

<div class="row g-3">
    {{-- ============ COMPLETUDE ============ --}}
    <div class="col-lg-6">
        <div class="gramma-card">
            <div class="gramma-card-head">
                <h6><i class="fas fa-check-double"></i> Status de configuração</h6>
                <span style="font-family:'Cormorant SC',serif; font-size:.75rem; letter-spacing:.22em; color:var(--bronze-dark); text-transform:uppercase;">
                    {{ $completeness['done'] }}/{{ $completeness['total'] }}
                </span>
            </div>
            <div class="gramma-card-body">
                <div style="display:flex; align-items:baseline; gap:.5rem;">
                    <span style="font-family:'Bodoni Moda',serif; font-size:2.5rem; font-weight:600; color:var(--ink); line-height:1;">{{ $completeness['percentage'] }}%</span>
                    <span style="font-family:'Cormorant Garamond',serif; font-style:italic; color:var(--stone);">
                        do site configurado
                    </span>
                </div>
                <div class="completion-meter">
                    <div style="--target: {{ $completeness['percentage'] }}%;"></div>
                </div>

                <div style="margin-top:1rem;">
                    @foreach($completeness['sections'] as $key => $sec)
                        <div class="section-row">
                            <span class="dot {{ $sec['filled'] ? 'ok' : 'pending' }}"></span>
                            <span class="label">{{ $sec['label'] }}</span>
                            @if($sec['filled'])
                                <i class="fas fa-check" style="color:#15803d;"></i>
                            @else
                                <a href="{{ route($sec['route']) }}">Preencher →</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ============ QUICK ACTIONS ============ --}}
    <div class="col-lg-6">
        <div class="gramma-card">
            <div class="gramma-card-head">
                <h6><i class="fas fa-bolt"></i> Acesso rápido</h6>
            </div>
            <div class="gramma-card-body">
                <a href="{{ route('admin.hero-slides.index') }}" class="quick-link">
                    <span class="ql-ic"><i class="fas fa-images"></i></span>
                    <span class="ql-text">
                        Hero & Slides
                        <small>Foto, vídeo, carrossel da página inicial</small>
                    </span>
                    <i class="fas fa-arrow-right arrow"></i>
                </a>
                <a href="{{ route('admin.courses.index') }}" class="quick-link">
                    <span class="ql-ic"><i class="fas fa-book-open"></i></span>
                    <span class="ql-text">
                        Cursos
                        <small>Adicionar, editar e organizar cursos</small>
                    </span>
                    <i class="fas fa-arrow-right arrow"></i>
                </a>
                <a href="{{ route('admin.glossary.index') }}" class="quick-link">
                    <span class="ql-ic"><i class="fas fa-feather-alt"></i></span>
                    <span class="ql-text">
                        Glossário
                        <small>Verbetes em grego, hebraico e mais</small>
                    </span>
                    <i class="fas fa-arrow-right arrow"></i>
                </a>
                <a href="{{ route('admin.languages.index') }}" class="quick-link">
                    <span class="ql-ic"><i class="fas fa-language"></i></span>
                    <span class="ql-text">
                        Idiomas & Traduções
                        <small>Editar textos em todos os idiomas</small>
                    </span>
                    <i class="fas fa-arrow-right arrow"></i>
                </a>
                <a href="{{ route('admin.email-test.index') }}" class="quick-link">
                    <span class="ql-ic"><i class="fas fa-paper-plane"></i></span>
                    <span class="ql-text">
                        Teste de Email
                        <small>Verificar configuração SMTP</small>
                    </span>
                    <i class="fas fa-arrow-right arrow"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="gramma-card">
            <div class="gramma-card-head">
                <h6><i class="fas fa-tools"></i> Manutenção rápida</h6>
                <span style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.22em; text-transform:uppercase; color:var(--bronze-dark);">
                    sem terminal
                </span>
            </div>
            <div class="gramma-card-body">
                <div class="maintenance-grid">
                    @foreach([
                        ['optimize-clear', 'fas fa-broom', 'Limpar tudo', 'Cache geral, views, rotas e configuração'],
                        ['view-clear', 'fas fa-window-maximize', 'Limpar views', 'Apaga views compiladas do Laravel'],
                        ['cache-clear', 'fas fa-database', 'Limpar cache', 'Limpa o cache da aplicação'],
                        ['route-clear', 'fas fa-route', 'Limpar rotas', 'Atualiza o cache de rotas'],
                        ['config-clear', 'fas fa-cogs', 'Limpar config', 'Atualiza a configuração carregada'],
                        ['event-clear', 'fas fa-bell', 'Limpar eventos', 'Refaz o cache de eventos'],
                        ['repair-media', 'fas fa-images', 'Reparar mídia', 'Verifica previews, storage e ficheiros em falta'],
                    ] as [$task, $icon, $title, $description])
                        <form method="POST" action="{{ route('admin.maintenance', $task) }}">
                            @csrf
                            <button type="submit" class="maintenance-tile">
                                <span class="mt-ic"><i class="{{ $icon }}"></i></span>
                                <span>
                                    <strong>{{ $title }}</strong>
                                    <span>{{ $description }}</span>
                                </span>
                            </button>
                        </form>
                    @endforeach
                </div>

                <div class="maintenance-meta">
                    <span class="maintenance-pill">
                        <i class="fas fa-photo-video"></i>
                        {{ $mediaHealth['ok'] }} media ok
                    </span>
                    <span class="maintenance-pill">
                        <i class="fas fa-search"></i>
                        {{ $mediaHealth['total'] }} referências
                    </span>
                    <span class="maintenance-pill" style="{{ $mediaHealth['missing'] > 0 ? 'color:#991b1b; border-color:#fecaca; background:#fef2f2;' : 'color:#166534; border-color:#bbf7d0; background:#ecfdf5;' }}">
                        <i class="fas {{ $mediaHealth['missing'] > 0 ? 'fa-exclamation-triangle' : 'fa-check-circle' }}"></i>
                        {{ $mediaHealth['missing'] }} em falta
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    {{-- ============ INFO DO SITE ============ --}}
    <div class="col-lg-6">
        <div class="gramma-card">
            <div class="gramma-card-head">
                <h6><i class="fas fa-info-circle"></i> Identidade do site</h6>
                <a href="{{ route('admin.settings.edit') }}" style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.22em; text-transform:uppercase; color:var(--bronze-dark); text-decoration:none;">
                    Editar →
                </a>
            </div>
            <div class="gramma-card-body">
                <table class="info-table">
                    <tr>
                        <td class="label">Nome</td>
                        <td class="val">{{ $settings->nome_site ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="val">{{ $settings->email_institucional ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Telefone</td>
                        <td class="val">{{ $settings->telefone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Localização</td>
                        <td class="val">{{ implode(', ', array_filter([$settings->cidade, $settings->pais])) ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Idioma padrão</td>
                        <td class="val"><span class="pill">{{ $settings->idioma_padrao ?? 'pt_BR' }}</span></td>
                    </tr>
                    <tr>
                        <td class="label">Tipo de Hero</td>
                        <td class="val"><span class="pill">{{ $settings->hero_tipo ?? 'imagem' }}</span></td>
                    </tr>
                    <tr>
                        <td class="label">SMTP</td>
                        <td class="val">
                            @if($smtpConfigured)
                                <span class="pill" style="color:#15803d; border-color:#bbf7d0; background:#ecfdf5;">{{ __('dashboard.smtp_configured') }}</span>
                            @else
                                <span class="pill" style="color:#a16207; border-color:#fde68a; background:#fef9c3;">{{ __('dashboard.smtp_not_configured') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Última atualização</td>
                        <td class="val">{{ $settings->updated_at ? $settings->updated_at->format('d/m/Y H:i') : '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- ============ REDES SOCIAIS ============ --}}
    <div class="col-lg-6">
        <div class="gramma-card">
            <div class="gramma-card-head">
                <h6><i class="fas fa-share-alt"></i> Redes sociais</h6>
                <a href="{{ route('admin.settings.edit') }}" style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.22em; text-transform:uppercase; color:var(--bronze-dark); text-decoration:none;">
                    Editar →
                </a>
            </div>
            <div class="gramma-card-body">
                @foreach([
                    ['Facebook',  'fab fa-facebook-f', '#1877f2', $settings->facebook],
                    ['Instagram', 'fab fa-instagram',  '#e1306c', $settings->instagram],
                    ['LinkedIn',  'fab fa-linkedin-in','#0a66c2', $settings->linkedin],
                    ['YouTube',   'fab fa-youtube',    '#ff0000', $settings->youtube],
                    ['TikTok',    'fab fa-tiktok',     '#010101', $settings->tiktok],
                    ['WhatsApp',  'fab fa-whatsapp',   '#25d366', $settings->whatsapp],
                ] as [$name, $ic, $color, $value])
                    <div class="social-line">
                        <span class="so-ic" style="background: {{ $color }};"><i class="{{ $ic }}"></i></span>
                        <span class="so-label">{{ $name }}</span>
                        @if($value)
                            <span class="so-status on">Configurado</span>
                            @if(str_starts_with((string) $value, 'http'))
                                <a href="{{ $value }}" target="_blank" style="color:var(--bronze-dark); margin-left:.5rem;">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                        @else
                            <span class="so-status off">— vazio</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

