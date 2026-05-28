@extends('layouts.adminlte')

@section('title', 'Categoria de Recursos')
@section('page-title', $category->exists ? 'Editar categoria' : 'Nova categoria')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.resources.index') }}">Recursos</a></li>
    <li class="breadcrumb-item active">{{ $category->exists ? 'Editar' : 'Nova' }}</li>
@endsection

@push('styles')
<style>
    .card-block { background:#fff; border:1px solid #e5e7eb; border-radius:10px; padding:1.5rem; margin-bottom:1.5rem; }
    .card-block h5 { font-family:'Bodoni Moda',serif; font-size:1.05rem; margin-bottom:.25rem; }
    .card-block .helper { font-size:.78rem; color:#6b7280; margin-bottom:1rem; }
    .lang-tabs .nav-link { font-size:.75rem; padding:.3rem .7rem; border-radius:6px 6px 0 0; color:#6b7280; font-weight:600; }
    .lang-tabs .nav-link.active { background:#1a1612; color:#e7c873; }
    .link-row {
        display:flex; align-items:flex-start; gap:.75rem;
        padding:.85rem 1rem; background:#fafaf6; border:1px solid #e5e7eb; border-radius:8px;
        margin-bottom:.5rem;
    }
    .link-row .drag-handle { cursor:grab; color:#d1d5db; padding-top:.3rem; }
    .link-row .info { flex:1; min-width:0; }
    .link-row .url { font-family:monospace; font-size:.78rem; color:#7e5223; word-break:break-all; }
    .link-row .title { font-family:'Bodoni Moda',serif; font-weight:500; }
    .link-row .desc { font-size:.85rem; color:#6b7280; }
    .link-row .actions { display:flex; gap:.35rem; flex-shrink:0; }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success" style="border-radius:8px;"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

{{-- =================== CATEGORY FORM =================== --}}
<form method="post" action="{{ $category->exists ? route('admin.resources.updateCategory', $category) : route('admin.resources.storeCategory') }}">
    @csrf
    @if($category->exists) @method('PUT') @endif

    <div class="card-block">
        <h5>Categoria</h5>
        <p class="helper">Cada categoria aparece como item no menu Resources do site. O slug é a parte da URL — só letras, números e hífens.</p>

        <div class="row">
            <div class="col-md-7">
                <label>Slug (URL)</label>
                <input type="text" name="slug" class="form-control mb-2" required
                       value="{{ old('slug', $category->slug) }}"
                       placeholder="ex.: classical-languages"
                       pattern="[a-z0-9-]+">
            </div>
            <div class="col-md-5">
                <label>Ícone <small class="text-muted">(FontAwesome — opcional)</small></label>
                <input type="text" name="icon" class="form-control mb-2"
                       value="{{ old('icon', $category->icon) }}"
                       placeholder="ex.: fa-scroll, fa-book, fa-language">
            </div>
        </div>

        <ul class="nav nav-tabs lang-tabs mt-3 mb-3">
            @foreach($languages as $code => $lang)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#cat-{{ $code }}">
                        {!! $lang['flag'] !!} {{ $lang['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($languages as $code => $lang)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="cat-{{ $code }}">
                    <div class="form-group">
                        <label>Título ({{ $code }})</label>
                        <input type="text" name="title[{{ $code }}]" class="form-control"
                               dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                               value="{{ old('title.' . $code, $category->title[$code] ?? '') }}"
                               placeholder="{{ $code === 'pt_BR' ? 'ex.: Línguas Clássicas' : 'ex.: Classical Languages' }}">
                    </div>
                    <div class="form-group">
                        <label>Descrição ({{ $code }})</label>
                        <textarea name="description[{{ $code }}]" class="form-control" rows="2"
                                  dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                                  placeholder="{{ $code === 'pt_BR' ? 'ex.: Dicionários de grego e hebraico, léxicos online…' : 'e.g. Greek and Hebrew dictionaries, online lexicons…' }}">{{ old('description.' . $code, $category->description[$code] ?? '') }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-check">
            <input type="checkbox" name="ativo" id="ativo" class="form-check-input" value="1"
                   {{ old('ativo', $category->ativo ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="ativo">Categoria visível no site</label>
        </div>
    </div>

    <button class="btn btn-primary" style="background:#1a1612;border-color:#1a1612;">
        <i class="fas fa-save me-1"></i>Guardar categoria
    </button>
    <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</form>

@if($category->exists)
    {{-- =================== LINKS WITHIN THIS CATEGORY =================== --}}
    <hr style="margin:2.5rem 0 1.5rem;">

    <div class="card-block">
        <h5><i class="fas fa-link me-2" style="color:#a87841;"></i>Links desta categoria</h5>
        <p class="helper">Cada link abre directamente a ferramenta externa numa nova aba. Não cria uma página intermédia.</p>

        @if($category->links->isEmpty())
            <p class="text-muted small">Ainda sem links. Adicione o primeiro no formulário abaixo.</p>
        @else
            <div id="link-list">
                @foreach($category->links as $link)
                    <div class="link-row" data-id="{{ $link->id }}">
                        <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>
                        <div class="info">
                            <div class="title">{{ $link->title['pt_BR'] ?? $link->title['en'] ?? '(sem título)' }}</div>
                            <a href="{{ $link->url }}" target="_blank" class="url">{{ $link->url }}</a>
                            @if(!empty($link->description['pt_BR']) || !empty($link->description['en']))
                                <div class="desc">{{ $link->description['pt_BR'] ?? $link->description['en'] ?? '' }}</div>
                            @endif
                        </div>
                        <div class="actions">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick='openEditLink(@json($link))'>
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="post" action="{{ route('admin.resources.destroyLink', [$category, $link]) }}"
                                  class="d-inline" onsubmit="return confirm('Remover este link?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <hr style="margin:1.5rem 0;">
        <h6 style="font-family:'Bodoni Moda',serif;"><i class="fas fa-plus me-2"></i>Adicionar link</h6>
        <form method="post" action="{{ route('admin.resources.storeLink', $category) }}">
            @csrf
            <div class="form-group">
                <label>URL</label>
                <input type="url" name="url" class="form-control" required
                       placeholder="https://www.perseus.tufts.edu/hopper/">
            </div>

            <ul class="nav nav-tabs lang-tabs mb-3">
                @foreach($languages as $code => $lang)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#newlink-{{ $code }}">
                            {!! $lang['flag'] !!} {{ $lang['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($languages as $code => $lang)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="newlink-{{ $code }}">
                        <div class="form-group">
                            <label>Título ({{ $code }})</label>
                            <input type="text" name="title[{{ $code }}]" class="form-control"
                                   dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                                   placeholder="{{ $code === 'pt_BR' ? 'ex.: Perseus Digital Library' : 'e.g. Perseus Digital Library' }}">
                        </div>
                        <div class="form-group">
                            <label>Descrição curta ({{ $code }})</label>
                            <input type="text" name="description[{{ $code }}]" class="form-control"
                                   dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                                   placeholder="{{ $code === 'pt_BR' ? 'ex.: Textos gregos e latinos com léxicos integrados' : 'e.g. Greek & Latin texts with integrated lexicons' }}">
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-primary" style="background:#1a1612;border-color:#1a1612;">
                <i class="fas fa-plus me-1"></i>Adicionar link
            </button>
        </form>
    </div>

    {{-- Edit link modal --}}
    <div class="modal fade" id="editLinkModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius:12px;">
                <form method="post" id="editLinkForm">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 style="font-family:'Bodoni Moda',serif;"><i class="fas fa-edit me-2"></i>Editar link</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input type="url" name="url" id="el_url" class="form-control" required>
                        </div>
                        <ul class="nav nav-tabs lang-tabs mb-3">
                            @foreach($languages as $code => $lang)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#el-{{ $code }}">
                                        {!! $lang['flag'] !!} {{ $lang['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach($languages as $code => $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="el-{{ $code }}">
                                    <div class="form-group">
                                        <label>Título ({{ $code }})</label>
                                        <input type="text" name="title[{{ $code }}]" id="el_title_{{ $code }}" class="form-control" dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Descrição ({{ $code }})</label>
                                        <input type="text" name="description[{{ $code }}]" id="el_desc_{{ $code }}" class="form-control" dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="ativo" id="el_ativo" class="form-check-input" value="1">
                            <label for="el_ativo" class="form-check-label">Link visível no site</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" style="background:#1a1612;border-color:#1a1612;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const LANGS = @json(array_keys($languages));

@if($category->exists)
function openEditLink(link) {
    document.getElementById('editLinkForm').action = '{{ url("admin/resources/categories/" . $category->id . "/links") }}/' + link.id;
    document.getElementById('el_url').value = link.url || '';
    document.getElementById('el_ativo').checked = !!link.ativo;
    LANGS.forEach(function(code) {
        var t = document.getElementById('el_title_' + code);
        var d = document.getElementById('el_desc_'  + code);
        if (t) t.value = (link.title && link.title[code]) || '';
        if (d) d.value = (link.description && link.description[code]) || '';
    });
    $('#editLinkModal').modal('show');
}

const llist = document.getElementById('link-list');
if (llist) {
    Sortable.create(llist, {
        handle: '.drag-handle', animation: 150,
        onEnd: function() {
            const ids = Array.from(llist.querySelectorAll('[data-id]')).map(el => el.getAttribute('data-id'));
            fetch('{{ route("admin.resources.reorderLinks", $category) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ order: ids })
            });
        }
    });
}
@endif
</script>
@endpush
