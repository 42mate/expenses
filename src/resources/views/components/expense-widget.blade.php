<div class="col-lg-3 mb-5">
    <h4 class="mb-5"><a href="{{ $index_route }}">{{ __($title) }}</a></h4>
    <div class="mb-4">
        <div class="card">
            <div class="card-body">
                @forelse ($data as $transaction)
                    <div>
                        <span class=" font-weight-bold text-primary small mb-1">
                        {{ __($transaction->name) }} ({{ __($transaction->code) }})
                    </span>
                        <span class=" mb-0 font-weight-bold text-gray-800 text-right float-right">
                        {{ $transaction->symbol }} {{ floatval($transaction->total) }}
                    </span>
                    </div>
                @empty
                    <div>
                        {{ __('You have no ' . $title . ' registered.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="small">
        <a href="{{ $create_route }}">
            <i class="fas fa-plus"></i> {{ __("Add " . $title) }}
        </a>
    </div>
</div>
