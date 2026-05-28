@extends('layouts.public')

@section('meta-title', __('site.partners_page_title') . ' — ' . config('app.name'))

@push('styles')
<style>
    .partners-hero {
        position: relative;
        background: linear-gradient(180deg, #f6f2ea 0%, #ece4d8 100%);
        color: #111;
        padding: 5.5rem 0 3.5rem;
        overflow: hidden;
    }
    .partners-hero .container { position: relative; z-index: 2; }
    .partners-hero .eyebrow {
        font-family: var(--font-site-menu);
        font-size: .82rem;
        letter-spacing: .32em;
        text-transform: lowercase;
        color: rgba(17,17,17,.52);
        margin-bottom: 1rem;
    }
    .partners-hero h1,
    .partners-hero .lede,
    .partners-hero p {
        color: #111 !important;
    }
    .partners-hero h1 {
        font-family: var(--font-site-course);
        font-weight: 500;
        font-size: clamp(2.4rem, 5vw, 4rem);
        margin-bottom: 1.25rem;
    }
    .partners-hero .lede {
        font-family: var(--font-site-body);
        font-size: 1.08rem;
        max-width: 720px;
        line-height: 1.8;
    }

    .partners-body { background: linear-gradient(180deg, #f8f4ed 0%, #efe6da 100%); padding: 6.5rem 0 6rem; }
    .partners-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.2rem;
        margin-top: 1rem;
    }
    .partner-card {
        text-align: left;
        text-decoration: none;
        color: var(--ink);
        display: grid;
        grid-template-columns: 76px minmax(0, 1fr);
        gap: 1rem;
        align-items: center;
        transition: transform .25s, box-shadow .25s;
        background: rgba(255,255,255,.78);
        border: 1px solid rgba(17,17,17,.08);
        border-radius: 28px;
        padding: 1rem;
        box-shadow: 0 14px 34px rgba(17,17,17,.06);
    }
    .partner-card:hover { transform: translateY(-4px); color: var(--ink); box-shadow: 0 20px 42px rgba(17,17,17,.1); }
    .partner-photo {
        width: 76px; height: 76px;
        border-radius: 50%;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--line);
        box-shadow: 0 4px 14px rgba(26,22,18,.06);
    }
    .partner-photo img { width: 100%; height: 100%; object-fit: cover; }
    .partner-photo-placeholder {
        width:100%; height:100%;
        display:flex; align-items:center; justify-content:center;
        font-family: var(--font-site-course);
        font-size: 1.6rem;
        color: var(--bronze);
        background: var(--parchment);
    }
    .partner-name {
        font-family: var(--font-site-course);
        font-size: 1.05rem;
        font-weight: 500;
        letter-spacing: .015em;
    }
    .partners-empty {
        text-align: center;
        padding: 3rem 1rem;
        font-family: var(--font-site-body);
        font-size: 1.25rem;
        color: var(--stone);
        border: 1px dashed var(--line);
        background: #fff;
        margin-top: 2.5rem;
    }
    .partners-empty i { color: var(--bronze); font-size: 2rem; display:block; margin-bottom: .75rem; }
</style>
@endpush

@section('content')

<section class="partners-body">
    <div class="container">
        @if($partners->isEmpty())
            <div class="partners-empty">
                <i class="fas fa-handshake"></i>
                {{ __('site.partners_empty') }}
            </div>
        @else
            <div class="partners-grid">
                @foreach($partners as $partner)
                    @php $tag = $partner->link ? 'a' : 'div'; @endphp
                    <{{ $tag }} class="partner-card"
                        @if($partner->link) href="{{ $partner->link }}" target="_blank" rel="noopener noreferrer" @endif>
                        <div class="partner-photo">
                            @if($partner->foto)
                                <img src="{{ $partner->fotoUrl() }}" alt="{{ $partner->nome }}">
                            @else
                                <div class="partner-photo-placeholder">{{ mb_strtoupper(mb_substr($partner->nome, 0, 1)) }}</div>
                            @endif
                        </div>
                        <div>
                            <div class="partner-name">{{ $partner->nome }}</div>
                        </div>
                    </{{ $tag }}>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
