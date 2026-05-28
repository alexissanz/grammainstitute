@extends('layouts.adminlte')

@section('title', 'Recursos · Resources')
@section('page-title', 'Recursos · Resources')

@section('breadcrumb')
    <li class="breadcrumb-item active">Recursos</li>
@endsection

@push('styles')
<style>
    .cat-card {
        background:#fff; border:1px solid #e5e7eb; border-radius:10px;
        padding:1.25rem 1.5rem; margin-bottom:.75rem;
        display:flex; align-items:center; gap:1rem;
    }
    .cat-card .ico {
        width:42px; height:42px; border-radius:50%;
        background:rgba(168,120,65,.12); color:#7e5223;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0;
    }
    .cat-card .main { flex:1; min-width:0; }
    .cat-card .actions { display:flex; gap:.4rem; flex-shrink:0; }
    .cat-card .name { font-family:'Bodoni Moda',serif; font-weight:600; font-size:1.05rem; }
    .cat-card .meta { font-size:.78rem; color:#6b7280; }
    .badge-inactive { font-size:.65rem; padding:.1rem .45rem; background:#f3f4f6; color:#6b7280; border-radius:4px; margin-left:.4rem; }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success" style="border-radius:8px;"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<div class="alert" style="background:#eef3ff; border:1px solid #c7d7f5; color:#1a3a5c; border-radius:10px; font-size:.875rem;">
    <i class="fas fa-info-circle me-1"></i>
    <strong>Como funciona:</strong> cada categoria é um agrupamento que aparece no menu Resources do site.
    Dentro de cada categoria, adicione links para ferramentas externas — cada link abre numa nova aba.
    Arraste <i class="fas fa-grip-vertical"></i> para reordenar.
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 style="font-family:'Bodoni Moda',serif; margin:0;">Categorias</h5>
    <a href="{{ route('admin.resources.createCategory') }}" class="btn btn-primary"
       style="background:#1a1612;border-color:#1a1612;border-radius:8px;">
        <i class="fas fa-plus me-1"></i>Nova categoria
    </a>
</div>

@if($categories->isEmpty())
    <div class="card text-center py-5" style="border-radius:12px; border:2px dashed #e5e7eb;">
        <div style="font-size:3rem; color:#d1d5db;"><i class="fas fa-folder-open"></i></div>
        <h6 class="text-muted">Sem categorias ainda</h6>
        <p class="text-muted small">Crie a primeira categoria para começar.</p>
    </div>
@else
    <div id="cat-list">
        @foreach($categories as $cat)
            <div class="cat-card" data-id="{{ $cat->id }}">
                <span class="drag-handle" style="cursor:grab; color:#d1d5db;"><i class="fas fa-grip-vertical"></i></span>
                <div class="ico"><i class="fas {{ $cat->icon ?: 'fa-bookmark' }}"></i></div>
                <div class="main">
                    <div class="name">
                        {{ $cat->title['pt_BR'] ?? $cat->title['en'] ?? $cat->slug }}
                        @if(!$cat->ativo)<span class="badge-inactive">INATIVA</span>@endif
                    </div>
                    <div class="meta">
                        <code>{{ $cat->slug }}</code> ·
                        <strong>{{ $cat->links->count() }}</strong> link(s) ·
                        {{ $cat->description['pt_BR'] ?? $cat->description['en'] ?? '' }}
                    </div>
                </div>
                <div class="actions">
                    <a href="{{ route('admin.resources.editCategory', $cat) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    <form method="post" action="{{ route('admin.resources.destroyCategory', $cat) }}" class="d-inline"
                          onsubmit="return confirm('Remover categoria E todos os seus links?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const list = document.getElementById('cat-list');
if (list) {
    Sortable.create(list, {
        handle: '.drag-handle', animation: 150,
        onEnd: function() {
            const ids = Array.from(list.querySelectorAll('[data-id]')).map(el => el.getAttribute('data-id'));
            fetch('{{ route("admin.resources.reorderCategories") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ order: ids })
            });
        }
    });
}
</script>
@endpush
