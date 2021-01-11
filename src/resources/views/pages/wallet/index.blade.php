@extends('theme.master_layout')

@section('content')
    <div class="col-md-8">
        <h1 class="mb-5">
            <i class="fas fa-wallet"></i> {{ __('Wallets') }}
            <div class="add_control">
                <a href="{{ route('wallet.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add wallet") }}
                </a>
            </div>
        </h1>

        <div class="">
            <div class="table ">
                @forelse ($wallets as $wallet)
                    <div class="row mb-1">
                        <div class="col-md-8">{{ $wallet->name }}</div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('wallet.edit', ['wallet' => $wallet->id]) }}" class="btn-primary btn">
                                Edit
                            </a>


                            <form method="POST" action="{{ route('wallet.delete', ['wallet' => $wallet->id]) }}" class="d-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </div>
                    </div>
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
    </div>
@endsection
