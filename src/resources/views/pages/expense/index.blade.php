@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-3">
            Expenses
        </h1>
        <div class="">
            <div class="table">
                <div class="row">
                    <div class="form-group col-sm-12 col-md-3">
                        <label for="dpFilterSearch">Search:</label>
                        {!! Form::text('dpFilterSearch', null, ['class' => 'form-control', 'id' => 'dpFilterSearch']) !!}
                    </div>
                    <div class="form-group  col-sm-12 col-md-3">
                        <label for="email">Category:</label>
                        <x-categories-drop-down id="dpFilterCategory" addEmpty="true" name="dpFilterSearch" selected="0" useAsValue="category" />
                    </div>
                    <div class="form-group col-sm-12 col-md-3">
                        <label for="email">Date:</label>
                        {!! Form::date('date', null, ['class' => 'form-control', 'id' => 'dpFilterDate']) !!}
                    </div>
                </div>
                @forelse ($expenses as $expense)
                    @if ($loop->first)
                        <table class="table table-bordered data-table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th class="d-block d-sm-table-cell">Category</th>
                                <th class="d-block d-sm-table-cell">Description</th>
                                <th class="d-block d-sm-table-cell">Total</th>
                            </tr>
                            </thead>
                            @endif
                            <tr>
                                <td>
                                    <a href="{{ route('expense.view', ['expense' => $expense->id]) }}">
                                        {{

                                        date('yy-m-d', strtotime($expense->date))
                                        }}
                                    </a>
                                </td>
                                <td class="d-block d-sm-table-cell">{{ $expense->category->category }}</td>
                                <td class="d-block d-sm-table-cell">{{ $expense->description }}</td>
                                <td class="d-block d-sm-table-cell font-weight-bold text-right">$ {{ $expense->amount }}</td>
                            </tr>
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
