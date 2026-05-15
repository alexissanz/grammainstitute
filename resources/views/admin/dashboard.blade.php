@extends('layouts.adminlte')

@section('title', __('dashboard.menu_dashboard'))
@section('page-title', __('dashboard.menu_dashboard'))

@section('content')
<div class="row">
    {{-- Card: Idioma Atual --}}
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-globe"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.card_locale') }}</span>
                <span class="info-box-number">{{ strtoupper(app()->getLocale()) }}</span>
            </div>
        </div>
    </div>

    {{-- Card: Idiomas Ativos --}}
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-language"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.card_languages') }}</span>
                <span class="info-box-number">{{ $activeLanguages }}</span>
            </div>
        </div>
    </div>

    {{-- Card: SMTP --}}
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="info-box">
            <span class="info-box-icon {{ $smtpConfigured ? 'bg-success' : 'bg-warning' }} elevation-1">
                <i class="fas fa-envelope"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.card_smtp') }}</span>
                <span class="info-box-number">
                    {{ $smtpConfigured ? __('dashboard.smtp_configured') : __('dashboard.smtp_not_configured') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Card: Estado do Site --}}
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-globe-americas"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.card_site_status') }}</span>
                <span class="info-box-number">{{ __('dashboard.site_active') }}</span>
            </div>
        </div>
    </div>

    {{-- Card: Última Atualização --}}
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="info-box">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.card_last_update') }}</span>
                <span class="info-box-number" style="font-size:1rem;">
                    {{ $settings->updated_at ? $settings->updated_at->format('d/m/Y H:i') : '—' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Card: Utilizador --}}
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="info-box">
            <span class="info-box-icon bg-dark elevation-1"><i class="fas fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.card_user') }}</span>
                <span class="info-box-number" style="font-size:1rem;">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> {{ $settings->nome_site ?? 'Gramma Institute' }}</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">{{ $settings->descricao_site ?? __('site.hero_subtitle') }}</p>
                @if($settings->email_institucional)
                    <p><i class="fas fa-envelope mr-1 text-primary"></i> {{ $settings->email_institucional }}</p>
                @endif
                @if($settings->telefone)
                    <p><i class="fas fa-phone mr-1 text-primary"></i> {{ $settings->telefone }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-rocket mr-1"></i> Acesso Rápido</h3>
            </div>
            <div class="card-body">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.settings.edit') }}" class="btn btn-outline-primary btn-sm mb-2 mr-2">
                        <i class="fas fa-cog"></i> {{ __('dashboard.menu_settings') }}
                    </a>
                    <a href="{{ route('admin.email-test.index') }}" class="btn btn-outline-info btn-sm mb-2 mr-2">
                        <i class="fas fa-envelope"></i> {{ __('dashboard.menu_email_test') }}
                    </a>
                    <a href="{{ route('admin.languages.index') }}" class="btn btn-outline-success btn-sm mb-2 mr-2">
                        <i class="fas fa-language"></i> {{ __('dashboard.menu_languages') }}
                    </a>
                @endif
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm mb-2">
                    <i class="fas fa-external-link-alt"></i> {{ __('site.nav_home') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
