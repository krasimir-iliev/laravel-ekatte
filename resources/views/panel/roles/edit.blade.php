@extends('layouts.panel')

@section('title', __('Edit Role'))

@section('content')
<nav>
    <ol class="breadcrumb border bg-white shadow-sm">
        <li class="breadcrumb-item pl-1">{{ __('Roles') }}</li>
        <li class="breadcrumb-item">
            <a href="{{ route('panel.roles.index') }}">{{ __('List Roles') }}</a>
        </li>
        <li class="breadcrumb-item pr-1">
            <a href="{{ route('panel.roles.edit', ['role' => $role->id]) }}">{{ __('Edit Role') }}</a>
        </li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center bg-transparent border-transparent">
        <div class="card-title mb-0">{{ __('Edit Role') }}</div>
    </div>

    <div class="card-body">
        <form action="{{ route('panel.roles.update', ['role' => $role->id]) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}: <span class="text-danger">*</span></label>

                        <input type="text" name="name" value="{{ old('name', $role->name) }}" id="name" @class(['form-control', 'is-invalid' => $errors->has('name')])>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <fieldset>
                <label>{{ __('Permissions') }}:</label>

                <div @class(['border-bottom', 'mb-3' , 'border-danger' => $errors->has('permissions') || $errors->has('permissions.*')])></div>

                <div class="row">
                    @php
                        $oldPermissions = old('permissions', $role->permissions->pluck('id')->toArray());
                        $oldPermissions = is_array($oldPermissions) ? $oldPermissions : [];
                    @endphp
                    @foreach ($permissions as $permission)
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}" class="form-check-input" @checked(in_array($permission->id, $oldPermissions))>

                                    <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->display_name }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('permissions')
                    <span class="invalid-feedback d-block border-top border-danger mt-0 mb-3 pt-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                @error('permissions.*')
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
