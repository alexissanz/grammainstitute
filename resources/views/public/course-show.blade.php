@extends('layouts.public')

@section('meta-title', $course->t('meta_title') ?: $course->t('nome') . ' — ' . ($settings->nome_site ?? 'Gramma Institute'))
@section('meta-description', $course->t('meta_description') ?: $course->t('descricao_curta'))

@push('styles')
<style>
    .c-hero {
        position: relative;
        min-height: 70vh;
        display: flex;
        align-items: flex-end;
        background: var(--ink);
        color: var(--ivory);
        padding: 6rem 0 4rem;
        overflow: hidden;
    }
    .c-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        background-image: linear-gradient(180deg, rgba(26,22,18,.55) 0%, rgba(26,22,18,.92) 80%), var(--bg-image);
        filter: contrast(1.04);
    }
    .c-hero .container { position: relative; z-index: 1; }
    .c-hero .back-link {
        font-family: 'Cormorant SC', serif;
        font-size: .8rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--gold-light);
        text-decoration: none;
        margin-bottom: 1.5rem;
        display: inline-block;
    }
    .c-hero .back-link:hover { color: var(--ivory); }
    .c-hero .glifo {
        font-family: 'Cinzel', serif;
        font-size: clamp(4rem, 12vw, 8rem);
        line-height: 1;
        color: var(--accent-color, var(--gold-light));
        font-weight: 700;
        margin-bottom: 1rem;
        display: inline-block;
        border-bottom: 2px solid var(--accent-color, var(--gold-light));
        padding-bottom: .3rem;
    }
    .c-hero h1 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(2.2rem, 5vw, 4rem);
        line-height: 1.08;
        letter-spacing: .015em;
        color: var(--ivory);
        margin-bottom: 1rem;
    }
    .c-hero .subtitle {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: clamp(1.2rem, 2vw, 1.6rem);
        color: rgba(250,246,236,.86);
        max-width: 720px;
    }
    .c-hero .meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(250,246,236,.15);
    }
    .c-hero .meta-item .label {
        font-family: 'Cormorant SC', serif;
        font-size: .7rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: rgba(250,246,236,.55);
        margin-bottom: .25rem;
    }
    .c-hero .meta-item .value {
        font-family: 'Cinzel', serif;
        font-size: 1rem;
        font-weight: 500;
        letter-spacing: .08em;
        color: var(--gold-light);
    }

    .c-section { padding: 5rem 0; }
    .c-section.alt { background: var(--parchment); }
    .c-section.ivory { background: var(--ivory); }
    .c-section h2 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(1.8rem, 3.2vw, 2.5rem);
        color: var(--ink);
        letter-spacing: .015em;
        margin-bottom: 1.5rem;
    }
    .c-section .eyebrow-c {
        font-family: 'Cormorant SC', serif;
        font-size: .8rem;
        font-weight: 600;
        letter-spacing: .32em;
        text-transform: uppercase;
        color: var(--bronze-dark);
        margin-bottom: .5rem;
    }
    .c-section p, .c-section li {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.18rem;
        line-height: 1.8;
        color: var(--ink-soft);
    }

    .pillar-text::first-letter {
        font-family: 'Cinzel', serif;
        font-size: 3.5rem;
        float: left;
        line-height: .9;
        padding-right: .65rem;
        padding-top: .3rem;
        color: var(--bronze-dark);
    }
    [dir="rtl"] .pillar-text::first-letter { float: right; padding-right: 0; padding-left: .65rem; }

    .learn-list { list-style: none; padding-left: 0; }
    .learn-list li {
        padding: 1rem 1rem 1rem 2.2rem;
        border-bottom: 1px solid var(--line);
        position: relative;
    }
    .learn-list li::before {
        content: '⌘';
        position: absolute;
        left: 0; top: 1rem;
        font-family: 'Cinzel', serif;
        color: var(--bronze);
        font-size: 1.1rem;
    }
    [dir="rtl"] .learn-list li { padding-left: 1rem; padding-right: 2.2rem; }
    [dir="rtl"] .learn-list li::before { left: auto; right: 0; }

    .level-card {
        background: #fff;
        padding: 2rem;
        height: 100%;
        border-top: 3px solid var(--accent-color, var(--bronze));
        box-shadow: 0 4px 22px rgba(26,22,18,.07);
    }
    .level-card .level-num {
        font-family: 'Cinzel', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--accent-color, var(--bronze-dark));
        line-height: 1;
        margin-bottom: .25rem;
    }
    .level-card .level-name {
        font-family: 'Cinzel', serif;
        font-size: 1.1rem;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--ink);
        margin-bottom: 1rem;
    }
    .level-card .level-duration {
        font-family: 'Cormorant SC', serif;
        font-size: .75rem;
        letter-spacing: .25em;
        color: var(--stone);
        text-transform: uppercase;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--line);
    }

    /* Teacher card */
    .teacher-block {
        background: var(--ink);
        color: var(--ivory);
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }
    .teacher-block::before {
        content: '';
        position: absolute;
        top: 50%; right: -10%;
        transform: translateY(-50%);
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(200,164,75,.08), transparent 60%);
        pointer-events: none;
    }
    .teacher-block .container { position: relative; z-index: 1; }
    .teacher-photo {
        width: 280px; height: 280px;
        border-radius: 50%;
        border: 2px solid var(--gold-light);
        padding: 8px;
        background: var(--ink);
        margin: 0 auto;
    }
    .teacher-photo img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .teacher-block h3 {
        font-family: 'Cinzel', serif;
        font-weight: 500;
        font-size: clamp(1.6rem, 3vw, 2.3rem);
        letter-spacing: .02em;
        color: var(--ivory);
        margin-bottom: .5rem;
    }
    .teacher-block .teacher-title {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.15rem;
        color: var(--gold-light);
        margin-bottom: 1.5rem;
    }
    .teacher-block p {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        line-height: 1.75;
        color: rgba(250,246,236,.82);
    }

    /* Contact CTA */
    .course-contact {
        background: var(--parchment);
        padding: 5rem 0;
    }
    .course-contact .panel {
        background: #fff;
        border: 1px solid var(--line);
        padding: 3rem 2.5rem;
        position: relative;
    }
    .course-contact .panel::before,
    .course-contact .panel::after {
        content: '';
        position: absolute;
        width: 12px; height: 12px;
        border: 1.5px solid var(--bronze);
    }
    .course-contact .panel::before { top: -6px; left: -6px; border-right: 0; border-bottom: 0; }
    .course-contact .panel::after  { bottom: -6px; right: -6px; border-left: 0; border-top: 0; }
    .course-contact .contact-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--line);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        color: var(--ink);
    }
    .course-contact .contact-item:last-child { border-bottom: 0; }
    .course-contact .contact-item i {
        width: 38px; height: 38px;
        background: var(--ink);
        color: var(--gold-light);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Related */
    .related-courses { background: var(--ivory); padding: 5rem 0; }
    .related-card {
        background: #fff;
        height: 100%;
        border-top: 3px solid var(--bronze);
        padding: 2rem;
        text-decoration: none;
        display: block;
        transition: transform .25s, box-shadow .25s;
        color: var(--ink);
    }
    .related-card:hover { transform: translateY(-4px); box-shadow: 0 14px 40px rgba(26,22,18,.1); }
    .related-card .glyph {
        font-family: 'Cinzel', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--bronze-dark);
        line-height: 1;
        margin-bottom: 1rem;
    }
    .related-card .title {
        font-family: 'Cinzel', serif;
        font-size: 1rem;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: .5rem;
    }
    .related-card .sub {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        font-size: 1rem;
    }

    @media (max-width: 767px) {
        .c-hero { min-height: auto; padding: 4rem 0 3rem; }
        .c-hero .meta-row { gap: 1.2rem; }
        .c-section { padding: 3rem 0; }
        .pillar-text::first-letter { font-size: 2.5rem; }
        .teacher-photo { width: 200px; height: 200px; margin-bottom: 2rem; }
        .course-contact .panel { padding: 2rem 1.5rem; }
    }
