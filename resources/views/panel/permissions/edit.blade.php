@extends('layouts.panel')

@section('title', __('Edit Permission'))

@section('content')
<nav>
    <ol class="breadcrumb border bg-white shadow-sm">
        <li class="breadcrumb-item pl-1">{{ __('Permissions') }}</li>
        <li class="breadcrumb-item">
            <a href="{{ route('panel.permissions.index') }}">{{ __('List Permissions') }}</a>
        </li>
        <li class="breadcrumb-item pr-1">
            <a href="{{ route('panel.permissions.edit', ['permission' => $permission->id]) }}">{{ __('Edit Permission') }}</a>
        </li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center bg-transparent border-transparent">
        <div class="card-title mb-0">{{ __('Edit Permission') }}</div>
    </div>

    <div class="card-body">
        <form action="{{ route('panel.permissions.update', ['permission' => $permission->id]) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}:</label>

                        <input type="text" value="{{ $permission->display_name }}" id="name" class="form-control" readonly="readonly">
                    </div>
                </div>
            </div>

            <fieldset>
                <label>{{ __('Roles') }}:</label>

                <div @class(['border-bottom', 'mb-3' , 'border-danger' => $errors->has('roles') || $errors->has('roles.*')])></div>

                <div class="row">
                    @php
                        $oldRoles = old('roles', $permission->roles->pluck('id')->toArray());
                        $oldRoles = is_array($oldRoles) ? $oldRoles : [];
                    @endphp
                    @foreach ($roles as $role)
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}" class="form-check-input" @checked(in_array($role->id, $oldRoles)) @disabled($role->readonly)>

                                    <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('roles')
                    <span class="invalid-feedback d-block border-top border-danger mt-0 mb-3 pt-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                @error('roles.*')
                    <span class="invalid-feedback d-block border-top border-danger mt-0 mb-3 pt-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <div class="border-bottom mb-3"></div>

            <button type="submit" class="btn btn-primary">
                {{ __('Update') }}
            </button>
        </form>
    </div>
</div>
@endsection
