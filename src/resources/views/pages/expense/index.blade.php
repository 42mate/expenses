@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-3">
            Expenses
        </h1>
        <div class="">
            <div class="table">

                @forelse ($expenses as $expense)
                    @if ($loop->first)
                        <table class="table table-bordered data-table-ajax"
                               endpoint="/api/v1/expenses/table"
                               columns="date,category_name,wallet,description,tags_formatted,amount_formatted"
                               linkeable="date,/expense/%id"
                               width="100%"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th class="d-block d-sm-table-cell">Category</th>
                                <th class="d-block d-sm-table-cell">Wallet</th>
                                <th class="d-block d-sm-table-cell">Description</th>
                                <th class="d-block d-sm-table-cell">Tags</th>
                                <th class="d-block d-sm-table-cell">Total</th>
                            </tr>
                            </thead>
                    @endif
                    @if ($loop->last)
                        </table>
                    @endif
                @empty
                    <p class="text-center">Good, you don't have any expense in this month.</p>
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