</style>
@endpush

@section('content')

@php
    $bgImg = $course->imagemFundoUrl() ?: $course->imagemCapaUrl() ?: 'https://images.unsplash.com/photo-1518780664697-55e3ad937233?auto=format&fit=crop&w=2400&q=85';
@endphp

<section class="c-hero" style="--bg-image: url('{{ $bgImg }}'); --accent-color: {{ $course->cor_destaque }};">
    <div class="container">
        <a href="{{ route('courses') }}" class="back-link">← {{ __('site.course_back') }}</a>
        <div class="row">
            <div class="col-lg-10">
                <div class="glifo" style="color: {{ $course->cor_destaque }}; border-color: {{ $course->cor_destaque }};">{{ $course->glifo }}</div>
                <h1>{{ $course->t('nome') }}</h1>
                @if($course->t('subtitulo'))
                    <p class="subtitle">{{ $course->t('subtitulo') }}</p>
                @endif

                <div class="meta-row">
                    @if($course->duracao_total)
                        <div class="meta-item">
                            <div class="label">{{ __('site.course_duration') }}</div>
                            <div class="value">{{ $course->duracao_total }}</div>
                        </div>
                    @endif
                    @if($course->formato)
                        <div class="meta-item">
                            <div class="label">{{ __('site.course_format') }}</div>
                            <div class="value">{{ $course->formato }}</div>
                        </div>
                    @endif
                    @if($course->preco)
                        <div class="meta-item">
                            <div class="label">{{ __('site.course_price') }}</div>
                            <div class="value">{{ $course->preco }}</div>
                        </div>
                    @endif
                    @if($course->vagas_por_turma)
                        <div class="meta-item">
                            <div class="label">{{ __('site.course_size') }}</div>
                            <div class="value">{{ $course->vagas_por_turma }} alunos</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- About --}}
