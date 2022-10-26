@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1> @if (empty($model)) {{ __('Add') }} @else {{ _('Edit') }} @endif {{ _('Wallet') }}</h1>

    <div class="col-md-8">
        @if (empty($model))
            {!! Form::open(['url' => route('wallet.store')]) !!}
        @else
            {!! Form::model($model, ['method' => 'put', 'url' => route('wallet.update', ['wallet' => $model->id])]) !!}
        @endif

        <div class="form-group">
            <label for="name">{{ __('Name') }}:</label>
            {!! Form::text('name', null, ['class' => [ 'form-control',  ($errors->has('name') ? 'is-invalid' : '')]]) !!}
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">{{ __('Balance') }}:</label>
            {!! Form::number('balance', null, ['class' => [ 'form-control',  ($errors->has('balance') ? 'is-invalid' : '')]]) !!}
            @error('balance')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group mt-5">
            {!! Form::submit(__('Send'), ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('wallet.index') }}">{{ __('Cancel') }}</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
