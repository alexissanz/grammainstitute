@extends('layouts.public')

@section('meta-title', __('site.nav_privacy') . ' — ' . config('app.name'))

@section('content')
<div style="background: linear-gradient(135deg, #1a3a5c 0%, #2d6a9f 100%); padding: 5rem 0 3rem; color: #fff;">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">{{ __('site.nav_privacy') }}</h1>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 p-md-5" style="border-radius:16px;">
                    <p class="text-muted"><strong>Última actualização:</strong> {{ date('d/m/Y') }}</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">1. Coleta de Dados</h4>
                    <p class="text-muted">O Gramma Institute coleta apenas os dados necessários para a prestação dos serviços educacionais, incluindo nome, e-mail, telefone e informações acadêmicas.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">2. Uso dos Dados</h4>
                    <p class="text-muted">Os dados coletados são utilizados exclusivamente para: comunicações sobre cursos, envio de materiais didáticos e melhoria contínua dos nossos serviços.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">3. Segurança</h4>
                    <p class="text-muted">Implementamos medidas técnicas e organizacionais adequadas para proteger seus dados contra acesso não autorizado, alteração, divulgação ou destruição.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">4. Seus Direitos</h4>
                    <p class="text-muted">Você tem o direito de acessar, corrigir ou solicitar a exclusão dos seus dados pessoais. Entre em contacto através do nosso e-mail institucional.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">5. Contacto</h4>
                    <p class="text-muted">Para questões relacionadas com privacidade: <a href="mailto:{{ $settings->email_institucional ?? 'admin@grammainstitute.pro' }}">{{ $settings->email_institucional ?? 'admin@grammainstitute.pro' }}</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
