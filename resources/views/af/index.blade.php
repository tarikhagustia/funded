@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            Hi, {{ auth()->user()->name }}
        </div>
    </div>
@endsection
