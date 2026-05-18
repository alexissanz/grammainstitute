@extends('layouts.public')

@section('meta-title', __('site.courses_title') . ' — ' . ($settings->nome_site ?? 'Gramma Institute'))

@push('styles')
<style>
    .cl-hero {
        background:
            linear-gradient(135deg, rgba(26,22,18,.85) 0%, rgba(26,22,18,.7) 100%),
            url('https://images.unsplash.com/photo-1532153975070-2e9ab71f1b14?auto=format&fit=crop&w=2400&q=85') center/cover no-repeat;
        color: var(--ivory);
        padding: 7rem 0 5rem;
        text-align: center;
    }
    .cl-hero h1 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(2.2rem, 5vw, 4rem);
        line-height: 1.08;
        letter-spacing: .025em;
        color: var(--ivory);
        margin-bottom: 1rem;
    }
    .cl-hero .lede {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: clamp(1.2rem, 2.2vw, 1.6rem);
        color: rgba(250,246,236,.86);
        max-width: 720px;
        margin: 0 auto;
    }

    .cl-grid { background: var(--ivory); padding: 6rem 0; }

    .cl-card {
        position: relative;
        background: #fff;
        height: 100%;
        overflow: hidden;
        text-decoration: none;
        color: var(--ink);
        display: flex; flex-direction: column;
        transition: transform .3s, box-shadow .3s;
        border-top: 3px solid var(--accent, var(--bronze));
    }
    .cl-card:hover { transform: translateY(-6px); box-shadow: 0 18px 50px rgba(26,22,18,.12); color: var(--ink); }
    .cl-card .cover {
        height: 220px;
        background-size: cover; background-position: center;
        position: relative;
    }
    .cl-card .cover::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(26,22,18,0) 50%, rgba(26,22,18,.7) 100%);
    }
    .cl-card .glyph {
        position: absolute;
        bottom: 1.2rem; left: 1.5rem;
        font-family: 'Cinzel', serif;
        font-size: 3rem;
        font-weight: 700;
        color: var(--ivory);
        line-height: 1;
        z-index: 2;
        text-shadow: 0 2px 12px rgba(0,0,0,.4);
    }
    .cl-card .body {
        padding: 2rem 1.8rem 2rem;
        display: flex; flex-direction: column;
        flex-grow: 1;
    }
    .cl-card .tag {
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        margin-bottom: .75rem;
    }
    .cl-card h3 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: 1.35rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--ink);
        margin-bottom: .5rem;
        line-height: 1.25;
    }
    .cl-card .sub {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.05rem;
        color: var(--stone);
        margin-bottom: 1.2rem;
    }
    .cl-card .desc {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.08rem;
        line-height: 1.65;
        color: var(--ink-soft);
        flex-grow: 1;
        margin-bottom: 1.5rem;
    }
    .cl-card .meta-row {
        display: flex;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--line);
        margin-bottom: 1.2rem;
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--stone);
    }
    .cl-card .meta-row > div { flex: 1; }
    .cl-card .meta-row strong { color: var(--ink); font-family: 'Cinzel', serif; font-weight: 500; display: block; margin-top: 2px; }
    .cl-card .more {
        font-family: 'Cormorant SC', serif;
        font-size: .75rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--accent, var(--bronze-dark));
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        margin-top: auto;
        transition: gap .25s;
    }
    .cl-card:hover .more { gap: .85rem; }

    @media (max-width: 767px) {
        .cl-hero { padding: 4rem 0 3rem; }
        .cl-grid { padding: 3rem 0 4rem; }
        .cl-card .cover { height: 180px; }
        .cl-card .body { padding: 1.5rem 1.25rem; }
        .cl-card h3 { font-size: 1.15rem; }
    }
</style>
@endpush

@section('content')

<section class="cl-hero">
    <div class="container">
        <div class="ornament light"><i class="fas fa-feather"></i></div>
        <div style="font-family:'Cormorant SC',serif; font-size:.9rem; font-weight:600; letter-spacing:.4em; color: var(--gold-light); text-transform:uppercase; margin-bottom: 1rem;">
            {{ __('site.courses_subtitle') }}
        </div>
        <h1>{{ __('site.courses_title') }}</h1>
        <p class="lede">Cinco idiomas. Uma única tradição de ensino — a do texto, do mestre e do tempo lento.</p>
    </div>
</section>

<section class="cl-grid">
    <div class="container">
        @if($courses->isEmpty())
            <p style="text-align:center; font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.2rem; color: var(--stone);">
                Nenhum curso ainda. Adicione no painel.
            </p>
        @else
            <div class="row g-4">
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('courses.show', $course->slug) }}"
                           class="cl-card"
                           style="--accent: {{ $course->cor_destaque }};">
                            <div class="cover" @if($course->imagemCapaUrl()) style="background-image: url('{{ $course->imagemCapaUrl() }}');" @endif>
                                <div class="glyph">{{ $course->glifo }}</div>
                            </div>
                            <div class="body">
                                <div class="tag">{{ $course->duracao_total }}</div>
                                <h3>{{ $course->t('nome') }}</h3>
                                <div class="sub">{{ $course->t('subtitulo') }}</div>
                                <p class="desc">{{ Str::limit($course->t('descricao_curta'), 180) }}</p>

                                <div class="meta-row">
                                    @if($course->formato)
                                        <div>
                                            Formato
                                            <strong>{{ Str::limit($course->formato, 22) }}</strong>
                                        </div>
                                    @endif
                                    @if($course->preco)
                                        <div>
                                            Investimento
                                            <strong>{{ Str::limit($course->preco, 22) }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <span class="more">{{ __('site.course_learn_more') }} <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
