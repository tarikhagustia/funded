@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <span>{{ __('Cost Operation Approval Detail') }}</span>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>{{ __('Agent') }}</label>
                                <input class="form-control" readonly value="{{$model->agent->agentname}}">
                            </div>

                            <div class="form-group">
                                <label>{{ __('Agent Approval') }}</label>
                                <input class="form-control" readonly value="{{$model->agentApproval->agentname}}">
                            </div>

                            <div class="form-group">
                                <label>{{ __('Title') }}</label>
                                <input class="form-control" readonly value="{{$model->title}}">
                            </div>

                            <div class="form-group" id="items">
                                <label>{{ __('Items') }}</label>

                                @foreach($model->items as $key => $item)

                                <div class="row {{$key > 0 ? 'mt-2' : ''}}">
                                    <div class="col-6">
                                        <input class="form-control" readonly value="{{$item->name}}">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control" readonly value="{{number_format($item->amount)}}" type="text">
                                    </div>
                                </div>

                                @endforeach

                            </div>

                            <div class="form-group">
                                <label for="date">{{ __('Total') }}</label>
                                <input class="form-control" readonly type="text" value="{{ number_format($model->total) }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date">{{ __('Date') }}</label>
                                <input class="form-control" readonly type="date" value="{{ $model->date }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <a href="{{route('console.operating-costs.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection