@extends('layouts.public')

@section('meta-title', __('site.courses_title') . ' — ' . config('app.name'))

@section('content')

<div style="background: linear-gradient(135deg, #1a3a5c 0%, #2d6a9f 100%); padding: 5rem 0 3rem; color: #fff;">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">{{ __('site.courses_title') }}</h1>
        <p class="lead opacity-75">{{ __('site.courses_subtitle') }}</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row g-4">
            @foreach([
                ['pt_BR', 'course_portuguese', 'fas fa-flag', '#1a3a5c', 'Nosso idioma-mãe ensinado com rigor e carinho para quem deseja aprimorar a escrita, fala e leitura em português.'],
                ['en',    'course_english',    'fas fa-globe-europe', '#2d6a9f', 'O inglês continua sendo o idioma do mundo dos negócios, da tecnologia e da ciência. Aprenda com nativos.'],
                ['es',    'course_spanish',    'fas fa-sun',   '#c8390c', 'O espanhol abre portas para mais de 20 países. Aprenda com métodos comunicativos e imersão cultural.'],
                ['he',    'course_hebrew',     'fas fa-star-of-david', '#0038b8', 'O hebraico moderno, língua do Estado de Israel. Aprenda a ler, escrever e conversar em uma das línguas mais antigas do mundo.'],
                ['el',    'course_greek',      'fas fa-columns', '#0d5eaf', 'O grego moderno, língua de uma das civilizações mais influentes da história. Uma experiência cultural única.'],
            ] as [$code, $key, $icon, $color, $desc])
            <div class="col-md-6 col-lg-4">
                <div class="course-card card h-100">
                    <div class="card-header text-white d-flex align-items-center" style="background: {{ $color }}; min-height: 70px;">
                        <i class="{{ $icon }} fa-2x me-3 opacity-75"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ __("site.{$key}") }}</h5>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="text-muted flex-grow-1">{{ $desc }}</p>
                        <div class="mt-3 pt-3 border-top">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="fw-bold text-primary">A1–C2</div>
                                    <div class="text-muted small">Níveis</div>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-primary">Online</div>
                                    <div class="text-muted small">Modalidade</div>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-primary">Cert.</div>
                                    <div class="text-muted small">Int'l</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-sm mt-3">
                            {{ __('site.course_learn_more') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
