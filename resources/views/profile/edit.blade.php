@extends('layouts.adminlte')

@section('title', __('dashboard.profile_title'))
@section('page-title', __('dashboard.profile_title'))

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('dashboard.menu_profile') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-edit mr-1"></i> {{ __('dashboard.profile_title') }}</h3>
            </div>
            <div class="card-body">
                @if(session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Perfil atualizado com sucesso!
                    </div>
                @endif
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>{{ __('dashboard.profile_name') }}</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('dashboard.profile_email') }}</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('dashboard.profile_role') }}</label>
                        <input type="text" class="form-control" readonly
                               value="{{ $user->isAdmin() ? __('dashboard.profile_role_admin') : __('dashboard.profile_role_user') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> {{ __('dashboard.profile_update') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-key mr-1"></i> Alterar Senha</h3>
            </div>
            <div class="card-body">
                @if(session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Senha atualizada!
                    </div>
                @endif
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Senha atual</label>
                        <input name="current_password" type="password"
                               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('dashboard.profile_password') }}</label>
                        <input name="password" type="password"
                               class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('dashboard.profile_confirm_password') }}</label>
                        <input name="password_confirmation" type="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key mr-1"></i> Alterar Senha
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
