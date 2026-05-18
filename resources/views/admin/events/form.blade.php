@extends('layouts.adminlte')

@section('title', $event->exists ? 'Editar Evento' : 'Novo Evento')
@section('page-title', $event->exists ? 'Editar — ' . $event->t('titulo') : 'Novo Evento')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Eventos</a></li>
    <li class="breadcrumb-item active">{{ $event->exists ? 'Editar' : 'Novo' }}</li>
@endsection

@push('styles')
<style>
    .lang-tabs .nav-link { font-size: .72rem; padding: .25rem .75rem; border-radius: 4px; color: #6b7280; }
    .lang-tabs .nav-link.active { background: #1a3a5c; color: #fff; }
    .form-section { border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
    .form-section h6 { font-weight: 700; color: #1a3a5c; margin-bottom: .25rem; font-size: .95rem; }
    .toggle-card {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        cursor: pointer;
        transition: all .15s;
        text-align: center;
    }
    .toggle-card.selected { background: #eef3ff; border-color: #1a3a5c; }
    .toggle-card i { font-size: 1.4rem; color: #1a3a5c; display: block; margin-bottom: .35rem; }
    .toggle-card label { font-size: .78rem; font-weight: 600; color: #374151; cursor: pointer; margin: 0; }
</style>
@endpush

@section('content')

<form method="post" action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}" enctype="multipart/form-data">
    @csrf
    @if($event->exists) @method('PUT') @endif

    <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        <div class="card-body p-4">

            {{-- WHEN --}}
            <div class="form-section">
                <h6><i class="far fa-calendar me-2"></i>Quando acontece</h6>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Início <span class="text-danger">*</span></label>
                        <input name="data_inicio" type="datetime-local" required class="form-control"
                               value="{{ old('data_inicio', optional($event->data_inicio)->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Fim (opcional)</label>
                        <input name="data_fim" type="datetime-local" class="form-control"
                               value="{{ old('data_fim', optional($event->data_fim)->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Timezone</label>
                        <input name="timezone" type="text" class="form-control" value="{{ old('timezone', $event->timezone ?? 'America/Sao_Paulo') }}">
                    </div>
                </div>
            </div>

            {{-- FORMATO + GRATUITO/PAGO --}}
            <div class="form-section">
                <h6><i class="fas fa-toggle-on me-2"></i>Formato e tipo</h6>
                <div class="row g-3 mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Formato</label>
                        <div class="row g-2">
                            @foreach(['presencial' => ['fa-map-marker-alt','Presencial'], 'online' => ['fa-globe','Online'], 'hibrido' => ['fa-broadcast-tower','Híbrido']] as $key => [$ico, $lbl])
                                <div class="col-md-4">
                                    <label class="toggle-card {{ old('formato', $event->formato) === $key ? 'selected' : '' }}" data-format="{{ $key }}">
                                        <i class="fas {{ $ico }}"></i>
                                        <input type="radio" name="formato" value="{{ $key }}" {{ old('formato', $event->formato) === $key ? 'checked' : '' }} style="display:none;">
                                        <span>{{ $lbl }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="d-flex align-items-center gap-3 p-3 border rounded" style="cursor:pointer; background: #f0fdf4;">
                            <input type="checkbox" name="gratuito" value="1" id="gratuito-toggle" {{ old('gratuito', $event->gratuito) ? 'checked' : '' }} style="width:18px;height:18px;">
                            <div>
                                <div class="fw-bold" style="color:#15803d;"><i class="fas fa-gift me-1"></i>Evento gratuito</div>
                                <small class="text-muted">Desmarque para definir um preço</small>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-6" id="preco-block">
                        <label class="form-label">Preço (texto exibido) e valor numérico</label>
                        <div class="row g-2">
                            <div class="col-7">
                                <input name="preco" type="text" class="form-control" placeholder="R$ 80 · gratuito para alunos" value="{{ old('preco', $event->preco) }}">
                            </div>
                            <div class="col-3">
                                <input name="preco_valor" type="number" step="0.01" class="form-control" placeholder="80.00" value="{{ old('preco_valor', $event->preco_valor) }}">
                            </div>
                            <div class="col-2">
                                <input name="moeda" type="text" class="form-control" placeholder="BRL" value="{{ old('moeda', $event->moeda ?? 'BRL') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- IMAGEM + COR --}}
            <div class="form-section">
                <h6><i class="fas fa-image me-2"></i>Visual</h6>
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label">Imagem do evento</label>
                        <input name="imagem" type="file" class="form-control" accept="image/*">
                        @if($event->imagemUrl())
                            <img src="{{ $event->imagemUrl() }}" style="margin-top:.5rem; max-height:80px; border-radius:6px;">
                        @endif
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cor</label>
                        <input name="cor_destaque" type="color" class="form-control form-control-color" value="{{ old('cor_destaque', $event->cor_destaque ?? '#a87841') }}" style="width:100%;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ordem</label>
                        <input name="ordem" type="number" class="form-control" value="{{ old('ordem', $event->ordem) }}">
                    </div>
                </div>
            </div>

            {{-- CONTEÚDO MULTILÍNGUE --}}
            <div class="form-section">
                <h6><i class="fas fa-language me-2"></i>Conteúdo (multilíngue)</h6>

                @php
                    $fields = [
                        ['key' => 'titulo',     'label' => 'Título do evento',     'type' => 'input',    'required' => true],
                        ['key' => 'subtitulo',  'label' => 'Subtítulo',            'type' => 'input'],
                        ['key' => 'descricao',  'label' => 'Descrição completa',   'type' => 'textarea', 'rows' => 8],
                        ['key' => 'local_nome', 'label' => 'Nome do local',         'type' => 'input'],
                    ];
                @endphp

                @foreach($fields as $f)
                    <div class="mb-4">
                        <label class="form-label">{{ $f['label'] }} @if(!empty($f['required'])) <span class="text-danger">*</span> @endif</label>
                        <ul class="nav lang-tabs mb-2" data-field="{{ $f['key'] }}">
                            @foreach($locales as $i => $loc)
                                <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                            @endforeach
                        </ul>
                        @foreach($locales as $i => $loc)
                            <div class="lang-pane" data-field="{{ $f['key'] }}" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                                @if($f['type'] === 'input')
                                    <input name="{{ $f['key'] }}[{{ $loc }}]" type="text" class="form-control"
                                           value="{{ old($f['key'] . '.' . $loc, $event->{$f['key']}[$loc] ?? '') }}">
                                @else
                                    <textarea name="{{ $f['key'] }}[{{ $loc }}]" class="form-control" rows="{{ $f['rows'] ?? 3 }}">{{ old($f['key'] . '.' . $loc, $event->{$f['key']}[$loc] ?? '') }}</textarea>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            {{-- LOCAL --}}
            <div class="form-section">
                <h6><i class="fas fa-map-pin me-2"></i>Localização</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Endereço</label>
                        <input name="local_endereco" type="text" class="form-control" value="{{ old('local_endereco', $event->local_endereco) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cidade</label>
                        <input name="local_cidade" type="text" class="form-control" value="{{ old('local_cidade', $event->local_cidade) }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Link da sala online (Zoom, Meet, etc.)</label>
                        <input name="link_online" type="text" class="form-control" value="{{ old('link_online', $event->link_online) }}" placeholder="https://meet.google.com/...">
                    </div>
                </div>
            </div>

            {{-- INSCRIÇÃO + VAGAS --}}
            <div class="form-section">
                <h6><i class="fas fa-ticket-alt me-2"></i>Inscrição</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Link de inscrição</label>
                        <input name="link_inscricao" type="text" class="form-control" value="{{ old('link_inscricao', $event->link_inscricao) }}" placeholder="https://...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Vagas totais</label>
                        <input name="vagas_total" type="number" class="form-control" value="{{ old('vagas_total', $event->vagas_total) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Vagas ocupadas</label>
                        <input name="vagas_ocupadas" type="number" class="form-control" value="{{ old('vagas_ocupadas', $event->vagas_ocupadas ?? 0) }}">
                    </div>
                </div>
            </div>

            {{-- PALESTRANTE --}}
            <div class="form-section">
                <h6><i class="fas fa-user me-2"></i>Palestrante / Conduzido por</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome</label>
                        <input name="palestrante_nome" type="text" class="form-control" value="{{ old('palestrante_nome', $event->palestrante_nome) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Foto</label>
                        <input name="palestrante_foto" type="file" class="form-control" accept="image/*">
                        @if($event->palestranteFotoUrl())
                            <img src="{{ $event->palestranteFotoUrl() }}" style="margin-top:.5rem; max-height:50px; border-radius:50%;">
                        @endif
                    </div>
                    <div class="col-12">
                        <label class="form-label">Título do palestrante (multilíngue)</label>
                        <ul class="nav lang-tabs mb-2" data-field="palestrante_titulo">
                            @foreach($locales as $i => $loc)
                                <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                            @endforeach
                        </ul>
                        @foreach($locales as $i => $loc)
                            <div class="lang-pane" data-field="palestrante_titulo" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                                <input name="palestrante_titulo[{{ $loc }}]" type="text" class="form-control" value="{{ old('palestrante_titulo.' . $loc, $event->palestrante_titulo[$loc] ?? '') }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- VISIBILIDADE --}}
            <div class="form-section" style="border-bottom:0;">
                <h6><i class="fas fa-eye me-2"></i>Visibilidade</h6>
                <div class="d-flex gap-3 flex-wrap">
                    <label class="d-flex align-items-center gap-2 p-2 border rounded" style="cursor:pointer;">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', $event->ativo) ? 'checked' : '' }}> Activo (visível no site)
                    </label>
                    <label class="d-flex align-items-center gap-2 p-2 border rounded" style="cursor:pointer;">
                        <input type="checkbox" name="destaque" value="1" {{ old('destaque', $event->destaque) ? 'checked' : '' }}> Em destaque
                    </label>
                </div>
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between" style="background:#fafafa; border-radius: 0 0 12px 12px;">
            <a href="{{ route('admin.events.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
            <button class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Guardar Evento</button>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    // Format radios (toggle-card)
    document.querySelectorAll('.toggle-card[data-format]').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.toggle-card[data-format]').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input[type=radio]').checked = true;
        });
    });

    // Gratuito toggles preco block
    var gratuito = document.getElementById('gratuito-toggle');
    var precoBlock = document.getElementById('preco-block');
    function refreshPreco() {
        precoBlock.style.opacity = gratuito.checked ? '.4' : '1';
        precoBlock.style.pointerEvents = gratuito.checked ? 'none' : '';
    }
    if (gratuito) {
        gratuito.addEventListener('change', refreshPreco);
        refreshPreco();
    }

    // Lang tabs
    document.querySelectorAll('.lang-tabs').forEach(function(tabs) {
        const field = tabs.dataset.field;
        tabs.querySelectorAll('.nav-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const lang = this.dataset.lang;
                tabs.querySelectorAll('.nav-link').forEach(x => x.classList.remove('active'));
                this.classList.add('active');
                document.querySelectorAll('.lang-pane[data-field="' + field + '"]').forEach(p => p.style.display = p.dataset.lang === lang ? '' : 'none');
            });
        });
    });
</script>
@endpush
