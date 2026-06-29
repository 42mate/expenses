@extends('theme/logout')
@section('content')
    <div class="col-lg-12 p-5">
        <h2 class="mb-4 text-center">Login</h2>

        <form method="POST" action="{{ route('login') }}" class="mt-5 mb-5">
            @csrf

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="form-group mb-3">
                        <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="col-form-label">{{ __('Password') }}</label>

                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Sign in') }} <i class="fas fa-sign-in-alt"></i>
                        </button>
                    </div>

                    <div class="mb-0">
                        <a href="{{ route('register') }}">
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
