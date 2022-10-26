@extends('theme/master_layout')

@section('content')
        <h1>
            {{ __('Expense') }}
        </h1>
        <div class="mb-2">
            <div>
                <label class="font-weight-bold"> {{ __('Date') }}: </label> 
                    {{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}
            </div>
            <div>
                <label class="font-weight-bold"> {{ __('Amount') }}: </label> 
                    $ {{ $expense->amount }}
            </div>

            <div>
                <label class="font-weight-bold"> {{ __('Category') }}: </label> 
                    {{ $expense->category->category}}
            </div>
            <div>
                <label class="font-weight-bold"> {{ __('Wallet') }}: </label> 
                    {{ isset($expense->wallet->name) ? $expense->wallet->name : __('No wallet') }}
            </div>
            <div>
                <label class="font-weight-bold"> {{ __('Description') }}: </label>
                    {{ $expense->description }}
            </div>
        </div>
        <div>
            <a href="{{ route('expense.index') }}" 
                class="btn btn-success">
                {{ __('Back') }}
            </a>
            <a href="{{ route('expense.edit', ['expense' => $expense->id]) }}" 
                class="btn btn-primary">
                {{ __('Edit') }}
            </a>
            <a href="{{ route('home') }}"
                class="btn btn-danger float-right">
                {{ __('Delete') }}
            </a>
        </div>
@endsection
