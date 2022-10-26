@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1> @if (empty($model)) {{ __("Add") }} @else  {{ __("Edit") }} @endif  {{ __("Income source") }}</h1>

    <div class="col-md-8">

        @if (empty($model))
            {!! Form::open(['url' => route('income_source.store')]) !!}
        @else
            {!! Form::model($model, 
                ['method' => 'put', 
                 'url' => route('income_source.update', ['income_source' => $model->id])]) !!}
        @endif

        <div class="form-group">
            <label for="source">{{ __('Name') }}:</label>
            {!! Form::text('source', null, 
                ['class' => [
                    'form-control',
                    ($errors->has('source') ? 'is-invalid' : '')]]) !!}
            @error('source')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group mt-5">
            {!! Form::submit(__('Send'), ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" 
                href="{{ route('income_source.index') }}">
                {{ __('Cancel') }}
            </a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
