@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">{{ __('Account Type Form') }}</div>
                        <div class="card-body">
                            <form action="{{ route('console.account-types.store') }}" method="post" autocomplete="on">
                                @csrf
                                <div class="form-group">
                                    <label for="account_type">{{ __('Account Type') }}</label>
                                    <input class="form-control @error('account_type') is-invalid @enderror" id="account_type" name="account_type" placeholder="eg. TP10-MC-LP" value="{{ old('account_type') }}">
                                    @error('account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_group_name">{{ __('MT4 Group Name') }}</label>
                                    <input class="form-control @error('meta_group_name') is-invalid @enderror" id="meta_group_name" name="meta_group_name" placeholder="eg. T10-MC-LP" value="{{ old('meta_group_name') }}">
                                    @error('meta_group_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="securities">{{ __('Securities') }}</label>
                                    <input class="form-control @error('securities') is-invalid @enderror" id="securities" name="securities" placeholder="eg. Forex-LP, Metal-LP, Commodity-LP, Index-LP" value="{{ old('securities') }}">
                                    @error('securities')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="rate">{{ __('Rate') }}</label>
                                    <input type="number" class="form-control @error('rate') is-invalid @enderror" id="rate" name="rate" placeholder="eg. 10000" value="{{ old('rate') }}">
                                    @error('securities')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <button class="btn btn-primary"><i class="far fa-save"></i> {{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
