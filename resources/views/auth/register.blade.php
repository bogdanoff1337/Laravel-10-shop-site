@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        <div class="card-header">{{ __('Register') }}</div>
                        @csrf

                        <div class="row mb-3">
                            <input id="name" type="text"
                                class="input-reg form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="row mb-3">
                            <input id="email" type="email"
                                class="input-reg  form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">

                            <input id="password" type="password"
                                class="input-reg form-control @error('password') is-invalid @enderror" name="password"
                                required autocomplete="new-password" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="row mb-3">
                            <input id="password-confirm" type="password" class="input-reg form-control"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm Password">

                        </div>

                        <div class="row mb-0">

                            <button type="submit" class="btn btn-reg">
                                {{ __('Register') }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
