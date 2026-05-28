@extends('layouts.public')

@section('meta-title', $term->termo . ' (' . $term->transliteracao . ') — ' . __('site.glossary_title'))

@push('styles')
<style>
    .gs-hero {
        position: relative;
        background: var(--ink);
        color: var(--ivory);
        padding: 7rem 0 6rem;
        overflow: hidden;
    }
    .gs-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        background-image: linear-gradient(135deg, rgba(0,0,0,.7) 0%, rgba(0,0,0,.94) 100%), var(--bg-image);
    }
    .gs-hero .container { position: relative; z-index: 1; text-align: center; }
    .gs-hero .back {
        font-family: 'Cormorant SC', serif;
        font-size: .8rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--gold-light);
        text-decoration: none;
    }
    .gs-hero .lingua-tag {
        font-family: 'Cormorant SC', serif;
        font-size: .85rem;
        letter-spacing: .4em;
        text-transform: uppercase;
        color: var(--gold-light);
        margin: 2rem 0 1.5rem;
    }
    .gs-hero .termo {
        font-family: 'Cinzel', serif;
        font-size: clamp(4rem, 12vw, 9rem);
        font-weight: 600;
        color: var(--ivory);
        line-height: 1;
        margin-bottom: .5rem;
    }
    .gs-hero .termo.hebrew { font-family: 'Noto Sans Hebrew', serif; }
    .gs-hero .translit {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: clamp(1.4rem, 2.4vw, 1.9rem);
        color: var(--gold-light);
        letter-spacing: .05em;
        margin-bottom: 1rem;
    }
    .gs-hero .resumo {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.15rem, 1.8vw, 1.4rem);
        line-height: 1.6;
        color: rgba(250,246,236,.86);
        max-width: 720px;
        margin: 1rem auto 0;
    }

    .gs-body { background: var(--ivory); padding: 6rem 0; }
    .gs-body .lead-text {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        line-height: 1.85;
        color: var(--ink-soft);
    }
    .gs-body .lead-text::first-letter {
        font-family: 'Cinzel', serif;
        font-size: 5rem;
        float: left;
        line-height: .85;
        padding-right: 1rem;
        padding-top: .35rem;
        color: var(--bronze-dark);
    }
    [dir="rtl"] .gs-body .lead-text::first-letter { float: right; padding-right: 0; padding-left: 1rem; }
    .gs-body p { margin-bottom: 1.5rem; }

    .gs-meta-box {
        background: var(--parchment);
        border-left: 3px solid var(--bronze);
        padding: 2rem;
        margin: 3rem 0;
    }
    [dir="rtl"] .gs-meta-box { border-left: 0; border-right: 3px solid var(--bronze); }
    .gs-meta-box .meta-eyebrow {
        font-family: 'Cormorant SC', serif;
        font-size: .8rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        margin-bottom: .5rem;
    }
    .gs-meta-box p {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        line-height: 1.7;
        color: var(--ink);
        margin: 0;
    }

    .gs-quote {
        background: var(--ink);
        color: var(--ivory);
        padding: 5rem 0;
        text-align: center;
        position: relative;
    }
    .gs-quote::before {
        content: '"';
        position: absolute;
        top: 1rem; left: 50%;
        transform: translateX(-50%);
        font-family: 'Cinzel', serif;
        font-size: 12rem;
        color: rgba(255,255,255,.1);
        line-height: 1;
        font-weight: 700;
    }
    .gs-quote .container { position: relative; z-index: 1; }
    .gs-quote .quote-text {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: clamp(1.4rem, 3vw, 2.1rem);
        line-height: 1.5;
        color: var(--gold-light);
        max-width: 820px;
        margin: 0 auto 1.5rem;
    }
    .gs-quote .quote-author {
        font-family: 'Cormorant SC', serif;
        font-size: .85rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: rgba(250,246,236,.7);
    }

    .gs-related {
        background: var(--parchment);
        padding: 5rem 0;
    }
    .gs-related .related-card {
        background: #fff;
        padding: 1.75rem;
        text-decoration: none;
        display: block;
        height: 100%;
        border-top: 2px solid var(--bronze);
        transition: transform .25s, box-shadow .25s;
        color: var(--ink);
    }
    .gs-related .related-card:hover { transform: translateY(-4px); box-shadow: 0 14px 40px rgba(0,0,0,.1); }
    .gs-related .related-card .termo {
        font-family: 'Cinzel', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--ink);
    }
    .gs-related .related-card .termo.hebrew { font-family: 'Noto Sans Hebrew', serif; font-size: 2rem; }
    .gs-related .related-card .translit {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        font-size: .95rem;
    }

    @media (max-width: 767px) {
        .gs-hero { padding: 4rem 0 3rem; }
        .gs-body { padding: 3rem 0; }
        .gs-body .lead-text { font-size: 1.15rem; }
        .gs-body .lead-text::first-letter { font-size: 3.5rem; }
        .gs-quote { padding: 3rem 0; }
        .gs-related { padding: 3rem 0; }
    }
