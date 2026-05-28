@extends('layouts.adminlte')

@section('title', 'Glossário')
@section('page-title', 'Glossary by Letter')

@section('breadcrumb')
    <li class="breadcrumb-item active">Glossário</li>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <p class="text-muted mb-0" style="font-size:.875rem;">
        Um bloco por letra. No site, o visitante escolhe a letra e o conteúdo aparece de forma alinhada.
    </p>
    <a href="{{ route('admin.glossary.create') }}" class="btn btn-primary" style="border-radius:8px;">
        <i class="fas fa-plus me-2"></i>Nova Letra
    </a>
</div>

@if($terms->isEmpty())
<div class="card text-center py-5" style="border-radius:12px; border:2px dashed #e5e7eb;">
    <div style="font-size:3rem; color:#d1d5db; margin-bottom:1rem;"><i class="fas fa-book"></i></div>
    <h6 class="text-muted">Nenhuma letra ainda</h6>
</div>
@else
<div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background:#f9fafb;">
                <tr>
                    <th style="padding:1rem 1.25rem; font-size:.75rem; letter-spacing:.06em; text-transform:uppercase; color:#6b7280;">Letra</th>
                    <th style="padding:1rem;">Título</th>
                    <th style="padding:1rem;">Resumo</th>
                    <th style="padding:1rem;">Estado</th>
                    <th style="padding:1rem; text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($terms as $term)
                <tr>
                    <td style="padding: .9rem 1.25rem;">
                        <div style="font-family: Georgia, serif; font-size:1.8rem; font-weight:700; color:#1a3a5c; line-height:1;">
                            {{ $term->letterKey() }}
                        </div>
                    </td>
                    <td style="padding: .9rem;">{{ $term->termo }}</td>
                    <td style="padding: .9rem; max-width:360px;"><small>{{ \Illuminate\Support\Str::limit($term->t('significado'), 120) }}</small></td>
                    <td style="padding: .9rem;">
                        @if($term->ativo)
                            <span class="badge bg-success" style="font-size:.7rem; padding:.3rem .65rem;">Activo</span>
                        @else
                            <span class="badge bg-secondary" style="font-size:.7rem; padding:.3rem .65rem;">Oculto</span>
                        @endif
                    </td>
                    <td style="padding: .9rem; text-align:right; white-space:nowrap;">
                        <a href="{{ route('admin.glossary.edit', $term) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="post" action="{{ route('admin.glossary.destroy', $term) }}" class="d-inline" onsubmit="return confirm('Remover esta letra?');">
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
