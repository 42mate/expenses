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
        <div class="form-group">
            {!! forms()->field(__('Name'), 'category'); !!}
        </div>
        <div class="form-group mt-5">
            {!! forms()->submit(__('Send'))->attributes(['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('category.index') }}">{{ __('Cancel') }}</a>
        </div>
        {!! forms()->close() !!}
    </div>
@endsection
