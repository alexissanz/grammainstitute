@extends('layouts.public')

@section('meta-title', __('site.about_title') . ' — ' . config('app.name'))

@section('content')

{{-- Page Header --}}
<div style="background: linear-gradient(135deg, #1a3a5c 0%, #2d6a9f 100%); padding: 5rem 0 3rem; color: #fff;">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">{{ __('site.about_title') }}</h1>
        <p class="lead opacity-75">{{ __('site.about_subtitle') }}</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center mb-5">
            <div class="col-lg-6">
                <h2 class="section-title">{{ __('site.about_mission') }}</h2>
                <div class="divider-gold"></div>
                <p class="text-muted">O Gramma Institute nasce do compromisso com a excelência no ensino de idiomas. Nossa missão é proporcionar uma experiência de aprendizagem transformadora, conectando pessoas a novas culturas e oportunidades por meio da linguagem.</p>
                <p class="text-muted">Acreditamos que o domínio de um idioma é uma das ferramentas mais poderosas para o desenvolvimento pessoal e profissional.</p>
            </div>
            <div class="col-lg-6">
                <div style="background: var(--gramma-light); border-radius: 16px; padding: 2.5rem; border-left: 4px solid var(--gramma-gold);">
                    <i class="fas fa-quote-left fa-2x mb-3" style="color: var(--gramma-gold);"></i>
                    <p class="fs-5 fw-medium fst-italic">"A linguagem é o mapa da cultura. Ela te diz de onde as pessoas vêm e para onde vão."</p>
                    <p class="text-muted mb-0">— Rita Mae Brown</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach([
                ['fa-eye', __('site.about_vision'), 'Ser o instituto de referência para o ensino de idiomas com metodologias modernas, abordagem humanizada e qualidade reconhecida internacionalmente.'],
                ['fa-heart', __('site.about_values'), 'Excelência, respeito à diversidade cultural, inovação pedagógica, compromisso com o progresso de cada aluno e ética em todas as relações.'],
            ] as [$icon, $title, $text])
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="advantage-icon mb-3">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <h4 class="fw-bold mb-3">{{ $title }}</h4>
                        <p class="text-muted">{{ $text }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
