@extends('layouts.public')

@section('meta-title', $course->t('meta_title') ?: $course->t('nome') . ' - ' . ($settings->nome_site ?? 'Gramma Institute'))
@section('meta-description', $course->t('meta_description') ?: $course->t('descricao_curta'))

@push('styles')
<style>
    .c-hero {
        position: relative;
        min-height: 70vh;
        background: var(--ink);
        overflow: hidden;
    }
    .c-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        background-image: var(--bg-image);
        filter: contrast(1.04);
    }

    /* Black & white model — white content background, black details/text. */
    .c-section { padding: 5rem 0; background: #fff; color: #111; }
    .c-section.alt { background: #fff; }
    .c-section.ivory { background: #fff; }
    .c-section h2 {
        font-family: var(--font-site-course);
        font-weight: 500;
        font-size: clamp(1.8rem, 3.2vw, var(--font-size-title));
        color: #111;
        letter-spacing: .015em;
        margin-bottom: 1.5rem;
    }
    .c-section .eyebrow-c,
    .c-section .ornament,
    .course-contact .eyebrow-c,
    .course-contact .ornament {
        display: none !important;
    }
    .c-section p, .c-section li {
        font-family: var(--font-site-body);
        font-size: 1.18rem;
        line-height: 1.8;
        color: rgba(0,0,0,.82);
        text-align: justify;
        text-justify: inter-word;
    }
    .course-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin: 2rem 0 2.5rem;
    }
    .course-short-description {
        font-family: var(--font-site-body);
        font-size: 1.22rem;
        line-height: 1.8;
        color: #111;
        margin-bottom: 1.5rem;
        max-width: 920px;
        text-align: justify;
        text-justify: inter-word;
    }
    .course-info-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,.18);
        padding: 1.2rem 1.25rem;
        border-radius: 20px;
    }
    .course-info-card .label {
        font-family: var(--font-site-smallcaps);
        font-size: .72rem;
        letter-spacing: .24em;
        text-transform: uppercase;
        color: rgba(0,0,0,.55);
        margin-bottom: .45rem;
    }
    .course-info-card .value {
        font-family: var(--font-site-body);
        font-size: 1.08rem;
        line-height: 1.65;
        color: #111;
        text-align: justify;
        text-justify: inter-word;
    }
    .course-info-card .value-lines {
        display: grid;
        gap: .35rem;
    }
    .course-info-card .value-line {
        display: block;
    }
    .about-course-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.6rem;
        align-items: start;
        max-width: 980px;
        margin: 0 auto;
    }
    .course-copy-shell {
        max-width: 980px;
        margin: 0 auto;
    }
    .course-copy-shell > p:first-of-type::first-letter {
        font-family: var(--font-site-course);
        font-size: 3.5rem;
        float: left;
        line-height: .9;
        padding-right: .65rem;
        padding-top: .3rem;
        color: #111;
    }
    [dir="rtl"] .course-copy-shell > p:first-of-type::first-letter {
        float: right;
        padding-right: 0;
        padding-left: .65rem;
    }
    .about-course-visual {
        position: relative;
        min-height: 360px;
        border-radius: 28px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 16px 42px rgba(0,0,0,.16);
    }
    .about-course-visual::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(180deg, rgba(0,0,0,.08) 0%, rgba(0,0,0,.42) 100%),
            var(--about-image);
        background-size: cover;
        background-position: center;
        filter: grayscale(100%);
        transform: scale(1.02);
    }

    .pillar-text::first-letter {
        font-family: var(--font-site-course);
        font-size: 3.5rem;
        float: left;
        line-height: .9;
        padding-right: .65rem;
        padding-top: .3rem;
        color: #111;
    }
    [dir="rtl"] .pillar-text::first-letter { float: right; padding-right: 0; padding-left: .65rem; }

    .learn-list { list-style: none; padding-left: 0; }
    .learn-list li {
        padding: 1rem 1rem 1rem 2.2rem;
        border-bottom: 1px solid rgba(0,0,0,.14);
        position: relative;
    }
    .learn-list li::before {
        content: '•';
        position: absolute;
        left: 0; top: 1rem;
        font-family: 'Cinzel', serif;
        color: #111;
        font-size: 1.1rem;
    }
    [dir="rtl"] .learn-list li { padding-left: 1rem; padding-right: 2.2rem; }
    [dir="rtl"] .learn-list li::before { left: auto; right: 0; }

    .level-card {
        background: #fff;
        padding: 2rem;
        height: 100%;
        border: 1px solid rgba(0,0,0,.12);
        border-top: 3px solid #111;
        box-shadow: 0 4px 22px rgba(0,0,0,.06);
        border-radius: 24px;
    }
    .level-card .level-num {
        font-family: var(--font-site-course);
        font-size: 2.5rem;
        font-weight: 700;
        color: #111;
        line-height: 1;
        margin-bottom: .25rem;
    }
    .level-card .level-name {
        font-family: var(--font-site-course);
        font-size: clamp(1rem, 2vw, var(--font-size-course));
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #111;
        margin-bottom: 1rem;
    }
    .level-card .level-duration {
        font-family: var(--font-site-smallcaps);
        font-size: .75rem;
        letter-spacing: .25em;
        color: rgba(0,0,0,.55);
        text-transform: uppercase;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(0,0,0,.14);
    }
    .level-card p {
        text-align: justify;
        text-justify: inter-word;
        hyphens: auto;
        -webkit-hyphens: auto;
        word-spacing: normal;
        text-wrap: pretty;
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
        font-family: var(--font-site-course);
        font-weight: 500;
        font-size: clamp(1.6rem, 3vw, 2.3rem);
        letter-spacing: .02em;
        color: var(--ivory);
        margin-bottom: .5rem;
    }
    .teacher-block .teacher-title {
        font-family: var(--font-site-body);
        font-style: italic;
        font-size: 1.15rem;
        color: var(--gold-light);
        margin-bottom: 1.5rem;
    }
    .teacher-block p {
        font-family: var(--font-site-body);
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
        font-family: var(--font-site-body);
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
        font-family: var(--font-site-course);
        font-size: 2rem;
        font-weight: 700;
        color: var(--bronze-dark);
        line-height: 1;
        margin-bottom: 1rem;
    }
    .related-card .title {
        font-family: var(--font-site-course);
        font-size: clamp(.95rem, 1.6vw, calc(var(--font-size-course) * 0.75));
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: .5rem;
    }
    .related-card .sub {
        font-family: var(--font-site-body);
        font-style: italic;
        color: var(--stone);
        font-size: 1rem;
    }

    @media (max-width: 767px) {
        .c-hero {
            min-height: 46vh;
            border-bottom-left-radius: 28px;
            border-bottom-right-radius: 28px;
        }
        .c-section { padding: 3rem 0; }
        .c-section h2 {
            font-size: 1.55rem;
            line-height: 1.2;
            text-align: center;
            margin-bottom: 1.2rem;
        }
        .c-section p, .c-section li {
            font-size: 1.05rem;
            line-height: 1.7;
        }
        .course-info-grid {
            grid-template-columns: 1fr;
            gap: .85rem;
            margin: 1.5rem 0 2rem;
        }
        .course-info-card {
            padding: 1rem 1rem;
            border-radius: 18px;
        }
        .about-course-grid {
            grid-template-columns: 1fr;
            gap: 1.35rem;
        }
        .about-course-visual {
            min-height: 280px;
            order: -1;
            border-radius: 22px;
        }
        .learn-list li {
            padding: .95rem .95rem .95rem 1.75rem;
        }
        .level-card {
            padding: 1.5rem 1.2rem;
            border-radius: 20px;
        }
        .pillar-text::first-letter { font-size: 2.5rem; }
        .course-copy-shell > p:first-of-type::first-letter { font-size: 2.5rem; }
        .teacher-photo { width: 200px; height: 200px; margin-bottom: 2rem; }
        .course-contact .panel { padding: 2rem 1.5rem; }
    }
    @media (max-width: 575px) {
        .c-section .col-lg-8,
        .c-section .col-lg-10,
        .c-section .offset-lg-1,
        .c-section .offset-lg-2 {
            padding-left: .35rem;
            padding-right: .35rem;
        }
        .c-hero {
            min-height: 40vh;
            border-bottom-left-radius: 22px;
            border-bottom-right-radius: 22px;
        }
        .level-card .level-name {
            font-size: 1rem;
            line-height: 1.3;
        }
    }
