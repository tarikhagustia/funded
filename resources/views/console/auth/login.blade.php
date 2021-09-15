@extends('layouts.guest')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <form action="{{ route('console.login') }}" method="post">
                            @csrf
                            <img src="https://bullishfx.id/wp-content/uploads/2020/07/bullish-logo-2-e1594917801368.png" class="mb-2">
                            <p class="text-muted">Hi, Admin! Login to your account</p>
                            <div class="input-group mb-3 form-group has-error">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-envelope"></i></span></div>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" placeholder="Email" required name="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Password" required name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
