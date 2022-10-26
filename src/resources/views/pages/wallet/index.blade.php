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
                                <th>{{ __('Balance') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                @endif
                <tr class="">
                    <td class="">{{ $wallet->name }}</td>
                    <td>
                        $ {{ $wallet->balance }}
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
                    <p>{{ __("You don't have any wallet") }}</p>
                    <div>
                        <a href="{{ route('wallet.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>  {{ __('Add') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
