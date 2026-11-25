@extends('layouts.panel')

@section('title', __('Create Town Hall'))

@section('content')
<nav>
    <ol class="breadcrumb border bg-white shadow-sm">
        <li class="breadcrumb-item pl-1">{{ __('Town Halls') }}</li>
        <li class="breadcrumb-item">
            <a href="{{ route('panel.town-halls.index') }}">{{ __('List Town Halls') }}</a>
        </li>
        <li class="breadcrumb-item pr-1">
            <a href="{{ route('panel.town-halls.create') }}">{{ __('Create Town Hall') }}</a>
        </li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center bg-transparent border-transparent">
        <div class="card-title mb-0">{{ __('Create Town Hall') }}</div>
    </div>

    <div class="card-body">
        <form action="{{ route('panel.town-halls.store') }}" method="post" autocomplete="off">
            @csrf

            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="code">{{ __('Code') }}: <span class="text-danger">*</span></label>

                        <input type="text" name="code" value="{{ old('code') }}" id="code" @class(['form-control', 'is-invalid' => $errors->has('code')])>

                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                @foreach ($locales as $locale)
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="name-{{ $locale }}">{{ __('Name') }} <span class="text-primary text-uppercase">{{ $locale }}</span>: <span class="text-danger">*</span></label>

                            <input type="text" name="{{ $locale }}[name]" value="{{ old($locale . '.name') }}" id="name-{{ $locale }}" @class(['form-control', 'is-invalid' => $errors->has($locale . '.name')])>

                            @error($locale . '.name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endforeach

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="municipality_id">{{ __('Municipality') }}: <span class="text-danger">*</span></label>

                        @php
                            $oldMunicipalities = old('municipality_id');
                        @endphp
                        <select name="municipality_id" id="municipality_id" @class(['form-control', 'is-invalid' => $errors->has('municipality_id')]) data-placeholder="{{ __('Select an option') }}">
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach($municipalities as $municipality)
                                <option value="{{ $municipality->id }}" @selected($municipality->id == $oldMunicipalities)>{{ $municipality->name }}</option>
                            @endforeach
                        </select>

                        @error('municipality_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-bottom mb-3"></div>

            <button type="submit" class="btn btn-primary">
                {{ __('Create') }}
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script type="module">
    $('#municipality_id').select2();
</script>
@endsection
