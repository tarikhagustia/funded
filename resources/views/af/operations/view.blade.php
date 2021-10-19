@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <span>{{ __('Cost Operation Approval Detail') }}</span>
                            <div class="float-right d-flex">                               
                                <button class="btn btn-sm btn-success mr-2" onclick="return confirm('Are u sure to Approve this?') ? $('#form-approve-{{$model->id}}').submit() : null">
                                    <i class="fas fa-check" data-tooltip="Approve"></i>
                                </button>
                                <form id="form-approve-{{$model->id}}" action="{{ route('costs-operation.update.status', $model->id) }}" method="post">@csrf <input type="hidden" name="status" value="Approved"></form>

                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are u sure to Reject this?') ? $('#form-reject-{{$model->id}}').submit() : null">
                                    <i class="fas fa-times" data-tooltip="Reject"></i>
                                </button>
                                <form id="form-reject-{{$model->id}}" action="{{ route('costs-operation.update.status', $model->id) }}" method="post">@csrf <input type="hidden" name="status" value="Rejected"></form>
                            </div>
                        </div>
                        <div class="card-body">

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
                                        <input class="form-control" readonly value="{{$item->amount}}" type="number">
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
                                <a href="{{route('costs-operation.approval')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection