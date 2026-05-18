@extends('layouts.adminlte')

@section('title', $promotion->exists ? 'Editar Promoção' : 'Nova Promoção')
@section('page-title', $promotion->exists ? 'Editar — ' . $promotion->t('titulo') : 'Nova Promoção')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">Promoções</a></li>
    <li class="breadcrumb-item active">{{ $promotion->exists ? 'Editar' : 'Nova' }}</li>
@endsection

@push('styles')
<style>
    .lang-tabs .nav-link { font-size: .72rem; padding: .25rem .75rem; border-radius: 4px; color: #6b7280; }
    .lang-tabs .nav-link.active { background: #1a3a5c; color: #fff; }
    .form-section { border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
    .form-section h6 { font-weight: 700; color: #1a3a5c; margin-bottom: .25rem; font-size: .95rem; }
    .placement-card {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        cursor: pointer;
        transition: all .15s;
    }
    .placement-card:has(input:checked) { background: #eef3ff; border-color: #1a3a5c; }
    .placement-card .desc { font-size: .8rem; color: #6b7280; margin-top: .15rem; }
</style>
@endpush

@section('content')

<form method="post" action="{{ $promotion->exists ? route('admin.promotions.update', $promotion) : route('admin.promotions.store') }}" enctype="multipart/form-data">
    @csrf
    @if($promotion->exists) @method('PUT') @endif

    <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        <div class="card-body p-4">

            {{-- VISIBILIDADE / ONDE APARECE --}}
            <div class="form-section">
                <h6><i class="fas fa-eye me-2"></i>Onde aparece</h6>
                <p class="text-muted small">Escolha em quais áreas do site esta promoção deve aparecer.</p>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="placement-card">
                            <input type="checkbox" name="mostrar_topbar" value="1" {{ old('mostrar_topbar', $promotion->mostrar_topbar) ? 'checked' : '' }} style="margin-top:3px;">
                            <div>
                                <strong>Barra superior</strong>
                                <div class="desc">Faixa fina no topo de todas as páginas</div>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="placement-card">
                            <input type="checkbox" name="mostrar_home" value="1" {{ old('mostrar_home', $promotion->mostrar_home) ? 'checked' : '' }} style="margin-top:3px;">
                            <div>
                                <strong>Banner na Home</strong>
                                <div class="desc">Banner grande na página inicial</div>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="placement-card">
                            <input type="checkbox" name="mostrar_popup" value="1" {{ old('mostrar_popup', $promotion->mostrar_popup) ? 'checked' : '' }} style="margin-top:3px;">
                            <div>
                                <strong>Pop-up</strong>
                                <div class="desc">Aparece uma vez por sessão</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- AGENDAMENTO --}}
            <div class="form-section">
                <h6><i class="far fa-calendar me-2"></i>Período</h6>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Início (opcional)</label>
                        <input name="inicio" type="datetime-local" class="form-control"
                               value="{{ old('inicio', optional($promotion->inicio)->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Fim (opcional)</label>
                        <input name="fim" type="datetime-local" class="form-control"
                               value="{{ old('fim', optional($promotion->fim)->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ordem</label>
                        <input name="ordem" type="number" class="form-control" value="{{ old('ordem', $promotion->ordem) }}">
                    </div>
                </div>
                <small class="text-muted">Deixe em branco para a promoção ficar sempre activa enquanto estiver "Activa".</small>
            </div>

            {{-- VISUAL --}}
            <div class="form-section">
                <h6><i class="fas fa-palette me-2"></i>Visual</h6>
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Imagem de fundo (opcional)</label>
                        <input name="imagem" type="file" class="form-control" accept="image/*">
                        @if($promotion->imagemUrl())
                            <img src="{{ $promotion->imagemUrl() }}" style="margin-top:.5rem; max-height:60px; border-radius:6px;">
                        @endif
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cor de fundo</label>
                        <input name="cor_fundo" type="color" class="form-control form-control-color" value="{{ old('cor_fundo', $promotion->cor_fundo ?? '#1a1612') }}" style="width:100%;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cor do texto</label>
                        <input name="cor_texto" type="color" class="form-control form-control-color" value="{{ old('cor_texto', $promotion->cor_texto ?? '#faf6ec') }}" style="width:100%;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cor destaque</label>
                        <input name="cor_destaque" type="color" class="form-control form-control-color" value="{{ old('cor_destaque', $promotion->cor_destaque ?? '#c8a44b') }}" style="width:100%;">
                    </div>
                </div>
            </div>

            {{-- AÇÃO --}}
            <div class="form-section">
                <h6><i class="fas fa-link me-2"></i>Ação ao clicar</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Link / URL</label>
                        <input name="cta_url" type="text" class="form-control" value="{{ old('cta_url', $promotion->cta_url) }}" placeholder="/courses ou https://...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Código de desconto</label>
                        <input name="codigo_promo" type="text" class="form-control" value="{{ old('codigo_promo', $promotion->codigo_promo) }}" placeholder="INVERNO26">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Texto do desconto</label>
                        <input name="desconto" type="text" class="form-control" value="{{ old('desconto', $promotion->desconto) }}" placeholder="20% OFF">
                    </div>
                </div>
            </div>

            {{-- CONTEÚDO MULTILÍNGUE --}}
            <div class="form-section">
                <h6><i class="fas fa-language me-2"></i>Textos (multilíngue)</h6>

                @php
                    $fields = [
                        ['key' => 'titulo',      'label' => 'Título principal', 'type' => 'input',    'required' => true],
                        ['key' => 'subtitulo',   'label' => 'Subtítulo',         'type' => 'input'],
                        ['key' => 'descricao',   'label' => 'Descrição',         'type' => 'textarea', 'rows' => 3],
                        ['key' => 'badge_texto', 'label' => 'Texto do badge',    'type' => 'input'],
                        ['key' => 'cta_texto',   'label' => 'Texto do botão',    'type' => 'input'],
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
                                    <input name="{{ $f['key'] }}[{{ $loc }}]" type="text" class="form-control" value="{{ old($f['key'] . '.' . $loc, $promotion->{$f['key']}[$loc] ?? '') }}">
                                @else
                                    <textarea name="{{ $f['key'] }}[{{ $loc }}]" class="form-control" rows="{{ $f['rows'] ?? 3 }}">{{ old($f['key'] . '.' . $loc, $promotion->{$f['key']}[$loc] ?? '') }}</textarea>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            {{-- ESTADO --}}
            <div class="form-section" style="border-bottom:0;">
                <h6><i class="fas fa-toggle-on me-2"></i>Estado</h6>
                <label class="d-flex align-items-center gap-2 p-2 border rounded" style="cursor:pointer;">
                    <input type="checkbox" name="ativo" value="1" {{ old('ativo', $promotion->ativo) ? 'checked' : '' }}> Promoção activa
                </label>
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between" style="background:#fafafa; border-radius: 0 0 12px 12px;">
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
            <button class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Guardar Promoção</button>
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
                document.querySelectorAll('.lang-pane[data-field="' + field + '"]').forEach(p => p.style.display = p.dataset.lang === lang ? '' : 'none');
            });
        });
    });
</script>
@endpush
