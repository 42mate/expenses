@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1>
        @if (empty($model)) {{ __("Add") }}
        @else  {{ __("Edit") }}
        @endif  {{ __("Income Source") }}
    </h1>
    <x-help>
        {{ __('Income sources are from where you get the money, it can be for example salary, rent, loan and others.') }} <br />
        {{ __('When you create an income, you can select the source of the income.') }} <br />
    </x-help>
    <div class="col-md-8">
        {!! forms()->create('income_source', !empty($model) ? $model : null) !!}
            {!! forms()->field( __('Name'), 'source') !!}

            <div class="form-group mb-3">
                {!! forms()->submit(__('Save')) !!}
                <a class="btn btn-warning" href="{{ route('income_source.index') }}">
                    {{ __('Cancel') }}
                </a>
            </div>
        {!! forms()->end() !!}
    </div>
@endsection
