@extends('theme/master_layout')

@section('content')
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
        {!! forms()->create('category', !empty($model) ? $model: null) !!}
            {!! forms()->field(__('Name'), 'category'); !!}
            <div class="form-group mb-3">
                {!! forms()->submit(__('Save'))->attributes(['class' => 'btn btn-primary']) !!}
                <a class="btn btn-warning" href="{{ route('category.index') }}">{{ __('Cancel') }}</a>
            </div>
        {!! forms()->end() !!}
    </div>
@endsection
