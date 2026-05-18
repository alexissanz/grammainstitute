@extends('layouts.adminlte')

@section('title', 'Eventos')
@section('page-title', 'Gerir Eventos')

@section('breadcrumb')
    <li class="breadcrumb-item active">Eventos</li>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <p class="text-muted mb-0" style="font-size:.875rem;">
        Calendário académico exibido em <code>/events</code> e nos cards da página inicial.
    </p>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary" style="border-radius:8px;">
        <i class="fas fa-plus me-2"></i>Novo Evento
    </a>
</div>

@if($events->isEmpty())
<div class="card text-center py-5" style="border-radius:12px; border:2px dashed #e5e7eb;">
    <div style="font-size:3rem; color:#d1d5db; margin-bottom:1rem;"><i class="far fa-calendar"></i></div>
    <h6 class="text-muted">Nenhum evento criado ainda</h6>
</div>
@else
<div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background:#f9fafb;">
                <tr>
                    <th style="padding:1rem 1.25rem; font-size:.75rem; letter-spacing:.06em; text-transform:uppercase; color:#6b7280;">Evento</th>
                    <th style="padding:1rem;">Quando</th>
                    <th style="padding:1rem;">Tipo</th>
                    <th style="padding:1rem;">Preço</th>
                    <th style="padding:1rem;">Vagas</th>
                    <th style="padding:1rem;">Estado</th>
                    <th style="padding:1rem; text-align:right;">Acções</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td style="padding: .8rem 1.25rem;">
                        <div class="d-flex align-items-center gap-3">
                            @if($event->imagemUrl())
                                <img src="{{ $event->imagemUrl() }}" style="width:60px; height:42px; object-fit:cover; border-radius:6px; flex-shrink:0;">
                            @else
                                <div style="width:60px; height:42px; background:#f3f4f6; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#9ca3af; flex-shrink:0;"><i class="far fa-calendar"></i></div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $event->t('titulo') }}</div>
                                <small class="text-muted">/{{ $event->slug }}</small>
                            </div>
                        </div>
                    </td>
                    <td style="padding: .8rem;">
                        <div style="font-weight:600; color:#1a3a5c;">{{ $event->data_inicio->translatedFormat('d M Y') }}</div>
                        <small class="text-muted">{{ $event->data_inicio->format('H:i') }}@if($event->data_fim) — {{ $event->data_fim->format('H:i') }} @endif</small>
                    </td>
                    <td style="padding: .8rem;">
                        @if($event->formato === 'online')
                            <span class="badge bg-info">Online</span>
                        @elseif($event->formato === 'hibrido')
                            <span class="badge bg-primary">Híbrido</span>
                        @else
                            <span class="badge bg-secondary">Presencial</span>
                        @endif
                    </td>
                    <td style="padding: .8rem;">
                        @if($event->gratuito)
                            <span class="badge bg-success">Gratuito</span>
                        @else
                            <span>{{ $event->preco ?: $event->moeda . ' ' . $event->preco_valor }}</span>
                        @endif
                    </td>
                    <td style="padding: .8rem;">
                        @if($event->vagas_total)
                            {{ $event->vagas_ocupadas }}/{{ $event->vagas_total }}
                        @else
                            —
                        @endif
                    </td>
                    <td style="padding: .8rem;">
                        @if($event->ativo)
                            <span class="badge bg-success" style="font-size:.7rem;">Activo</span>
                        @else
                            <span class="badge bg-secondary" style="font-size:.7rem;">Oculto</span>
                        @endif
                        @if($event->destaque)
                            <span class="badge bg-warning text-dark" style="font-size:.7rem;">★</span>
                        @endif
                    </td>
                    <td style="padding: .8rem; text-align:right; white-space:nowrap;">
                        <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fas fa-external-link-alt"></i></a>
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="post" action="{{ route('admin.events.destroy', $event) }}" class="d-inline" onsubmit="return confirm('Remover este evento?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
