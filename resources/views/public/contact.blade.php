@extends('layouts.public')

@section('meta-title', __('site.contact_title') . ' — ' . config('app.name'))

@section('content')

<div style="background: linear-gradient(135deg, #1a3a5c 0%, #2d6a9f 100%); padding: 5rem 0 3rem; color: #fff;">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">{{ __('site.contact_title') }}</h1>
        <p class="lead opacity-75">{{ __('site.contact_subtitle') }}</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <h3 class="fw-bold mb-4" style="color: var(--gramma-blue);">Informações de Contacto</h3>
                @if($settings->email_institucional)
                <div class="d-flex mb-3">
                    <div class="advantage-icon me-3 flex-shrink-0" style="width:48px;height:48px;font-size:1.1rem;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ __('site.contact_email') }}</div>
                        <a href="mailto:{{ $settings->email_institucional }}">{{ $settings->email_institucional }}</a>
                    </div>
                </div>
                @endif
                @if($settings->telefone)
                <div class="d-flex mb-3">
                    <div class="advantage-icon me-3 flex-shrink-0" style="width:48px;height:48px;font-size:1.1rem;">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ __('site.contact_phone') }}</div>
                        <p class="text-muted mb-0">{{ $settings->telefone }}</p>
                    </div>
                </div>
                @endif
                @if($settings->endereco || $settings->cidade)
                <div class="d-flex mb-3">
                    <div class="advantage-icon me-3 flex-shrink-0" style="width:48px;height:48px;font-size:1.1rem;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ __('site.contact_address') }}</div>
                        <p class="text-muted mb-0">{{ $settings->endereco }}</p>
                        <p class="text-muted mb-0">{{ $settings->cidade }}{{ $settings->pais ? ', ' . $settings->pais : '' }}</p>
                    </div>
                </div>
                @endif

                <div class="d-flex gap-3 mt-4">
                    @if($settings->facebook) <a href="{{ $settings->facebook }}" target="_blank" style="color:var(--gramma-blue);"><i class="fab fa-facebook fa-2x"></i></a> @endif
                    @if($settings->instagram) <a href="{{ $settings->instagram }}" target="_blank" style="color:var(--gramma-blue);"><i class="fab fa-instagram fa-2x"></i></a> @endif
                    @if($settings->linkedin) <a href="{{ $settings->linkedin }}" target="_blank" style="color:var(--gramma-blue);"><i class="fab fa-linkedin fa-2x"></i></a> @endif
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold mb-4" style="color: var(--gramma-blue);">Envie uma mensagem</h4>
                        <form>
                            <div class="mb-3">
                                <label class="form-label fw-medium">{{ __('site.contact_name') }}</label>
                                <input type="text" class="form-control form-control-lg" placeholder="{{ __('site.contact_name') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">{{ __('site.contact_email') }}</label>
                                <input type="email" class="form-control form-control-lg" placeholder="email@exemplo.com">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-medium">{{ __('site.contact_message') }}</label>
                                <textarea class="form-control" rows="5" placeholder="{{ __('site.contact_message') }}"></textarea>
                            </div>
                            <button type="submit" class="btn btn-lg w-100 fw-bold text-white" style="background:var(--gramma-blue);">
                                <i class="fas fa-paper-plane me-2"></i> {{ __('site.contact_send') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
