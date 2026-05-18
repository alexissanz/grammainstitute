@extends('layouts.adminlte')

@section('title', 'Idiomas & Traduções')
@section('page-title', 'Idiomas & Traduções')

@section('breadcrumb')
    <li class="breadcrumb-item active">Idiomas</li>
@endsection

@push('styles')
<style>
    .lang-row { transition: background .15s; }
    .lang-row:hover { background: #f8f9ff; }
    .toggle-form button { border-radius: 20px; font-size: .78rem; padding: .25rem .8rem; font-weight: 600; border: none; cursor: pointer; }
    .flag-cell { font-size: 1.4rem; }
    .dir-badge { font-size: .72rem; border-radius: 4px; padding: .15rem .5rem; font-weight: 700; }
    .action-btn { font-size: .8rem; border-radius: 6px; padding: .3rem .7rem; }
</style>
@endpush

@section('content')
<div class="row g-3">

    {{-- Main languages table --}}
    <div class="col-lg-8">
        <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.07);">
            <div class="card-header d-flex align-items-center justify-content-between" style="background:#fff; border-bottom:2px solid #1a3a5c; border-radius:12px 12px 0 0;">
                <h6 class="mb-0 fw-bold" style="color:#1a3a5c;">
                    <i class="fas fa-language me-2"></i>Idiomas do Sistema
                </h6>
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addLangModal" style="border-radius:8px; font-size:.8rem;">
                    <i class="fas fa-plus me-1"></i>Adicionar Idioma
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size:.875rem;">
                        <thead style="background:#f8f9fb;">
                            <tr>
                                <th class="px-3" style="font-size:.75rem; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.04em; padding:.75rem;">Idioma</th>
                                <th style="font-size:.75rem; font-weight:700; color:#6b7280; text-transform:uppercase;">Código</th>
                                <th style="font-size:.75rem; font-weight:700; color:#6b7280; text-transform:uppercase;">Dir.</th>
                                <th style="font-size:.75rem; font-weight:700; color:#6b7280; text-transform:uppercase;">Estado</th>
                                <th style="font-size:.75rem; font-weight:700; color:#6b7280; text-transform:uppercase;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($languages as $code => $info)
                            <tr class="lang-row">
                                <td class="px-3 py-2">
                                    <span class="flag-cell me-2">{{ $info['flag'] }}</span>
                                    <span class="fw-500">{{ $info['name'] }}</span>
                                    @if($settings->idioma_padrao === $code)
                                        <span class="badge ms-1" style="background:#1a3a5c; font-size:.7rem; border-radius:10px;">Padrão</span>
                                    @endif
                                </td>
                                <td><code style="background:#f3f4f6; padding:.15rem .5rem; border-radius:4px;">{{ $code }}</code></td>
                                <td>
                                    <span class="dir-badge {{ $info['dir'] === 'rtl' ? 'text-white' : 'text-dark' }}"
                                          style="background: {{ $info['dir'] === 'rtl' ? '#7c3aed' : '#e5e7eb' }};">
                                        {{ strtoupper($info['dir']) }}
                                    </span>
                                </td>
                                <td>
                                    <form method="post" action="{{ route('admin.languages.toggle') }}" class="toggle-form d-inline">
                                        @csrf
                                        <input type="hidden" name="locale" value="{{ $code }}">
                                        <button type="submit"
                                                style="background: {{ in_array($code, $active) ? '#dcfce7; color:#16a34a;' : '#f3f4f6; color:#6b7280;' }}"
                                                {{ $settings->idioma_padrao === $code ? 'disabled title="Idioma padrão não pode ser desativado"' : '' }}>
                                            <i class="fas {{ in_array($code, $active) ? 'fa-toggle-on' : 'fa-toggle-off' }} me-1"></i>
                                            {{ in_array($code, $active) ? 'Ativo' : 'Inativo' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.translations.edit', $code) }}" class="btn action-btn btn-primary me-1" style="font-size:.78rem;">
                                        <i class="fas fa-edit me-1"></i>Traduções
                                    </a>
                                    <a href="{{ route('locale.switch', $code) }}" class="btn action-btn btn-outline-secondary" style="font-size:.78rem;">
                                        <i class="fas fa-eye me-1"></i>Testar
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Info panel --}}
    <div class="col-lg-4">
        <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.07); margin-bottom:1rem;">
            <div class="card-header" style="background:#fff; border-bottom:2px solid #1a3a5c; border-radius:12px 12px 0 0;">
                <h6 class="mb-0 fw-bold" style="color:#1a3a5c;"><i class="fas fa-info-circle me-2"></i>Como funciona</h6>
            </div>
            <div class="card-body" style="font-size:.875rem;">
                <p>Cada idioma tem ficheiros de tradução em <code>lang/[código]/</code>.</p>
                <ul class="ps-3">
                    <li>Clique em <strong>Traduções</strong> para editar os textos</li>
                    <li>Use <strong>Auto-traduzir</strong> para preencher a partir do PT-BR</li>
                    <li>O botão <strong>Ativo/Inativo</strong> controla se o idioma aparece no seletor</li>
                    <li>O idioma <strong>padrão</strong> não pode ser desativado</li>
                </ul>
            </div>
        </div>

        <div class="card" style="border-radius:12px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.07);">
            <div class="card-header" style="background:#fff; border-bottom:2px solid #1a3a5c; border-radius:12px 12px 0 0;">
                <h6 class="mb-0 fw-bold" style="color:#1a3a5c;"><i class="fas fa-check-circle me-2"></i>Idiomas Activos</h6>
            </div>
            <div class="card-body" style="font-size:.875rem;">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($languages as $code => $info)
                        @if(in_array($code, $active))
                        <span style="background:#eef3ff; color:#1a3a5c; border-radius:20px; padding:.2rem .8rem; font-size:.8rem; font-weight:600; border:1px solid #c7d7f5;">
                            {{ $info['flag'] }} {{ $code }}
                        </span>
                        @endif
                    @endforeach
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.settings.edit') }}#tab-idiomas" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-cog me-1"></i>Gerir em Configurações
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Adicionar Idioma --}}
<div class="modal fade" id="addLangModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px;">
            <form method="post" action="{{ route('admin.languages.add') }}">
                @csrf
                <div class="modal-header" style="border-bottom:2px solid #1a3a5c;">
                    <h5 class="modal-title fw-bold" style="color:#1a3a5c;"><i class="fas fa-plus-circle me-2"></i>Adicionar Idioma</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label fw-500">Código do Idioma</label>
                        <input name="code" type="text" class="form-control" placeholder="Ex: fr, de, ar, zh_CN" required
                               pattern="[a-z]{2}(_[A-Z]{2})?" maxlength="10">
                        <small class="text-muted">Formato: <code>xx</code> ou <code>xx_XX</code> (ex: <code>fr</code>, <code>zh_CN</code>)</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-500">Nome do Idioma</label>
                        <input name="name" type="text" class="form-control" placeholder="Ex: Français, Deutsch" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-500">Direção de Escrita</label>
                        <select name="dir" class="form-control">
                            <option value="ltr">LTR — Esquerda para Direita (padrão)</option>
                            <option value="rtl">RTL — Direita para Esquerda (Árabe, Hebraico...)</option>
                        </select>
                    </div>
                    <div class="alert alert-info py-2 mb-0" style="font-size:.82rem;">
                        <i class="fas fa-lightbulb me-1"></i>
                        Os ficheiros de tradução serão criados automaticamente a partir do português. Depois poderá editá-los e usar o auto-translate.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-plus me-1"></i>Criar Idioma</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
