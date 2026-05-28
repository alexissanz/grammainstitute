@extends('layouts.public')

@section('meta-title', __('site.glossary_title') . ' - ' . ($settings->nome_site ?? 'Gramma Institute'))

@push('styles')
<style>
    .gl-shell { background: #ffffff; color: #111; min-height: 100vh; }
    .gl-hero { padding: 2.5rem 0 .5rem; text-align: center; }
    .gl-hero h1 {
        font-family: var(--font-site-course);
        font-size: clamp(2.3rem, 5vw, 4.6rem);
        line-height: .98;
        margin: 0 0 .8rem;
        color: #111;
    }
    .gl-hero p {
        font-family: var(--font-site-body);
        color: rgba(17,17,17,.68);
        font-size: 1.1rem;
        max-width: 760px;
        margin: 0 auto;
        line-height: 1.8;
    }
    .gl-alpha {
        position: sticky;
        top: 72px;
        z-index: 30;
        background: rgba(255,255,255,.88);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(17,17,17,.08);
        border-bottom: 1px solid rgba(17,17,17,.08);
        padding: 1rem 0;
    }
    .gl-alpha-shell {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr) 42px;
        gap: .75rem;
        align-items: center;
    }
    .gl-alpha-row {
        display: flex;
        gap: .55rem;
        flex-wrap: nowrap;
        justify-content: flex-start;
        overflow-x: auto;
        scrollbar-width: none;
        scroll-behavior: smooth;
        padding: .15rem 0;
    }
    .gl-alpha-row::-webkit-scrollbar { display: none; }
    .gl-alpha-btn {
        flex: 0 0 auto;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1px solid rgba(17,17,17,.12);
        background: rgba(255,255,255,.55);
        color: rgba(17,17,17,.72);
        font-family: var(--font-site-course);
        font-size: 1rem;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,.45), 0 10px 24px rgba(17,17,17,.06);
        transition: all .26s ease;
    }
    .gl-alpha-btn.active,
    .gl-alpha-btn:hover {
        background: #111;
        color: #fff;
        border-color: #111;
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 18px 30px rgba(17,17,17,.14);
    }
    .gl-alpha-nav {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: 1px solid rgba(17,17,17,.12);
        background: rgba(255,255,255,.62);
        color: #111;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 24px rgba(17,17,17,.06);
        transition: all .22s ease;
    }
    .gl-alpha-nav:hover {
        background: #111;
        color: #fff;
        border-color: #111;
    }
    .gl-stage { padding: 3rem 0 5rem; min-height: 70vh; display: flex; align-items: center; }
    .gl-stage .container { width: 100%; }
    .gl-pane {
        display: none;
        opacity: 0;
        transform: translateY(26px) scale(.985);
    }
    .gl-pane.active {
        display: block;
        animation: glossaryIn .7s cubic-bezier(.22,.78,.2,1) forwards;
    }
    @keyframes glossaryIn {
        from { opacity: 0; transform: translateY(26px) scale(.985); filter: blur(8px); }
        to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }
    .gl-letter-card {
        background: #fff;
        color: #111;
        border-radius: 36px;
        padding: 2.4rem;
        margin: 0 auto;
        max-width: 980px;
        box-shadow: 0 28px 70px rgba(17,17,17,.09);
        border: 1px solid rgba(17,17,17,.06);
    }
    .gl-letter-head {
        display: flex;
        align-items: end;
        gap: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid rgba(17,17,17,.08);
        padding-bottom: 1rem;
    }
    .gl-letter-mark {
        font-family: var(--font-site-course);
        font-size: clamp(3rem, 8vw, 5.4rem);
        line-height: .9;
        color: #111;
    }
    .gl-letter-copy h2 {
        font-family: var(--font-site-course);
        font-size: 1.5rem;
        margin: 0 0 .3rem;
    }
    .gl-letter-copy p {
        font-family: var(--font-site-body);
        font-size: 1rem;
        line-height: 1.8;
        color: rgba(17,17,17,.66);
        margin: 0;
    }
    .gl-entry-list {
        display: grid;
        gap: 1rem;
    }
    .gl-entry {
        padding: 1.1rem 0;
        border-bottom: 1px solid rgba(17,17,17,.08);
    }
    .gl-entry:last-child { border-bottom: 0; }
    .gl-term {
        font-family: var(--font-site-course);
        font-size: clamp(1.15rem, 2.4vw, 1.55rem);
        color: #111;
        margin: 0 0 .4rem;
    }
    .gl-def {
        font-family: var(--font-site-body);
        font-size: 1.04rem;
        line-height: 1.9;
        color: rgba(17,17,17,.76);
        white-space: pre-line;
        text-align: justify;
        text-justify: inter-word;
    }
    .gl-empty {
        text-align: center;
        padding: 5rem 0;
        color: rgba(17,17,17,.6);
        font-family: var(--font-site-body);
    }
    @media (max-width: 767px) {
        .gl-hero { padding: 4.5rem 0 2rem; }
        .gl-alpha { top: 60px; }
        .gl-alpha-btn { width: 40px; height: 40px; }
        .gl-letter-card { padding: 1.4rem; border-radius: 24px; }
        .gl-letter-head { align-items: center; }
    }
