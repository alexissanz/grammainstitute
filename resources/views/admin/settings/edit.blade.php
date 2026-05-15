@extends('layouts.adminlte')

@section('title', __('settings.title'))
@section('page-title', __('settings.title'))

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('settings.title') }}</li>
@endsection

@section('content')
<form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        {{-- GERAL --}}
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> {{ __('settings.section_general') }}</h3>
                </div>
                <div class="card-body">
                    @foreach(['nome_site','titulo_site','subtitulo_site'] as $field)
                    <div class="form-group">
                        <label>{{ __("settings.{$field}") }}</label>
                        <input type="text" name="{{ $field }}" class="form-control @error($field) is-invalid @enderror"
                               value="{{ old($field, $settings->$field) }}">
                        @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
                    <div class="form-group">
                        <label>{{ __('settings.descricao_site') }}</label>
                        <textarea name="descricao_site" class="form-control" rows="3">{{ old('descricao_site', $settings->descricao_site) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ __('settings.texto_rodape') }}</label>
                        <textarea name="texto_rodape" class="form-control" rows="2">{{ old('texto_rodape', $settings->texto_rodape) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTACTO --}}
        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-address-book mr-1"></i> {{ __('settings.section_contact') }}</h3>
                </div>
                <div class="card-body">
                    @foreach(['email_institucional','telefone','whatsapp','endereco','cidade','pais'] as $field)
                    <div class="form-group">
                        <label>{{ __("settings.{$field}") }}</label>
                        <input type="text" name="{{ $field }}" class="form-control @error($field) is-invalid @enderror"
                               value="{{ old($field, $settings->$field) }}">
                        @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- REDES SOCIAIS --}}
        <div class="col-md-6">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-share-alt mr-1"></i> {{ __('settings.section_social') }}</h3>
                </div>
                <div class="card-body">
                    @foreach(['facebook','instagram','linkedin','youtube','tiktok'] as $field)
                    <div class="form-group">
                        <label><i class="fab fa-{{ $field }} mr-1"></i>{{ __("settings.{$field}") }}</label>
                        <input type="url" name="{{ $field }}" class="form-control @error($field) is-invalid @enderror"
                               value="{{ old($field, $settings->$field) }}" placeholder="https://">
                        @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="col-md-6">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search mr-1"></i> {{ __('settings.section_seo') }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('settings.meta_title') }}</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $settings->meta_title) }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('settings.meta_description') }}</label>
                        <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $settings->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- IMAGENS --}}
        <div class="col-md-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-images mr-1"></i> {{ __('settings.section_media') }}</h3>
                </div>
                <div class="card-body">
                    @foreach(['logo','favicon','imagem_hero'] as $field)
                    <div class="form-group">
                        <label>{{ __("settings.{$field}") }}</label>
                        @if($settings->$field)
                            <div class="mb-2">
                                <img src="{{ Storage::url($settings->$field) }}"
                                     alt="{{ $field }}"
                                     style="max-height:60px; max-width:150px;"
                                     class="img-thumbnail">
                                <small class="text-muted d-block">{{ __('settings.current_image') }}</small>
                            </div>
                        @endif
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error($field) is-invalid @enderror"
                                       name="{{ $field }}" id="{{ $field }}"
                                       accept="{{ $field === 'favicon' ? '.ico,.png' : 'image/*' }}">
                                <label class="custom-file-label" for="{{ $field }}">
                                    {{ __("settings.upload_{$field}") }}
                                </label>
                            </div>
                        </div>
                        @error($field)<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- IDIOMAS --}}
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-language mr-1"></i> {{ __('settings.section_locale') }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('settings.idioma_padrao') }}</label>
                        <select name="idioma_padrao" class="form-control">
                            @foreach(['pt_BR' => 'Português (Brasil)','en' => 'English','es' => 'Español','he' => 'עברית','el' => 'Ελληνικά'] as $code => $name)
                                <option value="{{ $code }}" {{ old('idioma_padrao', $settings->idioma_padrao) === $code ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('settings.idiomas_activos') }}</label>
                        @foreach(['pt_BR' => 'Português (Brasil)','en' => 'English','es' => 'Español','he' => 'עברית','el' => 'Ελληνικά'] as $code => $name)
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" name="idiomas_activos[]" value="{{ $code }}" id="lang_{{ $code }}"
                                       {{ is_array($settings->idiomas_activos) && in_array($code, $settings->idiomas_activos) ? 'checked' : '' }}>
                                <label for="lang_{{ $code }}">{{ $name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- SMTP --}}
        <div class="col-12">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-mail-bulk mr-1"></i> {{ __('settings.section_smtp') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('settings.smtp_host') }}</label>
                                <input type="text" name="smtp_host" class="form-control" value="{{ old('smtp_host', $settings->smtp_host) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('settings.smtp_port') }}</label>
                                <input type="number" name="smtp_port" class="form-control" value="{{ old('smtp_port', $settings->smtp_port) }}" placeholder="587">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('settings.smtp_username') }}</label>
                                <input type="text" name="smtp_username" class="form-control" value="{{ old('smtp_username', $settings->smtp_username) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('settings.smtp_password') }}</label>
                                <input type="password" name="smtp_password" class="form-control" autocomplete="new-password">
                                <small class="text-muted">{{ __('settings.smtp_password_hint') }}</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('settings.smtp_encryption') }}</label>
                                <select name="smtp_encryption" class="form-control">
                                    @foreach(['tls','ssl','starttls'] as $enc)
                                        <option value="{{ $enc }}" {{ old('smtp_encryption', $settings->smtp_encryption) === $enc ? 'selected' : '' }}>
                                            {{ strtoupper($enc) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{ __('settings.smtp_from_address') }}</label>
                                <input type="email" name="smtp_from_address" class="form-control" value="{{ old('smtp_from_address', $settings->smtp_from_address) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('settings.smtp_from_name') }}</label>
                                <input type="text" name="smtp_from_name" class="form-control" value="{{ old('smtp_from_name', $settings->smtp_from_name) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save mr-1"></i> {{ __('settings.save') }}
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').text(fileName);
    });
</script>
@endpush

@php use Illuminate\Support\Facades\Storage; @endphp
