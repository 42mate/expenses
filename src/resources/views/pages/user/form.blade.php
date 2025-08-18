@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1>
        <i class="fas fa-user"></i> {{ __('Profile') }}
    </h1>
    <div class="row justify-content-left">
        <div class="col-md-8 no-gutters">
            {!! forms()->create('user', !empty($model) ? $model : null) !!}
            <div class="form-group mb-3">
                {!! forms()->field(__('Name'), 'name') !!}
            </div>

            <div class="form-group mb-3">
                {!! forms()->field(__('Email'), 'email') !!}
            </div>

            <div class="form-group mb-3">
                {!! forms()->field(__('Password'), 'password', 'password') !!}
            </div>

            <div class="form-group mb-3">
                {!! forms()->field(__('Password Confirm'), 'password_confirmation', 'password') !!}
            </div>
            <div class="form-group mb-3">
                {!! forms()->label(__('Default Currency')) !!}
                <x-currencies-drop-down name="default_currency_id"
                                        addEmpty="true"
                                        use_as_label="name"
                                        errors="{{ $errors->has('default_currency_id') }}"
                                        selected="{{ empty($model) ? 0 : $model->default_currency_id }}"
                />
            </div>
            <div>
                {!! forms()->submit(__('Save')) !!}
                <a class="btn btn-warning" href="{{ route('home') }}">{{ __('Cancel') }}</a>
            </div>
            {!! forms()->end() !!}
        </div>
    </div>
@endsection
