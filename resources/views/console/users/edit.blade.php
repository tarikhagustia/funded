@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">{{ __('Users Form') }}</div>
                        <div class="card-body">
                            <form action="{{ route('console.users.update', $user) }}" method="post" autocomplete="on">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="eg. John Due" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="eg. john@example.com" type="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="********" type="password" autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role">{{ __('Role') }}</label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                        @foreach($roles as $row)
                                            <option value="{{ $row->name }}" {{ old('role', $user->roles[0]->name) == $row->name ? 'selected' : null }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
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
