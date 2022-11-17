<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
    <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('expense.index') }}" data-toggle="collapse" data-target="#collapseExpense" aria-expanded="true" aria-controls="collapseExpense">
        <i class="fas fa-money-bill-wave"></i>
        <span>{{ __('Expenses') }}</span>
    </a>
    <div id="collapseExpense" class="collapse" aria-labelledby="collapseExpense" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('expense.index') }}">
                <i class="fas fa-money-bill-wave"></i>
                <span>{{ __('Expenses') }}</span>
            </a>
            <a class="collapse-item " href="{{ route('category.index') }}" >
                <i class="fas fa-tasks"></i>
                <span>{{ __('Categories') }}</span>
            </a>
            <a class="collapse-item" href="{{ route('recurrent_expense.index') }}">
                <i class="far fa-calendar-alt"></i>
                <span>{{ __('Recurrent') }}</span>
            </a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('incomes.index') }}" data-toggle="collapse" data-target="#collapseIncome" aria-expanded="true" aria-controls="collapseIncome">
        <i class="fas fa-cash-register"></i>
        <span>{{ __('Incomes') }}</span>
    </a>
    <div id="collapseIncome" class="collapse" aria-labelledby="collapseIncome" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('incomes.index') }}">
              <i class="fa-solid fa-sack-dollar"></i>
              <span>{{ __('Incomes') }}</span>
            </a>
            <a class="collapse-item" href="{{ route('income_source.index') }}" >
                <i class="fa-brands fa-sourcetree"></i>
                <span>{{ __('Sources') }}</span>
            </a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('wallet.index') }}" data-toggle="collapse" data-target="#collapseWallet" aria-expanded="true" aria-controls="collapseWallet">
        <i class="fas fa-wallet"></i>
        <span>{{ __('Wallets') }}</span>
    </a>
    <div id="collapseWallet" class="collapse" aria-labelledby="collapseWallet" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('wallet.index') }}">
                <i class="fas fa-wallet"></i>
                <span>{{ __('Wallets') }}</span>
            </a>
{{--            <a class="collapse-item" href="{{ route('wallet.index') }}" >--}}
{{--                <i class="fa-solid fa-money-bill-transfer"></i>--}}
{{--                <span>{{ __('Transfer') }}</span>--}}
{{--            </a>--}}
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link " href="{{ route('expense.pending') }}">
        <i class="fa-solid fa-bell"></i>
        <span>{{ __('Pending Payments') }}</span>
    </a>
</li>

{{--<li class="nav-item">--}}
{{--    <a class="nav-link " href="{{ route('wallet.index') }}">--}}
{{--        <i class="fa-solid fa-building-columns"></i>--}}
{{--        <span>{{ __('Loans') }}</span>--}}
{{--    </a>--}}
{{--</li>--}}

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
        <i class="fas fa-chart-bar"></i>
        <span>{{ __('Reports') }}</span>
    </a>
    <div id="collapseReports" class="collapse" aria-labelledby="collapseReports" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('reports.month_flow') }}">{{ __('Expenses by Month') }}</a>

            <a class="collapse-item" href="{{ route('reports.expenses_by_category') }}">{{ __('Expenses by Category') }}</a>
        </div>
    </div>
</li>



<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
