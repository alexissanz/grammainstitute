@extends('layouts.public')

@php
    $meta         = $sections[$current];
    $sectionTitle = $about->t($meta['title_field']) ?: $meta['fallback'];
@endphp

@section('meta-title', $sectionTitle . ' — ' . config('app.name'))

@push('styles')
    @include('public._about_styles')
    <style>
        .about-content p,
        .about-content li,
        .about-content .lead-p,
        .about-content .accent-card p,
        .about-content .expertise-item span {
            text-align: justify;
            text-justify: inter-word;
        }
        /* Content-only sub-page: no hero, no side-nav, no ornaments, no titles. */
        .about-solo { background: var(--ivory); padding: 5rem 0 6rem; position: relative; }
        .about-solo > .container { position: relative; z-index: 1; }
        @media (max-width: 575px) { .about-solo { padding: 3.5rem 0 4rem; } }

        /* "Who is" portrait — editorial, black & white, text wraps around it. */
        .who-portrait {
            float: right;
            width: clamp(190px, 34%, 320px);
            margin: .3rem 0 1.4rem 2.2rem;
            shape-outside: inset(0 round 18px);
        }
        .who-portrait img {
            display: block;
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 18px;
            filter: grayscale(100%) contrast(1.04);
            border: 1px solid rgba(0,0,0,.12);
            box-shadow: 0 22px 48px rgba(0,0,0,.20);
        }
        .who-portrait.is-color img { filter: none; }
        .who-portrait figcaption {
            margin-top: .65rem;
            text-align: center;
            font-family: 'Cormorant SC', serif;
            font-size: .72rem;
            letter-spacing: .24em;
            text-transform: uppercase;
            color: var(--ink);
        }
        [dir="rtl"] .who-portrait { float: left; margin: .3rem 2.2rem 1.4rem 0; }
        @media (max-width: 640px) {
            .who-portrait { float: none; width: min(220px, 62%); margin: 0 auto 1.75rem; }
        }
    </style>
@endpush

@section('content')

<section class="about-solo">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 about-content">

                @if($current === 'areas-of-expertise')
                    @php $list = $about->expertiseList(); @endphp
                    @if(!empty($list))
                        <div class="expertise-grid">
                            @foreach($list as $i => $item)
                                <div class="expertise-item">
                                    <span>{{ $item }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    @if($current === 'who-is' && $about->fotoUrl())
                        <figure class="who-portrait {{ $about->foto_bw ? '' : 'is-color' }}">
                            <img src="{{ $about->fotoUrl() }}" alt="{{ $sectionTitle }}">
                            @if($about->quote_author)
                                <figcaption>{{ $about->quote_author }}</figcaption>
                            @endif
                        </figure>
                    @endif
                    @if($meta['text_field'])
                        @foreach(preg_split("/\r\n\r\n|\n\n/", trim((string) $about->t($meta['text_field']))) as $para)
                            @if(trim($para) !== '')
                                <p class="lead-p">{{ $para }}</p>
                            @endif
                        @endforeach
                    @endif

                    @if($current === 'who-is' && $about->t('quote_text'))
                        <blockquote class="about-quote">“{{ $about->t('quote_text') }}”</blockquote>
                        @if($about->quote_author)
                            <div class="about-quote-author">{{ $about->quote_author }}</div>
                        @endif
                    @endif
                @endif

            </div>
        </div>
    </div>
</section>

@endsection
