@extends('layouts.adminlte')

@section('title', 'Cursos')
@section('page-title', 'Gerir Cursos')

@section('breadcrumb')
    <li class="breadcrumb-item active">Cursos</li>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <p class="text-muted mb-0" style="font-size:.875rem;">
        Cada curso aparece na página inicial e tem a sua própria página detalhada <code>/courses/{slug}</code>.
    </p>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary" style="border-radius:8px;">
        <i class="fas fa-plus me-2"></i>Novo Curso
    </a>
</div>

@if($courses->isEmpty())
<div class="card text-center py-5" style="border-radius:12px; border:2px dashed #e5e7eb;">
    <div style="font-size:3rem; color:#d1d5db; margin-bottom:1rem;"><i class="fas fa-book-open"></i></div>
    <h6 class="text-muted">Nenhum curso ainda</h6>
    <p class="text-muted small">Clique em "Novo Curso" para começar.</p>
</div>
@else
<div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background:#f9fafb;">
                <tr>
                    <th style="padding:1rem 1.25rem; font-size:.75rem; letter-spacing:.06em; text-transform:uppercase; color:#6b7280;">Curso</th>
                    <th style="padding:1rem;">Glifo</th>
                    <th style="padding:1rem;">Professor</th>
                    <th style="padding:1rem;">Formato</th>
                    <th style="padding:1rem;">Estado</th>
                    <th style="padding:1rem; text-align:right;">Acções</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $c)
                <tr>
                    <td style="padding: .8rem 1.25rem;">
                        <div class="d-flex align-items-center gap-3">
                            @if($c->imagemCapaUrl())
                                <img src="{{ $c->imagemCapaUrl() }}" style="width:60px; height:42px; object-fit:cover; border-radius:6px; flex-shrink:0;">
                            @else
                                <div style="width:60px; height:42px; background:#f3f4f6; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#9ca3af; flex-shrink:0;"><i class="fas fa-image"></i></div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $c->t('nome') }}</div>
                                <small class="text-muted">/{{ $c->slug }}</small>
                            </div>
                        </div>
                    </td>
                    <td style="padding: .8rem; font-family:'Georgia', serif; font-size:1.3rem; color: {{ $c->cor_destaque }};">{{ $c->glifo }}</td>
                    <td style="padding: .8rem;">{{ $c->professor_nome }}</td>
                    <td style="padding: .8rem;"><small>{{ $c->formato }}</small></td>
                    <td style="padding: .8rem;">
                        @if($c->ativo)
                            <span class="badge bg-success" style="font-size:.7rem; padding:.3rem .65rem;">Activo</span>
                        @else
                            <span class="badge bg-secondary" style="font-size:.7rem; padding:.3rem .65rem;">Oculto</span>
                        @endif
                        @if($c->destaque)
                            <span class="badge bg-warning text-dark" style="font-size:.7rem; padding:.3rem .65rem;">★ Destaque</span>
                        @endif
                    </td>
                    <td style="padding: .8rem; text-align:right; white-space:nowrap;">
                        <a href="{{ route('courses.show', $c->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Ver no site"><i class="fas fa-external-link-alt"></i></a>
                        <a href="{{ route('admin.courses.edit', $c) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="post" action="{{ route('admin.courses.destroy', $c) }}" class="d-inline" onsubmit="return confirm('Remover este curso?');">
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
