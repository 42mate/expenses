@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-5">
            <i class="fas fa-money-bill-wave"></i> {{ __('Expenses') }}
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
                    <label for="category"> {{ __('Category') }}:</label>

                    <x-categories-drop-down name="category_id"
                                            use_as_label="category"
                                            selected="{{ request()->get('category_id', null) }}"
                                            addEmpty="true"
                                            addDefault="true"
                    />

                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="category">{{ __('Wallet') }}:</label>

                    <x-wallet-drop-down name="wallet_id"
                        use_as_label="name"
                        selected="{{ request()->get('wallet_id', null) }}"
                        addDefault="true"
                        addEmpty="true"/>

                    @error('wallet_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="category">{{ __('Description') }}:</label>
                    {!! Form::text('description', 
                        request()->get('description', null), 
                        ['class' => [ 'form-control',  
                            ($errors->has('description') ? 'is-invalid' : '')]]) !!}

                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="category"> {{ __('Date From') }}:</label>
                    {!! Form::date('date_from', 
                        (empty(request()->get('date_from', null)) 
                            ? '' : request()->get('date_from')), 
                            ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}

                    @error('date_from')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="category"> {{ __('Date To') }}:</label>
                    {!! Form::date('date_to',  
                        (empty(request()->get('date_to', null)) 
                            ? '' : request()->get('date_to')), 
                            ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}
                    @error('date_to')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-12 text-right form-reverse">
                    {!! Form::button('<i class="fas fa-filter"></i> ' . __('Filter'), 
                        ['class' => 'btn btn-primary', 
                         'type' => 'submit', 
                         'value' => 'filter', 
                         'name' => 'action']) !!}

                    <a href="{{ route('expense.index') }}" class="btn btn-secondary">
                        <i class="fas fa-minus-circle"></i> {{ __('Reset') }}
                    </a>
                    {!! Form::button('<i class="fas fa-file-excel"></i>' . __('Export'), 
                        ['class' => 'btn btn-success', 
                         'type' => 'submit', 
                         'value' => 'xls', 
                         'name' => 'action']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div>
                @forelse ($expenses as $expense)
                    @if ($loop->first)
                        <table class="table"
                               width="100%"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th class="d-block d-sm-table-cell">{{ __('Category') }}</th>
                                <th class="d-block d-sm-table-cell">{{ __('Wallet') }}</th>
                                <th class="d-block d-sm-table-cell">{{ __('Description') }}</th>
                                <th class="d-block d-sm-table-cell text-right">{{ __('Total') }}</th>
                                <th class="d-block d-sm-table-cell text-right"></th>
                            </tr>
                            </thead>
                    @endif
                        <tr>
                            <td>
                                <span class="font-weight-bold">
                                    {{ $expense->date->format('Y-m-d') }}
                                </span>
                            </td>
                            <td class="d-block d-sm-table-cell">
                                <a href="{{ route('expense.index', 
                                    ['category_id' => $expense->category_idx]) }}">
                                    {{ $expense->category_name }}
                                </a>
                            </td>
                            <td class="d-block d-sm-table-cell">
                                <a href="{{ route('expense.index', 
                                    ['wallet_id' => $expense->wallet_idx]) }}">
                                    {{ $expense->wallet_name }}
                                </a>
                            </td>
                            <td class="d-block d-sm-table-cell">
                                {{ $expense->description }}
                            </td>
                            <td class="d-block d-sm-table-cell font-weight-bold text-right">
                                {{ $expense->amount_formatted }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('expense.edit', [$expense->id]) }}" 
                                    class="btn btn-primary btn-sm">
                                   {{ __('Edit') }}
                                </a>
                            </td>
                        </tr>
                    @if ($loop->last)
                        </table>
                        <div>
                            <div class="float-right pr-5 text-righ">
                        <span class="font-weight-bold text-right">
                            {{ __('TOTAL') }}: $ {{ $total }}
                        </span>
                            </div>
                            {{ $expenses->withQueryString()->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                @empty
                    <p class="text-center">{{ __("Good, you don't have any expense in this month.") }}</p>
                    <div class="text-center">
                        <a href="{{ route('expense.create') }}" class="btn btn-primary">
                            {{ __("Add your first expense") }}
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
