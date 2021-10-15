@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">{{ __('Cost Operation Form') }}</div>
                        <div class="card-body">
                            <form action="{{ route('costs-operation.update',$model->id) }}" method="post" autocomplete="on">
                                @method('PUT')
                                @csrf

                                <input type="hidden" name="type" value="{{Request::route()->getName() == 'costs-operation.request.create' ? 'costs-operation.request' : 'costs-operation.approval'}}">

                                <div class="form-group">
                                    <label for="title">{{ __('Title') }}</label>
                                    <input class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="eg. Biaya untuk meeting ke papua" value="{{ old('title', $model->title) }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group" id="items">
                                    <label for="items">{{ __('Items') }}</label>

                                    @foreach($model->items as $key => $item)

                                    <input type="hidden" name="items[{{$key}}][id]" value="{{$item->id}}">

                                    <div class="row {{$key > 0 ? 'mt-2' : ''}}">
                                        <div class="col-6">
                                            <input class="form-control" name="items[{{$key}}][name]" value="{{$item->name}}" placeholder="Name">
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control" name="items[{{$key}}][amount]" value="{{$item->amount}}" type="number" placeholder="Amount">
                                        </div>
                                    </div>

                                    @endforeach

                                </div>

                                <div class="form-group">
                                    <label for="date">{{ __('Date') }}</label>
                                    <input class="form-control @error('date') is-invalid @enderror" id="date" name="date" type="date" placeholder="eg. T10-MC-LP"  value="{{ old('date', $model->date) }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary"><i class="far fa-save"></i> {{ __('Submit') }}</button>
                                    <button type="button" class="btn btn-primary" id="add-item"><i class="fa fa-plus"></i> {{ __('Add Item') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("javascript")

<script>

    $("#add-item").click(function(){
        var rows = $("#items .row").get()

        var html = `<div class="row mt-2">
                        <div class="col-6">
                            <input class="form-control" name="items[${rows.length}][name]" placeholder="Name">
                        </div>
                        <div class="col-6">
                            <input class="form-control" name="items[${rows.length}][amount]" type="number" placeholder="Amount">
                        </div>
                    </div>`

        $("#items").append(html)
    })

</script>
@endpush