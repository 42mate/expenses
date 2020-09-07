@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1> @if (empty($model)) Add @else Edit @endif Wallet</h1>

        @if (empty($model))
            {!! Form::open(['url' => route('wallet.store')]) !!}
        @else
            {!! Form::model($model, ['method' => 'put', 'url' => route('wallet.update', ['wallet' => $model->id])]) !!}
        @endif

        <div class="form-group">
            <label for="name">Name:</label>
            {!! Form::text('name', null, ['class' => [ 'form-control',  ($errors->has('name') ? 'is-invalid' : '')]]) !!}
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group mt-5">
            {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('wallet.index') }}">Cancel</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection