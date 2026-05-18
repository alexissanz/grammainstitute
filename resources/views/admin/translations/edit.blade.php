@extends('layouts.adminlte')

@section('title', 'Traduções — ' . $langInfo['name'])
@section('page-title', 'Traduções — ' . $langInfo['flag'] . ' ' . $langInfo['name'])

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.languages.index') }}">Idiomas</a></li>
    <li class="breadcrumb-item active">{{ $locale }}</li>
@endsection

@push('styles')
<style>
    .trans-tabs .nav-link { font-size:.83rem; padding:.55rem 1rem; color:#6b7280; border-bottom:3px solid transparent; border-radius:0; font-weight:500; }
    .trans-tabs .nav-link.active { color:#1a3a5c; border-bottom-color:#1a3a5c; background:transparent; }
    .trans-row { display:flex; align-items:flex-start; gap:.75rem; padding:.5rem 0; border-bottom:1px solid #f3f4f6; }
    .trans-row:last-child { border-bottom:none; }
    .trans-key { flex:0 0 200px; font-family:monospace; font-size:.78rem; color:#6b7280; background:#f9fafb; border-radius:4px; padding:.2rem .5rem; margin-top:.4rem; word-break:break-all; }
    .trans-input { flex:1; }
    .trans-btn { flex:0 0 36px; }
    .trans-btn button { width:36px; height:36px; border-radius:8px; border:1px solid #e5e7eb; background:#fff; cursor:pointer; font-size:.9rem; transition:all .15s; }
    .trans-btn button:hover { background:#eef3ff; border-color:#2d6a9f; color:#1a3a5c; }
    .trans-btn button.loading { opacity:.5; cursor:wait; }
    .source-text { flex:0 0 260px; font-size:.78rem; color:#9ca3af; border-left:2px solid #e5e7eb; padding-left:.75rem; margin-top:.4rem; line-height:1.4; }
    .file-tab-content .form-control { font-size:.875rem; }
    .file-tab-content textarea.form-control { min-height:60px; resize:vertical; }
    @media (max-width: 768px) {
        .trans-row { flex-wrap: wrap; }
        .trans-key { flex: 0 0 100%; }
        .source-text { flex: 0 0 100%; border-left: none; border-top: 1px solid #f0f0f0; padding-left: 0; padding-top: .5rem; margin-top: 0; }
    }
</style>
@endpush

@section('content')

{{-- Header bar --}}
<div class="card mb-3" style="border-radius:12px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.07);">
    <div class="card-body py-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h5 class="mb-1 fw-bold" style="color:#1a3a5c;">
                    {{ $langInfo['flag'] }} Editar Traduções — {{ $langInfo['name'] }}
                    <code class="ms-2" style="font-size:.7em; background:#f3f4f6; border-radius:4px; padding:.1rem .4rem;">{{ $locale }}</code>
                </h5>
                <p class="mb-0 text-muted" style="font-size:.85rem;">
                    A coluna cinzenta mostra o texto em PT-BR como referência.
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" id="translateAllBtn" class="btn btn-outline-primary btn-sm" style="border-radius:8px;">
                    <i class="fas fa-magic me-1"></i>Auto-traduzir aba actual
                </button>
                <a href="{{ route('admin.languages.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;">
                    <i class="fas fa-arrow-left me-1"></i>Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{{ route('admin.translations.update', $locale) }}" id="trans-form">
    @csrf
    @method('PUT')

<div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.07);">
    <div class="card-header p-0 border-0" style="background:#fff; border-radius:12px 12px 0 0; overflow:hidden;">
        <ul class="nav trans-tabs border-bottom" id="trans-tabs-nav">
            @php $files = ['site' => 'Site Público', 'dashboard' => 'Dashboard', 'auth' => 'Autenticação', 'settings' => 'Configurações', 'email' => 'Email']; @endphp
            @foreach($files as $file => $label)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#ftab-{{ $file }}">
                    {{ $label }}
                    <span class="badge ms-1" style="background:#e5e7eb; color:#374151; font-size:.65rem; border-radius:10px;">
                        {{ count($translations[$file] ?? []) }}
                    </span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="card-body p-4 file-tab-content">
        <div class="tab-content">
            @foreach($files as $file => $label)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="ftab-{{ $file }}" data-file="{{ $file }}">

                @if(isset($translations[$file]) && count($translations[$file]) > 0)

                @php
                    $isRtlLang = ($langInfo['dir'] ?? 'ltr') === 'rtl';
                @endphp

                @foreach($translations[$file] as $key => $value)
                <div class="trans-row">
                    <div class="trans-key" title="{{ $key }}">{{ $key }}</div>
                    <div class="trans-input">
                        @if(strlen((string)($ptBR[$file][$key] ?? '')) > 80)
                        <textarea name="translations[{{ $file }}][{{ $key }}]"
                                  class="form-control trans-field"
                                  data-key="{{ $key }}"
                                  data-file="{{ $file }}"
                                  dir="{{ $isRtlLang ? 'rtl' : 'ltr' }}"
                                  rows="2">{{ old("translations.{$file}.{$key}", $value) }}</textarea>
                        @else
                        <input type="text"
                               name="translations[{{ $file }}][{{ $key }}]"
                               class="form-control trans-field"
                               data-key="{{ $key }}"
                               data-file="{{ $file }}"
                               dir="{{ $isRtlLang ? 'rtl' : 'ltr' }}"
                               value="{{ old("translations.{$file}.{$key}", $value) }}">
                        @endif
                    </div>
                    <div class="trans-btn">
                        <button type="button" class="translate-one-btn"
                                data-key="{{ $key }}" data-file="{{ $file }}"
                                title="Auto-traduzir este campo"
                                data-locale="{{ $locale }}">
                            <i class="fas fa-language"></i>
                        </button>
                    </div>
                    <div class="source-text" title="PT-BR (referência)">
                        {{ $ptBR[$file][$key] ?? '' }}
                    </div>
                </div>
                @endforeach

                @else
                <p class="text-muted text-center py-4">Nenhuma chave encontrada para este ficheiro.</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center" style="background:#fafafa; border-radius:0 0 12px 12px;">
        <small class="text-muted"><i class="fas fa-info-circle me-1"></i>As traduções são salvas nos ficheiros PHP em <code>lang/{{ $locale }}/</code></small>
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-2"></i>Guardar Traduções
        </button>
    </div>
</div>
</form>

{{-- Toast notification --}}
<div id="toast-msg" style="position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;display:none;">
    <div style="background:#1a3a5c;color:#fff;border-radius:10px;padding:.75rem 1.25rem;box-shadow:0 4px 20px rgba(0,0,0,0.2);font-size:.875rem;" id="toast-inner"></div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    const CSRF   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const locale = '{{ $locale }}';

    // Map Laravel locale codes to MyMemory API codes
    const mmMap = { 'pt_BR': 'pt-BR', 'en': 'en', 'es': 'es', 'he': 'he', 'el': 'el' };
    const target = mmMap[locale] || locale;

    function showToast(msg, success) {
        const t = document.getElementById('toast-msg');
        const i = document.getElementById('toast-inner');
        i.textContent = msg;
        t.querySelector('div').style.background = success ? '#16a34a' : '#dc2626';
        t.style.display = 'block';
        clearTimeout(t._to);
        t._to = setTimeout(function() { t.style.display = 'none'; }, 3000);
    }

    async function translateField(field, sourceText) {
        if (!sourceText) return;
        field.disabled = true;

        try {
            const res = await fetch('{{ route("admin.auto-translate") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ text: sourceText, target: target, source: 'pt-BR' })
            });
            const data = await res.json();
            if (data.translation) {
                field.value = data.translation;
                field.style.background = '#f0fdf4';
                setTimeout(function() { field.style.background = ''; }, 1500);
            } else {
                showToast('Tradução não disponível para este texto.', false);
            }
        } catch(e) {
            showToast('Erro ao traduzir. Verifique a ligação.', false);
        } finally {
            field.disabled = false;
        }
    }

    // Individual translate buttons
    document.querySelectorAll('.translate-one-btn').forEach(function(btn) {
        btn.addEventListener('click', async function() {
            const key  = this.getAttribute('data-key');
            const file = this.getAttribute('data-file');
            const field = document.querySelector('[data-key="' + key + '"][data-file="' + file + '"]');
            if (!field) return;

            // Get source from PT-BR column (the source-text div next to the field)
            const row = field.closest('.trans-row');
            const sourceEl = row ? row.querySelector('.source-text') : null;
            const sourceText = sourceEl ? sourceEl.textContent.trim() : '';

            btn.classList.add('loading');
            await translateField(field, sourceText);
            btn.classList.remove('loading');
        });
    });

    // Translate all visible fields in active tab
    document.getElementById('translateAllBtn').addEventListener('click', async function() {
        const activePane = document.querySelector('.tab-pane.active');
        if (!activePane) return;

        const rows = activePane.querySelectorAll('.trans-row');
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>A traduzir...';

        let count = 0;
        for (const row of rows) {
            const field = row.querySelector('.trans-field');
            const sourceEl = row.querySelector('.source-text');
            if (!field || !sourceEl) continue;
            const sourceText = sourceEl.textContent.trim();
            if (!sourceText) continue;
            await translateField(field, sourceText);
            count++;
            // Small delay to avoid rate limiting
            await new Promise(r => setTimeout(r, 300));
        }

        this.disabled = false;
        this.innerHTML = '<i class="fas fa-magic me-1"></i>Auto-traduzir aba actual';
        showToast(count + ' campos traduzidos!', true);
    });
})();
</script>
@endpush
