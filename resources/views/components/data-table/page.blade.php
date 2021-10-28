@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('/vendor/select2/css/select2.min.css') }}">
    <style>
        .select2-container--default .select2-selection--multiple {
            border: 1px solid;
            border-color: #d8dbe0;
            border-radius: 0.25em;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid;
            border-color: #d8dbe0;
            border-radius: 0.25em;
        }
    </style>
@endpush

@push('javascript')
    <script src="{{ asset('/vendor/select2/js/select2.min.js') }}"></script>
    {{ $dataTable->scripts() }}
@endpush

@if (isset($dates) && is_array($dates))
    <x-data-table.date-range-filter :dates="$dates" />
@endif
