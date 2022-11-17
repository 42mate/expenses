<div class="col-lg-3">
    <h4 class="mb-5"><a href="{{ $index_route }}">{{ __($title) }}</a></h4>
    <div class="mb-4">
        <div class="card">
            <div class="card-body">
                @forelse ($data as $transaction)
                    <span class=" font-weight-bold text-primary text-uppercase mb-1">
                        {{ $transaction->code }}
                    </span>
                    <span class=" mb-0 font-weight-bold text-gray-800 text-right float-right">
                        {{ $transaction->symbol }} {{ floatval($transaction->total) }}
                    </span>
                @empty
                    <div>
                        {{ __('You have no ' . $title . ' registered.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="">
        <a href="{{ $create_route }}">
            <i class="fas fa-plus"></i> {{ __("Add " . $title) }}
        </a>
    </div>
</div>