</style>
@endpush

@section('content')

@php
    $bgImg = $term->imagemUrl() ?: 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=2400&q=85';
    $isHe = $term->lingua === 'he';
@endphp

<section class="gs-hero" style="--bg-image: url('{{ $bgImg }}');">
    <div class="container">
        <a href="{{ route('glossary.index') }}" class="back">← {{ __('site.glossary_back') }}</a>
        <div class="lingua-tag">{{ App\Models\GlossaryTerm::linguaLabel($term->lingua) }} @if($term->categoria) · {{ $term->categoria }} @endif</div>
        <h1 class="termo {{ $isHe ? 'hebrew' : '' }}">{{ $term->termo }}</h1>
        <div class="translit">{{ $term->transliteracao }}</div>
        <p class="resumo">{{ $term->t('significado') }}</p>
    </div>
</section>

<section class="gs-body">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @if($term->t('descricao'))
                    <div class="lead-text">
                        @foreach(preg_split('/\n\n+/', trim($term->t('descricao'))) as $i => $paragraph)
                            <p>{!! nl2br(e($paragraph)) !!}</p>
                        @endforeach
                    </div>
                @endif

                @if($term->t('etimologia'))
                    <div class="gs-meta-box">
                        <div class="meta-eyebrow">{{ __('site.glossary_etymology') }}</div>
                        <p>{{ $term->t('etimologia') }}</p>
                    </div>
                @endif

                @if($term->t('exemplo_uso'))
                    <div class="gs-meta-box">
                        <div class="meta-eyebrow">{{ __('site.glossary_example') }}</div>
                        <p>{{ $term->t('exemplo_uso') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@if($term->t('citacao_classica'))
<section class="gs-quote">
    <div class="container">
        <div class="ornament light"><i class="fas fa-feather"></i></div>
        <p class="quote-text">"{{ $term->t('citacao_classica') }}"</p>
        @if($term->t('citacao_autor'))
            <div class="quote-author">— {{ $term->t('citacao_autor') }}</div>
        @endif
    </div>
</section>
@endif

@if($related->count())
<section class="gs-related">
    <div class="container">
        <div class="text-center mb-5">
            <div style="font-family:'Cormorant SC',serif; font-size:.8rem; letter-spacing:.32em; text-transform:uppercase; color: var(--bronze-dark); margin-bottom: .5rem;">
                Verbetes próximos
            </div>
            <h2 style="font-family:'Cinzel',serif; font-weight:500; font-size:2rem; color: var(--ink); letter-spacing:.015em;">
                Outros termos em {{ App\Models\GlossaryTerm::linguaLabel($term->lingua) }}
            </h2>
        </div>
        <div class="row g-4">
            @foreach($related as $r)
                <div class="col-md-4">
                    <a href="{{ route('glossary.show', $r->slug) }}" class="related-card">
                        <div class="termo {{ $r->lingua === 'he' ? 'hebrew' : '' }}">{{ $r->termo }}</div>
                        <div class="translit">{{ $r->transliteracao }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
