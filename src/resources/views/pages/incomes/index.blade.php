@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-5">
            <i class="fa-solid fa-sack-dollar"></i> {{ __('Incomes') }}
            <div class="add_control">
                <a href="{{ route('incomes.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add Income") }}
                </a>
            </div>
        </h1>
        <div class="">
            @include('includes._form_transactions_filter', ['type' => 'incomes', 'errors' => $errors])

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
                                <th class="d-block d-sm-table-cell">{{__('Currency')}}</th>
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
                        <td class="d-block d-sm-table-cell">
                            {{ $income->currency->code }}
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
                            @include('includes._totals_transactions_index', ['totals' => $totals])
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
