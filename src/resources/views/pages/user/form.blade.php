@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Hello, {{ $model->name }}
                </div>
                <div class="card-body">
                    @if (!$errors->isEmpty())
                        <div class="alert alert-danger">The form contains some errors, please verify</div>
                    @endif

                    {!! Form::model($model, ['method' => 'put', 'url' => route('user.update', ['model' => $model->id])]) !!}
                    <div class="form-group">
                        {!! Form::label('Name') !!}
                        {!! Form::text('name', null, ['class' => [ 'form-control',  ($errors->has('name') ? 'is-invalid' : '')]]) !!}
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('Email') !!}
                        {!! Form::email('email', null, ['class' => [ 'form-control',  ($errors->has('email') ? 'is-invalid' : '')]]) !!}
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('Password') !!}
                        {!! Form::password('password', ['class' => [ 'form-control',  ($errors->has('password') ? 'is-invalid' : '')]]) !!}
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('Password Confirm') !!}
                        {!! Form::password('password_confirmation', ['class' => [ 'form-control',  ($errors->has('password_confirmation') ? 'is-invalid' : '')]]) !!}
                        @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div>
                        {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                        <a class="btn btn-warning" href="{{ route('home') }}">Cancel</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection