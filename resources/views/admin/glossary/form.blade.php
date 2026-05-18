@extends('layouts.adminlte')

@section('title', $term->exists ? 'Editar Verbete' : 'Novo Verbete')
@section('page-title', $term->exists ? 'Editar Verbete — ' . $term->termo : 'Novo Verbete')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.glossary.index') }}">Glossário</a></li>
    <li class="breadcrumb-item active">{{ $term->exists ? 'Editar' : 'Novo' }}</li>
@endsection

@push('styles')
<style>
    .lang-tabs .nav-link { font-size: .72rem; padding: .25rem .75rem; border-radius: 4px; color: #6b7280; }
    .lang-tabs .nav-link.active { background: #1a3a5c; color: #fff; }
    .form-section { border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
    .form-section h6 { font-weight: 700; color: #1a3a5c; margin-bottom: .25rem; font-size: .95rem; }
</style>
@endpush

@section('content')

<form method="post" action="{{ $term->exists ? route('admin.glossary.update', $term) : route('admin.glossary.store') }}" enctype="multipart/form-data">
    @csrf
    @if($term->exists) @method('PUT') @endif

    <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        <div class="card-body p-4">

            <div class="form-section">
                <h6><i class="fas fa-quote-right me-2"></i>Termo</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Termo (no script original) <span class="text-danger">*</span></label>
                        <input name="termo" type="text" class="form-control" required maxlength="180"
                               value="{{ old('termo', $term->termo) }}"
                               style="font-family: Georgia, serif; font-size: 1.3rem;"
                               placeholder="Λόγος / אֱמֶת / Veritas">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Transliteração</label>
                        <input name="transliteracao" type="text" class="form-control" maxlength="180"
                               value="{{ old('transliteracao', $term->transliteracao) }}"
                               placeholder="lógos / emet / veritas">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Língua <span class="text-danger">*</span></label>
                        <select name="lingua" class="form-control" required>
                            @foreach(['el' => 'Grego (Ἑλληνική)', 'he' => 'Hebraico (עברית)', 'la' => 'Latim', 'en' => 'Inglês', 'es' => 'Espanhol', 'pt' => 'Português'] as $code => $label)
                                <option value="{{ $code }}" {{ old('lingua', $term->lingua) === $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Categoria</label>
                        <input name="categoria" type="text" class="form-control" maxlength="100"
                               value="{{ old('categoria', $term->categoria) }}" placeholder="Filosofia, Bíblico...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Slug <small>(URL: /glossary/slug)</small></label>
                        <input name="slug" type="text" class="form-control" value="{{ old('slug', $term->slug) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ordem</label>
                        <input name="ordem" type="number" class="form-control" value="{{ old('ordem', $term->ordem) }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <label class="d-flex align-items-center gap-2 p-2 border rounded w-100" style="cursor:pointer;">
                            <input type="checkbox" name="ativo" value="1" {{ old('ativo', $term->ativo) ? 'checked' : '' }}> Activo
                        </label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="d-flex align-items-center gap-2 p-2 border rounded" style="cursor:pointer;">
                        <input type="checkbox" name="destaque" value="1" {{ old('destaque', $term->destaque) ? 'checked' : '' }}>
                        <strong>Verbete em destaque</strong>
                        <small class="text-muted">(aparece na grade dourada na página inicial e no topo do glossário)</small>
                    </label>
                </div>
            </div>

            <div class="form-section">
                <h6><i class="fas fa-image me-2"></i>Imagem</h6>
                <input name="imagem" type="file" class="form-control" accept="image/*">
                @if($term->imagemUrl())
                    <img src="{{ $term->imagemUrl() }}" style="margin-top:.5rem; max-height:100px; border-radius:6px;">
                @endif
                <small class="text-muted d-block mt-1">Usada como fundo do cartão em destaque e no topo da página do verbete.</small>
            </div>

            {{-- Conteúdo Traduzível --}}
            <div class="form-section">
                <h6><i class="fas fa-language me-2"></i>Conteúdo (multilíngue)</h6>

                @php
                    $fields = [
                        ['key' => 'significado',      'label' => 'Significado (resumo curto)',  'type' => 'textarea', 'rows' => 3, 'required' => true],
                        ['key' => 'descricao',        'label' => 'Descrição completa (separe parágrafos com linha em branco)', 'type' => 'textarea', 'rows' => 8],
                        ['key' => 'etimologia',       'label' => 'Etimologia',                  'type' => 'textarea', 'rows' => 2],
                        ['key' => 'exemplo_uso',      'label' => 'Exemplo de uso',              'type' => 'textarea', 'rows' => 2],
                        ['key' => 'citacao_classica', 'label' => 'Citação clássica',            'type' => 'textarea', 'rows' => 2],
                        ['key' => 'citacao_autor',    'label' => 'Autor da citação',            'type' => 'input'],
                    ];
                @endphp

                @foreach($fields as $f)
                    <div class="mb-4">
                        <label class="form-label">
                            {{ $f['label'] }}
                            @if(!empty($f['required'])) <span class="text-danger">*</span> @endif
                        </label>
                        <ul class="nav lang-tabs mb-2" data-field="{{ $f['key'] }}">
                            @foreach($locales as $i => $loc)
                                <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                            @endforeach
                        </ul>
                        @foreach($locales as $i => $loc)
                            <div class="lang-pane" data-field="{{ $f['key'] }}" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                                @if($f['type'] === 'input')
                                    <input name="{{ $f['key'] }}[{{ $loc }}]" type="text" class="form-control"
                                           value="{{ old($f['key'] . '.' . $loc, $term->{$f['key']}[$loc] ?? '') }}">
                                @else
                                    <textarea name="{{ $f['key'] }}[{{ $loc }}]" class="form-control" rows="{{ $f['rows'] ?? 3 }}">{{ old($f['key'] . '.' . $loc, $term->{$f['key']}[$loc] ?? '') }}</textarea>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between" style="background:#fafafa; border-radius: 0 0 12px 12px;">
            <a href="{{ route('admin.glossary.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
            <button class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Guardar Verbete</button>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.lang-tabs').forEach(function(tabs) {
        const field = tabs.dataset.field;
        tabs.querySelectorAll('.nav-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const lang = this.dataset.lang;
                tabs.querySelectorAll('.nav-link').forEach(x => x.classList.remove('active'));
                this.classList.add('active');
                document.querySelectorAll('.lang-pane[data-field="' + field + '"]').forEach(function(p) {
                    p.style.display = p.dataset.lang === lang ? '' : 'none';
                });
            });
        });
    });
</script>
@endpush
