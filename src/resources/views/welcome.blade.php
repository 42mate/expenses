@extends('theme/master_layout')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    <div class="card-body">
                        <h1> 👋 {{ __('Hello there!') }}</h1>
                        <p>
                            {{ __('Welcome to Expenses!') }}
                        </p>
                        <p>
                            {{ __('Start Checklist') }}
                            <ul>
                                <li class="@if (!$status['category']) {{ 'done' }} @endif">
                                    <a href="{{ route('category.index') }}">{{ __('Create your expenses categories') }}</a>
                                </li>
                                <li class="@if (!$status['source']) {{ 'done' }} @endif">
                                    <a href="{{ route('income_source.index') }}">{{ __('Create your income sources') }}</a>
                                </li>
                                <li class="@if (!$status['wallet']) {{ 'done' }} @endif">
                                    <a href="{{ route('wallet.index') }}">{{ __('Create your wallets') }}</a>
                                </li>
                                <li class="@if (!$status['expense']) {{ 'done' }} @endif">
                                    <a href="{{ route('expense.create') }}">{{ __('Add your first Expense') }}</a>
                                </li>
                                <li class="@if (!$status['income']) {{ 'done' }} @endif">
                                    <a href="{{ route('incomes.create') }}">{{ __('Add your first Income') }}</a>
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
