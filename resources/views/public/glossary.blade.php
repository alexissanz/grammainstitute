@extends('layouts.public')

@section('meta-title', __('site.glossary_title') . ' — ' . ($settings->nome_site ?? 'Gramma Institute'))

@push('styles')
<style>
    .g-hero {
        background:
            linear-gradient(135deg, rgba(26,22,18,.88) 0%, rgba(26,22,18,.7) 100%),
            url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=2400&q=85') center/cover no-repeat;
        color: var(--ivory);
        padding: 7rem 0 6rem;
        position: relative;
    }
    .g-hero h1 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(2.2rem, 5vw, 4rem);
        line-height: 1.08;
        letter-spacing: .025em;
        color: var(--ivory);
        margin-bottom: 1rem;
        text-align: center;
    }
    .g-hero .lede {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: clamp(1.2rem, 2.2vw, 1.6rem);
        color: rgba(250,246,236,.86);
        max-width: 720px;
        margin: 0 auto;
        text-align: center;
    }

    /* Filter bar */
    .g-filter {
        background: var(--ivory);
        border-bottom: 1px solid var(--line);
        padding: 1.5rem 0;
        position: sticky;
        top: 73px;
        z-index: 50;
    }
    .g-filter .filter-row {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    .g-filter .chip {
        font-family: 'Cormorant SC', serif;
        font-size: .8rem;
        font-weight: 600;
        letter-spacing: .2em;
        text-transform: uppercase;
        padding: .55rem 1.2rem;
        border: 1px solid var(--line);
        background: #fff;
        color: var(--ink-soft);
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }
    .g-filter .chip.active,
    .g-filter .chip:hover {
        background: var(--ink);
        color: var(--gold-light);
        border-color: var(--ink);
    }

    .g-grid { background: var(--parchment); padding: 5rem 0 6rem; }

    /* Featured row */
    .g-featured-card {
        background: var(--ink);
        color: var(--ivory);
        padding: 3rem 2.5rem;
        position: relative;
        overflow: hidden;
        height: 100%;
        text-decoration: none;
        display: block;
        transition: transform .25s;
    }
    .g-featured-card:hover { transform: translateY(-5px); color: var(--ivory); }
    .g-featured-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background-size: cover; background-position: center;
        background-image: linear-gradient(180deg, rgba(26,22,18,.6) 0%, rgba(26,22,18,.95) 100%), var(--bg);
        z-index: 0;
    }
    .g-featured-card > * { position: relative; z-index: 1; }
    .g-featured-card .lingua-tag {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem;
        letter-spacing: .35em;
        color: var(--gold-light);
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .g-featured-card .termo {
        font-family: 'Cinzel', serif;
        font-size: 3rem;
        font-weight: 600;
        color: var(--gold-light);
        margin-bottom: .25rem;
        line-height: 1;
    }
    .g-featured-card .termo.hebrew { font-family: 'Noto Sans Hebrew', 'Cormorant Garamond', serif; font-size: 3.5rem; }
    .g-featured-card .translit {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.1rem;
        color: rgba(250,246,236,.7);
        margin-bottom: 1.5rem;
    }
    .g-featured-card .resumo {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        line-height: 1.7;
        color: rgba(250,246,236,.88);
        margin-bottom: 1.5rem;
    }
    .g-featured-card .read-link {
        font-family: 'Cormorant SC', serif;
        font-size: .75rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--gold-light);
        display: inline-flex; align-items: center; gap: .5rem;
        transition: gap .25s;
    }
    .g-featured-card:hover .read-link { gap: .9rem; }

    /* Regular cards */
    .g-card {
        background: #fff;
        padding: 2rem;
        height: 100%;
        border-top: 2px solid var(--bronze);
        text-decoration: none;
        display: flex; flex-direction: column;
        transition: transform .25s, box-shadow .25s;
        color: var(--ink);
    }
    .g-card:hover { transform: translateY(-4px); box-shadow: 0 14px 40px rgba(26,22,18,.1); color: var(--ink); }
    .g-card .lingua-tag {
        font-family: 'Cormorant SC', serif;
        font-size: .68rem;
        letter-spacing: .3em;
        color: var(--bronze-dark);
        text-transform: uppercase;
        margin-bottom: .75rem;
    }
    .g-card .termo {
        font-family: 'Cinzel', serif;
        font-size: 2.2rem;
        font-weight: 600;
        color: var(--ink);
        line-height: 1;
        margin-bottom: .25rem;
    }
    .g-card .termo.hebrew { font-family: 'Noto Sans Hebrew', serif; font-size: 2.6rem; }
    .g-card .translit {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1rem;
        color: var(--stone);
        margin-bottom: 1rem;
    }
    .g-card .resumo {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.05rem;
        line-height: 1.65;
        color: var(--ink-soft);
        flex-grow: 1;
        margin-bottom: 1.25rem;
    }
    .g-card .read-link {
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        display: inline-flex; align-items: center; gap: .5rem;
        transition: gap .25s;
    }
    .g-card:hover .read-link { gap: .8rem; }

    @media (max-width: 767px) {
        .g-hero { padding: 4rem 0 3rem; }
        .g-filter { top: 60px; padding: 1rem 0; }
        .g-filter .chip { padding: .45rem 1rem; font-size: .7rem; }
        .g-featured-card { padding: 2rem 1.5rem; }
        .g-featured-card .termo { font-size: 2.3rem; }
        .g-card { padding: 1.5rem 1.25rem; }
        .g-grid { padding: 3rem 0 4rem; }
    }
