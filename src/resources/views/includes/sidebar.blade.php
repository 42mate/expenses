<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
    <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{ route('expense.index') }}">
        <i class="fas fa-fw fa-cog"></i>
        <span>{{ __('Expenses') }}</span>
    </a>
    <a class="nav-link" href="{{ route('recurrent_expense.index') }}">
        <i class="far fa-calendar-alt"></i>
        <span>{{ __('Recurrent Expenses') }}</span>
    </a>

    <a class="nav-link " href="{{ route('wallet.index') }}">
        <i class="fas fa-wallet"></i>
        <span>{{ __('Wallets') }}</span>
    </a>
    <a class="nav-link " href="{{ route('category.index') }}" >
        <i class="fas fa-tasks"></i>
        <span>{{ __('Categories') }}</span>
    </a>
    <a class="nav-link " href="{{ route('tag.index') }}" >
        <i class="fas fa-tags"></i>
        <span>{{ __('Tags') }}</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
        <i class="fas fa-chart-bar"></i>
        <span>Reports</span>
    </a>
    <div id="collapseReports" class="collapse" aria-labelledby="collapseReports" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('reports.month_flow') }}">Month Flow</a>
        </div>
    </div>
</li>



<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
