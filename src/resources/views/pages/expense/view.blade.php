@extends('theme/master_layout')

@section('content')
<div class="card">
    <div class="card-header">
        Expense
    </div>
    <div class="card-body">
        <div>
            <label class="font-weight-bold">Date: </label> {{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}
        </div>
        <div>
            <label class="font-weight-bold">Category: </label> {{ $expense->category->category}}
        </div>
        <div>
            <label class="font-weight-bold">Description: </label> {{ $expense->description }}
        </div>
        <div>
            <label class="font-weight-bold">Amount: </label> $ {{ $expense->amount }}
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-success">Back</a>
            <a href="{{ route('expense.edit', ['expense' => $expense->id]) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('home') }}" class="btn btn-danger float-right">Delete</a>
        </div>
    </div>
</div>
@endsection
