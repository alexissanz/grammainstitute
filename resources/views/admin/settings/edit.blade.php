@extends('layouts.adminlte')

@section('title', __('settings.title'))
@section('page-title', __('settings.title'))

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('settings.title') }}</li>
@endsection

@push('styles')
<style>
    .settings-tabs .nav-link {
        border-radius: 0; padding: .7rem 1.1rem;
        color: #6b7280; font-weight: 500; font-size: .875rem;
        border-bottom: 3px solid transparent;
        transition: all .15s;
    }
    .settings-tabs .nav-link.active {
        color: var(--gramma-blue);
        border-bottom-color: var(--gramma-blue);
        background: transparent;
    }
    .settings-tabs .nav-link:hover:not(.active) { color: var(--gramma-blue); background: #f8f9ff; }
    .settings-tabs .nav-link i { margin-right: .4rem; }
    .form-label { font-weight: 500; font-size: .875rem; color: #374151; }
    .form-label small { font-weight: 400; color: #9ca3af; }
    .img-preview { max-height: 80px; border-radius: 8px; object-fit: contain; border: 1px solid #e5e7eb; padding: 4px; background: #f9fafb; }
    .hero-type-card {
        border: 2px solid #e5e7eb; border-radius: 10px; padding: 1rem;
        cursor: pointer; transition: all .2s; text-align: center;
    }
    .hero-type-card:hover { border-color: #2d6a9f; }
    .hero-type-card.selected { border-color: var(--gramma-blue); background: #eef3ff; }
    .hero-type-card .hicon { font-size: 1.8rem; margin-bottom: .4rem; }
    .hero-type-card .hlabel { font-size: .85rem; font-weight: 600; color: #374151; }
    .hero-panel { display: none; }
    .hero-panel.active { display: block; }
</style>
@endpush

@section('content')
<form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="settings-form">
    @csrf
    @method('PUT')

<div class="card" style="border-radius:14px; border:none; box-shadow:0 2px 16px rgba(0,0,0,0.08);">

    {{-- Tab navigation --}}
    <div class="card-header p-0 border-0" style="border-radius:14px 14px 0 0; overflow:hidden; background:#fff;">
        <ul class="nav settings-tabs border-bottom" style="flex-wrap:nowrap; overflow-x:auto;">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-geral"><i class="fas fa-building"></i>Geral</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-contato"><i class="fas fa-phone"></i>Contacto</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-social"><i class="fas fa-share-alt"></i>Social</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-whatsapp"><i class="fab fa-whatsapp" style="color:#25d366;"></i>WhatsApp</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-founder"><i class="fas fa-user-tie"></i>Fundador</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-hero"><i class="fas fa-star"></i>Hero</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-tipografia"><i class="fas fa-font"></i>Tipografia</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-rodape"><i class="fas fa-shoe-prints"></i>Rodapé</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-idiomas"><i class="fas fa-language"></i>Idiomas</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-seo"><i class="fas fa-search"></i>SEO</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-smtp"><i class="fas fa-envelope"></i>SMTP</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-midia"><i class="fas fa-image"></i>Mídia</a></li>
        </ul>
    </div>

    <div class="card-body p-4">
        <div class="tab-content">

            {{-- TAB: GERAL --}}
            <div class="tab-pane fade show active" id="tab-geral">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome do Site</label>
                        <input name="nome_site" type="text" class="form-control @error('nome_site') is-invalid @enderror"
                               value="{{ old('nome_site', $settings->nome_site) }}" placeholder="Gramma Institute">
                        @error('nome_site')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Título Principal</label>
                        <input name="titulo_site" type="text" class="form-control"
                               value="{{ old('titulo_site', $settings->titulo_site) }}" placeholder="Instituto Internacional de Línguas">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Subtítulo / Slogan</label>
                        <input name="subtitulo_site" type="text" class="form-control"
                               value="{{ old('subtitulo_site', $settings->subtitulo_site) }}" placeholder="Aprenda idiomas com quem entende de línguas">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descrição do Site <small>(usada no rodapé e dashboard)</small></label>
                        <textarea name="descricao_site" class="form-control" rows="3"
                                  placeholder="Breve descrição do instituto...">{{ old('descricao_site', $settings->descricao_site) }}</textarea>
                    </div>
                    {{-- "Texto do Rodapé" foi movido para o separador Rodapé. --}}
                </div>
            </div>

            {{-- TAB: CONTACTO --}}
            <div class="tab-pane fade" id="tab-contato">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Email Institucional</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input name="email_institucional" type="email" class="form-control @error('email_institucional') is-invalid @enderror"
                                   value="{{ old('email_institucional', $settings->email_institucional) }}" placeholder="info@grammainstitute.com">
                        </div>
                        @error('email_institucional')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input name="telefone" type="text" class="form-control"
                                   value="{{ old('telefone', $settings->telefone) }}" placeholder="+55 11 9 9999-9999">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text" style="color:#25d366;"><i class="fab fa-whatsapp"></i></span>
                            <input name="whatsapp" type="text" class="form-control"
                                   value="{{ old('whatsapp', $settings->whatsapp) }}" placeholder="+55 11 9 9999-9999">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Link da Loja / Store</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-store"></i></span>
                            <input name="loja_url" type="text" class="form-control"
                                   value="{{ old('loja_url', $settings->loja_url) }}" placeholder="https://loja.exemplo.com">
                        </div>
                        <small class="text-muted">Aparece como “loja” no menu do site. Deixe vazio para esconder.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Endereço</label>
                        <input name="endereco" type="text" class="form-control"
                               value="{{ old('endereco', $settings->endereco) }}" placeholder="Rua das Línguas, 123">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cidade</label>
                        <input name="cidade" type="text" class="form-control"
                               value="{{ old('cidade', $settings->cidade) }}" placeholder="São Paulo">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">País</label>
                        <input name="pais" type="text" class="form-control"
                               value="{{ old('pais', $settings->pais) }}" placeholder="Brasil">
                    </div>
                </div>
            </div>

            {{-- TAB: SOCIAL --}}
            <div class="tab-pane fade" id="tab-social">
                <div class="row g-3">
                    @foreach([
                        ['facebook', 'fab fa-facebook', '#1877f2', 'https://facebook.com/grammainstitute'],
                        ['instagram', 'fab fa-instagram', '#e1306c', 'https://instagram.com/grammainstitute'],
                        ['linkedin', 'fab fa-linkedin', '#0a66c2', 'https://linkedin.com/company/grammainstitute'],
                        ['youtube', 'fab fa-youtube', '#ff0000', 'https://youtube.com/@grammainstitute'],
                        ['tiktok', 'fab fa-tiktok', '#010101', 'https://tiktok.com/@grammainstitute'],
                        ['google_url', 'fab fa-google', '#4285f4', 'https://www.google.com/search?q=Gramma+Institute'],
                        ['wikipedia_url', 'fab fa-wikipedia-w', '#111111', 'https://en.wikipedia.org/wiki/Gramma_Institute'],
                    ] as [$field, $icon, $color, $placeholder])
                    <div class="col-md-6">
                        <label class="form-label">{{ $field === 'google_url' ? 'Google' : ($field === 'wikipedia_url' ? 'Wikipedia' : ucfirst($field)) }}</label>
                        <div class="input-group">
                            <span class="input-group-text" style="color:{{ $color }};"><i class="{{ $icon }}"></i></span>
                            <input name="{{ $field }}" type="url" class="form-control @error($field) is-invalid @enderror"
                                   value="{{ old($field, $settings->$field) }}" placeholder="{{ $placeholder }}">
                        </div>
                        @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- TAB: WHATSAPP --}}
            <div class="tab-pane fade" id="tab-whatsapp">
                <p class="text-muted small mb-3">
                    Configure o botão flutuante de WhatsApp que aparece em todas as páginas do site.
                </p>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="d-flex align-items-center gap-2 p-3"
                               style="border:2px solid #25d366; border-radius:10px; cursor:pointer; background:#f0fdf4;">
                            <input type="checkbox" name="whatsapp_ativo" value="1"
                                   {{ old('whatsapp_ativo', $settings->whatsapp_ativo) ? 'checked' : '' }}
                                   style="width:18px; height:18px;">
                            <span class="fw-bold" style="color:#15803d;">
                                <i class="fab fa-whatsapp me-1"></i>
                                Activar botão flutuante de WhatsApp no site
                            </span>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Número do WhatsApp <small>(com código do país, ex.: +5511999998888)</small></label>
                        <div class="input-group">
                            <span class="input-group-text" style="color:#25d366;"><i class="fab fa-whatsapp"></i></span>
                            <input name="whatsapp" type="text" class="form-control"
                                   value="{{ old('whatsapp', $settings->whatsapp) }}" placeholder="+55 11 9 9999-9999">
                        </div>
                        <small class="text-muted">Mesmo campo do separador Contacto.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Posição no ecrã</label>
                        <select name="whatsapp_posicao" class="form-control">
                            <option value="right" {{ old('whatsapp_posicao', $settings->whatsapp_posicao ?? 'right') === 'right' ? 'selected' : '' }}>Canto inferior direito</option>
                            <option value="left"  {{ old('whatsapp_posicao', $settings->whatsapp_posicao ?? 'right') === 'left'  ? 'selected' : '' }}>Canto inferior esquerdo</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Título do widget</label>
                        <input name="whatsapp_titulo_widget" type="text" class="form-control"
                               value="{{ old('whatsapp_titulo_widget', $settings->whatsapp_titulo_widget) }}"
                               placeholder="Fale connosco">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Subtítulo do widget</label>
                        <input name="whatsapp_subtitulo_widget" type="text" class="form-control"
                               value="{{ old('whatsapp_subtitulo_widget', $settings->whatsapp_subtitulo_widget) }}"
                               placeholder="Respondemos em poucos minutos">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nome do atendente</label>
                        <input name="whatsapp_atendente_nome" type="text" class="form-control"
                               value="{{ old('whatsapp_atendente_nome', $settings->whatsapp_atendente_nome) }}"
                               placeholder="Equipa Gramma">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cargo / função do atendente</label>
                        <input name="whatsapp_atendente_cargo" type="text" class="form-control"
                               value="{{ old('whatsapp_atendente_cargo', $settings->whatsapp_atendente_cargo) }}"
                               placeholder="Aconselhamento de cursos">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Cor do botão</label>
                        <input name="whatsapp_cor" type="color" class="form-control form-control-color" style="width:100%;"
                               value="{{ old('whatsapp_cor', $settings->whatsapp_cor ?? '#25d366') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Mensagem inicial enviada ao clicar</label>
                        <textarea name="whatsapp_mensagem_padrao" class="form-control" rows="3"
                                  placeholder="Olá! Gostaria de saber mais sobre os cursos do Gramma Institute.">{{ old('whatsapp_mensagem_padrao', $settings->whatsapp_mensagem_padrao) }}</textarea>
                        <small class="text-muted">Esta mensagem será pré-preenchida no WhatsApp do visitante.</small>
                    </div>
                </div>
            </div>

            {{-- TAB: FOUNDER --}}
            <div class="tab-pane fade" id="tab-founder">
                <p class="text-muted small mb-3">
                    Dados do fundador/diretor que aparecem na página inicial e na página dedicada <code>/founder</code>.
                </p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome do Fundador</label>
                        <input name="founder_nome" type="text" class="form-control"
                               value="{{ old('founder_nome', $settings->founder_nome) }}" placeholder="Prof. Aléxios Konstantínou">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cargo / Título</label>
                        <input name="founder_titulo" type="text" class="form-control"
                               value="{{ old('founder_titulo', $settings->founder_titulo) }}" placeholder="Fundador e Diretor Académico">
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Foto do Fundador <small>(JPG/PNG/WebP, máx. 4MB)</small></label>
                        <input name="founder_foto" type="file" class="form-control" accept="image/*">
                        <small class="text-muted">A foto aparece dentro de uma moldura oval clássica com glifos de língua à volta.</small>
                    </div>
                    <div class="col-md-4">
                        @if($settings->founder_foto)
                            <img src="{{ Storage::url($settings->founder_foto) }}" class="img-preview" style="max-height: 120px; border-radius: 50%;">
                        @endif
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Assinatura (imagem PNG transparente) <small>opcional</small></label>
                        <input name="founder_assinatura" type="file" class="form-control" accept=".png,.svg,.webp">
                    </div>
                    <div class="col-md-4">
                        @if($settings->founder_assinatura)
                            <img src="{{ Storage::url($settings->founder_assinatura) }}" class="img-preview">
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="form-label">Citação Curta <small>(aparece em destaque no site)</small></label>
                        <textarea name="founder_citacao_curta" maxlength="280" class="form-control" rows="2"
                                  placeholder="Cada língua é uma janela. Estudá-la é abrir uma porta para o mundo que a moldou.">{{ old('founder_citacao_curta', $settings->founder_citacao_curta) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Biografia curta <small>(2-4 frases)</small></label>
                        <textarea name="founder_bio" class="form-control" rows="4"
                                  placeholder="Filólogo formado pela Universidade de Atenas...">{{ old('founder_bio', $settings->founder_bio) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Carta aos visitantes <small>(texto completo, separe parágrafos com linha em branco)</small></label>
                        <textarea name="founder_carta" class="form-control" rows="10"
                                  style="font-family: Georgia, serif; line-height: 1.6;"
                                  placeholder="Caro visitante, ...">{{ old('founder_carta', $settings->founder_carta) }}</textarea>
                        <small class="text-muted">Se ficar vazia, mostramos um texto padrão sugerido.</small>
                    </div>

                    <hr class="my-3">

                    <div class="col-12">
                        <h6 class="mb-2"><i class="fas fa-share-alt me-2"></i>Redes Sociais Pessoais</h6>
                    </div>
                    @foreach([
                        ['founder_linkedin',  'fab fa-linkedin',   '#0a66c2', 'LinkedIn',  'https://linkedin.com/in/...'],
                        ['founder_instagram', 'fab fa-instagram',  '#e1306c', 'Instagram', 'https://instagram.com/...'],
                        ['founder_facebook',  'fab fa-facebook',   '#1877f2', 'Facebook',  'https://facebook.com/...'],
                        ['founder_twitter',   'fab fa-x-twitter',  '#000',    'X (Twitter)','https://x.com/...'],
                        ['founder_youtube',   'fab fa-youtube',    '#ff0000', 'YouTube',   'https://youtube.com/@...'],
                        ['founder_email',     'fas fa-envelope',   '#555',    'Email',     'pessoal@dominio.com'],
                    ] as [$field, $icon, $color, $label, $placeholder])
                    <div class="col-md-6">
                        <label class="form-label">{{ $label }}</label>
                        <div class="input-group">
                            <span class="input-group-text" style="color:{{ $color }};"><i class="{{ $icon }}"></i></span>
                            <input name="{{ $field }}" type="{{ $field === 'founder_email' ? 'email' : 'url' }}" class="form-control"
                                   value="{{ old($field, $settings->$field) }}" placeholder="{{ $placeholder }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- TAB: HERO --}}
            <div class="tab-pane fade" id="tab-hero">
                <p class="text-muted small mb-3">Escolha como o bloco principal (hero) do site vai aparecer.</p>
                <input type="hidden" name="hero_tipo" id="hero_tipo_input" value="{{ old('hero_tipo', $settings->hero_tipo ?? 'imagem') }}">
                <div class="row g-2 mb-4">
                    @foreach(['imagem' => ['fas fa-image', 'Imagem Estática'], 'slides' => ['fas fa-images', 'Carrossel de Slides'], 'video' => ['fas fa-video', 'Vídeo de Fundo']] as $tipo => [$ico, $lbl])
                    <div class="col-4">
                        <div class="hero-type-card {{ (old('hero_tipo', $settings->hero_tipo ?? 'imagem')) === $tipo ? 'selected' : '' }}"
                             onclick="selectHeroType('{{ $tipo }}', this)">
                            <div class="hicon"><i class="{{ $ico }}" style="color:#1a3a5c;"></i></div>
                            <div class="hlabel">{{ $lbl }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="hp-imagem" class="hero-panel {{ (old('hero_tipo', $settings->hero_tipo ?? 'imagem')) === 'imagem' ? 'active' : '' }}">
                    <label class="form-label">Imagem do Hero <small>(JPG/PNG/WebP, máx. 4MB)</small></label>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <input name="imagem_hero" type="file" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            @if($settings->imagem_hero)
                                <img src="{{ Storage::url($settings->imagem_hero) }}" class="img-preview">
                            @endif
                        </div>
                    </div>
                </div>

                <div id="hp-slides" class="hero-panel {{ (old('hero_tipo', $settings->hero_tipo ?? 'imagem')) === 'slides' ? 'active' : '' }}">
                    <div class="alert mb-0" style="background:#eef3ff; border:1px solid #c7d7f5; border-radius:10px; color:#1a3a5c;">
                        <i class="fas fa-info-circle me-2"></i>
                        Com o tipo <strong>Slides</strong>, gerencie as imagens e textos em
                        <a href="{{ route('admin.hero-slides.index') }}" style="color:#1a3a5c; font-weight:700;">Conteúdo → Hero Slides</a>.
                        <br><small>Actualmente: <strong>{{ \App\Models\HeroSlide::count() }}</strong> slide(s) criados.</small>
                    </div>
                </div>

                <div id="hp-video" class="hero-panel {{ (old('hero_tipo', $settings->hero_tipo ?? 'imagem')) === 'video' ? 'active' : '' }}">
                    <label class="form-label">Vídeo do Hero <small>(MP4/WebM, máx. 50MB)</small></label>
                    <input name="hero_video" type="file" class="form-control" accept="video/mp4,video/webm,video/ogg">
                    @if($settings->hero_video)
                        <div class="mt-2">
                            <small class="text-success"><i class="fas fa-check-circle me-1"></i>Actual: {{ basename($settings->hero_video) }}</small>
                        </div>
                    @endif
                    <p class="text-muted small mt-2">O vídeo tocará automaticamente, silencioso e em loop.</p>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-tipografia">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="alert alert-dark mb-0" style="border-radius:12px;">
                            Configure a tipografia global do site. Estas opcoes controlam fonte e tamanho da navegacao, dos cursos, do hero, dos titulos e do rodape.
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Fonte geral do site</label>
                        <select name="font_body_family" class="form-control">
                            @foreach($fontOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('font_body_family', $settings->font_body_family ?? 'didot') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fonte dos titulos</label>
                        <select name="font_display_family" class="form-control">
                            @foreach($fontOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('font_display_family', $settings->font_display_family ?? 'bodoni') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fonte do menu</label>
                        <select name="font_menu_family" class="form-control">
                            @foreach($fontOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('font_menu_family', $settings->font_menu_family ?? 'didot') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fonte dos cursos</label>
                        <select name="font_course_family" class="form-control">
                            @foreach($fontOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('font_course_family', $settings->font_course_family ?? 'cinzel') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fonte do rodape</label>
                        <select name="font_footer_family" class="form-control">
                            @foreach($fontOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('font_footer_family', $settings->font_footer_family ?? 'didot') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tamanho base</label>
                        <input name="font_body_size" type="number" min="14" max="24" class="form-control"
                               value="{{ old('font_body_size', $settings->font_body_size ?? 18) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tamanho do menu</label>
                        <input name="font_menu_size" type="number" min="12" max="28" class="form-control"
                               value="{{ old('font_menu_size', $settings->font_menu_size ?? 14) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tamanho dos cursos</label>
                        <input name="font_course_size" type="number" min="16" max="48" class="form-control"
                               value="{{ old('font_course_size', $settings->font_course_size ?? 22) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tamanho dos titulos</label>
                        <input name="font_title_size" type="number" min="24" max="72" class="form-control"
                               value="{{ old('font_title_size', $settings->font_title_size ?? 38) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tamanho do rodape</label>
                        <input name="font_footer_size" type="number" min="12" max="24" class="form-control"
                               value="{{ old('font_footer_size', $settings->font_footer_size ?? 16) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tamanho do texto inicial do hero</label>
                        <input name="font_hero_intro_size" type="number" min="28" max="120" class="form-control"
                               value="{{ old('font_hero_intro_size', $settings->font_hero_intro_size ?? 70) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tamanho do texto dos videos</label>
                        <input name="font_hero_slide_size" type="number" min="24" max="120" class="form-control"
                               value="{{ old('font_hero_slide_size', $settings->font_hero_slide_size ?? 64) }}">
                    </div>
                </div>
            </div>

            {{-- TAB: RODAPÉ --}}
            <div class="tab-pane fade" id="tab-rodape">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Texto do rodapé (copyright)</label>
                        <input name="texto_rodape" type="text" class="form-control"
                               value="{{ old('texto_rodape', $settings->texto_rodape) }}"
                               placeholder="© {{ date('Y') }} Gramma Institute. Todos os direitos reservados.">
                        <small class="text-muted">Linha de baixo do rodapé. Deixe vazio para usar o copyright automático.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tagline da marca</label>
                        <input name="footer_tagline_text" type="text" class="form-control"
                               value="{{ old('footer_tagline_text', $settings->footer_tagline_text) }}"
                               placeholder="languages - education - research">
                        <small class="text-muted">Frase pequena por baixo do logótipo. Vazio = "languages - education - research".</small>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label">Texto do crédito</label>
                        <input name="footer_credit_text" type="text" class="form-control"
                               value="{{ old('footer_credit_text', $settings->footer_credit_text) }}"
                               placeholder="Designed &amp; coded by Alexandre Cristóvão">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Link do crédito (URL)</label>
                        <input name="footer_credit_url" type="text" class="form-control"
                               value="{{ old('footer_credit_url', $settings->footer_credit_url) }}"
                               placeholder="https://www.linkedin.com/in/...">
                    </div>
                    <div class="col-12">
                        <div class="alert mb-0" style="background:#eef3ff;border:1px solid #c7d7f5;border-radius:8px;font-size:.82rem;color:#1a3a5c;">
                            <i class="fas fa-envelope me-1"></i> O <strong>email em destaque</strong> do rodapé vem do campo "Email Institucional" —
                            <a href="#tab-contato" onclick="document.querySelector('a[href=\'#tab-contato\']').click(); return false;" style="text-decoration:underline;color:#1a3a5c;font-weight:600;">editar em Contacto</a>.
                        </div>
                    </div>

                    <div class="col-12"><hr class="my-1"><strong>Altura do rodapé</strong></div>
                    <div class="col-md-6">
                        <label class="form-label">Espaço no topo (px)</label>
                        <input name="footer_padding_top" type="number" min="0" max="200" class="form-control"
                               value="{{ old('footer_padding_top', $settings->footer_padding_top ?? 44) }}">
                        <small class="text-muted">Menor = rodapé mais baixo.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Espaço em baixo (px)</label>
                        <input name="footer_padding_bottom" type="number" min="0" max="200" class="form-control"
                               value="{{ old('footer_padding_bottom', $settings->footer_padding_bottom ?? 20) }}">
                    </div>

                    <div class="col-12"><hr class="my-1"><strong>Tamanho de cada texto (px)</strong></div>
                    <div class="col-md-3">
                        <label class="form-label">Email (destaque)</label>
                        <input name="footer_email_size" type="number" min="10" max="40" class="form-control"
                               value="{{ old('footer_email_size', $settings->footer_email_size ?? 16) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Crédito (Alexandre)</label>
                        <input name="footer_credit_size" type="number" min="10" max="40" class="form-control"
                               value="{{ old('footer_credit_size', $settings->footer_credit_size ?? 16) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Copyright</label>
                        <input name="footer_copyright_size" type="number" min="10" max="40" class="form-control"
                               value="{{ old('footer_copyright_size', $settings->footer_copyright_size ?? 15) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tagline da marca</label>
                        <input name="footer_tagline_size" type="number" min="8" max="40" class="form-control"
                               value="{{ old('footer_tagline_size', $settings->footer_tagline_size ?? 13) }}">
                    </div>

                    <div class="col-12">
                        <small class="text-muted"><i class="fas fa-info-circle"></i> A <strong>fonte</strong> do rodapé está no separador <strong>Tipografia</strong>.</small>
                    </div>
                </div>
            </div>

            {{-- TAB: IDIOMAS --}}
            <div class="tab-pane fade" id="tab-idiomas">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Idioma Padrão do Site</label>
                        <select name="idioma_padrao" class="form-control">
                            @foreach(['pt_BR' => '🇧🇷 Português (Brasil)', 'en' => '🇬🇧 English', 'es' => '🇪🇸 Español', 'he' => '🇮🇱 עברית', 'el' => '🇬🇷 Ελληνικά'] as $code => $label)
                                <option value="{{ $code }}" {{ ($settings->idioma_padrao ?? 'pt_BR') === $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Idiomas Activos</label>
                        <div class="row g-2 mt-1">
                            @foreach(['pt_BR' => ['🇧🇷', 'Português (Brasil)'], 'en' => ['🇬🇧', 'English'], 'es' => ['🇪🇸', 'Español'], 'he' => ['🇮🇱', 'עברית (RTL)'], 'el' => ['🇬🇷', 'Ελληνικά']] as $code => [$flag, $name])
                            <div class="col-6 col-md-4">
                                <label class="d-flex align-items-center gap-2 p-2" style="border:1px solid #e5e7eb; border-radius:8px; cursor:pointer;">
                                    <input type="checkbox" name="idiomas_activos[]" value="{{ $code }}"
                                           {{ in_array($code, $settings->idiomas_activos ?? []) ? 'checked' : '' }}>
                                    <span>{{ $flag }} {{ $name }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-info py-2 mb-0" style="font-size:.85rem;">
                            <i class="fas fa-info-circle me-1"></i>
                            Para editar as traduções de cada idioma, vá a
                            <a href="{{ route('admin.languages.index') }}">Idiomas & Traduções</a>.
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB: SEO --}}
            <div class="tab-pane fade" id="tab-seo">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Meta Title <small>(máx. 160 caracteres)</small></label>
                        <input name="meta_title" type="text" maxlength="160" class="form-control"
                               value="{{ old('meta_title', $settings->meta_title) }}"
                               placeholder="Gramma Institute — Instituto Internacional de Línguas">
                        <div class="form-text">Recomendado: 50–60 caracteres.</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description <small>(máx. 320 caracteres)</small></label>
                        <textarea name="meta_description" class="form-control" rows="3" maxlength="320"
                                  placeholder="Aprenda idiomas com o Gramma Institute...">{{ old('meta_description', $settings->meta_description) }}</textarea>
                        <div class="form-text">Recomendado: 120–160 caracteres.</div>
                    </div>
                </div>
            </div>

            {{-- TAB: SMTP --}}
            <div class="tab-pane fade" id="tab-smtp">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <p class="text-muted small mb-0">Configure o servidor de email para envio de mensagens do site.</p>
                    <a href="{{ route('admin.email-test.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-paper-plane me-1"></i>Testar Email
                    </a>
                </div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Host SMTP</label>
                        <input name="smtp_host" type="text" class="form-control"
                               value="{{ old('smtp_host', $settings->smtp_host) }}" placeholder="smtp.gmail.com">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Porta</label>
                        <input name="smtp_port" type="number" class="form-control"
                               value="{{ old('smtp_port', $settings->smtp_port ?? 587) }}" placeholder="587">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Utilizador / Email</label>
                        <input name="smtp_username" type="text" class="form-control"
                               value="{{ old('smtp_username', $settings->smtp_username) }}" placeholder="noreply@grammainstitute.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Senha SMTP <small>(deixe em branco para manter)</small></label>
                        <input name="smtp_password" type="password" class="form-control" autocomplete="new-password"
                               placeholder="••••••••">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Encriptação</label>
                        <select name="smtp_encryption" class="form-control">
                            <option value="tls" {{ ($settings->smtp_encryption ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ ($settings->smtp_encryption ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="starttls" {{ ($settings->smtp_encryption ?? '') === 'starttls' ? 'selected' : '' }}>STARTTLS</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email "De:" (From)</label>
                        <input name="smtp_from_address" type="email" class="form-control"
                               value="{{ old('smtp_from_address', $settings->smtp_from_address) }}" placeholder="noreply@grammainstitute.com">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nome "De:" (From Name)</label>
                        <input name="smtp_from_name" type="text" class="form-control"
                               value="{{ old('smtp_from_name', $settings->smtp_from_name) }}" placeholder="Gramma Institute">
                    </div>
                </div>
            </div>

            {{-- TAB: MÍDIA --}}
            <div class="tab-pane fade" id="tab-midia">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Logo do Site (cabeçalho) <small>(PNG/SVG/WebP, máx. 2MB)</small></label>
                        <input name="logo" type="file" class="form-control" accept="image/*">
                        @if($settings->logo)
                            <div class="mt-2 d-flex align-items-center gap-3 p-2" style="background:#fafafa;border-radius:8px;">
                                <img src="{{ Storage::url($settings->logo) }}" class="img-preview" alt="Logo" style="max-height:60px;">
                                <div class="small text-muted">{{ basename($settings->logo) }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Logo do Rodapé (versão escura/preta)
                            <small>(opcional, para mostrar sobre fundo ink — PNG/SVG, máx. 2MB)</small></label>
                        <input name="logo_rodape" type="file" class="form-control" accept="image/*">
                        @if($settings->logo_rodape)
                            <div class="mt-2 d-flex align-items-center gap-3 p-2" style="background:#1a1612;border-radius:8px;">
                                <img src="{{ Storage::url($settings->logo_rodape) }}" alt="Logo rodapé"
                                     style="max-height:60px; filter: brightness(0) invert(1);">
                                <div class="small" style="color:#c8a44b;">{{ basename($settings->logo_rodape) }}</div>
                            </div>
                        @endif
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-info-circle me-1"></i> Se não definir, o rodapé usará o logo do cabeçalho.
                            Será automaticamente invertido para aparecer claro sobre o fundo escuro.
                        </small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Favicon <small>(ICO ou PNG 32×32, máx. 512KB)</small></label>
                        <input name="favicon" type="file" class="form-control" accept=".ico,.png">
                        @if($settings->favicon)
                            <div class="mt-2">
                                <img src="{{ Storage::url($settings->favicon) }}" class="img-preview" style="max-height:40px;" alt="Favicon">
                                <div class="mt-1 small text-muted">{{ basename($settings->favicon) }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>{{-- /tab-content --}}
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2" style="background:#fafafa; border-radius:0 0 14px 14px;">
        <small class="text-muted">
            <i class="fas fa-clock me-1"></i>
            Última atualização: {{ $settings->updated_at ? $settings->updated_at->format('d/m/Y \à\s H:i') : 'Nunca' }}
        </small>
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-2"></i>Guardar Configurações
        </button>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
function selectHeroType(tipo, el) {
    document.getElementById('hero_tipo_input').value = tipo;
    document.querySelectorAll('.hero-type-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    ['imagem','slides','video'].forEach(function(t) {
        var p = document.getElementById('hp-' + t);
        if (p) p.classList.toggle('active', t === tipo);
    });
}
</script>
@endpush
