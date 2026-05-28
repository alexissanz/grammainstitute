@extends('layouts.public')

@section('meta-title', ($settings->founder_nome ?? 'Fundador') . ' — ' . ($settings->nome_site ?? 'Gramma Institute'))

@push('styles')
<style>
    /* ========== FOUNDER HERO ========== */
    .founder-hero {
        background: var(--ink);
        color: var(--ivory);
        padding: 7rem 0 5rem;
        position: relative;
        overflow: hidden;
    }
    .founder-hero::before {
        content: 'Γράμμα';
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%,-50%);
        font-family: 'Cinzel', serif;
        font-size: clamp(10rem, 28vw, 28rem);
        color: rgba(255,255,255,.025);
        font-weight: 700;
        letter-spacing: .04em;
        pointer-events: none;
        line-height: 1;
    }
    .founder-hero .container { position: relative; z-index: 1; }

    /* OVAL PORTRAIT */
    .oval-portrait {
        position: relative;
        width: 100%;
        max-width: 360px;
        aspect-ratio: 3/4;
        margin: 0 auto;
    }
    .oval-portrait .frame {
        position: absolute;
        inset: 0;
        border: 1.5px solid var(--gold-light);
        border-radius: 50%;
        transform: scaleY(1.05);
        pointer-events: none;
    }
    .oval-portrait .frame::before,
    .oval-portrait .frame::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }
    .oval-portrait .frame::before {
        inset: -12px;
        border: 1px solid rgba(255,255,255,.35);
    }
    .oval-portrait .frame::after {
        inset: -24px;
        border: 1px dashed rgba(255,255,255,.22);
    }
    .oval-portrait .photo {
        position: absolute;
        inset: 6px;
        background: var(--ink-soft) center/cover no-repeat;
        border-radius: 50%;
        filter: sepia(.05) contrast(1.03);
    }
    .oval-portrait .glyph-tl,
    .oval-portrait .glyph-tr,
    .oval-portrait .glyph-bl,
    .oval-portrait .glyph-br {
        position: absolute;
        font-family: 'Cinzel', serif;
        color: var(--gold-light);
        font-size: 1.4rem;
        font-weight: 600;
        background: var(--ink);
        padding: .4rem .6rem;
        border: 1px solid rgba(255,255,255,.4);
        border-radius: 50%;
        width: 50px; height: 50px;
        display: flex; align-items: center; justify-content: center;
        z-index: 2;
    }
    .oval-portrait .glyph-tl { top: -2%; left: 8%; }
    .oval-portrait .glyph-tr { top: 12%; right: -4%; font-family: 'Noto Sans Hebrew', serif; }
    .oval-portrait .glyph-bl { bottom: 18%; left: -4%; }
    .oval-portrait .glyph-br { bottom: 0%; right: 8%; }
    .oval-portrait .ribbon {
        position: absolute;
        bottom: -32px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--ink);
        border: 1px solid var(--gold-light);
        color: var(--gold-light);
        padding: .55rem 1.5rem;
        font-family: 'Cormorant SC', serif;
        font-size: .72rem;
        letter-spacing: .35em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .founder-eyebrow {
        font-family: 'Cormorant SC', serif;
        font-size: .85rem;
        font-weight: 600;
        letter-spacing: .42em;
        color: var(--gold-light);
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .founder-name {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(2rem, 4.5vw, 3.4rem);
        line-height: 1.12;
        letter-spacing: .015em;
        color: var(--ivory);
        margin-bottom: .5rem;
    }
    .founder-role {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.25rem;
        color: var(--gold-light);
        margin-bottom: 2rem;
    }
    .founder-pull-quote {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: clamp(1.2rem, 2.2vw, 1.6rem);
        line-height: 1.55;
        color: rgba(255,255,255,.92);
        padding-left: 1.8rem;
        border-left: 2px solid var(--gold-light);
        margin: 2rem 0;
    }
    [dir="rtl"] .founder-pull-quote { border-left: 0; border-right: 2px solid var(--gold-light); padding-left: 0; padding-right: 1.8rem; }

    .founder-socials {
        display: flex;
        gap: .8rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }
    .founder-socials a {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        padding: .55rem 1rem;
        border: 1px solid rgba(255,255,255,.3);
        color: rgba(255,255,255,.85);
        font-family: 'Inter', sans-serif;
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all .25s;
    }
    .founder-socials a:hover {
        background: var(--gold-light);
        color: var(--ink);
        border-color: var(--gold-light);
    }
    .founder-socials a i { color: var(--gold-light); font-size: .95rem; transition: color .25s; }
    .founder-socials a:hover i { color: var(--ink); }

    /* ========== LETTER SECTION ========== */
    .founder-letter {
        background: var(--ivory);
        padding: 7rem 0;
        position: relative;
    }
    .founder-letter::before,
    .founder-letter::after {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        max-width: 720px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--bronze), transparent);
    }
    .founder-letter::before { top: 0; }
    .founder-letter::after { bottom: 0; }
    .letter-title {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(2rem, 4vw, 3rem);
        color: var(--ink);
        text-align: center;
        margin-bottom: 3rem;
        letter-spacing: .02em;
    }
    .letter-body {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        line-height: 1.85;
        color: var(--ink-soft);
        max-width: 720px;
        margin: 0 auto;
    }
    .letter-body p { margin-bottom: 1.5rem; }
    .letter-body p:first-of-type::first-letter {
        font-family: 'Cinzel', serif;
        font-size: 5.5rem;
        float: left;
        line-height: .9;
        padding-right: 1rem;
        padding-top: .55rem;
        color: var(--bronze-dark);
    }
    .letter-signature {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid var(--line);
        max-width: 720px;
        margin-left: auto;
        margin-right: auto;
    }
    .letter-signature .sig-name {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.5rem;
        color: var(--ink);
    }
    .letter-signature .sig-role {
        font-family: 'Cormorant SC', serif;
        font-size: .8rem;
        letter-spacing: .25em;
        text-transform: uppercase;
        color: var(--stone);
    }
    .letter-signature img.sig {
        max-height: 64px;
        opacity: .85;
        filter: contrast(1.2);
    }

    /* ========== ACHIEVEMENTS ROW ========== */
    .founder-trust {
        background: var(--parchment);
        padding: 5rem 0;
        border-top: 1px solid var(--line);
    }
    .trust-item {
        text-align: center;
        padding: 1rem;
    }
    .trust-item .num {
        font-family: 'Cinzel', serif;
        font-size: 3rem;
        font-weight: 700;
        color: var(--bronze-dark);
        line-height: 1;
        margin-bottom: .5rem;
    }
    .trust-item .label {
        font-family: 'Cormorant SC', serif;
        font-size: .85rem;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--ink-soft);
    }

    @media (max-width: 767px) {
        .founder-hero { padding: 4rem 0 3.5rem; text-align: center; }
        .oval-portrait { max-width: 240px; margin-bottom: 4rem; }
        .oval-portrait .glyph-tl, .oval-portrait .glyph-tr,
        .oval-portrait .glyph-bl, .oval-portrait .glyph-br {
            width: 40px; height: 40px; font-size: 1.1rem; padding: .3rem .4rem;
        }
        .founder-pull-quote { text-align: left; }
        .founder-letter { padding: 4rem 0; }
        .letter-body { font-size: 1.15rem; }
        .letter-body p:first-of-type::first-letter { font-size: 4rem; }
        .letter-signature { flex-direction: column; text-align: center; gap: .75rem; }
        .founder-socials { justify-content: center; }
    }
