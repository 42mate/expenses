@extends('theme/master_layout')

@section('content')
        <h1>
            Expense
        </h1>
        <div class="mb-2">
            <div>
                <label class="font-weight-bold">Date: </label> {{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}
            </div>
            <div>
                <label class="font-weight-bold">Amount: </label> $ {{ $expense->amount }}
            </div>

            <div>
                <label class="font-weight-bold">Category: </label> {{ $expense->category->category}}
            </div>
            <div>
                <label class="font-weight-bold">Wallet: </label> {{ isset($expense->wallet->name) ? $expense->wallet->name : __('No wallet') }}
            </div>
            <div>
                <label class="font-weight-bold">Description: </label> {{ $expense->description }}
            </div>
            <div>
                <label class="font-weight-bold">Tags: </label>
                <span class="tags">
                    @foreach($expense->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                </span>
            </div>
        </div>
        <div>
            <a href="{{ route('expense.index') }}" class="btn btn-success">Back</a>
            <a href="{{ route('expense.edit', ['expense' => $expense->id]) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('home') }}" class="btn btn-danger float-right">Delete</a>
        </div>
@endsection