@if($course->t('descricao_longa'))
<section class="c-section ivory">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="eyebrow-c">{{ __('site.course_about') }}</div>
                <h2>{{ __('site.course_about') }}</h2>
                <div class="ornament" style="margin: 1rem 0 2rem;"><i class="fas fa-feather"></i></div>
                <p class="pillar-text">{{ $course->t('descricao_longa') }}</p>
            </div>
        </div>
    </div>
</section>
@endif

{{-- History --}}
@if($course->t('historia_lingua'))
<section class="c-section alt">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="eyebrow-c">{{ __('site.course_history') }}</div>
                <h2>{{ __('site.course_history') }}</h2>
                <div class="ornament" style="margin: 1rem 0 2rem;"><i class="fas fa-scroll"></i></div>
                <p>{{ $course->t('historia_lingua') }}</p>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Alphabet + For whom --}}
@if($course->t('alfabeto_info') || $course->t('para_quem'))
<section class="c-section ivory">
    <div class="container">
        <div class="row g-5">
            @if($course->t('alfabeto_info'))
                <div class="col-lg-6">
                    <div class="eyebrow-c">{{ __('site.course_alphabet') }}</div>
                    <h2>{{ __('site.course_alphabet') }}</h2>
                    <p>{{ $course->t('alfabeto_info') }}</p>
                </div>
            @endif
            @if($course->t('para_quem'))
                <div class="col-lg-6">
                    <div class="eyebrow-c">{{ __('site.course_for_whom') }}</div>
                    <h2>{{ __('site.course_for_whom') }}</h2>
                    <p>{{ $course->t('para_quem') }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- What you learn --}}
@if(count($course->tArray('o_que_aprende')))
<section class="c-section alt">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="eyebrow-c">{{ __('site.course_what_you_learn') }}</div>
                <h2>{{ __('site.course_what_you_learn') }}</h2>
                <div class="ornament" style="margin: 1rem 0 2rem;"><i class="fas fa-quote-right"></i></div>
                <ul class="learn-list">
                    @foreach($course->tArray('o_que_aprende') as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Levels --}}
@if(is_array($course->niveis) && count($course->niveis))
<section class="c-section ivory">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow-c">{{ __('site.course_levels') }}</div>
            <h2>{{ __('site.course_levels') }}</h2>
            <div class="ornament"><i class="fas fa-layer-group"></i></div>
        </div>
        <div class="row g-4">
            @foreach($course->niveis as $i => $nivel)
                <div class="col-md-4">
                    <div class="level-card" style="--accent-color: {{ $course->cor_destaque }};">
                        <div class="level-num">{{ $i + 1 }}</div>
                        <div class="level-name">
                            {{ $nivel['nome'][app()->getLocale()] ?? $nivel['nome']['pt_BR'] ?? $nivel['nome']['en'] ?? '' }}
                        </div>
                        <p>{{ $nivel['descricao'][app()->getLocale()] ?? $nivel['descricao']['pt_BR'] ?? $nivel['descricao']['en'] ?? '' }}</p>
                        @if(!empty($nivel['duracao']))
                            <div class="level-duration"><i class="far fa-clock me-2"></i>{{ $nivel['duracao'] }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Teacher --}}
