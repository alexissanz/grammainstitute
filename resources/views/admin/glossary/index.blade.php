@extends('layouts.adminlte')

@section('title', 'Glossário')
@section('page-title', 'Gerir Glossário')

@section('breadcrumb')
    <li class="breadcrumb-item active">Glossário</li>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <p class="text-muted mb-0" style="font-size:.875rem;">
        Verbetes do glossário público em <code>/glossary</code>. Suporta grego, hebraico, latim e qualquer outro idioma.
    </p>
    <a href="{{ route('admin.glossary.create') }}" class="btn btn-primary" style="border-radius:8px;">
        <i class="fas fa-plus me-2"></i>Novo Verbete
    </a>
</div>

@if($terms->isEmpty())
<div class="card text-center py-5" style="border-radius:12px; border:2px dashed #e5e7eb;">
    <div style="font-size:3rem; color:#d1d5db; margin-bottom:1rem;"><i class="fas fa-book"></i></div>
    <h6 class="text-muted">Nenhum verbete ainda</h6>
</div>
@else
<div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background:#f9fafb;">
                <tr>
                    <th style="padding:1rem 1.25rem; font-size:.75rem; letter-spacing:.06em; text-transform:uppercase; color:#6b7280;">Termo</th>
                    <th style="padding:1rem;">Língua</th>
                    <th style="padding:1rem;">Categoria</th>
                    <th style="padding:1rem;">Estado</th>
                    <th style="padding:1rem; text-align:right;">Acções</th>
                </tr>
            </thead>
            <tbody>
                @foreach($terms as $t)
                <tr>
                    <td style="padding: .9rem 1.25rem;">
                        <div style="font-family: {{ $t->lingua === 'he' ? "'Noto Sans Hebrew', serif" : "Georgia, serif" }}; font-size:1.5rem; font-weight:600; color:#1a3a5c; line-height: 1;">
                            {{ $t->termo }}
                        </div>
                        <div style="font-style: italic; color: #6b7280; font-size: .85rem; margin-top: 4px;">
                            {{ $t->transliteracao }} · /{{ $t->slug }}
                        </div>
                    </td>
                    <td style="padding: .9rem;">{{ App\Models\GlossaryTerm::linguaLabel($t->lingua) }}</td>
                    <td style="padding: .9rem;"><small>{{ $t->categoria }}</small></td>
                    <td style="padding: .9rem;">
                        @if($t->ativo)
                            <span class="badge bg-success" style="font-size:.7rem; padding:.3rem .65rem;">Activo</span>
                        @else
                            <span class="badge bg-secondary" style="font-size:.7rem; padding:.3rem .65rem;">Oculto</span>
                        @endif
                        @if($t->destaque)
                            <span class="badge bg-warning text-dark" style="font-size:.7rem; padding:.3rem .65rem;">★</span>
                        @endif
                    </td>
                    <td style="padding: .9rem; text-align:right; white-space:nowrap;">
                        <a href="{{ route('glossary.show', $t->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fas fa-external-link-alt"></i></a>
                        <a href="{{ route('admin.glossary.edit', $t) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="post" action="{{ route('admin.glossary.destroy', $t) }}" class="d-inline" onsubmit="return confirm('Remover este verbete?');">
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
