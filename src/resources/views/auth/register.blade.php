@extends('theme/logout')

@section('content')
    <div class="col-lg-12 p-5">
        <h2 class="mb-4  text-center">{{ __('Create an account') }}</h2>

        <form method="POST" action="{{ route('register') }}" class="mb-5 mt-5">
            @csrf

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="form-group mb-3">
                        <label for="name" class="col-form-label">{{ __('Name') }}</label>

                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror" name="name"
                               value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>

                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror" name="email"
                               value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="col-form-label">{{ __('Password') }}</label>

                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>

                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="form-group mb-4">
                        <label for="default_currency_id" class="col-form-label">
                            {{ __('Default Currency') }}
                        </label>

                        <x-currencies-drop-down name="default_currency_id"
                                                addEmpty="true"
                                                use_as_label="name"
                                                errors="{{ $errors->has('default_currency_id') }}"
                                                selected="0"
                        />
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-0">
                        <a href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }} <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
