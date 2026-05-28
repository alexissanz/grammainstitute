@extends('layouts.public')

@section('meta-title', __('site.contact_title') . ' - ' . config('app.name'))

@push('styles')
<style>
    .contact-shell { background: linear-gradient(180deg, ffffff 0%, ffffff 100%); color: #111; padding: 5.5rem 0 6rem; }
    .contact-shell .eyebrow {
        font-family: var(--font-site-menu);
        font-size: .72rem;
        letter-spacing: .32em;
        text-transform: lowercase;
        color: rgba(17,17,17,.5);
        margin-bottom: 1rem;
    }
    .contact-shell h1 {
        font-family: var(--font-site-course);
        font-size: clamp(2.4rem, 5vw, 4.8rem);
        line-height: .98;
        margin: 0 0 1rem;
        color: #111;
    }
    .contact-shell .lede {
        font-family: var(--font-site-body);
        font-size: 1.1rem;
        line-height: 1.8;
        color: rgba(17,17,17,.7);
        max-width: 640px;
        margin-bottom: 0;
    }
    .contact-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(320px, .9fr);
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .contact-panel {
        background: rgba(255,255,255,.55);
        border: 1px solid rgba(17,17,17,.08);
        border-radius: 32px;
        padding: 2rem;
        backdrop-filter: blur(8px);
    }
    .contact-list {
        display: grid;
        gap: 1rem;
    }
    .contact-card {
        display: grid;
        grid-template-columns: 56px minmax(0, 1fr);
        gap: 1rem;
        align-items: start;
        padding: 1.1rem 0;
        border-bottom: 1px solid rgba(17,17,17,.08);
    }
    .contact-card:last-child { border-bottom: 0; }
    .contact-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #111;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
    }
    .contact-label {
        font-family: var(--font-site-menu);
        font-size: .7rem;
        letter-spacing: .24em;
        text-transform: lowercase;
        color: rgba(17,17,17,.46);
        margin-bottom: .4rem;
    }
    .contact-value,
    .contact-value a {
        font-family: var(--font-site-course);
        font-size: clamp(1.1rem, 2vw, 1.55rem);
        line-height: 1.3;
        color: #111;
        text-decoration: none;
        word-break: break-word;
    }
    .contact-notes {
        display: grid;
        gap: 1rem;
    }
    .social-board {
        margin-top: 1rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: .9rem;
    }
    .social-card {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: 1rem 1.05rem;
        border-radius: 22px;
        background: rgba(255,255,255,.7);
        border: 1px solid rgba(17,17,17,.08);
        text-decoration: none;
        color: #111;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .social-card:hover {
        transform: translateY(-2px);
        color: #111;
        box-shadow: 0 18px 32px rgba(17,17,17,.08);
        background: #fff;
    }
    .social-card i {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #111;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: .95rem;
    }
    .social-card strong {
        display: block;
        font-family: var(--font-site-course);
        font-size: 1rem;
        line-height: 1.1;
        margin-bottom: .18rem;
    }
    .social-card span {
        display: block;
        font-family: var(--font-site-body);
        font-size: .84rem;
        color: rgba(17,17,17,.58);
        line-height: 1.4;
    }
    .note-block {
        border-radius: 28px;
        padding: 1.6rem 1.5rem;
        background: #fff;
        color: #111;
    }
    .note-block h3 {
        font-family: var(--font-site-course);
        font-size: 1.5rem;
        margin: 0 0 .75rem;
    }
    .note-block p {
        font-family: var(--font-site-body);
        font-size: 1rem;
        line-height: 1.8;
        margin: 0;
        color: rgba(17,17,17,.72);
    }
    .social-row {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        margin-top: .75rem;
    }
    .social-row a {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 1px solid rgba(17,17,17,.14);
        color: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: transform .2s ease, background .2s ease;
    }
    .social-row a:hover { transform: translateY(-2px); background: rgba(17,17,17,.08); }
    @media (max-width: 991px) {
        .contact-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .contact-shell { padding: 4.25rem 0 4.5rem; }
        .contact-panel, .note-block { border-radius: 24px; }
        .contact-card { grid-template-columns: 48px minmax(0, 1fr); gap: .9rem; }
        .contact-icon { width: 48px; height: 48px; }
        .contact-value, .contact-value a { font-size: 1.05rem; }
    }
