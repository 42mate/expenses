@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1>
         @if (empty($model)) {{ __('Add') }}
         @else {{ __('Edit') }}
         @endif {{ __('Category') }}
    </h1>

    <x-help>
        {{ __('Categories are used to classified expenses.') }} <br />
        {{ __('Classification helps to get better reports and find expense habits.') }} <br />
        {{ __('When you create an expense, you can select the category of the expense.') }} <br />
    </x-help>

    <div class="col-md-8">
        @if (empty($model))
            {!! Form::open(['url' => route('category.store')]) !!}
        @else
            {!! Form::model($model, ['method' => 'put',
                    'url' => route('category.update',
                    ['category' => $model->id])]) !!}
        @endif

        <div class="form-group">
            <label for="category">{{ __('Name')}}:</label>
            {!! Form::text('category', null,
                    ['class' => [ 'form-control',
                            ($errors->has('category') ? 'is-invalid' : '')]]) !!}
            @error('category')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group mt-5">
            {!! Form::submit(__('Send'), ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('category.index') }}">{{ __('Cancel') }}</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
