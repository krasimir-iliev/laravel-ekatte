@extends('layouts.panel')

@section('title', __('Edit Settlement'))

@section('content')
<nav>
    <ol class="breadcrumb border bg-white shadow-sm">
        <li class="breadcrumb-item pl-1">{{ __('Settlements') }}</li>
        <li class="breadcrumb-item">
            <a href="{{ route('panel.settlements.index') }}">{{ __('List Settlements') }}</a>
        </li>
        <li class="breadcrumb-item pr-1">
            <a href="{{ route('panel.settlements.edit', ['settlement' => $settlement->id]) }}">{{ __('Edit Settlement') }}</a>
        </li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center bg-transparent border-transparent">
        <div class="card-title mb-0">{{ __('Edit Settlement') }}</div>
    </div>

    <div class="card-body">
        <form action="{{ route('panel.settlements.update', ['settlement' => $settlement->id]) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12 col-sm-4 col-lg-2">
                    <div class="form-group">
                        <label for="ekatte">{{ __('EKATTE') }}: <span class="text-danger">*</span></label>

                        <input type="text" name="ekatte" value="{{ old('ekatte', $settlement->ekatte) }}" id="ekatte" @class(['form-control', 'is-invalid' => $errors->has('ekatte')])>

                        @error('ekatte')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-4 col-lg-2">
                    <div class="form-group">
                        <label for="settlement_kind_id">{{ __('Kind') }}: <span class="text-danger">*</span></label>

                        @php
                            $oldSettlementKinds = old('settlement_kind_id', $settlement->settlement_kind_id);
                        @endphp
                        <select name="settlement_kind_id" id="settlement_kind_id" @class(['form-control', 'settlements-select2' , 'is-invalid' => $errors->has('settlement_kind_id')]) data-placeholder="{{ __('Select an option') }}">
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach($settlementKinds as $settlementKind)
                                <option value="{{ $settlementKind->id }}" @selected($settlementKind->id == $oldSettlementKinds)>{{ $settlementKind->name }}</option>
                            @endforeach
                        </select>

                        @error('settlement_kind_id')
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

                            <input type="text" name="{{ $locale }}[name]" value="{{ old($locale . '.name', $settlement->translate($locale)?->name) }}" id="name-{{ $locale }}" @class(['form-control', 'is-invalid' => $errors->has($locale . '.name')])>

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
                            $oldDistricts = old('district_id', $settlement->townHall?->municipality?->district_id);
                        @endphp
                        <select name="district_id" id="district_id" @class(['form-control', 'settlements-select2' , 'is-invalid' => $errors->has('district_id')]) data-placeholder="{{ __('Select an option') }}">
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

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="municipality_id">{{ __('Municipality') }}: <span class="text-danger">*</span></label>

                        @php
                            $oldMunicipalities = old('municipality_id', $settlement->townHall?->municipality_id);
                        @endphp
                        <input type="hidden" name="municipality_id" value="">
                        <select name="municipality_id" id="municipality_id" @class(['form-control', 'settlements-select2' , 'is-invalid' => $errors->has('municipality_id')]) data-placeholder="{{ __('Select an option') }}" @if($municipalities->isEmpty()) disabled="disabled" @endif>
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

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="town_hall_id">{{ __('Town Hall') }}: <span class="text-danger">*</span></label>

                        @php
                            $oldTownHalls = old('town_hall_id', $settlement->town_hall_id);
                        @endphp
                        <input type="hidden" name="town_hall_id" value="">
                        <select name="town_hall_id" id="town_hall_id" @class(['form-control', 'settlements-select2' , 'is-invalid' => $errors->has('town_hall_id')]) data-placeholder="{{ __('Select an option') }}" @if($townHalls->isEmpty()) disabled="disabled" @endif>
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach($townHalls as $townHall)
                                <option value="{{ $townHall->id }}" @selected($townHall->id == $oldTownHalls)>{{ $townHall->name }}</option>
                            @endforeach
                        </select>

                        @error('town_hall_id')
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
@include('panel.settlements.scripts.filters')
@endsection
