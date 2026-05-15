@extends('layouts.public')

@section('meta-title', __('site.nav_terms') . ' — ' . config('app.name'))

@section('content')
<div style="background: linear-gradient(135deg, #1a3a5c 0%, #2d6a9f 100%); padding: 5rem 0 3rem; color: #fff;">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">{{ __('site.nav_terms') }}</h1>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 p-md-5" style="border-radius:16px;">
                    <p class="text-muted"><strong>Última actualização:</strong> {{ date('d/m/Y') }}</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">1. Aceitação dos Termos</h4>
                    <p class="text-muted">Ao utilizar os serviços do Gramma Institute, você concorda com estes Termos de Uso. Caso não concorde, solicitamos que não utilize nossos serviços.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">2. Serviços</h4>
                    <p class="text-muted">O Gramma Institute oferece serviços educacionais de ensino de idiomas, incluindo aulas presenciais e online, materiais didáticos e certificações.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">3. Propriedade Intelectual</h4>
                    <p class="text-muted">Todo o conteúdo disponibilizado pelo Gramma Institute, incluindo textos, imagens e materiais didáticos, é protegido por direitos autorais.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">4. Conduta do Utilizador</h4>
                    <p class="text-muted">Os utilizadores comprometem-se a usar os serviços de forma ética e legal, respeitando os demais alunos, professores e colaboradores.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">5. Modificações</h4>
                    <p class="text-muted">O Gramma Institute reserva-se o direito de modificar estes termos a qualquer momento. As alterações entram em vigor imediatamente após publicação.</p>
                    <h4 class="fw-bold mt-4 mb-3" style="color:var(--gramma-blue);">6. Contacto</h4>
                    <p class="text-muted">Dúvidas: <a href="mailto:{{ $settings->email_institucional ?? 'admin@grammainstitute.pro' }}">{{ $settings->email_institucional ?? 'admin@grammainstitute.pro' }}</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
