<div class="recurrent-drawer">
    <div class="recurrent-drawer__header">
        <div>
            <h2 class="recurrent-drawer__title">{{ __('Recurrent expenses') }}</h2>
            <p class="recurrent-drawer__sub">{{ __('Pick one to fill in the form') }}</p>
        </div>
        <button type="button" class="recurrent-drawer__close sidebarCollapse" aria-label="{{ __('Close') }}">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="recurrent-drawer__body">
        @forelse($recurrent_expenses as $recurrent)
            <div @class(['recurrent-item', 'is-paid' => $recurrent->usedThisMonth()])>
                <div class="recurrent-item__main">
                    <span class="recurrent-item__desc">{{ $recurrent->description }}</span>
                    <span class="recurrent-item__meta">
                        <i class="far fa-clock"></i>
                        {{ empty($recurrent->last_use_date)
                            ? __('Never used')
                            : __('Last') . ' ' . $recurrent->last_use_date->format('M d, Y') }}
                        @if($recurrent->usedThisMonth())
                            <span class="recurrent-item__badge">{{ __('Used this month') }}</span>
                        @endif
                    </span>
                </div>
                <div class="recurrent-item__side">
                    <span class="recurrent-item__amount">{{ $recurrent->amount_formatted }}</span>
                    <button type="button" class="btn btn-primary btn-sm fill-expense"
                            data-expense="{{ $recurrent->getJsonData() }}">
                        <i class="fas fa-arrow-left"></i> {{ __('Use') }}
                    </button>
                </div>
            </div>
        @empty
            <div class="recurrent-empty">
                <i class="far fa-calendar-alt"></i>
                <p>{{ __('You have no recurrent expenses yet.') }}</p>
            </div>
        @endforelse
    </div>
</div>
