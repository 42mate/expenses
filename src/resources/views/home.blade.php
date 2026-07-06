@extends('theme/master_layout')

@section('content')
    <div class="dashboard">
        <div class="dashboard-head">
            <div>
                <h1 class="dashboard-title">{{ __('Dashboard') }}</h1>
                <p class="dashboard-sub">
                    {{ __('Welcome back') }}, {{ Auth::user()->name }} — {{ __("here's your money at a glance.") }}
                </p>
            </div>
            <div class="dashboard-actions">
                <a href="{{ route('expense.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ __('Add expense') }}
                </a>
                <a href="{{ route('incomes.create') }}" class="btn btn-ghost">
                    <i class="fas fa-plus me-1"></i> {{ __('Add income') }}
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <div class="row g-4">
                    <x-expense-widget title="Expenses"/>
                    <x-expense-widget title="Incomes"/>

                    <div class="col-12">
                        <div class="card dashboard-card h-100">
                            <div class="dashboard-card-header">
                                <span class="dc-title">
                                    <span class="dc-icon is-expense"><i class="fas fa-chart-pie"></i></span>
                                    {{ __('Expenses by category') }}
                                </span>
                                <span class="kpi-sub">{{ __('This month') }} · {{ $displayCurrency->code }}</span>
                            </div>
                            <div class="dashboard-card-body">
                                @if (!empty($expenseCategories))
                                    <div class="dash-chart">
                                        <canvas id="expenseCategoryChart"></canvas>
                                    </div>
                                @else
                                    <div class="dc-empty">
                                        <i class="fas fa-chart-pie"></i>
                                        <p>{{ __('No expenses registered this month yet.') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <x-wallet-balance-widget />
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
        var el = document.getElementById('expenseCategoryChart');
        if (!el || typeof Chart === 'undefined') return;

        var labels = @json($expenseCategories ?? []);
        var values = @json($expenseCategoryTotals ?? []);
        var palette = ['#6d67f6', '#22c55e', '#f59e0b', '#ef4444', '#38bdf8',
            '#a855f7', '#14b8a6', '#ec4899', '#eab308', '#f97316', '#84cc16', '#64748b'];
        var colors = labels.map(function (_, i) { return palette[i % palette.length]; });
        var total = values.reduce(function (a, b) { return a + Number(b); }, 0);

        new Chart(el.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{ data: values, backgroundColor: colors, borderWidth: 0 }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 62,
                legend: {
                    position: 'right',
                    labels: { fontColor: '#9aa1ad', padding: 12, boxWidth: 12 }
                },
                tooltips: {
                    callbacks: {
                        label: function (item, data) {
                            var v = data.datasets[0].data[item.index] || 0;
                            var pct = total ? Math.round(v / total * 100) : 0;
                            return ' ' + data.labels[item.index] + ': {{ $displayCurrency->symbol }} ' +
                                Number(v).toLocaleString(undefined, {
                                    minimumFractionDigits: 2, maximumFractionDigits: 2
                                }) + ' (' + pct + '%)';
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
