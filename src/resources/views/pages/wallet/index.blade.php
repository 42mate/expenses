@extends('theme.master_layout')

@section('content')
    <div class="">
        <h1 class="mb-5">
            <i class="fas fa-wallet"></i> {{ __('Wallets') }}
            <div class="add_control">
                <a href="{{ route('wallet.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add wallet") }}
                </a>
            </div>
        </h1>

        <div class="">
            @forelse ($wallets as $wallet)
                @if ($loop->first)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Currency') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                @endif
                <tr class="">
                    <td class="">{{ $wallet->name }}</td>
                    <td class="">{{ $wallet->currency->code }}</td>
                    <td>
                        $ {{ floatval($wallet->balance) }}
                    </td>
                    <td class="text-right">
                        <a href="{{ route('wallet.edit', ['wallet' => $wallet->id]) }}" class="btn-primary btn  btn-sm">
                            {{ __('Edit') }}
                        </a>

                        <form method="POST" action="{{ route('wallet.delete', ['wallet' => $wallet->id]) }}" class="d-inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                        </form>
                    </td>
                </tr>
                @if ($loop->last)
                    </table>
                @endif
            @empty
                <div class="text-center">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-2">
                                {{ __('Wallets are where you have the money, a bank account, a digital wallet, a crypto wallet, or a box with money in your house.') }}
                            </div>
                            <div class="mb-2">
                                {{ __('Each wallet have a given currency') }}
                            </div>
                            <div class="mb-2">
                                {{ __('When you create a wallet, you have to set how many money you have on that wallet') }}
                            </div>
                            <div class="mb-2">
                                {{ __('Every time you add an Expense and you select a wallet, the money will be discounted from the wallet') }}
                            </div>
                            <div class="mb-2">
                                {{ __('Every time you add an Income and you select a wallet, the money will be added from the wallet') }}
                            </div>
                            <div class="mb-2">
                                {{ __('This will help you the have the wallet balance') }}
                            </div>
                            <div class="mb-2">
                                {{ __('On a Expense or an Income, if you set a wallet on the transaction, the currency of the wallet will be set to the transaction.') }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('wallet.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>  {{ __('Add your first wallet') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