</style>
@endpush

@section('content')

@php
    $founder    = $settings;
    $founderImg = $settings->founder_foto
        ? Storage::url($settings->founder_foto)
        : 'https://images.unsplash.com/photo-1559548331-f9cb98001426?auto=format&fit=crop&w=900&q=85';
    $founderName = $settings->founder_nome ?: 'Prof. Aléxios Konstantínou';
    $founderRole = $settings->founder_titulo ?: 'Fundador e Diretor Académico';
    $quote = $settings->founder_citacao_curta ?: 'Cada língua é uma janela. Estudá-la é abrir uma porta para o mundo que a moldou.';
    $bio   = $settings->founder_bio;
    $carta = $settings->founder_carta ?: <<<'CARTA'
Caro visitante,

quando, há mais de vinte anos, comecei a ensinar grego clássico a um pequeno grupo de amigos numa sala emprestada de uma livraria em Lisboa, não imaginei que aquilo se tornaria uma escola. O que me movia era simples: a impaciência diante de cursos que tratavam o grego, o hebraico, o inglês, como se fossem sistemas operativos a instalar. Uma língua não se instala — habita-se. E habitá-la exige tempo, texto, e bons mestres.

O Gramma Institute nasceu dessa impaciência e dessa convicção. Recusamos a língua reduzida a fórmulas, a ginástica de exames, a app no telemóvel. Trabalhamos com filólogos formados, em turmas pequenas, com livros — sim, livros — e com a paciência de quem sabe que aprender uma língua é demorar.

Mas não somos uma escola passada. Os nossos alunos preparam-se para certificações internacionais, defendem teses, fazem negócios em Buenos Aires e leem textos em Atenas. Aprender o grego de Platão não é uma fuga do mundo: é uma forma de regressar a ele com olhos mais finos.

Convido-o a percorrer estas páginas. Veja os cursos, leia o glossário, escreva-nos. Estamos aqui há quase duas décadas porque acreditamos que vale a pena. E porque, no fim, os melhores alunos que tivemos foram aqueles que, como o leitor agora, decidiram parar um instante e olhar para a palavra.

Com amizade,
CARTA;
    $socials = [
        'linkedin'  => ['icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn',  'url' => $settings->founder_linkedin],
        'instagram' => ['icon' => 'fab fa-instagram',   'label' => 'Instagram', 'url' => $settings->founder_instagram],
        'facebook'  => ['icon' => 'fab fa-facebook-f',  'label' => 'Facebook',  'url' => $settings->founder_facebook],
        'twitter'   => ['icon' => 'fab fa-x-twitter',   'label' => 'X / Twitter','url' => $settings->founder_twitter],
        'youtube'   => ['icon' => 'fab fa-youtube',     'label' => 'YouTube',   'url' => $settings->founder_youtube],
        'email'     => ['icon' => 'far fa-envelope',    'label' => 'Email',     'url' => $settings->founder_email ? 'mailto:' . $settings->founder_email : null],
    ];