</style>
@endpush

@section('content')
@php
    $socialLinks = collect([
        ['label' => 'Google', 'hint' => 'Search profile', 'icon' => 'fab fa-google', 'url' => $settings->google_url],
        ['label' => 'LinkedIn', 'hint' => 'Institute page', 'icon' => 'fab fa-linkedin-in', 'url' => $settings->linkedin],
        ['label' => 'Instagram', 'hint' => 'Visual updates', 'icon' => 'fab fa-instagram', 'url' => $settings->instagram],
        ['label' => 'Facebook', 'hint' => 'Community page', 'icon' => 'fab fa-facebook-f', 'url' => $settings->facebook],
        ['label' => 'TikTok', 'hint' => 'Short content', 'icon' => 'fab fa-tiktok', 'url' => $settings->tiktok],
        ['label' => 'WhatsApp', 'hint' => 'Direct contact', 'icon' => 'fab fa-whatsapp', 'url' => $settings->whatsappLink()],
        ['label' => 'YouTube', 'hint' => 'Video channel', 'icon' => 'fab fa-youtube', 'url' => $settings->youtube],
        ['label' => 'Wikipedia', 'hint' => 'Public reference', 'icon' => 'fab fa-wikipedia-w', 'url' => $settings->wikipedia_url],
    ])->filter(fn ($item) => ! empty($item['url']));
@endphp
<section class="contact-shell">
    <div class="container">
        <div class="eyebrow">{{ __('site.nav_contact') }}</div>
        <h1>{{ __('site.contact_title') }}</h1>
        <p class="lede">{{ __('site.contact_subtitle') }}</p>

        <div class="contact-grid">
            <div class="contact-panel">
                <div class="contact-list">
                    @if($settings->email_institucional)
                        <div class="contact-card">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="contact-label">{{ __('site.contact_email') }}</div>
                                <div class="contact-value"><a href="mailto:{{ $settings->email_institucional }}">{{ $settings->email_institucional }}</a></div>
                            </div>
                        </div>
                    @endif
                    @if($settings->telefone)
                        <div class="contact-card">
                            <div class="contact-icon"><i class="fas fa-phone"></i></div>
                            <div>
                                <div class="contact-label">{{ __('site.contact_phone') }}</div>
                                <div class="contact-value">{{ $settings->telefone }}</div>
                            </div>
                        </div>
                    @endif
                    @if($settings->endereco || $settings->cidade || $settings->pais)
                        <div class="contact-card">
                            <div class="contact-icon"><i class="fas fa-location-arrow"></i></div>
                            <div>
                                <div class="contact-label">{{ __('site.contact_address') }}</div>
                                <div class="contact-value">{{ collect([$settings->endereco, $settings->cidade, $settings->pais])->filter()->implode(', ') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="contact-notes">
                <div class="note-block">
                    <h3>Gramma Institute</h3>
                    <p>Languages, education, research. A cleaner and more aligned contact page, consistent with the rest of the site.</p>
                </div>
                <div class="note-block">
                    <h3>Gramma Institute online</h3>
                    <p>All public channels and references of the institute in one place.</p>
                    <div class="social-board">
                        @foreach($socialLinks as $item)
                            <a href="{{ $item['url'] }}" target="_blank" rel="noopener" class="social-card">
                                <i class="{{ $item['icon'] }}"></i>
                                <div>
                                    <strong>{{ $item['label'] }}</strong>
                                    <span>{{ $item['hint'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
