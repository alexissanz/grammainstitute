@extends('layouts.public')

@section('meta-title', $event->t('titulo') . ' — ' . ($settings->nome_site ?? 'Gramma Institute'))
@section('meta-description', $event->t('subtitulo'))

@push('styles')
<style>
    .es-hero {
        position: relative;
        min-height: 70vh;
        color: var(--ivory);
        display: flex; align-items: flex-end;
        padding: 6rem 0 3rem;
        background: var(--ink);
        overflow: hidden;
    }
    .es-hero::before {
        content: ''; position: absolute; inset: 0;
        background-size: cover; background-position: center;
        background-image: linear-gradient(180deg, rgba(0,0,0,.45) 0%, rgba(0,0,0,.95) 80%), var(--bg);
    }
    .es-hero .container { position: relative; z-index: 1; }
    .es-hero .back {
        font-family: 'Cormorant SC', serif;
        font-size: .8rem; letter-spacing: .3em; text-transform: uppercase;
        color: var(--gold-light); text-decoration: none; margin-bottom: 2rem; display: inline-block;
    }
    .es-tags { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
    .es-tag {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem; letter-spacing: .28em; text-transform: uppercase;
        padding: .35rem .8rem;
        border: 1px solid var(--gold-light);
        color: var(--gold-light);
    }
    .es-tag.free { background: rgba(74,222,128,.15); border-color: #4ade80; color: #a7f3d0; }
    .es-tag.paid { background: rgba(255,255,255,.18); border-color: var(--gold-light); color: var(--gold-light); }
    .es-hero h1 {
        font-family: 'Cinzel', serif; font-weight: 500;
        font-size: clamp(2.2rem, 5vw, 4rem); line-height: 1.08;
        letter-spacing: .015em; color: var(--ivory); margin-bottom: 1rem;
    }
    .es-hero .subtitle {
        font-family: 'Cormorant Garamond', serif; font-style: italic;
        font-size: clamp(1.2rem, 2vw, 1.6rem);
        color: rgba(250,246,236,.86); max-width: 720px;
    }

    /* Date / location strip */
    .es-strip {
        background: var(--ink);
        border-top: 1px solid rgba(250,246,236,.1);
        color: var(--ivory);
        padding: 2rem 0;
    }
    .es-strip .item { display: flex; align-items: center; gap: 1rem; }
    .es-strip .item i {
        width: 44px; height: 44px;
        background: var(--ev-color, var(--gold-light));
        color: var(--ink);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .es-strip .label {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem; letter-spacing: .3em; text-transform: uppercase;
        color: rgba(250,246,236,.55);
    }
    .es-strip .value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        color: var(--ivory);
    }

    .es-body { background: var(--ivory); padding: 5rem 0; }
    .es-body p, .es-body li {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.18rem; line-height: 1.8;
        color: var(--ink-soft);
    }
    .es-body p::first-letter {
        font-family: 'Cinzel', serif; font-size: 3.5rem;
        float: left; line-height: .9; padding-right: .65rem; padding-top: .3rem;
        color: var(--bronze-dark);
    }
    [dir="rtl"] .es-body p::first-letter { float: right; padding-right: 0; padding-left: .65rem; }
    .es-body p:not(:first-of-type)::first-letter { all: unset; }

    .es-side {
        background: var(--parchment);
        border-left: 1px solid var(--line);
        padding: 2.5rem;
        height: 100%;
    }
    [dir="rtl"] .es-side { border-left: 0; border-right: 1px solid var(--line); }
    .es-side .price-tag {
        font-family: 'Cinzel', serif;
        font-size: 2.5rem;
        font-weight: 600;
        color: var(--ink);
        line-height: 1;
        margin-bottom: .25rem;
    }
    .es-side .price-tag.free { color: #1f6e3b; }
    .es-side .price-sub {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }
    .es-side .vagas {
        background: #fff;
        padding: 1rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .es-side .vagas-bar {
        height: 8px; background: #e5e7eb; margin: .5rem 0;
        position: relative; overflow: hidden;
    }
    .es-side .vagas-bar::before {
        content: ''; position: absolute; inset: 0;
        background: var(--ev-color, var(--bronze));
        transform: scaleX(var(--pct, 0)); transform-origin: left;
    }
    .es-side .vagas-label {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem; letter-spacing: .25em; text-transform: uppercase;
        color: var(--stone);
    }

    .es-speaker {
        background: var(--ink);
        color: var(--ivory);
        padding: 4rem 0;
    }
    .es-speaker-photo {
        width: 200px; height: 200px;
        border-radius: 50%;
        border: 2px solid var(--gold-light);
        padding: 6px;
        margin: 0 auto;
    }
    .es-speaker-photo img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

    @media (max-width: 767px) {
        .es-hero { min-height: auto; padding: 4rem 0 2rem; }
        .es-side { border: 0; margin-top: 2rem; }
        .es-body { padding: 3rem 0; }
        .es-body p { font-size: 1.1rem; }
        .es-strip { padding: 1.5rem 0; }
        .es-strip .item { margin-bottom: 1rem; }
    }
</style>
@endpush

@section('content')

@php
    $bgImg = $event->imagemUrl() ?: 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=2400&q=85';
    $remaining = $event->vagas_total ? max(0, $event->vagas_total - $event->vagas_ocupadas) : null;
    $pct = ($event->vagas_total && $event->vagas_total > 0)
        ? min(1, $event->vagas_ocupadas / $event->vagas_total) : 0;
@endphp

<section class="es-hero" style="--bg: url('{{ $bgImg }}'); --ev-color: {{ $event->cor_destaque }};">
    <div class="container">
        <a href="{{ route('events.index') }}" class="back">← {{ __('site.event_back') }}</a>
        <div class="es-tags">
            @if($event->gratuito)
                <span class="es-tag free"><i class="fas fa-check me-1"></i>{{ __('site.event_free') }}</span>
            @else
                <span class="es-tag paid"><i class="fas fa-tag me-1"></i>{{ __('site.event_paid') }}</span>
            @endif
            <span class="es-tag">
                @if($event->formato === 'online') <i class="fas fa-globe me-1"></i> Online
                @elseif($event->formato === 'hibrido') <i class="fas fa-broadcast-tower me-1"></i> Híbrido
                @else <i class="fas fa-map-marker-alt me-1"></i> Presencial
                @endif
            </span>
            <span class="es-tag" style="border-color: rgba(250,246,236,.4); color: rgba(250,246,236,.85);">
                {{ $event->statusLabel() }}
            </span>
        </div>
        <h1>{{ $event->t('titulo') }}</h1>
        @if($event->t('subtitulo'))
            <p class="subtitle">{{ $event->t('subtitulo') }}</p>
        @endif
    </div>
</section>

<section class="es-strip" style="--ev-color: {{ $event->cor_destaque }};">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="item">
                    <i class="far fa-calendar"></i>
                    <div>
                        <div class="label">{{ __('site.event_when') }}</div>
                        <div class="value">{{ $event->data_inicio->translatedFormat('d M Y') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="item">
                    <i class="far fa-clock"></i>
                    <div>
                        <div class="label">{{ __('site.event_time') }}</div>
                        <div class="value">
                            {{ $event->data_inicio->format('H:i') }}
                            @if($event->data_fim) — {{ $event->data_fim->format('H:i') }} @endif
                        </div>
                    </div>
                </div>
            </div>
            @if($event->t('local_nome'))
                <div class="col-md-3 col-6">
                    <div class="item">
                        <i class="fas fa-map-pin"></i>
                        <div>
                            <div class="label">{{ __('site.event_where') }}</div>
                            <div class="value">{{ $event->t('local_nome') }}</div>
                        </div>
                    </div>
                </div>
            @endif
            @if($event->local_endereco)
                <div class="col-md-3 col-6">
                    <div class="item">
                        <i class="fas fa-location-arrow"></i>
                        <div>
                            <div class="label">{{ __('site.event_address') }}</div>
                            <div class="value">{{ $event->local_endereco }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="es-body">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                @if($event->t('descricao'))
                    @foreach(preg_split('/\n\n+/', trim($event->t('descricao'))) as $paragraph)
                        <p>{!! nl2br(e($paragraph)) !!}</p>
                    @endforeach
                @endif
            </div>
            <div class="col-lg-5">
                <div class="es-side" style="--ev-color: {{ $event->cor_destaque }}; --pct: {{ $pct }};">
                    <div style="font-family:'Cormorant SC',serif; font-size:.72rem; letter-spacing:.3em; color: var(--bronze-dark); text-transform:uppercase; margin-bottom:.5rem;">
                        {{ __('site.event_investment') }}
                    </div>
                    <div class="price-tag {{ $event->gratuito ? 'free' : '' }}">{{ $event->precoFormatado() }}</div>
                    <div class="price-sub">
                        @if($event->gratuito)
                            {{ __('site.event_free_subtitle') }}
                        @else
                            {{ __('site.event_paid_subtitle') }}
                        @endif
                    </div>

                    @if($remaining !== null)
                        <div class="vagas">
                            <div class="vagas-label">
                                <i class="fas fa-users me-1"></i>
                                {{ $event->vagas_ocupadas }} / {{ $event->vagas_total }}
                                — {{ $remaining }} {{ __('site.event_spots_left') }}
                            </div>
                            <div class="vagas-bar"></div>
                        </div>
                    @endif

                    @if($event->link_inscricao)
                        <a href="{{ $event->link_inscricao }}" target="_blank" rel="noopener" class="btn-classical-dark" style="width:100%; justify-content:center;">
                            {{ __('site.event_register') }} <i class="fas fa-arrow-right"></i>
                        </a>
                    @elseif($event->link_online)
                        <a href="{{ $event->link_online }}" target="_blank" rel="noopener" class="btn-classical-dark" style="width:100%; justify-content:center;">
                            <i class="fas fa-video"></i> {{ __('site.event_join') }}
                        </a>
                    @else
                        <a href="{{ route('contact') }}" class="btn-classical-dark" style="width:100%; justify-content:center;">
                            {{ __('site.event_contact') }} <i class="fas fa-envelope ms-1"></i>
                        </a>
                    @endif

                    @if($settings->whatsappLink())
                        <a href="{{ $settings->whatsappLink() }}" target="_blank" rel="noopener" class="btn-classical-outline" style="width:100%; justify-content:center; margin-top:.75rem; color: var(--ink); border-color: var(--ink);">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if($event->palestrante_nome)
<section class="es-speaker">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-4 text-center">
                <div class="es-speaker-photo">
                    @if($event->palestranteFotoUrl())
                        <img src="{{ $event->palestranteFotoUrl() }}" alt="{{ $event->palestrante_nome }}">
                    @else
                        <div style="width:100%; height:100%; background: var(--ink-soft); border-radius:50%; display:flex; align-items:center; justify-content:center; color: var(--gold-light); font-family:'Cinzel',serif; font-size:3rem;">
                            {{ mb_substr($event->palestrante_nome, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
                <div style="font-family:'Cormorant SC',serif; font-size:.78rem; letter-spacing:.3em; color: var(--gold-light); text-transform:uppercase; margin-bottom:.5rem;">
                    {{ __('site.event_speaker') }}
                </div>
                <h3 style="font-family:'Cinzel',serif; font-weight:500; font-size:2rem; color: var(--ivory); letter-spacing:.02em; margin-bottom:.5rem;">
                    {{ $event->palestrante_nome }}
                </h3>
                @if($event->t('palestrante_titulo'))
                    <p style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.2rem; color: var(--gold-light);">
                        {{ $event->t('palestrante_titulo') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

@if($upcoming->isNotEmpty())
<section class="ev-section alt">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">{{ __('site.events_other') }}</div>
            <h2 class="section-title-classical">{{ __('site.events_other_title') }}</h2>
        </div>
        <div class="row g-4">
            @foreach($upcoming as $e)
                <div class="col-md-4">
                    <a href="{{ route('events.show', $e->slug) }}" style="background:#fff; padding:1.75rem; height:100%; display:block; text-decoration:none; color:var(--ink); border-top: 2px solid {{ $e->cor_destaque }}; transition:transform .25s, box-shadow .25s;"
                       onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 14px 40px rgba(0,0,0,.1)';"
                       onmouseout="this.style.transform=''; this.style.boxShadow='';">
                        <div style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.3em; color: var(--stone); text-transform:uppercase; margin-bottom:.65rem;">
                            {{ $e->data_inicio->translatedFormat('d M · H:i') }}
                        </div>
                        <h4 style="font-family:'Cinzel',serif; font-size:1.1rem; color: var(--ink); letter-spacing:.05em; line-height:1.3; margin-bottom:.5rem;">
                            {{ $e->t('titulo') }}
                        </h4>
                        <p style="font-family:'Cormorant Garamond',serif; font-style:italic; color: var(--stone); font-size:1rem;">
                            {{ $e->t('subtitulo') }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
