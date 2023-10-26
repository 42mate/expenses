<div class="col-lg-3 mb-5">
    <div class="mb-4">
        <div class="card">
            <div class="card-header">
                {{ __($title) }}
                <div class="small float-right">
                    <a href="{{ $create_route }}">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @forelse ($data as $transaction)
                    <div>
                        <span class="small mb-1">
                            {{ __($transaction->name) }} ({{ __($transaction->code) }})
                        </span>
                        <span class="small mb-0 font-weight-bold text-gray-800 text-right float-right">
                            {{ $transaction->symbol }} {{ floatval($transaction->total) }}
                        </span>
                    </div>
                @empty
                    <div class="small text-center">
                        {{ __('You have no ' . $title . ' registered.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
