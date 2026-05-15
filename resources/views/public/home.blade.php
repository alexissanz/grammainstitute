@extends('layouts.public')

@section('meta-title', $settings->meta_title ?? 'Gramma Institute — ' . __('site.subtitulo_site'))

@section('content')

{{-- HERO --}}
<section class="hero-section">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title">{{ __('site.hero_title') }}</h1>
                <p class="hero-subtitle">{{ __('site.hero_subtitle') }}</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('courses') }}" class="btn-hero-primary">{{ __('site.hero_cta') }}</a>
                    <a href="{{ route('about') }}" class="btn-hero-outline">{{ __('site.hero_cta2') }}</a>
                </div>
                <div class="hero-languages">
                    @foreach([__('site.course_portuguese'), __('site.course_english'), __('site.course_spanish'), __('site.course_hebrew'), __('site.course_greek')] as $lang)
                        <span class="hero-lang-badge">{{ $lang }}</span>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <div style="background: rgba(255,255,255,0.08); border-radius: 20px; padding: 3rem 2rem; border: 1px solid rgba(255,255,255,0.15);">
                    <i class="fas fa-graduation-cap" style="font-size: 5rem; color: rgba(200,169,81,0.9);"></i>
                    <p class="mt-3" style="color: rgba(255,255,255,0.8); font-size: 1.1rem; font-weight: 500;">Instituto Internacional de Línguas</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- COURSES --}}
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">{{ __('site.courses_title') }}</h2>
            <div class="divider-gold mx-auto"></div>
            <p class="section-subtitle">{{ __('site.courses_subtitle') }}</p>
        </div>
        <div class="row g-4">
            @foreach([
                ['pt_BR', 'course_portuguese', 'fas fa-flag', '#1a3a5c', '#ffffff'],
                ['en',    'course_english',    'fas fa-globe', '#2d6a9f', '#ffffff'],
                ['es',    'course_spanish',    'fas fa-sun',   '#c8390c', '#ffffff'],
                ['he',    'course_hebrew',     'fas fa-star-of-david', '#0038b8', '#ffffff'],
                ['el',    'course_greek',      'fas fa-columns', '#0d5eaf', '#ffffff'],
            ] as [$code, $key, $icon, $color, $textColor])
            <div class="col-lg-4 col-md-6">
                <div class="course-card card h-100">
                    <div class="card-header text-white" style="background: {{ $color }};">
                        <i class="{{ $icon }} me-2"></i> {{ __("site.{$key}") }}
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="text-muted flex-grow-1">
                            {{ __('site.advantage_1_text') }}
                        </p>
                        <a href="{{ route('courses') }}" class="btn btn-outline-primary btn-sm mt-2 align-self-start">
                            {{ __('site.course_learn_more') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ADVANTAGES --}}
<section class="section section-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">{{ __('site.advantages_title') }}</h2>
            <div class="divider-gold mx-auto"></div>
        </div>
        <div class="row g-4">
            @foreach([
                ['fa-chalkboard-teacher', 'advantage_1'],
                ['fa-lightbulb',          'advantage_2'],
                ['fa-calendar-alt',       'advantage_3'],
                ['fa-certificate',        'advantage_4'],
            ] as [$icon, $key])
            <div class="col-md-6 col-lg-3">
                <div class="text-center px-3">
                    <div class="advantage-icon mx-auto">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <h5 class="fw-bold mb-2">{{ __("site.{$key}_title") }}</h5>
                    <p class="text-muted">{{ __("site.{$key}_text") }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- METHODOLOGY --}}
<section class="section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div style="background: linear-gradient(135deg, #1a3a5c, #2d6a9f); border-radius: 20px; padding: 3rem; text-align:center; color:#fff;">
                    <i class="fas fa-book-open" style="font-size:4rem; opacity:.9;"></i>
                    <h3 class="mt-3 fw-bold">{{ __('site.methodology_title') }}</h3>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5">
                <h2 class="section-title">{{ __('site.methodology_title') }}</h2>
                <div class="divider-gold"></div>
                <p class="section-subtitle">{{ __('site.methodology_subtitle') }}</p>
                @foreach([1,2,3] as $i)
                <div class="d-flex mb-3">
                    <div class="me-3 flex-shrink-0" style="width:36px;height:36px;background:var(--gramma-blue);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">{{ $i }}</div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ __("site.methodology_{$i}_title") }}</h6>
                        <p class="text-muted mb-0">{{ __("site.methodology_{$i}_text") }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="section section-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">{{ __('site.testimonials_title') }}</h2>
            <div class="divider-gold mx-auto"></div>
        </div>
        <div class="row g-4">
            @foreach([1,2,3] as $i)
            <div class="col-md-4">
                <div class="testimonial-card h-100">
                    <div class="pt-4 pb-2 px-2">
                        <p class="text-muted">{{ __("site.testimonial_{$i}_text") }}</p>
                        <div class="d-flex align-items-center mt-3">
                            <div style="width:40px;height:40px;background:var(--gramma-blue);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;flex-shrink:0;">
                                {{ substr(__("site.testimonial_{$i}_author"), 0, 1) }}
                            </div>
                            <div class="ms-3">
                                <div class="fw-bold" style="font-size:.95rem;">{{ __("site.testimonial_{$i}_author") }}</div>
                                <div class="text-warning" style="font-size:.8rem;">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CONTACT CTA --}}
<section class="section section-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <h2 class="section-title">{{ __('site.contact_title') }}</h2>
                <div class="divider-gold"></div>
                <p class="section-subtitle">{{ __('site.contact_subtitle') }}</p>
                @if($settings->email_institucional)
                    <p><i class="fas fa-envelope me-2" style="color:var(--gramma-gold);"></i> {{ $settings->email_institucional }}</p>
                @endif
                @if($settings->telefone)
                    <p><i class="fas fa-phone me-2" style="color:var(--gramma-gold);"></i> {{ $settings->telefone }}</p>
                @endif
            </div>
            <div class="col-lg-5">
                <form class="p-4" style="background:rgba(255,255,255,0.08);border-radius:12px;border:1px solid rgba(255,255,255,0.15);">
                    <div class="mb-3">
                        <input type="text" class="form-control bg-transparent border-light text-white"
                               placeholder="{{ __('site.contact_name') }}" style="color:#fff !important;">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control bg-transparent border-light"
                               placeholder="{{ __('site.contact_email') }}" style="color:#fff !important;">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control bg-transparent border-light" rows="3"
                                  placeholder="{{ __('site.contact_message') }}" style="color:#fff !important;"></textarea>
                    </div>
                    <button type="submit" class="btn w-100" style="background:var(--gramma-gold);color:#1a1a2e;font-weight:700;">
                        {{ __('site.contact_send') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
