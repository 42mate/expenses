@extends('theme/master_layout')

@section('content')
<div class="card">
    <div class="card-header">
        Expense
    </div>
    <div class="card-body">
        <div class="row">
            <label>Date: </label> {{ $expense->date }}
        </div>
        <div class="row">
            <label>Category: </label> {{ $expense->category->category}}
        </div>
        <div class="row">
            <label>Description: </label> {{ $expense->description }}
        </div>
        <div class="row">
            <label>Amount: </label> $ {{ $expense->amount }}
        </div>
        <div class="row">
            <a href="{{ route('home') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>
@endsection
