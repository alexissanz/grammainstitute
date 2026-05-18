@extends('layouts.adminlte')

@section('title', 'Hero Slides')
@section('page-title', 'Gerir Hero Slides')

@section('breadcrumb')
    <li class="breadcrumb-item active">Hero Slides</li>
@endsection

@push('styles')
<style>
    .slide-item { border-radius:10px; border:1px solid #e5e7eb; transition:box-shadow .2s, border-color .2s; }
    .slide-item:hover { box-shadow:0 4px 16px rgba(0,0,0,0.09); border-color:#c7d7f5; }
    .slide-thumb { width:100px; height:62px; object-fit:cover; border-radius:6px; flex-shrink:0; }
    .slide-thumb-placeholder { width:100px; height:62px; border-radius:6px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .drag-handle { cursor:grab; color:#d1d5db; font-size:1.1rem; flex-shrink:0; }
    .drag-handle:active { cursor:grabbing; }
    .lang-tabs-mini .nav-link { font-size:.75rem; padding:.25rem .6rem; border-radius:4px; color:#6b7280; }
    .lang-tabs-mini .nav-link.active { background:#1a3a5c; color:#fff; }
    .lang-tabs-mini .nav-item + .nav-item { margin-left:.25rem; }
    .slide-active-badge { font-size:.72rem; padding:.2rem .65rem; border-radius:20px; font-weight:600; }
    /* SortableJS ghost */
    .sortable-ghost { opacity: .4; background: #eef3ff; }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div>
        <p class="text-muted mb-0" style="font-size:.875rem;">
            Cada slide aparece no carrossel da página inicial quando o hero está em modo <strong>Slides</strong>.
            <a href="{{ route('admin.settings.edit') }}#tab-hero" style="color:#2d6a9f;">Mudar tipo de Hero →</a>
        </p>
    </div>
    <button class="btn btn-primary" data-toggle="modal" data-target="#slideModal" onclick="openAddModal()" style="border-radius:8px;">
        <i class="fas fa-plus me-2"></i>Adicionar Slide
    </button>
</div>

@if($slides->isEmpty())
<div class="card text-center py-5" style="border-radius:12px; border:2px dashed #e5e7eb;">
    <div style="font-size:3rem; color:#d1d5db; margin-bottom:1rem;"><i class="fas fa-images"></i></div>
    <h6 class="text-muted">Nenhum slide criado ainda</h6>
    <p class="text-muted small">Clique em "Adicionar Slide" para começar.</p>
</div>
@else
<div id="slides-list">
    @foreach($slides as $slide)
    <div class="slide-item card mb-2" data-id="{{ $slide->id }}">
        <div class="card-body d-flex align-items-center gap-3 flex-wrap">
            <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>

            @if($slide->imagem)
                <img src="{{ Storage::url($slide->imagem) }}" class="slide-thumb" alt="">
            @else
                <div class="slide-thumb-placeholder"><i class="fas fa-image text-muted"></i></div>
            @endif

            <div class="flex-grow-1 min-width-0">
                <div class="fw-bold" style="font-size:.9rem; color:#1a3a5c;">
                    {{ $slide->titulo['pt_BR'] ?? 'Sem título (PT-BR)' }}
                </div>
                <div class="text-muted" style="font-size:.8rem;">
                    {{ $slide->subtitulo['pt_BR'] ?? '' }}
                </div>
                <div class="mt-1 d-flex gap-1 flex-wrap">
                    @foreach(['pt_BR', 'en', 'es', 'he', 'el'] as $loc)
                        @if(!empty($slide->titulo[$loc]))
                        <span style="background:#f3f4f6; border-radius:4px; padding:.1rem .4rem; font-size:.68rem; color:#6b7280;">{{ $loc }}</span>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                <span class="slide-active-badge" style="background: {{ $slide->ativo ? '#dcfce7; color:#16a34a;' : '#f3f4f6; color:#6b7280;' }}">
                    {{ $slide->ativo ? 'Ativo' : 'Inativo' }}
                </span>
                <button class="btn btn-sm btn-outline-primary" onclick='openEditModal({{ json_encode($slide) }})' style="border-radius:6px;">
                    <i class="fas fa-edit"></i>
                </button>
                <form method="post" action="{{ route('admin.hero-slides.destroy', $slide) }}" class="d-inline"
                      onsubmit="return confirm('Remover este slide?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" style="border-radius:6px;"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<p class="text-muted small mt-2"><i class="fas fa-arrows-alt me-1"></i>Arraste para reordenar os slides.</p>
@endif

{{-- Slide Modal (Add/Edit) --}}
<div class="modal fade" id="slideModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:12px;">
            <form method="post" id="slideForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="slideFormMethod" name="_method" value="POST">
                <div class="modal-header" style="border-bottom:2px solid #1a3a5c;">
                    <h5 class="modal-title fw-bold" style="color:#1a3a5c;" id="slideModalTitle">
                        <i class="fas fa-image me-2"></i>Adicionar Slide
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{-- Image --}}
                    <div class="form-group">
                        <label class="font-weight-bold" style="font-size:.875rem;">Imagem do Slide <small class="text-muted">(JPG/PNG/WebP, máx. 5MB)</small></label>
                        <input type="file" name="imagem" id="slideImagem" class="form-control-file" accept="image/*">
                        <div id="slideImgPreview" class="mt-2"></div>
                    </div>

                    <hr>

                    {{-- Language tabs for titulo/subtitulo --}}
                    <label class="font-weight-bold" style="font-size:.875rem;">Título e Subtítulo por Idioma</label>
                    <ul class="nav nav-tabs lang-tabs-mini mt-2 mb-3" id="slideLangTabs">
                        @foreach(['pt_BR' => '🇧🇷 PT-BR *', 'en' => '🇬🇧 EN', 'es' => '🇪🇸 ES', 'he' => '🇮🇱 HE', 'el' => '🇬🇷 EL'] as $code => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#slang-{{ $code }}">{{ $label }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach(['pt_BR' => 'ltr', 'en' => 'ltr', 'es' => 'ltr', 'he' => 'rtl', 'el' => 'ltr'] as $code => $dir)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="slang-{{ $code }}">
                            <div class="form-group">
                                <label style="font-size:.82rem; color:#6b7280;">Título ({{ $code }})</label>
                                <input type="text" name="titulo[{{ $code }}]" id="titulo_{{ $code }}"
                                       class="form-control form-control-sm" dir="{{ $dir }}"
                                       placeholder="{{ $code === 'pt_BR' ? 'Obrigatório' : 'Opcional — preenche automaticamente com PT-BR se vazio' }}">
                            </div>
                            <div class="form-group">
                                <label style="font-size:.82rem; color:#6b7280;">Subtítulo ({{ $code }})</label>
                                <textarea name="subtitulo[{{ $code }}]" id="subtitulo_{{ $code }}"
                                          class="form-control form-control-sm" dir="{{ $dir }}" rows="2"
                                          placeholder="Opcional"></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Active toggle --}}
                    <div class="form-check mt-2">
                        <input type="checkbox" name="ativo" id="slideAtivo" class="form-check-input" value="1" checked>
                        <label class="form-check-label" for="slideAtivo" style="font-size:.875rem;">Slide ativo (visível no site)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="slideSubmitBtn">
                        <i class="fas fa-save me-1"></i>Guardar Slide
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// SortableJS for drag-and-drop
const list = document.getElementById('slides-list');
if (list) {
    Sortable.create(list, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: function() {
            const ids = Array.from(list.querySelectorAll('[data-id]')).map(el => el.getAttribute('data-id'));
            fetch('{{ route("admin.hero-slides.reorder") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ order: ids })
            });
        }
    });
}

function openAddModal() {
    document.getElementById('slideModalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Adicionar Slide';
    document.getElementById('slideForm').action = '{{ route("admin.hero-slides.store") }}';
    document.getElementById('slideFormMethod').value = 'POST';
    document.getElementById('slideForm').reset();
    document.getElementById('slideImgPreview').innerHTML = '';
    ['pt_BR','en','es','he','el'].forEach(function(loc) {
        var t = document.getElementById('titulo_' + loc);
        var s = document.getElementById('subtitulo_' + loc);
        if (t) t.value = '';
        if (s) s.value = '';
    });
    document.getElementById('slideAtivo').checked = true;
}

function openEditModal(slide) {
    document.getElementById('slideModalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Editar Slide';
    document.getElementById('slideForm').action = '{{ url("admin/hero-slides") }}/' + slide.id;
    document.getElementById('slideFormMethod').value = 'POST';

    // Populate fields
    var titulo = slide.titulo || {};
    var subtitulo = slide.subtitulo || {};
    ['pt_BR','en','es','he','el'].forEach(function(loc) {
        var t = document.getElementById('titulo_' + loc);
        var s = document.getElementById('subtitulo_' + loc);
        if (t) t.value = titulo[loc] || '';
        if (s) s.value = subtitulo[loc] || '';
    });

    document.getElementById('slideAtivo').checked = !!slide.ativo;

    // Show current image
    var preview = document.getElementById('slideImgPreview');
    if (slide.imagem) {
        preview.innerHTML = '<img src="/storage/' + slide.imagem + '" style="max-height:80px;border-radius:6px;border:1px solid #e5e7eb;" alt="">';
    } else {
        preview.innerHTML = '';
    }

    $('#slideModal').modal('show');
}

// Image preview on file select
document.getElementById('slideImagem').addEventListener('change', function(e) {
    var file = e.target.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('slideImgPreview').innerHTML =
            '<img src="' + ev.target.result + '" style="max-height:80px;border-radius:6px;border:1px solid #e5e7eb;margin-top:.5rem;" alt="">';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
