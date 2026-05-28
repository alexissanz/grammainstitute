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
    </style>
@endpush

@section('content')

<section class="about-solo">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 about-content">

                @if($current === 'mission')
                    <div class="accent-card">
                        <p>{{ $about->t('mission_text') }}</p>
                    </div>
                @elseif($current === 'closing-statement')
                    <div class="accent-card">
                        <p>{{ $about->t('closing_text') }}</p>
                    </div>
                @elseif($current === 'areas-of-expertise')
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