</style>
@endpush

@section('content')
<section class="gl-shell">
    <div class="gl-hero">
        <div class="container"></div>
    </div>

        <div class="gl-alpha">
        <div class="container">
            <div class="gl-alpha-shell">
                <button class="gl-alpha-nav" type="button" id="glAlphaPrev" aria-label="Previous letter"><i class="fas fa-chevron-left"></i></button>
                <div class="gl-alpha-row" id="glAlphaRow">
                    @foreach($letters as $index => $letter)
                        <button class="gl-alpha-btn {{ $index === 0 ? 'active' : '' }}" type="button" data-letter="{{ $letter }}">{{ $letter }}</button>
                    @endforeach
                </div>
                <button class="gl-alpha-nav" type="button" id="glAlphaNext" aria-label="Next letter"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>

    <div class="gl-stage">
        <div class="container">
            @if($groups->isEmpty())
                <div class="gl-empty">{{ __('site.glossary_empty') }}</div>
            @else
                @foreach($groups as $letter => $letterTerms)
                    @php
                        $lead = $letterTerms->first();
                    @endphp
                    <div class="gl-pane {{ $loop->first ? 'active' : '' }}" data-letter-pane="{{ $letter }}">
                        <div class="gl-letter-card">
                            <div class="gl-letter-head">
                                <div class="gl-letter-mark">{{ $letter }}</div>
                            </div>

                            <div class="gl-entry-list">
                                @foreach($letterTerms as $term)
                                    @php
                                        $blocks = preg_split("/\r?\n\s*\r?\n/", trim((string) ($term->t('descricao') ?: $term->t('significado'))));
                                    @endphp
                                    @foreach($blocks as $block)
                                        @php
                                            $lines = preg_split("/\r?\n/", trim($block));
                                            $entryTitle = trim(array_shift($lines) ?? '');
                                            $entryBody = trim(implode("\n", $lines));
                                        @endphp
                                        @if($entryTitle !== '')
                                            <article class="gl-entry">
                                                <h3 class="gl-term">{{ $entryTitle }}</h3>
                                                @if($entryBody !== '')
                                                    <div class="gl-def">{{ $entryBody }}</div>
                                                @endif
                                            </article>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function() {
        const buttons = document.querySelectorAll('.gl-alpha-btn');
        const panes = document.querySelectorAll('.gl-pane');
        const prev = document.getElementById('glAlphaPrev');
        const next = document.getElementById('glAlphaNext');
        let index = 0;

        // Static glossary: content changes ONLY when the user clicks a letter
        // (or the prev/next arrows). No auto-advance.
        function activateByIndex(newIndex, scroll) {
            if (!buttons.length) return;
            index = (newIndex + buttons.length) % buttons.length;
            const button = buttons[index];
            const letter = button.dataset.letter;
            buttons.forEach(x => x.classList.remove('active'));
            panes.forEach(x => x.classList.remove('active'));
            button.classList.add('active');
            document.querySelector('[data-letter-pane="' + letter + '"]')?.classList.add('active');
            if (scroll) button.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }

        buttons.forEach(function(button, buttonIndex) {
            button.addEventListener('click', function() { activateByIndex(buttonIndex, true); });
        });

        prev?.addEventListener('click', function() { activateByIndex(index - 1, true); });
        next?.addEventListener('click', function() { activateByIndex(index + 1, true); });

        // Show the first letter on load, without auto-rotating.
        activateByIndex(0, false);
    })();
</script>
@endpush
