@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">{{ __('Users Table') }}</div>
                <div class="card-body table-responsive">
                    {{$dataTable->table()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    {{ $dataTable->scripts() }}
@endpush