@if($course->professor_nome)
<section class="teacher-block">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-4 text-center">
                <div class="teacher-photo">
                    @if($course->professorFotoUrl())
                        <img src="{{ $course->professorFotoUrl() }}" alt="{{ $course->professor_nome }}">
                    @else
                        <div style="width:100%; height:100%; background: var(--ink-soft); border-radius:50%; display:flex; align-items:center; justify-content:center; color: var(--gold-light); font-family:'Cinzel',serif; font-size: 4rem;">
                            {{ mb_substr($course->professor_nome, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
                <div style="font-family:'Cormorant SC',serif; font-size:.8rem; letter-spacing:.32em; text-transform:uppercase; color: var(--gold-light); margin-bottom: .5rem;">
                    {{ __('site.course_teacher') }}
                </div>
                <h3>{{ $course->professor_nome }}</h3>
                @if($course->t('professor_titulos'))
                    <p class="teacher-title">{{ $course->t('professor_titulos') }}</p>
                @endif
                @if($course->t('professor_bio'))
                    <p>{{ $course->t('professor_bio') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- Contact / Enroll --}}
<section class="course-contact">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="eyebrow-c">{{ __('site.course_contact_title') }}</div>
                <h2 style="font-family:'Cinzel',serif; font-size: clamp(1.8rem,3.5vw,2.6rem); color: var(--ink); letter-spacing:.015em;">
                    {{ __('site.course_contact_title') }}
                </h2>
                <div class="ornament" style="margin: 1rem 0 2rem; justify-content: flex-start;"><i class="fas fa-feather"></i></div>
                <p style="font-family:'Cormorant Garamond',serif; font-size:1.2rem; line-height:1.7; color: var(--ink-soft);">
                    {{ __('site.course_contact_text') }}
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    @if($course->whatsappLink())
                        <a href="{{ $course->whatsappLink() }}" target="_blank" rel="noopener" class="btn-classical-dark">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    @endif
                    <a href="{{ route('contact') }}" class="btn-classical">{{ __('site.course_enroll') }} <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel">
                    @if($course->contato_whatsapp)
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <div>
                                <small style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.25em; text-transform:uppercase; color:var(--stone); display:block;">WhatsApp</small>
                                {{ $course->contato_whatsapp }}
                            </div>
                        </div>
                    @endif
                    @if($course->contato_email)
                        <div class="contact-item">
                            <i class="far fa-envelope"></i>
                            <div>
                                <small style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.25em; text-transform:uppercase; color:var(--stone); display:block;">Email</small>
                                {{ $course->contato_email }}
                            </div>
                        </div>
                    @endif
                    @if($course->contato_telefone)
                        <div class="contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <small style="font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.25em; text-transform:uppercase; color:var(--stone); display:block;">Telefone</small>
                                {{ $course->contato_telefone }}
                            </div>
                        </div>
                    @endif
                    @if(!$course->contato_whatsapp && !$course->contato_email && !$course->contato_telefone)
                        @if($settings->email_institucional)
                            <div class="contact-item">
                                <i class="far fa-envelope"></i>
                                <div>{{ $settings->email_institucional }}</div>
                            </div>
                        @endif
                        @if($settings->telefone)
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <div>{{ $settings->telefone }}</div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related --}}
@if($related->count())
<section class="related-courses">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow-c">Outros caminhos</div>
            <h2 style="font-family:'Cinzel',serif; font-size:1.8rem; color: var(--ink); letter-spacing:.015em;">Outros cursos do Gramma</h2>
        </div>
        <div class="row g-4">
            @foreach($related as $r)
                <div class="col-md-4">
                    <a href="{{ route('courses.show', $r->slug) }}" class="related-card">
                        <div class="glyph" style="color: {{ $r->cor_destaque }};">{{ $r->glifo }}</div>
                        <div class="title">{{ $r->t('nome') }}</div>
                        <div class="sub">{{ $r->t('subtitulo') }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
