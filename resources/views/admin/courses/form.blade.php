@extends('layouts.adminlte')

@section('title', $course->exists ? 'Editar Curso' : 'Novo Curso')
@section('page-title', $course->exists ? 'Editar — ' . $course->t('nome') : 'Novo Curso')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Cursos</a></li>
    <li class="breadcrumb-item active">{{ $course->exists ? 'Editar' : 'Novo' }}</li>
@endsection

@push('styles')
<style>
    .lang-tabs .nav-link { font-size: .72rem; padding: .25rem .75rem; border-radius: 4px; color: #6b7280; }
    .lang-tabs .nav-link.active { background: #1a3a5c; color: #fff; }
    .lang-tabs { gap: .25rem; flex-wrap: wrap; }
    .nivel-card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1rem; margin-bottom: .75rem; }
    .form-section { border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
    .form-section h6 { font-weight: 700; color: #1a3a5c; margin-bottom: .25rem; font-size: .95rem; }
    .form-section .help { font-size: .8rem; color: #6b7280; margin-bottom: 1rem; }
</style>
@endpush

@section('content')

<form method="post" action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}" enctype="multipart/form-data" novalidate>
    @csrf
    @if($course->exists) @method('PUT') @endif

    <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        <div class="card-body p-4">

            @if($errors->any())
                <div class="alert alert-danger" style="border-radius:10px;">
                    <strong>Nao foi possivel guardar o curso.</strong>
                    <div style="margin-top:.35rem;">Veja abaixo o motivo do erro:</div>
                    <ul style="margin:.65rem 0 0 1rem; padding:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Identificação --}}
            <div class="form-section">
                <h6><i class="fas fa-fingerprint me-2"></i>Identificação</h6>
                <p class="help">Glifo, cor e slug — a "marca" visual do curso.</p>
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Glifo <small>(Ελ, אב...)</small></label>
                        <input name="glifo" type="text" class="form-control" maxlength="20" value="{{ old('glifo', $course->glifo) }}" style="font-family: Georgia, serif; font-size: 1.4rem; text-align:center;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Código</label>
                        <input name="codigo" type="text" class="form-control" maxlength="20" value="{{ old('codigo', $course->codigo) }}" placeholder="el / he / en">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cor destaque</label>
                        <input name="cor_destaque" type="color" class="form-control form-control-color" value="{{ old('cor_destaque', $course->cor_destaque ?? '#a87841') }}" style="width:100%;">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Slug <small>(URL: /courses/slug)</small></label>
                        <input name="slug" type="text" class="form-control" value="{{ old('slug', $course->slug) }}" placeholder="auto-gerado a partir do nome">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ordem</label>
                        <input name="ordem" type="text" class="form-control" value="{{ old('ordem', $course->ordem) }}">
                    </div>
                </div>
            </div>

            {{-- Imagens --}}
            <div class="form-section">
                <h6><i class="fas fa-image me-2"></i>Imagens</h6>
                <p class="help">Imagem de capa (listagem) e imagem de fundo (página do curso).</p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Imagem de capa <small>(JPG/JPEG/PNG/WebP/GIF/BMP/AVIF/HEIC/HEIF/JFIF ate 20MB)</small></label>
                        <input name="imagem_capa" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif,.bmp,.avif,.heic,.heif,.jfif,image/*" data-image-preview="#preview-imagem-capa">
                        @if($course->imagemCapaUrl())
                            <img id="preview-imagem-capa" src="{{ $course->imagemCapaUrl() }}" style="margin-top:.5rem; max-height:80px; border-radius:6px;">
                        @else
                            <img id="preview-imagem-capa" style="margin-top:.5rem; max-height:80px; border-radius:6px; display:none;">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Imagem de fundo (banner) <small>(opcional ate 20MB)</small></label>
                        <input name="imagem_fundo" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif,.bmp,.avif,.heic,.heif,.jfif,image/*" data-image-preview="#preview-imagem-fundo">
                        @if($course->imagemFundoUrl())
                            <img id="preview-imagem-fundo" src="{{ $course->imagemFundoUrl() }}" style="margin-top:.5rem; max-height:80px; border-radius:6px;">
                        @else
                            <img id="preview-imagem-fundo" style="margin-top:.5rem; max-height:80px; border-radius:6px; display:none;">
                        @endif
                    </div>
                </div>
            </div>

            {{-- Conteúdo Traduzível --}}
            <div class="form-section">
                <h6><i class="fas fa-language me-2"></i>Conteúdo (multilíngue)</h6>
                <p class="help">Só o nome do curso é obrigatório. Todos os outros textos são opcionais em qualquer idioma.</p>

                @php
                    $textFields = [
                        ['key' => 'nome',            'label' => 'Nome do curso',          'type' => 'input'],
                        ['key' => 'subtitulo',       'label' => 'Subtítulo',              'type' => 'input'],
                        ['key' => 'descricao_curta', 'label' => 'Descrição curta (listagem)', 'type' => 'textarea', 'rows' => 2],
                        ['key' => 'descricao_longa', 'label' => 'Descrição longa (sobre o curso)', 'type' => 'textarea', 'rows' => 5],
                        ['key' => 'historia_lingua', 'label' => 'História da língua',     'type' => 'textarea', 'rows' => 5],
                        ['key' => 'alfabeto_info',   'label' => 'Sobre o alfabeto',       'type' => 'textarea', 'rows' => 3],
                        ['key' => 'para_quem',       'label' => 'Para quem é este curso','type' => 'textarea', 'rows' => 3],
                    ];
                @endphp

                @foreach($textFields as $f)
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
                                           value="{{ old($f['key'] . '.' . $loc, $course->{$f['key']}[$loc] ?? '') }}">
                                @else
                                    <textarea name="{{ $f['key'] }}[{{ $loc }}]" class="form-control" rows="{{ $f['rows'] ?? 3 }}">{{ old($f['key'] . '.' . $loc, $course->{$f['key']}[$loc] ?? '') }}</textarea>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach

                {{-- O que aprende (bullets) --}}
                <div class="mb-4">
                    <label class="form-label">O que vais aprender <small>(uma linha por item)</small></label>
                    <ul class="nav lang-tabs mb-2" data-field="o_que_aprende">
                        @foreach($locales as $i => $loc)
                            <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                        @endforeach
                    </ul>
                    @foreach($locales as $i => $loc)
                        <div class="lang-pane" data-field="o_que_aprende" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                            <textarea name="o_que_aprende[{{ $loc }}]" class="form-control" rows="6"
                                      placeholder="Um item por linha…">{{ old('o_que_aprende.' . $loc, implode("\n", $course->o_que_aprende[$loc] ?? [])) }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Níveis --}}
            <div class="form-section">
                <h6><i class="fas fa-layer-group me-2"></i>Níveis do curso</h6>
                <p class="help">Cada nível é um cartão na página do curso.</p>
                <div id="niveis-list">
                    @php $niveis = old('niveis', $course->niveis ?? []); @endphp
                    @foreach($niveis as $i => $n)
                        @include('admin.courses._nivel', ['idx' => $i, 'nivel' => $n, 'locales' => $locales])
                    @endforeach
                </div>
                <button type="button" id="add-nivel" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-plus me-1"></i>Adicionar nível
                </button>
            </div>

            {{-- Logística --}}
            <div class="form-section">
                <h6><i class="fas fa-calendar-alt me-2"></i>Logística</h6>
                <p class="help">Os textos têm separadores de idioma (EN / PT-BR / ES). Preencha cada língua.</p>
                @php
                    $logFields = [
                        'duracao_total' => ['label' => 'Duração total', 'ph' => '120h · 6 módulos'],
                        'formato'       => ['label' => 'Formato', 'ph' => 'Online · Presencial'],
                        'preco'         => ['label' => 'Investimento', 'ph' => 'R$ 290 / mês'],
                    ];
                @endphp
                <div class="row g-3">
                    @foreach($logFields as $key => $meta)
                        <div class="col-md-6">
                            <label class="form-label">{{ $meta['label'] }}</label>
                            <ul class="nav lang-tabs mb-1" data-field="{{ $key }}">
                                @foreach($locales as $i => $loc)
                                    <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                                @endforeach
                            </ul>
                            @foreach($locales as $i => $loc)
                                <div class="lang-pane" data-field="{{ $key }}" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                                    <input name="{{ $key }}[{{ $loc }}]" type="text" class="form-control"
                                           value="{{ old($key . '.' . $loc, data_get($course->{$key}, $loc)) }}" placeholder="{{ $meta['ph'] }}">
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="col-md-6">
                        <label class="form-label">Vagas por turma</label>
                        <input name="vagas_por_turma" type="text" class="form-control" value="{{ old('vagas_por_turma', $course->vagas_por_turma) }}">
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="d-flex align-items-center gap-2 p-2 border rounded" style="cursor:pointer;">
                            <input type="checkbox" name="material_gratis" value="1" {{ old('material_gratis', $course->material_gratis) ? 'checked' : '' }}> Material grátis
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="d-flex align-items-center gap-2 p-2 border rounded" style="cursor:pointer;">
                            <input type="checkbox" name="certificacao_gratis" value="1" {{ old('certificacao_gratis', $course->certificacao_gratis) ? 'checked' : '' }}> Com direito a certificação grátis
                        </label>
                    </div>
                </div>
                @php
                    $logTextos = [
                        'material_gratis_texto'      => ['label' => 'Texto do quadro “material grátis”', 'ph' => 'Free study material'],
                        'certificacao_gratis_texto'  => ['label' => 'Texto do quadro “certificação”', 'ph' => 'Free certificate included'],
                    ];
                @endphp
                <div class="row g-3 mt-1">
                    @foreach($logTextos as $key => $meta)
                        <div class="col-md-6">
                            <label class="form-label">{{ $meta['label'] }}</label>
                            <ul class="nav lang-tabs mb-1" data-field="{{ $key }}">
                                @foreach($locales as $i => $loc)
                                    <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                                @endforeach
                            </ul>
                            @foreach($locales as $i => $loc)
                                <div class="lang-pane" data-field="{{ $key }}" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                                    <input name="{{ $key }}[{{ $loc }}]" type="text" class="form-control"
                                           value="{{ old($key . '.' . $loc, data_get($course->{$key}, $loc)) }}" placeholder="{{ $meta['ph'] }}">
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Professor --}}
            <div class="form-section">
                <h6><i class="fas fa-user-graduate me-2"></i>Professor</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome</label>
                        <input name="professor_nome" type="text" class="form-control" value="{{ old('professor_nome', $course->professor_nome) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Foto <small>(JPG/JPEG/PNG/WebP/GIF/BMP/AVIF/HEIC/HEIF/JFIF ate 20MB)</small></label>
                        <input name="professor_foto" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif,.bmp,.avif,.heic,.heif,.jfif,image/*" data-image-preview="#preview-professor-foto">
                        @if($course->professorFotoUrl())
                            <img id="preview-professor-foto" src="{{ $course->professorFotoUrl() }}" style="margin-top:.5rem; max-height:60px; border-radius:50%;">
                        @else
                            <img id="preview-professor-foto" style="margin-top:.5rem; max-height:60px; border-radius:50%; display:none;">
                        @endif
                    </div>
                </div>

                <div class="mt-3 mb-3">
                    <label class="form-label">Títulos (uma frase) — multilíngue</label>
                    <ul class="nav lang-tabs mb-2" data-field="professor_titulos">
                        @foreach($locales as $i => $loc)
                            <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                        @endforeach
                    </ul>
                    @foreach($locales as $i => $loc)
                        <div class="lang-pane" data-field="professor_titulos" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                            <input name="professor_titulos[{{ $loc }}]" type="text" class="form-control"
                                   value="{{ old('professor_titulos.' . $loc, $course->professor_titulos[$loc] ?? '') }}"
                                   placeholder="PhD · Universidade de Atenas">
                        </div>
                    @endforeach
                </div>

                <div>
                    <label class="form-label">Bio — multilíngue</label>
                    <ul class="nav lang-tabs mb-2" data-field="professor_bio">
                        @foreach($locales as $i => $loc)
                            <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                        @endforeach
                    </ul>
                    @foreach($locales as $i => $loc)
                        <div class="lang-pane" data-field="professor_bio" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                            <textarea name="professor_bio[{{ $loc }}]" class="form-control" rows="3">{{ old('professor_bio.' . $loc, $course->professor_bio[$loc] ?? '') }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Contacto --}}
            <div class="form-section">
                <h6><i class="fas fa-address-card me-2"></i>Contacto deste curso</h6>
                <p class="help">Se ficar em branco, usamos o contacto geral do site.</p>
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">WhatsApp</label><input name="contato_whatsapp" type="text" class="form-control" value="{{ old('contato_whatsapp', $course->contato_whatsapp) }}"></div>
                    <div class="col-md-4"><label class="form-label">Email</label><input name="contato_email" type="text" class="form-control" value="{{ old('contato_email', $course->contato_email) }}"></div>
                    <div class="col-md-4"><label class="form-label">Telefone</label><input name="contato_telefone" type="text" class="form-control" value="{{ old('contato_telefone', $course->contato_telefone) }}"></div>
                </div>
            </div>

            {{-- Visibilidade --}}
            <div class="form-section" style="border-bottom:0;">
                <h6><i class="fas fa-eye me-2"></i>Visibilidade</h6>
                <div class="d-flex gap-3 flex-wrap">
                    <label class="d-flex align-items-center gap-2 p-2 border rounded" style="cursor:pointer;">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', $course->ativo) ? 'checked' : '' }}> Curso activo (visível no site)
                    </label>
                    <label class="d-flex align-items-center gap-2 p-2 border rounded" style="cursor:pointer;">
                        <input type="checkbox" name="destaque" value="1" {{ old('destaque', $course->destaque) ? 'checked' : '' }}> Curso em destaque
                    </label>
                </div>
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between" style="background:#fafafa; border-radius: 0 0 12px 12px;">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
            <button class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Guardar Curso</button>
        </div>
    </div>
</form>

{{-- Template for new niveis --}}
<template id="nivel-template">
    @include('admin.courses._nivel', ['idx' => '__I__', 'nivel' => ['nome' => [], 'descricao' => [], 'duracao' => ''], 'locales' => $locales])
</template>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('input[type="file"][data-image-preview]').forEach(function(input) {
        input.addEventListener('change', function() {
            var target = document.querySelector(input.getAttribute('data-image-preview'));
            var file = input.files && input.files[0];
            if (!target) return;
            if (!file) {
                target.removeAttribute('src');
                target.style.display = 'none';
                return;
            }
            var url = URL.createObjectURL(file);
            target.src = url;
            target.style.display = '';
        });
    });

    // Language tabs
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

    // Niveis dynamic add
    (function() {
        const list = document.getElementById('niveis-list');
        const tpl  = document.getElementById('nivel-template');
        const addBtn = document.getElementById('add-nivel');
        let counter = list.querySelectorAll('.nivel-card').length;
        addBtn.addEventListener('click', function() {
            const html = tpl.innerHTML.replace(/__I__/g, counter++);
            const div = document.createElement('div');
            div.innerHTML = html.trim();
            const card = div.firstElementChild;
            list.appendChild(card);
            // Re-bind lang tabs inside the new card
            card.querySelectorAll('.lang-tabs').forEach(function(tabs) {
                const field = tabs.dataset.field;
                tabs.querySelectorAll('.nav-link').forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const lang = this.dataset.lang;
                        tabs.querySelectorAll('.nav-link').forEach(x => x.classList.remove('active'));
                        this.classList.add('active');
                        card.querySelectorAll('.lang-pane[data-field="' + field + '"]').forEach(p => p.style.display = p.dataset.lang === lang ? '' : 'none');
                    });
                });
            });
            card.querySelector('.remove-nivel')?.addEventListener('click', () => card.remove());
        });
        list.querySelectorAll('.remove-nivel').forEach(b => b.addEventListener('click', () => b.closest('.nivel-card').remove()));
    })();
</script>
@endpush
