@extends('layouts.adminlte')

@section('title', 'Promoções')
@section('page-title', 'Gerir Promoções')

@section('breadcrumb')
    <li class="breadcrumb-item active">Promoções</li>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <p class="text-muted mb-0" style="font-size:.875rem;">
        Promoções aparecem na barra superior, banner da página inicial, ou popup — conforme configurado.
    </p>
    <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary" style="border-radius:8px;">
        <i class="fas fa-plus me-2"></i>Nova Promoção
    </a>
</div>

@if($promotions->isEmpty())
<div class="card text-center py-5" style="border-radius:12px; border:2px dashed #e5e7eb;">
    <div style="font-size:3rem; color:#d1d5db; margin-bottom:1rem;"><i class="fas fa-percent"></i></div>
    <h6 class="text-muted">Nenhuma promoção criada ainda</h6>
</div>
@else
<div class="row g-3">
    @foreach($promotions as $promo)
    <div class="col-md-6">
        <div class="card h-100" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08); overflow:hidden;">
            <div style="background: {{ $promo->cor_fundo }}; color: {{ $promo->cor_texto }}; padding: 1.5rem; position:relative;">
                @if($promo->t('badge_texto'))
                    <div style="display:inline-block; font-family:Georgia,serif; font-size:.7rem; font-weight:600; letter-spacing:.3em; text-transform:uppercase; color: {{ $promo->cor_destaque }}; padding:.2rem .6rem; border:1px solid {{ $promo->cor_destaque }}; margin-bottom:.5rem;">
                        {{ $promo->t('badge_texto') }}
                    </div>
                @endif
                <div style="font-family:Georgia,serif; font-size:1.3rem; font-weight:600; line-height:1.2; color:{{ $promo->cor_texto }};">
                    {{ $promo->t('titulo') }}
                </div>
                @if($promo->desconto)
                    <div style="font-family:Georgia,serif; font-size:1.6rem; font-weight:700; color: {{ $promo->cor_destaque }}; margin-top:.5rem;">
                        {{ $promo->desconto }}
                    </div>
                @endif
            </div>
            <div class="card-body" style="padding: 1.25rem;">
                <div class="d-flex flex-wrap gap-1 mb-2">
                    @if($promo->ativo) <span class="badge bg-success">Activa</span> @else <span class="badge bg-secondary">Inactiva</span> @endif
                    @if($promo->isCurrent()) <span class="badge bg-info">A decorrer agora</span> @endif
                    @if($promo->mostrar_topbar) <span class="badge bg-dark">↑ Topbar</span> @endif
                    @if($promo->mostrar_home) <span class="badge bg-primary">Home</span> @endif
                    @if($promo->mostrar_popup) <span class="badge bg-warning text-dark">Popup</span> @endif
                </div>
                <small class="text-muted d-block">
                    @if($promo->inicio) De {{ $promo->inicio->format('d/m/Y') }} @endif
                    @if($promo->fim) até {{ $promo->fim->format('d/m/Y') }} @endif
                    @if($promo->codigo_promo) · Código: <code>{{ $promo->codigo_promo }}</code> @endif
                </small>
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('admin.promotions.edit', $promo) }}" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="fas fa-edit me-1"></i>Editar</a>
                    <form method="post" action="{{ route('admin.promotions.destroy', $promo) }}" onsubmit="return confirm('Remover esta promoção?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection
