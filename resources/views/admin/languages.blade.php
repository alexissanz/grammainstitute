@extends('layouts.adminlte')

@section('title', __('dashboard.menu_languages'))
@section('page-title', __('dashboard.menu_languages'))

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('dashboard.menu_languages') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-language mr-1"></i> Idiomas do Sistema</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Idioma</th>
                            <th>Direção</th>
                            <th>Estado</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($languages as $code => $info)
                        <tr>
                            <td><code>{{ $code }}</code></td>
                            <td>{{ $info['flag'] }} {{ $info['name'] }}</td>
                            <td>
                                @if($info['dir'] === 'rtl')
                                    <span class="badge badge-info">RTL</span>
                                @else
                                    <span class="badge badge-secondary">LTR</span>
                                @endif
                            </td>
                            <td>
                                @if(in_array($code, $active))
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-secondary">Inativo</span>
                                @endif
                                @if($settings->idioma_padrao === $code)
                                    <span class="badge badge-primary ml-1">Padrão</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('locale.switch', $code) }}"
                                   class="btn btn-xs btn-outline-primary">
                                    Testar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.settings.edit') }}#locale" class="btn btn-sm btn-success">
                    <i class="fas fa-cog mr-1"></i> Gerir idiomas activos
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Informação</h3>
            </div>
            <div class="card-body">
                <p>O sistema suporta os seguintes idiomas de base:</p>
                <ul>
                    <li><strong>pt_BR</strong> — Português do Brasil (padrão)</li>
                    <li><strong>en</strong> — Inglês</li>
                    <li><strong>es</strong> — Espanhol</li>
                    <li><strong>he</strong> — Hebraico (RTL)</li>
                    <li><strong>el</strong> — Grego</li>
                </ul>
                <p class="text-muted small">Para adicionar novos idiomas, crie os ficheiros em <code>lang/[codigo]/</code>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
