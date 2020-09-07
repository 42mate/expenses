@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-3">
            <i class="fas fa-fw fa-cog"></i> {{ __('Expenses') }}
            <div class="add_control">
                <a href="{{ route('expense.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add expense") }}
                </a>
            </div>
        </h1>
        <div class="">
            <div class="filter">
                {!! Form::open(['url' => route('expense.index'), 'class' => 'row', 'method' => 'GET']) !!}

                <div class="form-group col-md-3">
                    <label for="category">Category:</label>

                    <x-categories-drop-down name="category_id" selected="{{ request()->get('category_id', null) }}" addEmpty="true"/>

                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="category">Wallet:</label>

                    <x-wallet-drop-down name="wallet_id" selected="{{ request()->get('wallet_id', null) }}" addEmpty="true"/>

                    @error('wallet_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="category">Tag:</label>
                    {!! Form::text('tags', request()->get('tags', null), ['class' => [ 'form-control',  ($errors->has('tags') ? 'is-invalid' : '')]]) !!}
                    @error('tags')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="category">Description:</label>
                    {!! Form::text('description', request()->get('description', null), ['class' => [ 'form-control',  ($errors->has('description') ? 'is-invalid' : '')]]) !!}
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="form-group col-md-6">
                    <label for="category">Date From:</label>
                    {!! Form::date('date_from', (empty(request()->get('date_from', null)) ? '' : request()->get('date_from')), ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}

                    @error('date_from')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="category">Date To:</label>
                    {!! Form::date('date_to',  (empty(request()->get('date_to', null)) ? '' : request()->get('date_to')), ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}
                    @error('date_to')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-12 text-right">
                    {!! Form::button('<i class="fas fa-file-excel"></i> Export', ['class' => 'btn btn-success', 'type' => 'submit', 'value' => 'xls', 'name' => 'action']) !!}


                    <a href="{{ route('expense.index') }}" class="btn btn-secondary"><i class="fas fa-minus-circle"></i> Reset</a>

                    {!! Form::button('<i class="fas fa-filter"></i> Filter', ['class' => 'btn btn-primary', 'type' => 'submit', 'value' => 'filter',  'name' => 'action']) !!}

                </div>
                {!! Form::close() !!}
            </div>
            <div class="table">
                @forelse ($expenses as $expense)
                    @if ($loop->first)
                        <table class="table table-bordered"
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
                            <tr>
                                <td><a href="{{ route('expense.edit', [$expense->id]) }}" class="font-weight-bold">{{ $expense->date }}</a></td>
                                <td class="d-block d-sm-table-cell"><a href="{{ route('expense.index', ['category_id' => $expense->category->id]) }}">{{ $expense->category->category }}</a></td>
                                <td class="d-block d-sm-table-cell"><a href="{{ route('expense.index', ['wallet_id' => $expense->wallet_id]) }}">{{ $expense->wallet }}</a></td>
                                <td class="d-block d-sm-table-cell">{{ $expense->description }}</td>
                                <td class="d-block d-sm-table-cell">
                                    @foreach($expense->tags as $tag)
                                        <a href="{{ route('expense.index', ['tags' => $tag->name]) }}">{{ $tag->name }}</a>&nbsp;
                                    @endforeach
                                </td>
                                <td class="d-block d-sm-table-cell font-weight-bold">{{ $expense->amount_formatted }}</td>
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
                <div>
                    <div class="float-right pr-5">
                        <span class="font-weight-bold">
                            TOTAL: $ {{ $total }}
                        </span>
                    </div>
                    {{ $expenses->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
