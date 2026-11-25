@extends('layouts.panel')

@section('title', __('Edit Municipality'))

@section('content')
<nav>
    <ol class="breadcrumb border bg-white shadow-sm">
        <li class="breadcrumb-item pl-1">{{ __('Municipalities') }}</li>
        <li class="breadcrumb-item">
            <a href="{{ route('panel.municipalities.index') }}">{{ __('List Municipalities') }}</a>
        </li>
        <li class="breadcrumb-item pr-1">
            <a href="{{ route('panel.municipalities.edit', ['municipality' => $municipality->id]) }}">{{ __('Edit Municipality') }}</a>
        </li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center bg-transparent border-transparent">
        <div class="card-title mb-0">{{ __('Edit Municipality') }}</div>
    </div>

    <div class="card-body">
        <form action="{{ route('panel.municipalities.update', ['municipality' => $municipality->id]) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="code">{{ __('Code') }}: <span class="text-danger">*</span></label>

                        <input type="text" name="code" value="{{ old('code', $municipality->code) }}" id="code" @class(['form-control', 'is-invalid' => $errors->has('code')])>

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

                            <input type="text" name="{{ $locale }}[name]" value="{{ old($locale . '.name', $municipality->translate($locale)?->name) }}" id="name-{{ $locale }}" @class(['form-control', 'is-invalid' => $errors->has($locale . '.name')])>

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
                        <label for="district_id">{{ __('District') }}: <span class="text-danger">*</span></label>

                        @php
                            $oldDistricts = old('district_id', $municipality->district_id);
                        @endphp
                        <select name="district_id" id="district_id" @class(['form-control', 'is-invalid' => $errors->has('district_id')]) data-placeholder="{{ __('Select an option') }}">
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" @selected($district->id == $oldDistricts)>{{ $district->name }}</option>
                            @endforeach
                        </select>

                        @error('district_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-bottom mb-3"></div>

            <button type="submit" class="btn btn-primary">
                {{ __('Update') }}
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script type="module">
    $('#district_id').select2();
</script>
@endsection