</style>
@endpush

@section('content')

@php
    $bgImg = $course->imagemFundoUrl() ?: $course->imagemCapaUrl() ?: 'https://images.unsplash.com/photo-1518780664697-55e3ad937233?auto=format&fit=crop&w=2400&q=85';
    $aboutImg = $course->imagemCapaUrl() ?: $bgImg;
    $durationLines = collect(preg_split('/\s*;\s*/', (string) $course->duracao_total))
        ->map(fn ($line) => trim($line))
        ->filter()
        ->values();
@endphp

<section class="c-hero" style="--bg-image: url('{{ $bgImg }}'); --accent-color: {{ $course->cor_destaque }};"></section>

{{-- About --}}
@if($course->t('descricao_longa'))
<section class="c-section ivory">
    <div class="container">
        <div class="about-course-grid">
            <div>
                @if($course->t('descricao_curta'))
                    <p class="course-short-description">{{ $course->t('descricao_curta') }}</p>
                @endif
                @if($course->duracao_total || $course->formato || $course->preco || $course->vagas_por_turma || $course->material_gratis || $course->certificacao_gratis)
                    <div class="course-info-grid">
                        @if($course->duracao_total)
                            <div class="course-info-card">
                                <div class="label">{{ __('site.course_duration') }}</div>
                                <div class="value value-lines">
                                    @foreach($durationLines as $line)
                                        <span class="value-line">{{ $line }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($course->formato)
                            <div class="course-info-card">
                                <div class="label">{{ __('site.course_format') }}</div>
                                <div class="value">{{ $course->formato }}</div>
                            </div>
                        @endif
                        @if($course->preco)
                            <div class="course-info-card">
                                <div class="label">{{ __('site.course_price') }}</div>
                                <div class="value">{{ $course->preco }}</div>
                            </div>
                        @endif
                        @if($course->vagas_por_turma)
                            <div class="course-info-card">
                                <div class="label">{{ __('site.course_size') }}</div>
                                <div class="value">{{ $course->vagas_por_turma }} students</div>
                            </div>
                        @endif
                        @if($course->material_gratis)
                            <div class="course-info-card">
                                <div class="label">Material</div>
                                <div class="value">{{ $course->material_gratis_texto ?: 'Free study material' }}</div>
                            </div>
                        @endif
                        @if($course->certificacao_gratis)
                            <div class="course-info-card">
                                <div class="label">Certificate</div>
                                <div class="value">{{ $course->certificacao_gratis_texto ?: 'Free certificate included' }}</div>
                            </div>
                        @endif
                    </div>
                @endif
                <p class="pillar-text">{{ $course->t('descricao_longa') }}</p>
            </div>
        </div>
    </div>
</section>
@endif

{{-- For whom --}}
@if($course->t('para_quem'))
<section class="c-section ivory">
    <div class="container">
        <div class="course-copy-shell">
            <p>{{ $course->t('para_quem') }}</p>
        </div>
    </div>
</section>
@endif

{{-- What you learn --}}
@if(count($course->tArray('o_que_aprende')))
<section class="c-section alt">
    <div class="container">
        <div class="course-copy-shell">
            <ul class="learn-list">
                @foreach($course->tArray('o_que_aprende') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endif

{{-- Levels --}}
@if(is_array($course->niveis) && count($course->niveis))
<section class="c-section ivory">
    <div class="container">
        <div class="course-copy-shell">
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
    </div>
</section>
@endif

@endsection


