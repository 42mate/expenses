@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-5">
            <i class="fas fa-cash-register"></i> {{ __('Incomes') }}
            <div class="add_control">
                <a href="{{ route('incomes.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add Income") }}
                </a>
            </div>
        </h1>
        <div class="">
            <div class="filter">
                {!! Form::open(['url' => route('incomes.index'), 'class' => 'row', 'method' => 'GET']) !!}
                <div class="form-group col-md-3">
                    <label for="income_source_id">{{ __('Income source') }}:</label>
                    <x-income-source-drop-down name="income_source_id"
                        use_as_label="source"
                        selected="{{ request()->get('income_source_id', null) }}"
                        addEmpty="true"
                        addDefault="true"
                    />
                    @error('income_source_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="wallet_id">{{ __('Wallet') }}:</label>
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
                        ['class' => [ 'form-control',  ($errors->has('description') ? 'is-invalid' : '')]]) !!}
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="category">{{__('Date from')}}:</label>
                    {!! Form::date('date_from', 
                        (empty(request()->get('date_from', null)) ? '' : request()->get('date_from')),
                        ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}
                    @error('date_from')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="category">{{__('Date to')}}:</label>
                    {!! Form::date('date_to',  
                        (empty(request()->get('date_to', null)) ? '' : request()->get('date_to')), 
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
                    <a href="{{ route('incomes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-minus-circle"></i>
                        {{ __('Reset') }}
                    </a>
                    {!! Form::button('<i class="fas fa-file-excel"></i> ' . __('Export'), 
                        ['class' => 'btn btn-success', 
                         'type' => 'submit', 
                         'value' => 'xls', 
                         'name' => 'action']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="content">
                @forelse ($incomes as $income)
                    @if ($loop->first)
                        <table class="table"
                               width="100%"
                               cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th class="d-block d-sm-table-cell">{{__('Income Source') }}</th>
                                <th class="d-block d-sm-table-cell">{{__('Wallet')}}</th>
                                <th class="d-block d-sm-table-cell">{{__('Description')}}</th>
                                <th class="d-block d-sm-table-cell text-right">{{__('Total')}}</th>
                                <th class="d-block d-sm-table-cell text-right"></th>
                            </tr>
                        </thead>
                    @endif

                    <tr>
                        <td>
                            <span class="font-weight-bold">
                                {{ $income->date->format('Y-m-d') }}
                            </span>
                        </td>
                        <td class="d-block d-sm-table-cell">
                            <a href="{{ route('incomes.index', ['income_source_id' => $income->income_source_idx]) }}">
                                {{ $income->income_source_name }}
                            </a>
                        </td>
                        <td class="d-block d-sm-table-cell">
                            <a href="{{ route('incomes.index', ['wallet_id' => $income->wallet_idx]) }}">
                                {{ $income->wallet_name }}
                            </a>
                        </td>
                        <td class="d-block d-sm-table-cell">
                            {{ $income->description }}
                        </td>
                        <td class="d-block d-sm-table-cell font-weight-bold text-right">
                            {{ $income->amount_formatted }}
                        </td>
                        <td class="text-right">
                            <a href="{{ route('incomes.edit', [$income->id]) }}" 
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
                                    {{ __('Total') }}: $ {{ $total }}
                                </span>
                            </div>
                            {{ $incomes->withQueryString()->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                @empty
                    <p class="text-center">
                        {{ __('Bad news, you don\'t have any income in this month.') }}
                    </p>
                    <div class="text-center">
                        <a href="{{ route('incomes.create') }}" class="btn btn-primary">
                            {{ __('Add your first Income') }}
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
