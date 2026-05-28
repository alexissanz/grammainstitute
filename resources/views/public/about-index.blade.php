@extends('layouts.public')

@section('meta-title', __('site.nav_about') . ' — ' . config('app.name'))

@push('styles')
    @include('public._about_styles')
@endpush

@section('content')

<section class="about-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="about-eyebrow">{{ __('site.nav_about') }}</div>
                <h1>{{ __('site.about_landing_title') }}</h1>
                @if($about->t('quote_text'))
                    <blockquote class="about-quote" style="color:rgba(250,246,236,.92); border-left-color: var(--gold);">
                        “{{ $about->t('quote_text') }}”
                    </blockquote>
                    @if($about->quote_author)
                        <div class="about-quote-author" style="color: var(--gold-light);">{{ $about->quote_author }}</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>

<section class="about-body">
    <div class="container">
        <div class="about-ornament" style="justify-content:center;"><i class="fas fa-feather"></i></div>
        <p style="text-align:center; max-width:680px; margin:0 auto; font-family:'Cormorant Garamond',serif; font-style:italic; color:var(--ink-soft); font-size:1.18rem; line-height:1.65;">
            {{ __('site.about_landing_lede') }}
        </p>

        <div class="about-index-grid">
            @foreach($sections as $slug => $meta)
                <a href="{{ route('about.section', $slug) }}" class="about-index-card">
                    <div class="ico"><i class="fas {{ $meta['icon'] }}"></i></div>
                    <h3>{{ $about->t($meta['title_field']) ?: $meta['fallback'] }}</h3>
                    @if($meta['text_field'] && $about->t($meta['text_field']))
                        <p class="lede">{{ \Illuminate\Support\Str::limit(strip_tags(preg_replace('/\s+/', ' ', $about->t($meta['text_field']))), 130) }}</p>
                    @elseif($slug === 'areas-of-expertise')
                        <p class="lede">{{ implode(' · ', array_slice($about->expertiseList(), 0, 4)) }}{{ count($about->expertiseList()) > 4 ? ' …' : '' }}</p>
                    @endif
                    <span class="more">{{ __('site.about_read_more') }} <i class="fas fa-arrow-right"></i></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