@endphp

<section class="founder-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 order-lg-2 mb-4 mb-lg-0">
                <div class="oval-portrait">
                    <span class="glyph-tl" aria-hidden="true">Γ</span>
                    <span class="glyph-tr" aria-hidden="true">א</span>
                    <span class="glyph-bl" aria-hidden="true">Λ</span>
                    <span class="glyph-br" aria-hidden="true">Α</span>
                    <div class="photo" style="background-image: url('{{ $founderImg }}');"></div>
                    <div class="frame"></div>
                    <div class="ribbon">Anno {{ now()->year }} · Director</div>
                </div>
            </div>
            <div class="col-lg-7 order-lg-1">
                <div class="founder-eyebrow">{{ __('site.founder_eyebrow') }}</div>
                <h1 class="founder-name">{{ $founderName }}</h1>
                <div class="founder-role">{{ $founderRole }}</div>

                <blockquote class="founder-pull-quote">"{{ $quote }}"</blockquote>

                @if($bio)
                    <p style="font-family:'Cormorant Garamond', serif; font-size:1.18rem; line-height:1.75; color: rgba(255,255,255,.8);">
                        {{ $bio }}
                    </p>
                @endif

                <div class="founder-socials">
                    @foreach($socials as $key => $s)
                        @if($s['url'])
                            <a href="{{ $s['url'] }}" target="_blank" rel="noopener">
                                <i class="{{ $s['icon'] }}"></i> {{ $s['label'] }}
                            </a>
                        @endif
                    @endforeach
                    @if(! collect($socials)->pluck('url')->filter()->count())
                        {{-- Placeholders so admin sees that social links plug in here --}}
                        <a href="#" style="opacity:.5; pointer-events:none;"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                        <a href="#" style="opacity:.5; pointer-events:none;"><i class="fab fa-instagram"></i> Instagram</a>
                        <a href="#" style="opacity:.5; pointer-events:none;"><i class="far fa-envelope"></i> Email</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="founder-letter">
    <div class="container">
        <h2 class="letter-title">{{ __('site.founder_letter_title') }}</h2>
        <div class="ornament" style="margin-bottom:3rem;"><i class="fas fa-feather"></i></div>

        <div class="letter-body">
            @foreach(preg_split('/\n\n+/', trim($carta)) as $paragraph)
                <p>{!! nl2br(e($paragraph)) !!}</p>
            @endforeach
        </div>

        <div class="letter-signature">
            @if($settings->founder_assinatura)
                <img src="{{ Storage::url($settings->founder_assinatura) }}" class="sig" alt="Assinatura">
            @else
                <div style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size:2.2rem; color:var(--bronze-dark); transform: rotate(-3deg);">
                    {{ $founderName }}
                </div>
            @endif
            <div>
                <div class="sig-name">{{ $founderName }}</div>
                <div class="sig-role">{{ $founderRole }}</div>
            </div>
        </div>
    </div>
</section>

<section class="founder-trust">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6 trust-item">
                <div class="num">{{ now()->year - 2008 }}</div>
                <div class="label">Anos de Ensino</div>
            </div>
            <div class="col-md-3 col-6 trust-item">
                <div class="num">5</div>
                <div class="label">Idiomas Lecionados</div>
            </div>
            <div class="col-md-3 col-6 trust-item">
                <div class="num">2.400+</div>
                <div class="label">Alunos Formados</div>
            </div>
            <div class="col-md-3 col-6 trust-item">
                <div class="num">12</div>
                <div class="label">Países Representados</div>
            </div>
        </div>
    </div>
</section>

<section class="cta-band" style="background: linear-gradient(135deg, rgba(0,0,0,.92) 0%, rgba(0,0,0,.75) 100%), url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=2400&q=85') center/cover no-repeat;">
    <div class="container">
        <div class="ornament light"><i class="fas fa-feather"></i></div>
        <h2 style="font-family:'Cinzel',serif; font-weight:500; font-size: clamp(2rem,4.5vw,3.4rem); letter-spacing:.04em; line-height:1.18; color:var(--ivory); margin-bottom:1.5rem;">
            Quer falar diretamente com a direção?
        </h2>
        <p style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size:1.25rem; color: rgba(255,255,255,.85); max-width:640px; margin:0 auto 2.5rem;">
            Aceitamos pedidos de aconselhamento académico — gratuitos e sem compromisso.
        </p>
        <div class="d-inline-flex flex-wrap gap-3 justify-content-center">
            <a href="{{ route('contact') }}" class="btn-classical">{{ __('site.contact_send') }} <i class="fas fa-arrow-right"></i></a>
            @if($settings->whatsappLink())
                <a href="{{ $settings->whatsappLink() }}" target="_blank" rel="noopener" class="btn-classical-outline">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            @endif
        </div>
    </div>
</section>

@endsection
