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
    .slide-thumb { width:120px; height:74px; object-fit:cover; border-radius:6px; flex-shrink:0; background:#000; }
    .slide-thumb-placeholder { width:120px; height:74px; border-radius:6px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#9ca3af; font-size:1.4rem; }
    .drag-handle { cursor:grab; color:#d1d5db; font-size:1.1rem; flex-shrink:0; }
    .drag-handle:active { cursor:grabbing; }
    .slide-active-badge { font-size:.72rem; padding:.2rem .65rem; border-radius:20px; font-weight:600; }
    .tipo-badge { font-size:.7rem; padding:.18rem .55rem; border-radius:20px; font-weight:600; background:#eef2ff; color:#4338ca; }
    .tipo-badge.is-video { background:#fef3c7; color:#92400e; }
    .sortable-ghost { opacity: .4; background: #eef3ff; }

    /* Media-type pickers in modal */
    .media-type-toggle { display:flex; gap:.5rem; margin-bottom:1rem; }
    .media-type-toggle .opt {
        flex:1; cursor:pointer; border:2px solid #e5e7eb; border-radius:8px;
        padding:.85rem .75rem; text-align:center; transition:all .15s;
        background:#fff;
    }
    .media-type-toggle .opt.active { border-color:#1a3a5c; background:#eef3fb; color:#1a3a5c; }
    .media-type-toggle .opt i { font-size:1.2rem; display:block; margin-bottom:.25rem; }
    .media-type-toggle .opt input { display:none; }

    .media-pane { display:none; }
    .media-pane.show { display:block; }
</style>
@endpush

@section('content')

<div class="alert mb-3" style="background:#eef3ff; border:1px solid #c7d7f5; border-radius:10px; color:#1a3a5c; font-size:.875rem;">
    <i class="fas fa-info-circle me-1"></i>
    Para que estes slides apareçam no site, vá às
    <a href="{{ route('admin.settings.edit') }}#tab-hero" style="color:#1a3a5c; text-decoration:underline; font-weight:600;">Configurações &rsaquo; Hero</a>
    e selecione <strong>"Carrossel de Slides"</strong>.
    Vídeos são <strong>silenciados automaticamente</strong>. O texto exibido no site segue a <strong>língua ativa</strong>.
</div>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div>
        <p class="text-muted mb-0" style="font-size:.875rem;">
            Cada slide aparece no carrossel da página inicial. Pode usar <strong>imagem</strong> ou <strong>vídeo</strong>.
            Arraste o handle <i class="fas fa-grip-vertical"></i> para reordenar.
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

            @if($slide->isVideo())
                <video class="slide-thumb" muted playsinline preload="metadata"
                       @if($slide->poster) poster="{{ url('media/' . $slide->poster) }}" @endif>
                    <source src="{{ url('media/' . $slide->video) }}">
                </video>
            @elseif($slide->imagem)
                <img src="{{ url('media/' . $slide->imagem) }}" class="slide-thumb" alt="">
            @else
                <div class="slide-thumb-placeholder"><i class="fas fa-image"></i></div>
            @endif

            <div class="flex-grow-1 min-width-0">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="tipo-badge {{ $slide->isVideo() ? 'is-video' : '' }}">
                        <i class="fas fa-{{ $slide->isVideo() ? 'film' : 'image' }} me-1"></i>{{ $slide->isVideo() ? 'Vídeo' : 'Imagem' }}
                    </span>
                </div>
                <div class="fw-bold" style="font-size:.92rem; color:#1a3a5c;">
                    {{ $slide->getTitulo() ?: 'Sem título' }}
                </div>
                <div class="text-muted" style="font-size:.82rem;">
                    {{ $slide->getSubtitulo() }}
                </div>
                <div class="mt-1 d-flex gap-1 flex-wrap">
                    @foreach(['pt_BR', 'en', 'es', 'he', 'el', 'la'] as $loc)
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
                <button class="btn btn-sm btn-outline-primary" onclick='openEditModal(@json($slide))' style="border-radius:6px;">
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
                    {{-- Media type picker --}}
                    <label class="font-weight-bold" style="font-size:.875rem;">Tipo de mídia</label>
                    <div class="media-type-toggle">
                        <label class="opt active" data-tipo="imagem">
                            <input type="radio" name="tipo" value="imagem" checked>
                            <i class="fas fa-image"></i>
                            Imagem
                        </label>
                        <label class="opt" data-tipo="video">
                            <input type="radio" name="tipo" value="video">
                            <i class="fas fa-film"></i>
                            Vídeo
                        </label>
                    </div>

                    {{-- Image pane --}}
                    <div class="media-pane show" data-pane="imagem">
                        <div class="form-group">
                            <label class="font-weight-bold" style="font-size:.85rem;">Imagem <small class="text-muted">(JPG/PNG/WebP — recomendado 1920×1080, máx. 5MB)</small></label>
                            <input type="file" name="imagem" id="slideImagem" class="form-control-file" accept="image/*">
                            <div id="slideImgPreview" class="mt-2"></div>
                        </div>
                    </div>

                    {{-- Video pane --}}
                    <div class="media-pane" data-pane="video">
                        <div class="form-group">
                            <label class="font-weight-bold" style="font-size:.85rem;">Vídeo <small class="text-muted">(MP4/WebM, máx. 50MB)</small></label>
                            <input type="file" name="video" id="slideVideo" class="form-control-file" accept="video/mp4,video/webm,video/quicktime">
                            <div id="slideVideoPreview" class="mt-2"></div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" style="font-size:.85rem;">Poster (imagem do vídeo)
                                <small class="text-muted">opcional — aparece enquanto o vídeo carrega</small></label>
                            <input type="file" name="poster" id="slidePoster" class="form-control-file" accept="image/*">
                            <div id="slidePosterPreview" class="mt-2"></div>
                        </div>
                    </div>

                    <hr>

                    @php $heroLangs = ['en' => 'English', 'pt_BR' => 'Português', 'es' => 'Español']; @endphp

                    <label class="font-weight-bold" style="font-size:.875rem;">
                        Título e Subtítulo por idioma <small class="text-muted">(opcional — deixe vazio para slide só com mídia)</small>
                    </label>
                    <div class="mb-2" style="font-size:.8rem; color:#6b7280;">
                        Preencha cada idioma. O site mostra o texto da língua ativa do visitante. (Idioma padrão: <strong>English</strong>.)
                    </div>
                    @foreach($heroLangs as $code => $label)
                        <div class="border rounded p-2 mb-2" style="background:#fafbfc;">
                            <div style="font-size:.72rem; font-weight:700; color:#1a3a5c; letter-spacing:.04em; margin-bottom:.35rem;">{{ $label }} <span class="text-muted">({{ $code }})</span></div>
                            <input type="text" name="titulo[{{ $code }}]" data-hero-titulo="{{ $code }}"
                                   class="form-control form-control-sm mb-1"
                                   placeholder="Título ({{ $code }})">
                            <textarea name="subtitulo[{{ $code }}]" data-hero-subtitulo="{{ $code }}"
                                      class="form-control form-control-sm" rows="2"
                                      placeholder="Descrição ({{ $code }})"></textarea>
                        </div>
                    @endforeach

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

// Tipo (imagem/video) toggle
document.querySelectorAll('.media-type-toggle .opt').forEach(function(opt) {
    opt.addEventListener('click', function() {
        var tipo = opt.getAttribute('data-tipo');
        document.querySelectorAll('.media-type-toggle .opt').forEach(function(o){ o.classList.remove('active'); });
        opt.classList.add('active');
        opt.querySelector('input').checked = true;
        document.querySelectorAll('.media-pane').forEach(function(p){ p.classList.toggle('show', p.getAttribute('data-pane') === tipo); });
    });
});

function setTipo(tipo) {
    var opt = document.querySelector('.media-type-toggle .opt[data-tipo="' + tipo + '"]');
    if (opt) opt.click();
    else document.querySelector('.media-type-toggle .opt[data-tipo="imagem"]').click();
}

function clearMediaPreviews() {
    ['slideImgPreview','slideVideoPreview','slidePosterPreview'].forEach(function(id){
        var el = document.getElementById(id); if (el) el.innerHTML = '';
    });
}

function openAddModal() {
    document.getElementById('slideModalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Adicionar Slide';
    document.getElementById('slideForm').action = '{{ route("admin.hero-slides.store") }}';
    document.getElementById('slideFormMethod').value = 'POST';
    document.getElementById('slideForm').reset();
    clearMediaPreviews();
    document.querySelectorAll('[data-hero-titulo],[data-hero-subtitulo]').forEach(function(el){ el.value = ''; });
    document.getElementById('slideAtivo').checked = true;
    setTipo('imagem');
}

function openEditModal(slide) {
    document.getElementById('slideModalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Editar Slide';
    document.getElementById('slideForm').action = '{{ url("admin/hero-slides") }}/' + slide.id;
    document.getElementById('slideFormMethod').value = 'POST';

    var titulo = slide.titulo || {};
    var subtitulo = slide.subtitulo || {};
    document.querySelectorAll('[data-hero-titulo]').forEach(function(el){
        el.value = titulo[el.getAttribute('data-hero-titulo')] || '';
    });
    document.querySelectorAll('[data-hero-subtitulo]').forEach(function(el){
        el.value = subtitulo[el.getAttribute('data-hero-subtitulo')] || '';
    });

    document.getElementById('slideAtivo').checked = !!slide.ativo;

    clearMediaPreviews();

    if (slide.imagem) {
        document.getElementById('slideImgPreview').innerHTML =
            '<img src="/storage/' + slide.imagem + '" style="max-height:120px;border-radius:6px;border:1px solid #e5e7eb;" alt="">';
    }
    if (slide.video) {
        document.getElementById('slideVideoPreview').innerHTML =
            '<video src="/storage/' + slide.video + '" controls muted style="max-height:150px;border-radius:6px;border:1px solid #e5e7eb;background:#000;"></video>';
    }
    if (slide.poster) {
        document.getElementById('slidePosterPreview').innerHTML =
            '<img src="/storage/' + slide.poster + '" style="max-height:90px;border-radius:6px;border:1px solid #e5e7eb;" alt="">';
    }

    setTipo(slide.tipo === 'video' ? 'video' : 'imagem');

    $('#slideModal').modal('show');
}

// Live previews
document.getElementById('slideImagem').addEventListener('change', function(e) {
    var f = e.target.files[0]; if (!f) return;
    var r = new FileReader();
    r.onload = function(ev) {
        document.getElementById('slideImgPreview').innerHTML =
            '<img src="' + ev.target.result + '" style="max-height:120px;border-radius:6px;border:1px solid #e5e7eb;margin-top:.5rem;" alt="">';
    };
    r.readAsDataURL(f);
});

document.getElementById('slideVideo').addEventListener('change', function(e) {
    var f = e.target.files[0]; if (!f) return;
    var url = URL.createObjectURL(f);
    document.getElementById('slideVideoPreview').innerHTML =
        '<video src="' + url + '" controls muted style="max-height:150px;border-radius:6px;border:1px solid #e5e7eb;background:#000;margin-top:.5rem;"></video>';
});

document.getElementById('slidePoster').addEventListener('change', function(e) {
    var f = e.target.files[0]; if (!f) return;
    var r = new FileReader();
    r.onload = function(ev) {
        document.getElementById('slidePosterPreview').innerHTML =
            '<img src="' + ev.target.result + '" style="max-height:90px;border-radius:6px;border:1px solid #e5e7eb;margin-top:.5rem;" alt="">';
    };
    r.readAsDataURL(f);
});
</script>
@endpush
