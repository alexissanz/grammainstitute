@extends('layouts.adminlte')

@section('title', __('dashboard.menu_dashboard'))
@section('page-title', __('dashboard.menu_dashboard'))

@push('styles')
<style>
    .stat-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.12); }
    .stat-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }
    .stat-value { font-size: 2rem; font-weight: 700; line-height: 1; }
    .stat-label { font-size: .8rem; color: #8a97a5; font-weight: 500; text-transform: uppercase; letter-spacing: .04em; }
    .completion-bar { height: 6px; border-radius: 10px; }
    .quick-btn {
        display: flex; align-items: center; gap: .75rem;
        padding: .75rem 1rem;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        color: #2c3e50;
        text-decoration: none;
        transition: all .2s;
        margin-bottom: .5rem;
        font-size: .9rem; font-weight: 500;
    }
    .quick-btn:hover { background: #f0f4ff; border-color: var(--gramma-blue); color: var(--gramma-blue); text-decoration: none; }
    .quick-btn .qicon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .site-header-card { background: linear-gradient(135deg, var(--gramma-blue) 0%, #2d6a9f 100%); border-radius: 14px; padding: 1.5rem 2rem; color: #fff; margin-bottom: 1.5rem; }
    .site-status-badge { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: #fff; border-radius: 20px; padding: .25rem .9rem; font-size: .8rem; font-weight: 600; }
    .completion-section { display: flex; align-items: center; gap: .75rem; padding: .6rem 0; border-bottom: 1px solid #f0f0f0; }
    .completion-section:last-child { border-bottom: none; }
    .completion-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
</style>
@endpush

@section('content')

{{-- Site header card --}}
<div class="site-header-card">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h4 class="mb-1 fw-bold" style="color:#fff;">{{ $settings->nome_site ?? 'Gramma Institute' }}</h4>
            <p class="mb-0" style="color:rgba(255,255,255,0.75); font-size:.9rem;">
                <i class="fas fa-link me-1"></i>
                <a href="{{ config('app.url') }}" target="_blank" style="color:rgba(255,255,255,0.85);">{{ config('app.url') }}</a>
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <span class="site-status-badge"><i class="fas fa-circle me-1" style="font-size:.5rem; color:#4ade80;"></i> Online</span>
            <a href="{{ route('home') }}" target="_blank" class="site-status-badge" style="text-decoration:none;">
                <i class="fas fa-external-link-alt me-1"></i> Ver Site
            </a>
        </div>
    </div>
</div>

{{-- Stats row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#e8f0fe;">
                    <i class="fas fa-language" style="color:#1a3a5c;"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $activeLanguages }}</div>
                    <div class="stat-label">Idiomas Ativos</div>
                </div>
            </div>
            <a href="{{ route('admin.languages.index') }}" class="stretched-link"></a>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#fef3e2;">
                    <i class="fas fa-images" style="color:#d97706;"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $slidesCount }}</div>
                    <div class="stat-label">Hero Slides</div>
                </div>
            </div>
            <a href="{{ route('admin.hero-slides.index') }}" class="stretched-link"></a>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:{{ $smtpConfigured ? '#ecfdf5' : '#fef9c3' }};">
                    <i class="fas fa-envelope" style="color:{{ $smtpConfigured ? '#16a34a' : '#ca8a04' }};"></i>
                </div>
                <div>
                    <div class="stat-value" style="font-size:1.1rem; padding-top:.4rem;">
                        {{ $smtpConfigured ? 'Activo' : 'Pendente' }}
                    </div>
                    <div class="stat-label">SMTP Email</div>
                </div>
            </div>
            <a href="{{ route('admin.settings.edit') }}#tab-smtp" class="stretched-link"></a>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#f0fdf4;">
                    <i class="fas fa-shield-alt" style="color:#15803d;"></i>
                </div>
                <div>
                    <div class="stat-value" style="font-size:1.1rem; padding-top:.4rem;">{{ $completeness['percentage'] }}%</div>
                    <div class="stat-label">Configurado</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Settings completeness --}}
    <div class="col-md-6">
        <div class="card" style="border-radius:12px; border:none; box-shadow: 0 2px 12px rgba(0,0,0,0.07); height:100%;">
            <div class="card-header border-0 pb-0" style="background:transparent;">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0" style="color:#1a3a5c;">
                        <i class="fas fa-tasks me-2" style="color:#2d6a9f;"></i>Completude das Configurações
                    </h6>
                    <span class="badge" style="background:#1a3a5c; border-radius:20px; font-weight:600;">
                        {{ $completeness['done'] }}/{{ $completeness['total'] }}
                    </span>
                </div>
                <div class="progress completion-bar mt-3" style="height:8px; border-radius:10px; background:#e9ecef;">
                    <div class="progress-bar" style="width:{{ $completeness['percentage'] }}%; background: linear-gradient(90deg, #1a3a5c, #2d6a9f); border-radius:10px;"></div>
                </div>
            </div>
            <div class="card-body pt-3">
                @foreach($completeness['sections'] as $sectionName => $section)
                <div class="completion-section">
                    <div class="completion-dot" style="background: {{ $section['filled'] ? '#16a34a' : '#e5e7eb' }};"></div>
                    <div class="flex-grow-1">
                        <div style="font-size:.875rem; font-weight:500; color:#374151;">{{ $sectionName }}</div>
                        <div style="font-size:.75rem; color:#9ca3af;">{{ $section['fields'] }}</div>
                    </div>
                    @if($section['filled'])
                        <i class="fas fa-check-circle" style="color:#16a34a; font-size:.9rem;"></i>
                    @else
                        <a href="{{ route('admin.settings.edit') }}" style="font-size:.75rem; color:#2d6a9f; text-decoration:none; font-weight:500;">Preencher</a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="col-md-6">
        <div class="card" style="border-radius:12px; border:none; box-shadow: 0 2px 12px rgba(0,0,0,0.07); height:100%;">
            <div class="card-header border-0 pb-0" style="background:transparent;">
                <h6 class="fw-bold mb-0" style="color:#1a3a5c;">
                    <i class="fas fa-bolt me-2" style="color:#d97706;"></i>Acesso Rápido
                </h6>
            </div>
            <div class="card-body pt-3">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.settings.edit') }}" class="quick-btn">
                    <div class="qicon" style="background:#e8f0fe;"><i class="fas fa-cog" style="color:#1a3a5c;"></i></div>
                    Configurações do Site
                </a>
                <a href="{{ route('admin.hero-slides.index') }}" class="quick-btn">
                    <div class="qicon" style="background:#fef3e2;"><i class="fas fa-images" style="color:#d97706;"></i></div>
                    Gerir Hero Slides
                </a>
                <a href="{{ route('admin.languages.index') }}" class="quick-btn">
                    <div class="qicon" style="background:#f0fdf4;"><i class="fas fa-language" style="color:#16a34a;"></i></div>
                    Idiomas & Traduções
                </a>
                <a href="{{ route('admin.email-test.index') }}" class="quick-btn">
                    <div class="qicon" style="background:#fdf2f8;"><i class="fas fa-paper-plane" style="color:#9333ea;"></i></div>
                    Testar Email SMTP
                </a>
                @endif
                <a href="{{ route('home') }}" target="_blank" class="quick-btn">
                    <div class="qicon" style="background:#f8f9fa;"><i class="fas fa-external-link-alt" style="color:#6b7280;"></i></div>
                    Ver Site Público
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Info row --}}
<div class="row g-3 mt-1">
    <div class="col-md-6">
        <div class="card" style="border-radius:12px; border:none; box-shadow: 0 2px 12px rgba(0,0,0,0.07);">
            <div class="card-header border-0 pb-0" style="background:transparent;">
                <h6 class="fw-bold mb-0" style="color:#1a3a5c;"><i class="fas fa-info-circle me-2" style="color:#2d6a9f;"></i>Informações do Site</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0" style="font-size:.875rem;">
                    <tr>
                        <td class="text-muted" style="width:40%;">Nome</td>
                        <td class="fw-500">{{ $settings->nome_site ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email</td>
                        <td>{{ $settings->email_institucional ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Telefone</td>
                        <td>{{ $settings->telefone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Localização</td>
                        <td>{{ implode(', ', array_filter([$settings->cidade, $settings->pais])) ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Idioma padrão</td>
                        <td><code>{{ $settings->idioma_padrao ?? 'pt_BR' }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Hero</td>
                        <td><span class="badge bg-secondary">{{ $settings->hero_tipo ?? 'imagem' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Última atualização</td>
                        <td>{{ $settings->updated_at ? $settings->updated_at->format('d/m/Y H:i') : '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" style="border-radius:12px; border:none; box-shadow: 0 2px 12px rgba(0,0,0,0.07);">
            <div class="card-header border-0 pb-0" style="background:transparent;">
                <h6 class="fw-bold mb-0" style="color:#1a3a5c;"><i class="fas fa-share-alt me-2" style="color:#2d6a9f;"></i>Redes Sociais</h6>
            </div>
            <div class="card-body">
                @foreach([
                    ['fab fa-facebook', $settings->facebook, 'Facebook', '#1877f2'],
                    ['fab fa-instagram', $settings->instagram, 'Instagram', '#e1306c'],
                    ['fab fa-linkedin', $settings->linkedin, 'LinkedIn', '#0a66c2'],
                    ['fab fa-youtube', $settings->youtube, 'YouTube', '#ff0000'],
                    ['fab fa-tiktok', $settings->tiktok, 'TikTok', '#010101'],
                ] as [$icon, $url, $name, $color])
                <div class="d-flex align-items-center justify-content-between py-1" style="border-bottom:1px solid #f0f0f0;">
                    <div class="d-flex align-items-center gap-2" style="font-size:.875rem;">
                        <i class="{{ $icon }}" style="color:{{ $color }}; width:18px;"></i>
                        <span class="text-muted">{{ $name }}</span>
                    </div>
                    @if($url)
                        <a href="{{ $url }}" target="_blank" style="font-size:.8rem; color:#2d6a9f;">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    @else
                        <span style="font-size:.75rem; color:#d1d5db;">Não configurado</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
