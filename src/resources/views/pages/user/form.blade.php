@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="mb-5">
        <i class="fas fa-user"></i> {{ __('Profile') }}
    </h1>
    <div class="row justify-content-left">
        <div class="col-md-8 no-gutters">
            @if (!$errors->isEmpty())
                <div class="alert alert-danger">
                    {{ __('The form contains some errors, please verify') }}
                </div>
            @endif

            {!! forms()->model($model,
                ['method' => 'put',
                'url' => route('user.update', ['model' => $model->id])]) !!}

            <div class="form-group">
                {!! forms()->label(__('Name')) !!}
                {!! forms()->text('name', null,
                    ['class' => [ 'form-control',  ($errors->has('name') ? 'is-invalid' : '')]]) !!}
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                {!! forms()->label(__('Email')) !!}
                {!! forms()->email('email', null,
                    ['class' => [ 'form-control',  ($errors->has('email') ? 'is-invalid' : '')]]) !!}
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                {!! forms()->label(__('Password')) !!}
                {!! forms()->password('password',
                    ['class' => [ 'form-control',  ($errors->has('password') ? 'is-invalid' : '')]]) !!}
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                {!! forms()->label(__('Password Confirm')) !!}
                {!! forms()->password('password_confirmation',
                    ['class' => [ 'form-control',  ($errors->has('password_confirmation') ? 'is-invalid' : '')]]) !!}
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                {!! forms()->label(__('Default Currency')) !!}
                <x-currencies-drop-down name="default_currency_id"
                                        addEmpty="true"
                                        use_as_label="name"
                                        errors="{{ $errors->has('default_currency_id') }}"
                                        selected="{{ empty($model) ? 0 : $model->default_currency_id }}"
                />
            </div>

            <div>
                {!! forms()->submit(__('Send'), ['class' => 'btn btn-primary']) !!}
                <a class="btn btn-warning" href="{{ route('home') }}">{{ __('Cancel') }}</a>
            </div>
            {!! forms()->close() !!}
        </div>
    </div>
@endsection
