@extends('layouts.panel')

@section('title', __('List Settlements'))

@section('content')
<nav>
    <ol class="breadcrumb border bg-white shadow-sm">
        <li class="breadcrumb-item pl-1">{{ __('Settlements') }}</li>
        <li class="breadcrumb-item pr-1">
            <a href="{{ route('panel.settlements.index') }}">{{ __('List Settlements') }}</a>
        </li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center bg-transparent border-transparent">
        <div class="card-title mb-0">{{ __('List Settlements') }}</div>

        <div class="btn-group btn-group-sm flex-shrink-0 ml-auto" role="group">
            <button type="button" class="btn p-0" data-toggle="collapse" data-dt-toggle="tooltip" data-placement="left" title="{{ __('Filters') }}" data-target="#settlementsTableFilters">
                <i class="fas fa-filter text-primary"></i>
            </button>
            <a href="{{ route('panel.settlements.export') }}" class="btn ml-2 p-0" data-dt-toggle="tooltip" data-placement="left" title="{{ __('Export All') }}">
                <i class="fas fa-download text-primary"></i>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div id="settlementsTableFilters" class="collapse">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <select name="district_id" id="district_id" class="form-control settlements-select2 settlements-table-filters" data-placeholder="{{ __('District') }}">
                            <option value="">{{ __('District') }}</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <select name="municipality_id" id="municipality_id" class="form-control settlements-select2 settlements-table-filters" data-placeholder="{{ __('Municipality') }}" disabled="disabled">
                            <option value="">{{ __('Municipality') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <select name="town_hall_id" id="town_hall_id" class="form-control settlements-select2 settlements-table-filters" data-placeholder="{{ __('Town Hall') }}" disabled="disabled">
                            <option value="">{{ __('Town Hall') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <table id="settlements-table" class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('EKATTE') }}</th>
                    <th>{{ __('Kind') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Town Hall') }}</th>
                    <th>{{ __('Municipality') }}</th>
                    <th>{{ __('District') }}</th>
                    <th>{{ __('Created') }}</th>
                    <th>{{ __('Updated') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@include('scripts.datatables')
@include('panel.settlements.scripts.filters')
<script type="module">
    var settlementsTableFilters = $('.settlements-table-filters');
    var settlementsTable = $('#settlements-table').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('panel.settlements.index') }}",
            data: function(data) {
                settlementsTableFilters.each(function() {
                    data[this.name] = this.value;
                });
            }
        },
        columns: [
            { data: 'id', name: 'id', searchable: false },
            { data: 'ekatte', name: 'ekatte' },
            { data: 'settlement_kind.name', name: 'settlement_kind.name' },
            { data: 'settlement_name', name: 'settlement_translations.name' },
            { data: 'town_hall_name', name: 'town_hall_translations.name' },
            { data: 'municipality_name', name: 'municipality_translations.name' },
            { data: 'district_name', name: 'district_translations.name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'actions', name: 'actions', searchable: false, orderable: false, className: 'py-2' }
        ]
    });

    settlementsTableFilters.on('change', function() {
        settlementsTable.draw();
    });

    $('body').tooltip({
        selector: '[data-dt-toggle="tooltip"]',
        trigger: 'hover'
    });
</script>
@endsection
