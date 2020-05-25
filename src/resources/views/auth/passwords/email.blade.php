@extends('theme/logout')

@section('content')
    <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
    <div class="col-lg-6 p-5">
        <h2 class="mb-4">Forgot your password</h2>
        <form method="POST" action="{{ route('password.email') }}" class="mb-5 mt-5">
            @csrf

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-2">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                       Send <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <a href="{{ route('login') }}">
                        Login
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection