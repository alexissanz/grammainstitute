@extends('layouts.adminlte')

@section('title', $term->exists ? 'Edit Glossary Letter' : 'New Glossary Letter')
@section('page-title', $term->exists ? 'Editar Letra — ' . $term->termo : 'Nova Letra do Glossário')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.glossary.index') }}">Glossário</a></li>
    <li class="breadcrumb-item active">{{ $term->exists ? 'Editar letra' : 'Nova letra' }}</li>
@endsection

@push('styles')
<style>
    .lang-tabs .nav-link { font-size: .72rem; padding: .25rem .75rem; border-radius: 4px; color: #6b7280; }
    .lang-tabs .nav-link.active { background: #1a3a5c; color: #fff; }
    .form-section { border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
    .form-section h6 { font-weight: 700; color: #1a3a5c; margin-bottom: .25rem; font-size: .95rem; }
    .form-help { color: #6b7280; font-size: .82rem; margin-bottom: 1rem; }
</style>
@endpush

@section('content')

<form method="post" action="{{ $term->exists ? route('admin.glossary.update', $term) : route('admin.glossary.store') }}" enctype="multipart/form-data">
    @csrf
    @if($term->exists) @method('PUT') @endif

    <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        <div class="card-body p-4">
            <div class="form-section">
                <h6><i class="fas fa-font me-2"></i>Letter block</h6>
                <p class="form-help">Escolha a letra e escreva o conteúdo completo desse bloco. No site, o visitante clica na letra e o conteúdo aparece com animação suave.</p>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Letter</label>
                        <select name="letra" class="form-control">
                            @foreach($letters as $letter)
                                <option value="{{ $letter }}" {{ old('letra', $term->letra ?: $term->termo) === $letter ? 'selected' : '' }}>{{ $letter }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Heading</label>
                        <input name="termo" type="text" class="form-control" value="{{ old('termo', $term->termo) }}" placeholder="A">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Order</label>
                        <input name="ordem" type="number" class="form-control" value="{{ old('ordem', $term->ordem) }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <label class="d-flex align-items-center gap-2 p-2 border rounded w-100" style="cursor:pointer;">
                            <input type="checkbox" name="ativo" value="1" {{ old('ativo', $term->ativo) ? 'checked' : '' }}> Active
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h6><i class="fas fa-image me-2"></i>Optional image</h6>
                <input name="imagem" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif,.bmp,.avif,.heic,.heif,.jfif,image/*">
                @if($term->imagemUrl())
                    <img src="{{ $term->imagemUrl() }}" style="margin-top:.5rem; max-height:100px; border-radius:6px;">
                @endif
            </div>

            <div class="form-section">
                <h6><i class="fas fa-language me-2"></i>Content</h6>
                <p class="form-help">Para cada item: primeira linha é o termo, linhas abaixo são a descrição. Deixe uma linha em branco antes do próximo termo.</p>

                @php
                    $fields = [
                        ['key' => 'significado', 'label' => 'Short intro', 'rows' => 2],
                        ['key' => 'descricao', 'label' => 'Letter content', 'rows' => 18],
                    ];
                @endphp

                @foreach($fields as $field)
                    <div class="mb-4">
                        <label class="form-label">{{ $field['label'] }}</label>
                        <ul class="nav lang-tabs mb-2" data-field="{{ $field['key'] }}">
                            @foreach($locales as $i => $locale)
                                <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $locale }}">{{ strtoupper(str_replace('_', '-', $locale)) }}</a></li>
                            @endforeach
                        </ul>
                        @foreach($locales as $i => $locale)
                            <div class="lang-pane" data-field="{{ $field['key'] }}" data-lang="{{ $locale }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                                <textarea
                                    name="{{ $field['key'] }}[{{ $locale }}]"
                                    class="form-control"
                                    rows="{{ $field['rows'] }}"
                                    placeholder="AA&#10;Subject of a transitive verb...&#10;&#10;Ablative&#10;Marker indicating movement away..."
                                >{{ old($field['key'] . '.' . $locale, $term->{$field['key']}[$locale] ?? '') }}</textarea>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between" style="background:#fafafa; border-radius: 0 0 12px 12px;">
            <a href="{{ route('admin.glossary.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
            <button class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Guardar Letra</button>
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
                document.querySelectorAll('.lang-pane[data-field="' + field + '"]').forEach(function(pane) {
                    pane.style.display = pane.dataset.lang === lang ? '' : 'none';
                });
            });
        });
    });
</script>
@endpush