</style>
@endpush

@section('content')

<section class="g-hero">
    <div class="container">
        <div class="ornament light"><i class="fas fa-feather"></i></div>
        <div style="text-align:center; font-family:'Cormorant SC', serif; font-size:.9rem; font-weight:600; letter-spacing:.4em; color: var(--gold-light); text-transform:uppercase; margin-bottom: 1rem;">
            {{ __('site.glossary_eyebrow') }}
        </div>
        <h1>{{ __('site.glossary_title') }}</h1>
        <p class="lede">{{ __('site.glossary_subtitle') }}</p>
    </div>
</section>

<div class="g-filter">
    <div class="container">
        <div class="filter-row">
            <a href="#" class="chip active" data-filter="all">{{ __('site.glossary_filter_all') }}</a>
            <a href="#" class="chip" data-filter="el">{{ __('site.glossary_filter_greek') }}</a>
            <a href="#" class="chip" data-filter="he">{{ __('site.glossary_filter_hebrew') }}</a>
            <a href="#" class="chip" data-filter="featured">{{ __('site.glossary_filter_featured') }}</a>
        </div>
    </div>
</div>

<section class="g-grid">
    <div class="container">
        @if($terms->isEmpty())
            <p style="text-align:center; font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.2rem; color: var(--stone);">
                {{ __('site.glossary_empty') }}
            </p>
        @else
            {{-- Featured row first --}}
            @php $featured = $terms->where('destaque', true); $regular = $terms->where('destaque', false); @endphp

            @if($featured->count())
                <div class="row g-4 mb-5">
                    @foreach($featured as $term)
                        <div class="col-lg-4 col-md-6 g-item" data-lingua="{{ $term->lingua }}" data-featured="1">
                            <a href="{{ route('glossary.show', $term->slug) }}"
                               class="g-featured-card"
                               @if($term->imagemUrl()) style="--bg: url('{{ $term->imagemUrl() }}');" @endif>
                                <div class="lingua-tag">{{ App\Models\GlossaryTerm::linguaLabel($term->lingua) }} · {{ $term->categoria }}</div>
                                <div class="termo {{ $term->lingua === 'he' ? 'hebrew' : '' }}">{{ $term->termo }}</div>
                                <div class="translit">{{ $term->transliteracao }}</div>
                                <p class="resumo">{{ Str::limit($term->t('significado'), 180) }}</p>
                                <span class="read-link">{{ __('site.glossary_read_more') }} <i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($regular->count())
                <div class="row g-4">
                    @foreach($regular as $term)
                        <div class="col-lg-4 col-md-6 g-item" data-lingua="{{ $term->lingua }}" data-featured="0">
                            <a href="{{ route('glossary.show', $term->slug) }}" class="g-card">
                                <div class="lingua-tag">{{ App\Models\GlossaryTerm::linguaLabel($term->lingua) }} @if($term->categoria) · {{ $term->categoria }} @endif</div>
                                <div class="termo {{ $term->lingua === 'he' ? 'hebrew' : '' }}">{{ $term->termo }}</div>
                                <div class="translit">{{ $term->transliteracao }}</div>
                                <p class="resumo">{{ Str::limit($term->t('significado'), 160) }}</p>
                                <span class="read-link">{{ __('site.glossary_read_more') }} <i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
    (function() {
        const chips = document.querySelectorAll('.g-filter .chip');
        const items = document.querySelectorAll('.g-item');
        chips.forEach(c => c.addEventListener('click', function(e) {
            e.preventDefault();
            chips.forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            const f = this.dataset.filter;
            items.forEach(it => {
                if (f === 'all') { it.style.display = ''; return; }
                if (f === 'featured') { it.style.display = it.dataset.featured === '1' ? '' : 'none'; return; }
                it.style.display = it.dataset.lingua === f ? '' : 'none';
            });
        }));
    })();
</script>
@endpush
