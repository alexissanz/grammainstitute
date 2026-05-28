@extends('layouts.adminlte')

@section('title', 'Página Sobre')
@section('page-title', 'Sobre · About Us')

@section('breadcrumb')
    <li class="breadcrumb-item active">Sobre</li>
@endsection

@push('styles')
<style>
    .about-card { border:1px solid #e5e7eb; border-radius:10px; background:#fff; padding:1.5rem; margin-bottom:1.5rem; }
    .about-card h5 {
        font-family:'Bodoni Moda',serif; font-size:1.1rem; font-weight:600;
        color:#1a1612; margin:0 0 .25rem 0;
    }
    .about-card .helper { font-size:.78rem; color:#6b7280; margin-bottom:1rem; }
    .lang-tabs .nav-link {
        font-size:.78rem; padding:.35rem .75rem; border-radius:6px 6px 0 0;
        color:#6b7280; font-family:'Inter',sans-serif; font-weight:600;
    }
    .lang-tabs .nav-link.active { background:#1a1612; color:#e7c873; }
    .pane-label { font-size:.78rem; color:#6b7280; margin-bottom:.25rem; font-family:'Inter',sans-serif; font-weight:600; }
    textarea.about-area { min-height:140px; resize:vertical; }
    .expertise-row { display:flex; gap:.5rem; align-items:center; margin-bottom:.35rem; }
    .expertise-row .form-control { flex:1; }
    .expertise-row .btn-remove {
        background:transparent; border:1px solid #e5e7eb; color:#b91c1c;
        width:34px; height:34px; border-radius:6px; flex-shrink:0;
    }
    .expertise-row .btn-remove:hover { background:#fee2e2; border-color:#b91c1c; }
    .expertise-lang-chip {
        font-size:.65rem; padding:.1rem .4rem; border-radius:4px;
        background:#f3f4f6; color:#6b7280; margin-right:.35rem;
        font-family:'Inter',sans-serif; letter-spacing:.05em;
    }
    .save-bar {
        position: sticky; bottom: 0;
        background: #fff; border-top: 1px solid #e5e7eb;
        padding: 1rem; margin: 1.5rem -1rem -1rem; z-index: 10;
        display: flex; justify-content: flex-end; gap: .75rem;
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success" style="border-radius:8px;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

<form method="post" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- ============================ OPENING QUOTE ============================ --}}
    <div class="about-card">
        <h5><i class="fas fa-quote-left me-2" style="color:#a87841;"></i>Citação de abertura</h5>
        <p class="helper">A frase em destaque no topo da página Sobre, com autor.</p>

        @include('admin.about._lang_tabs', ['name' => 'quote'])
        <div class="tab-content">
            @foreach($languages as $code => $lang)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="quote-{{ $code }}">
                    <label class="pane-label">Citação ({{ $code }})</label>
                    <textarea name="quote_text[{{ $code }}]" class="form-control about-area"
                              dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}">{{ $about->quote_text[$code] ?? '' }}</textarea>
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            <label class="pane-label">Autor da citação (mesmo para todos os idiomas)</label>
            <input type="text" name="quote_author" class="form-control" value="{{ $about->quote_author }}">
        </div>
    </div>

    {{-- ============================ FOUNDER (Who Is) ============================ --}}
    <div class="about-card">
        <h5><i class="fas fa-user me-2" style="color:#a87841;"></i>Quem é Alvaro Cunha?</h5>
        <p class="helper">Bio do fundador. Use parágrafos separados por linha em branco.</p>

        {{-- Portrait / foto --}}
        <div class="d-flex align-items-center mb-3" style="gap:1rem; flex-wrap:wrap;">
            <div style="width:96px; height:96px; border-radius:12px; overflow:hidden; background:#f3f4f6; border:1px solid #e5e7eb; flex-shrink:0;">
                @if($about->foto)
                    <img src="{{ $about->fotoUrl() }}" alt="Foto" style="width:100%; height:100%; object-fit:cover; filter:grayscale(100%);">
                @else
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#9ca3af;"><i class="fas fa-user fa-2x"></i></div>
                @endif
            </div>
            <div>
                <label class="pane-label">Foto (retrato de Alvaro Cunha)</label>
                <input type="file" name="foto" accept="image/png,image/jpeg,image/webp" class="form-control">
                <small class="text-muted">JPG/PNG/WebP, máx. 6MB. É exibida em "Who is" (a preto e branco).</small>
            </div>
        </div>

        @include('admin.about._lang_tabs', ['name' => 'founder'])
        <div class="tab-content">
            @foreach($languages as $code => $lang)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="founder-{{ $code }}">
                    <label class="pane-label">Título ({{ $code }})</label>
                    <input type="text" name="founder_title[{{ $code }}]" class="form-control mb-2"
                           dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                           value="{{ $about->founder_title[$code] ?? '' }}">
                    <label class="pane-label">Texto ({{ $code }})</label>
                    <textarea name="founder_text[{{ $code }}]" class="form-control about-area"
                              dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}">{{ $about->founder_text[$code] ?? '' }}</textarea>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============================ INSTITUTE ============================ --}}
    <div class="about-card">
        <h5><i class="fas fa-landmark me-2" style="color:#a87841;"></i>The Gramma Institute of Linguistics</h5>
        <p class="helper">História e descrição do instituto.</p>

        @include('admin.about._lang_tabs', ['name' => 'institute'])
        <div class="tab-content">
            @foreach($languages as $code => $lang)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="institute-{{ $code }}">
                    <label class="pane-label">Título ({{ $code }})</label>
                    <input type="text" name="institute_title[{{ $code }}]" class="form-control mb-2"
                           dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                           value="{{ $about->institute_title[$code] ?? '' }}">
                    <label class="pane-label">Texto ({{ $code }})</label>
                    <textarea name="institute_text[{{ $code }}]" class="form-control about-area"
                              dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}">{{ $about->institute_text[$code] ?? '' }}</textarea>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============================ MISSION ============================ --}}
    <div class="about-card">
        <h5><i class="fas fa-compass me-2" style="color:#a87841;"></i>Missão</h5>

        @include('admin.about._lang_tabs', ['name' => 'mission'])
        <div class="tab-content">
            @foreach($languages as $code => $lang)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="mission-{{ $code }}">
                    <label class="pane-label">Título ({{ $code }})</label>
                    <input type="text" name="mission_title[{{ $code }}]" class="form-control mb-2"
                           dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                           value="{{ $about->mission_title[$code] ?? '' }}">
                    <label class="pane-label">Texto ({{ $code }})</label>
                    <textarea name="mission_text[{{ $code }}]" class="form-control about-area"
                              dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}">{{ $about->mission_text[$code] ?? '' }}</textarea>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============================ EXPERTISE LIST ============================ --}}
    <div class="about-card">
        <h5><i class="fas fa-scroll me-2" style="color:#a87841;"></i>Áreas de Especialidade</h5>
        <p class="helper">Lista de áreas — uma por linha. Use os botões para adicionar ou remover.</p>

        @include('admin.about._lang_tabs', ['name' => 'expertise'])
        <div class="tab-content">
            @foreach($languages as $code => $lang)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="expertise-{{ $code }}">
                    <label class="pane-label">Título da secção ({{ $code }})</label>
                    <input type="text" name="expertise_title[{{ $code }}]" class="form-control mb-2"
                           dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                           value="{{ $about->expertise_title[$code] ?? '' }}">
                </div>
            @endforeach
        </div>

        <hr>
        <label class="pane-label mb-2">Itens (cada linha é uma área — preencha em pelo menos um idioma)</label>
        <div id="expertise-list">
            @php
                $items = $about->expertise_items ?? [];
                if (empty($items)) $items = [array_fill_keys(array_keys($languages), '')];
            @endphp
            @foreach($items as $i => $item)
                <div class="expertise-row" data-row>
                    @foreach($languages as $code => $lang)
                        <input type="text" class="form-control"
                               name="expertise_items[{{ $i }}][{{ $code }}]"
                               placeholder="{{ $code }}"
                               dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                               value="{{ $item[$code] ?? '' }}">
                    @endforeach
                    <button type="button" class="btn-remove" onclick="this.closest('[data-row]').remove()"
                            title="Remover esta linha">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addExpertiseRow()">
            <i class="fas fa-plus me-1"></i>Adicionar área
        </button>
    </div>

    {{-- ============================ CLOSING ============================ --}}
    <div class="about-card">
        <h5><i class="fas fa-feather me-2" style="color:#a87841;"></i>Encerramento</h5>

        @include('admin.about._lang_tabs', ['name' => 'closing'])
        <div class="tab-content">
            @foreach($languages as $code => $lang)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="closing-{{ $code }}">
                    <label class="pane-label">Título ({{ $code }})</label>
                    <input type="text" name="closing_title[{{ $code }}]" class="form-control mb-2"
                           dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}"
                           value="{{ $about->closing_title[$code] ?? '' }}">
                    <label class="pane-label">Texto ({{ $code }})</label>
                    <textarea name="closing_text[{{ $code }}]" class="form-control about-area"
                              dir="{{ $code === 'he' ? 'rtl' : 'ltr' }}">{{ $about->closing_text[$code] ?? '' }}</textarea>
                </div>
            @endforeach
        </div>
    </div>

    <div class="save-bar">
        <a href="{{ route('home') }}/about" target="_blank" class="btn btn-outline-secondary">
            <i class="fas fa-external-link-alt me-1"></i>Ver no site
        </a>
        <button type="submit" class="btn btn-primary" style="background:#1a1612;border-color:#1a1612;">
            <i class="fas fa-save me-1"></i>Guardar alterações
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
const LANGS = @json(array_keys($languages));

function addExpertiseRow() {
    const list = document.getElementById('expertise-list');
    const idx  = list.querySelectorAll('[data-row]').length;
    const row  = document.createElement('div');
    row.className = 'expertise-row';
    row.setAttribute('data-row', '');
    let html = '';
    LANGS.forEach(function (code) {
        html += '<input type="text" class="form-control" '
              + 'name="expertise_items[' + idx + '][' + code + ']" '
              + 'placeholder="' + code + '" '
              + 'dir="' + (code === 'he' ? 'rtl' : 'ltr') + '">';
    });
    html += '<button type="button" class="btn-remove" '
          + 'onclick="this.closest(\'[data-row]\').remove()"><i class="fas fa-times"></i></button>';
    row.innerHTML = html;
    list.appendChild(row);
}
</script>
@endpush
