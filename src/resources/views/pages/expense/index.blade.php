@extends('theme/master_layout')

@section('content')
    <div class="card">
        <div class="card-header">
            Expenses
        </div>
        <div class="card-body">
            <div class="table">
                @forelse ($expenses as $expense)
                    @if ($loop->first)
                        <table class="table table-bordered data-table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            @endif
                            <tr>
                                <td>
                                    <a href="{{ route('expense.view', ['expense' => $expense->id]) }}">
                                        {{ date('Y-m-d', strtotime($expense->date)) }}
                                    </a>
                                </td>
                                <td>{{ $expense->category->category }}</td>
                                <td>{{ $expense->description }}</td>
                                <td class="text-right">$ {{ $expense->amount }}</td>
                            </tr>
                            @if ($loop->last)
                        </table>
                    @endif
                @empty
                    <p class="text-center">Good, you don't have any expense</p>
                    <div class="text-center">
                        <a href="{{ route('expense.create') }}" class="btn btn-primary">
                            Add your first expense
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
