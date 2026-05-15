@extends('layouts.public')

@section('meta-title', __('site.methodology_title') . ' — ' . config('app.name'))

@section('content')

<div style="background: linear-gradient(135deg, #1a3a5c 0%, #2d6a9f 100%); padding: 5rem 0 3rem; color: #fff;">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">{{ __('site.methodology_title') }}</h1>
        <p class="lead opacity-75">{{ __('site.methodology_subtitle') }}</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row g-4">
            @foreach([
                ['fa-globe', 'methodology_1', '#1a3a5c'],
                ['fa-comments', 'methodology_2', '#2d6a9f'],
                ['fa-chart-line', 'methodology_3', '#3d8bcd'],
            ] as [$icon, $key, $color])
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4" style="border-radius: 16px; border-top: 4px solid {{ $color }} !important;">
                    <div class="card-body">
                        <div class="advantage-icon mx-auto mb-3" style="background: {{ $color }};">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <h4 class="fw-bold mb-3">{{ __("site.{$key}_title") }}</h4>
                        <p class="text-muted">{{ __("site.{$key}_text") }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0" style="background: var(--gramma-light); border-radius: 16px;">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h3 class="fw-bold mb-3" style="color: var(--gramma-blue);">Por que nossa metodologia funciona?</h3>
                                <p class="text-muted">Nossa abordagem é baseada em pesquisas modernas de aquisição de segunda língua, combinando teoria e prática de forma equilibrada. Os alunos progridem mais rápido porque aprendem em contextos reais e significativos.</p>
                                <ul class="text-muted">
                                    <li>Aulas com falantes nativos certificados</li>
                                    <li>Uso de materiais autênticos e atuais</li>
                                    <li>Feedback imediato e personalizado</li>
                                    <li>Integração de tecnologia no aprendizado</li>
                                </ul>
                            </div>
                            <div class="col-lg-5 text-center">
                                <div style="background: var(--gramma-blue); border-radius: 16px; padding: 2.5rem; color: #fff;">
                                    <div class="display-4 fw-bold" style="color: var(--gramma-gold);">95%</div>
                                    <p>dos alunos atingem seus objetivos dentro do prazo estimado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
