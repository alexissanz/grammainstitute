@extends('layouts.public')

@section('meta-title', 'Eventos — ' . ($settings->nome_site ?? 'Gramma Institute'))

@push('styles')
<style>
    .ev-hero {
        background: linear-gradient(135deg, rgba(26,22,18,.88) 0%, rgba(26,22,18,.65) 100%), url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=2400&q=85') center/cover no-repeat;
        color: var(--ivory);
        padding: 7rem 0 5rem;
        text-align: center;
    }
    .ev-hero h1 { font-family: 'Cinzel', serif; font-weight: 500; font-size: clamp(2.2rem, 5vw, 4rem); letter-spacing: .025em; color: var(--ivory); margin-bottom: 1rem; }
    .ev-hero .lede { font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: clamp(1.2rem, 2.2vw, 1.6rem); color: rgba(250,246,236,.86); max-width: 720px; margin: 0 auto; }

    .ev-section { padding: 5rem 0; }
    .ev-section.alt { background: var(--parchment); }

    /* Event row card (horizontal) */
    .ev-card {
        display: grid;
        grid-template-columns: 200px 1fr auto;
        gap: 2rem;
        align-items: stretch;
        background: #fff;
        margin-bottom: 1.5rem;
        text-decoration: none;
        color: var(--ink);
        transition: transform .25s, box-shadow .25s;
        border-left: 4px solid var(--ev-color, var(--bronze));
        box-shadow: 0 4px 22px rgba(26,22,18,.06);
    }
    [dir="rtl"] .ev-card { border-left: 0; border-right: 4px solid var(--ev-color, var(--bronze)); }
    .ev-card:hover { transform: translateY(-3px); box-shadow: 0 14px 40px rgba(26,22,18,.11); color: var(--ink); }
    .ev-card .ev-date {
        background: var(--ev-color, var(--bronze));
        color: #fff;
        padding: 1.5rem;
        text-align: center;
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        min-height: 160px;
    }
    .ev-card .ev-date .month {
        font-family: 'Cormorant SC', serif;
        font-size: .85rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        opacity: .95;
    }
    .ev-card .ev-date .day {
        font-family: 'Cinzel', serif;
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1;
        margin: .25rem 0;
    }
    .ev-card .ev-date .time {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1rem;
        opacity: .92;
    }
    .ev-card .ev-body {
        padding: 1.75rem 1.5rem;
        display: flex; flex-direction: column; justify-content: center;
    }
    .ev-card .ev-tags { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: .65rem; }
    .ev-card .ev-tag {
        font-family: 'Cormorant SC', serif;
        font-size: .68rem;
        letter-spacing: .25em;
        text-transform: uppercase;
        padding: .25rem .55rem;
        border: 1px solid var(--line);
        color: var(--ink-soft);
    }
    .ev-card .ev-tag.free  { background: #e8f5ed; color: #1f6e3b; border-color: #b9e1c8; }
    .ev-card .ev-tag.paid  { background: #fff6e0; color: #8a5a00; border-color: #f1d997; }
    .ev-card .ev-tag.online{ background: #e9eef9; color: #1f3a8a; border-color: #c4d2f3; }
    .ev-card h3 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: 1.45rem;
        letter-spacing: .015em;
        color: var(--ink);
        margin-bottom: .35rem;
        line-height: 1.25;
    }
    .ev-card .ev-sub {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        font-size: 1.05rem;
        margin-bottom: .5rem;
    }
    .ev-card .ev-meta {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        color: var(--ink-soft);
        display: flex; gap: 1.25rem; flex-wrap: wrap;
    }
    .ev-card .ev-meta i { color: var(--ev-color, var(--bronze)); margin-right: .35rem; }
    .ev-card .ev-cta-area {
        padding: 1.5rem;
        display: flex; flex-direction: column; align-items: flex-end; justify-content: center;
        background: var(--parchment);
        gap: .5rem;
        min-width: 200px;
    }
    .ev-card .ev-price {
        font-family: 'Cinzel', serif;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--ink);
        letter-spacing: .03em;
    }
    .ev-card .ev-price.free { color: #1f6e3b; }
    .ev-card .ev-spots {
        font-family: 'Cormorant SC', serif;
        font-size: .68rem;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--stone);
    }
    .ev-card .ev-more {
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--ev-color, var(--bronze-dark));
        display: inline-flex; align-items: center; gap: .4rem;
        margin-top: .5rem;
    }

    @media (max-width: 767px) {
        .ev-card { grid-template-columns: 1fr; }
        .ev-card .ev-date { min-height: auto; padding: 1rem; flex-direction: row; gap: 1rem; justify-content: flex-start; }
        .ev-card .ev-date .day { font-size: 2rem; margin: 0; }
        .ev-card .ev-cta-area { align-items: flex-start; background: #fff; border-top: 1px solid var(--line); padding: 1.25rem 1.5rem; }
    }
</style>
@endpush

@section('content')

<section class="ev-hero">
    <div class="container">
        <div class="ornament light"><i class="fas fa-calendar-alt"></i></div>
        <div style="font-family:'Cormorant SC',serif; font-size:.9rem; font-weight:600; letter-spacing:.4em; color: var(--gold-light); text-transform:uppercase; margin-bottom: 1rem;">
            {{ __('site.events_eyebrow') }}
        </div>
        <h1>{{ __('site.events_title') }}</h1>
        <p class="lede">{{ __('site.events_subtitle') }}</p>
    </div>
</section>

<section class="ev-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">{{ __('site.events_upcoming') }}</div>
            <h2 class="section-title-classical">{{ __('site.events_upcoming_title') }}</h2>
            <div class="ornament"><i class="fas fa-feather"></i></div>
        </div>

        @if($upcoming->isEmpty())
            <p style="text-align:center; font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.2rem; color: var(--stone);">
                {{ __('site.events_none') }}
            </p>
        @else
            @foreach($upcoming as $event)
                <a href="{{ route('events.show', $event->slug) }}" class="ev-card" style="--ev-color: {{ $event->cor_destaque }};">
                    <div class="ev-date">
                        <div class="month">{{ strtoupper($event->data_inicio->translatedFormat('M')) }}</div>
                        <div class="day">{{ $event->data_inicio->format('d') }}</div>
                        <div class="time">{{ $event->data_inicio->format('H:i') }}</div>
                    </div>
                    <div class="ev-body">
                        <div class="ev-tags">
                            @if($event->gratuito)
                                <span class="ev-tag free"><i class="fas fa-check me-1"></i>{{ __('site.event_free') }}</span>
                            @else
                                <span class="ev-tag paid"><i class="fas fa-tag me-1"></i>{{ __('site.event_paid') }}</span>
                            @endif
                            @if($event->formato === 'online')
                                <span class="ev-tag online"><i class="fas fa-globe me-1"></i>Online</span>
                            @elseif($event->formato === 'hibrido')
                                <span class="ev-tag online"><i class="fas fa-broadcast-tower me-1"></i>Híbrido</span>
                            @else
                                <span class="ev-tag"><i class="fas fa-map-marker-alt me-1"></i>Presencial</span>
                            @endif
                        </div>
                        <h3>{{ $event->t('titulo') }}</h3>
                        <div class="ev-sub">{{ $event->t('subtitulo') }}</div>
                        <div class="ev-meta">
                            @if($event->t('local_nome'))
                                <span><i class="fas fa-map-pin"></i>{{ $event->t('local_nome') }}</span>
                            @endif
                            @if($event->palestrante_nome)
                                <span><i class="fas fa-user"></i>{{ $event->palestrante_nome }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="ev-cta-area">
                        <div class="ev-price {{ $event->gratuito ? 'free' : '' }}">{{ $event->precoFormatado() }}</div>
                        @if($event->vagas_total)
                            @php $rem = max(0, $event->vagas_total - $event->vagas_ocupadas); @endphp
                            <div class="ev-spots">{{ $rem }} {{ __('site.event_spots_left') }}</div>
                        @endif
                        <span class="ev-more">{{ __('site.event_details') }} <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</section>

@if($past->isNotEmpty())
<section class="ev-section alt">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">{{ __('site.events_past') }}</div>
            <h2 class="section-title-classical">{{ __('site.events_past_title') }}</h2>
            <div class="ornament"><i class="fas fa-scroll"></i></div>
        </div>
        <div class="row g-4">
            @foreach($past as $event)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('events.show', $event->slug) }}" style="background:#fff; padding:1.75rem; height:100%; display:block; text-decoration:none; color:var(--ink); border-top: 2px solid {{ $event->cor_destaque }}; transition:transform .25s, box-shadow .25s;"
                       onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 14px 40px rgba(26,22,18,.1)';"
                       onmouseout="this.style.transform=''; this.style.boxShadow='';">
                        <div style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.3em; color: var(--stone); text-transform:uppercase; margin-bottom:.65rem;">
                            {{ $event->data_inicio->translatedFormat('d M Y') }}
                        </div>
                        <h4 style="font-family:'Cinzel',serif; font-size:1.15rem; color: var(--ink); letter-spacing:.05em; line-height:1.3; margin-bottom:.5rem;">
                            {{ $event->t('titulo') }}
                        </h4>
                        <p style="font-family:'Cormorant Garamond',serif; font-style:italic; color: var(--stone); font-size:1rem;">
                            {{ $event->t('subtitulo') }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
