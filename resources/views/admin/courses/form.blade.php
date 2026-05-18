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

<form method="post" action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}" enctype="multipart/form-data">
    @csrf
    @if($course->exists) @method('PUT') @endif

    <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        <div class="card-body p-4">

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
                        <input name="ordem" type="number" class="form-control" value="{{ old('ordem', $course->ordem) }}">
                    </div>
                </div>
            </div>

            {{-- Imagens --}}
            <div class="form-section">
                <h6><i class="fas fa-image me-2"></i>Imagens</h6>
                <p class="help">Imagem de capa (listagem) e imagem de fundo (página do curso).</p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Imagem de capa <small>(JPG/PNG/WebP)</small></label>
                        <input name="imagem_capa" type="file" class="form-control" accept="image/*">
                        @if($course->imagemCapaUrl())
                            <img src="{{ $course->imagemCapaUrl() }}" style="margin-top:.5rem; max-height:80px; border-radius:6px;">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Imagem de fundo (banner)</label>
                        <input name="imagem_fundo" type="file" class="form-control" accept="image/*">
                        @if($course->imagemFundoUrl())
                            <img src="{{ $course->imagemFundoUrl() }}" style="margin-top:.5rem; max-height:80px; border-radius:6px;">
                        @endif
                    </div>
                </div>
            </div>

            {{-- Conteúdo Traduzível --}}
            <div class="form-section">
                <h6><i class="fas fa-language me-2"></i>Conteúdo (multilíngue)</h6>
                <p class="help">Cada campo pode ter uma versão por idioma. Preencha pelo menos o PT-BR — os outros são opcionais.</p>

                @php
                    $textFields = [
                        ['key' => 'nome',            'label' => 'Nome do curso',          'type' => 'input',    'required' => true],
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
                <div class="row g-3">
                    <div class="col-md-3"><label class="form-label">Duração total</label><input name="duracao_total" type="text" class="form-control" value="{{ old('duracao_total', $course->duracao_total) }}" placeholder="120h · 6 módulos"></div>
                    <div class="col-md-3"><label class="form-label">Formato</label><input name="formato" type="text" class="form-control" value="{{ old('formato', $course->formato) }}" placeholder="Online · Presencial"></div>
                    <div class="col-md-3"><label class="form-label">Investimento</label><input name="preco" type="text" class="form-control" value="{{ old('preco', $course->preco) }}" placeholder="R$ 290 / mês"></div>
                    <div class="col-md-3"><label class="form-label">Vagas por turma</label><input name="vagas_por_turma" type="number" class="form-control" value="{{ old('vagas_por_turma', $course->vagas_por_turma) }}"></div>
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
                        <label class="form-label">Foto</label>
                        <input name="professor_foto" type="file" class="form-control" accept="image/*">
                        @if($course->professorFotoUrl())
                            <img src="{{ $course->professorFotoUrl() }}" style="margin-top:.5rem; max-height:60px; border-radius:50%;">
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
                    <div class="col-md-4"><label class="form-label">Email</label><input name="contato_email" type="email" class="form-control" value="{{ old('contato_email', $course->contato_email) }}"></div>
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
