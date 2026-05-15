@extends('layouts.adminlte')

@section('title', __('email.test_title'))
@section('page-title', __('email.test_title'))

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('email.test_title') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-paper-plane mr-1"></i> {{ __('email.test_subtitle') }}</h3>
            </div>
            <div class="card-body">
                @if(!$settings->smtp_host)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        {{ __('email.smtp_missing') }}
                        <a href="{{ route('admin.settings.edit') }}" class="alert-link">{{ __('dashboard.menu_settings') }}</a>
                    </div>
                @endif

                <form action="{{ route('admin.email-test.send') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="to">{{ __('email.to') }} *</label>
                        <input type="email" id="to" name="to"
                               class="form-control @error('to') is-invalid @enderror"
                               value="{{ old('to') }}" required>
                        @error('to')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="subject">{{ __('email.subject') }} *</label>
                        <input type="text" id="subject" name="subject"
                               class="form-control @error('subject') is-invalid @enderror"
                               value="{{ old('subject', __('email.default_subject')) }}" required>
                        @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="message">{{ __('email.message') }} *</label>
                        <textarea id="message" name="message" rows="5"
                                  class="form-control @error('message') is-invalid @enderror"
                                  required>{{ old('message', __('email.default_message')) }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @error('smtp')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-info" {{ !$settings->smtp_host ? 'disabled' : '' }}>
                        <i class="fas fa-paper-plane mr-1"></i> {{ __('email.send') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-server mr-1"></i> SMTP</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tr>
                        <th class="pl-3">Host</th>
                        <td>{{ $settings->smtp_host ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th class="pl-3">Port</th>
                        <td>{{ $settings->smtp_port ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th class="pl-3">Encryption</th>
                        <td>{{ strtoupper($settings->smtp_encryption ?? '—') }}</td>
                    </tr>
                    <tr>
                        <th class="pl-3">From</th>
                        <td>{{ $settings->smtp_from_address ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th class="pl-3">Estado</th>
                        <td>
                            @if($settings->smtp_host)
                                <span class="badge badge-success">{{ __('dashboard.smtp_configured') }}</span>
                            @else
                                <span class="badge badge-warning">{{ __('dashboard.smtp_not_configured') }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.settings.edit') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-cog mr-1"></i> Configurar SMTP
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
