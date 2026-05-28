@extends('layouts.public')

@section('meta-title', __('site.courses_title') . ' — ' . ($settings->nome_site ?? 'Gramma Institute'))

@push('styles')
<style>
    .cl-hero {
        background:
            linear-gradient(135deg, rgba(0,0,0,.85) 0%, rgba(0,0,0,.7) 100%),
            url('https://images.unsplash.com/photo-1532153975070-2e9ab71f1b14?auto=format&fit=crop&w=2400&q=85') center/cover no-repeat;
        color: var(--ivory);
        padding: 7rem 0 5rem;
        text-align: center;
    }
    .cl-hero h1 {
        font-family: var(--font-site-display);
        font-weight: 500;
        font-size: clamp(2.2rem, 5vw, var(--font-size-title));
        line-height: 1.08;
        letter-spacing: .025em;
        color: var(--ivory);
        margin-bottom: 1rem;
    }
    .cl-hero .lede {
        font-family: var(--font-site-body);
        font-style: italic;
        font-size: clamp(1.2rem, 2.2vw, 1.6rem);
        color: rgba(250,246,236,.86);
        max-width: 720px;
        margin: 0 auto;
    }

    .cl-grid { background: #fff; padding: 6rem 0; }

    .cl-card {
        position: relative;
        background: #000;
        height: 100%;
        overflow: hidden;
        text-decoration: none;
        color: var(--ivory);
        display: flex; flex-direction: column;
        transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        border-top: 3px solid #000;
        border-inline: 1px solid rgba(0,0,0,.16);
        border-bottom: 1px solid rgba(0,0,0,.16);
        touch-action: manipulation;
        -webkit-tap-highlight-color: rgba(255,255,255,.14);
        isolation: isolate;
        border-radius: 28px;
        min-height: 380px;
    }
    .cl-card:hover {
        transform: translateY(-12px) scale(1.015);
        box-shadow: 0 28px 64px rgba(0,0,0,.16);
        color: var(--ivory);
        border-color: rgba(0,0,0,.28);
    }
    .cl-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(180deg, rgba(0,0,0,.1) 0%, rgba(0,0,0,.84) 100%),
            var(--card-image);
        background-size: cover;
        background-position: center;
        filter: grayscale(100%);
        transform: scale(1.02);
        transition: transform .4s ease;
        pointer-events: none;
    }
    .cl-card:hover::before { transform: scale(1.08); }
    .cl-card .glyph {
        font-family: 'Cinzel', serif;
        font-size: 3.2rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        margin-bottom: 1rem;
        transition: transform .35s ease;
    }
    .cl-card:hover .glyph { transform: translateY(-4px) scale(1.06); }
    .cl-card .body {
        position: relative;
        z-index: 1;
        padding: 2rem 1.8rem 2rem;
        display: flex; flex-direction: column;
        flex-grow: 1;
        pointer-events: none;
    }
    .cl-card h3 {
        font-family: var(--font-site-course);
        font-weight: 500;
        font-size: clamp(1.1rem, 2.4vw, var(--font-size-course));
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #fff;
        margin-bottom: .5rem;
        line-height: 1.25;
    }
    .cl-card .sub {
        font-family: var(--font-site-body);
        font-style: italic;
        font-size: 1.05rem;
        color: rgba(255,255,255,.78);
        margin-bottom: 1.2rem;
    }
    .cl-card .desc {
        font-family: var(--font-site-body);
        font-size: 1.08rem;
        line-height: 1.65;
        color: rgba(255,255,255,.84);
        flex-grow: 1;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 767px) {
        .cl-hero { padding: 4rem 0 3rem; }
        .cl-grid { padding: 3rem 0 4rem; }
        .cl-card .body { padding: 1.6rem 1.3rem; }
        .cl-card h3 { font-size: 1.15rem; line-height: 1.3; }
        .cl-card .sub { font-size: 1rem; line-height: 1.45; }
        .cl-card .desc { font-size: 1rem; line-height: 1.55; }
        .cl-card { min-height: 360px; border-radius: 24px; }
    }
    @media (max-width: 575px) {
        .cl-grid .row.g-4 {
            row-gap: 1rem !important;
        }
        .cl-grid .col-md-6,
        .cl-grid .col-lg-4 {
            width: 100%;
        }
        .cl-card {
            min-height: 340px;
        }
    }
    @media (hover: none) and (pointer: coarse) {
        .cl-card:hover,
        .cl-card:hover::before,
        .cl-card:hover .glyph {
            transform: none;
            box-shadow: none;
        }
    }
</style>
@endpush

@section('content')

<section class="cl-hero">
    <div class="container">
        <div style="font-family:'Cormorant SC',serif; font-size:.9rem; font-weight:600; letter-spacing:.4em; color: var(--gold-light); text-transform:uppercase; margin-bottom: 1rem;">
            {{ __('site.courses_subtitle') }}
        </div>
        <h1>{{ __('site.courses_title') }}</h1>
        <p class="lede">Five languages. One teaching tradition shaped by text, mastery, and patient study.</p>
    </div>
</section>

<section class="cl-grid">
    <div class="container">
        @if($courses->isEmpty())
            <p style="text-align:center; font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.2rem; color: var(--stone);">
                No courses yet. Add them in the dashboard.
            </p>
        @else
            <div class="row g-4">
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('courses.show', $course->slug) }}"
                           class="cl-card"
                           style="--accent: {{ $course->cor_destaque }}; --card-image: url('{{ $course->imagemCapaUrl() }}');">
                            <div class="body">
                                <div class="glyph">{{ $course->glifo }}</div>
                                <h3>{{ $course->t('nome') }}</h3>
                                <p class="desc">{{ Str::limit($course->t('descricao_curta'), 180) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
