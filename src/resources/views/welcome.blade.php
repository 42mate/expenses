@extends('theme/master_layout')

@section('content')
    @php
        $steps = [
            ['done' => !$status['category'], 'route' => route('category.index'),      'icon' => 'fa-tags',            'label' => __('Create your expense categories')],
            ['done' => !$status['source'],   'route' => route('income_source.index'), 'icon' => 'fa-sitemap',         'label' => __('Create your income sources')],
            ['done' => !$status['wallet'],   'route' => route('wallet.index'),        'icon' => 'fa-wallet',          'label' => __('Create your wallets')],
            ['done' => !$status['expense'],  'route' => route('expense.create'),      'icon' => 'fa-money-bill-wave', 'label' => __('Add your first expense')],
            ['done' => !$status['income'],   'route' => route('incomes.create'),      'icon' => 'fa-sack-dollar',     'label' => __('Add your first income')],
        ];
        $total = count($steps);
        $doneCount = collect($steps)->where('done', true)->count();
        $percent = $total ? round($doneCount / $total * 100) : 0;
    @endphp

    <div class="onboarding">
        <div class="card onboarding-card">
            <div class="onboarding-head">
                <div>
                    <h1 class="onboarding-title">{{ __('Welcome to Expenses') }} 👋</h1>
                    <p class="onboarding-sub">
                        {{ __('Finish these quick steps to set things up — or skip and jump straight to your dashboard.') }}
                    </p>
                </div>
                <a href="{{ route('onboarding.skip') }}" class="onboarding-skip">
                    {{ __('Skip for now') }}
                </a>
            </div>

            <div class="onboarding-progress">
                <div class="onboarding-progress__bar">
                    <span style="width: {{ $percent }}%"></span>
                </div>
                <span class="onboarding-progress__label">{{ $doneCount }}/{{ $total }} {{ __('done') }}</span>
            </div>

            <ul class="onboarding-steps">
                @foreach($steps as $step)
                    <li @class(['onboarding-step', 'is-done' => $step['done']])>
                        <span class="onboarding-step__check"><i class="fas fa-check"></i></span>
                        <span class="onboarding-step__icon"><i class="fas {{ $step['icon'] }}"></i></span>
                        <span class="onboarding-step__label">{{ $step['label'] }}</span>
                        @if($step['done'])
                            <span class="onboarding-step__badge">{{ __('Done') }}</span>
                        @else
                            <a href="{{ $step['route'] }}" class="btn btn-primary btn-sm onboarding-step__action">
                                {{ __('Do it') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="onboarding-footer">
                <a href="{{ route('onboarding.skip') }}" class="btn btn-primary">
                    {{ __('Skip & go to my dashboard') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
