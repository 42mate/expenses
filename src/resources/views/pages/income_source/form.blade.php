@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1>
        @if (empty($model)) {{ __("Add") }}
        @else  {{ __("Edit") }}
        @endif  {{ __("Income source") }}
    </h1>

    <x-help>
        {{ __('Income sources are from where you get the money, it can be for example salary, rent, loan and others.') }} <br />
        {{ __('When you create an income, you can select the source of the income.') }} <br />
    </x-help>

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
