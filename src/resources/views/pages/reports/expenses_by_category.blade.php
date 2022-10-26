@extends('theme/master_layout')

@section('content')
    <h1>{{ __('Expenses by Cateogry') }}</h1>
    <div class="row">
        <div class="card-body col-6">
            @include('includes._widget_chart_by_category', ['expenses' => $expenses])
        </div>
    </div>
@endsection