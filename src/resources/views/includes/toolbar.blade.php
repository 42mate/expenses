
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <ul class="navbar-nav ms-auto">
        @guest
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="{{ route('register') }}" >
                    {{ __('Register') }}
                </a>
            </li>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="{{ route('login') }}" >
                    {{ __('Sign In') }}
                </a>
            </li>
        @else
        <li  class="nav-item dropdown no-arrow d-none d-lg-block">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>&nbsp; {{ __('Dashboard') }}</span>
            </a>
        </li>
        <li  class="nav-item dropdown no-arrow">
            <a class="nav-link" href="{{ route('expense.create') }}" title="{{ __('Add Expense') }}">
                <i class="fas fa-money-bill-wave"></i>
                <span class="d-none d-md-inline">&nbsp; {{ __('Add Expense') }}</span>
            </a>
        </li>

        <!-- Nav Item - Display currency selector -->
        <li class="nav-item dropdown no-arrow d-flex align-items-center">
            <form method="POST" action="{{ route('display_currency.update') }}" class="m-0 px-2">
                @csrf
                <select name="display_currency_id"
                        class="form-select form-select-sm display-currency-select"
                        title="{{ __('Display currency') }}"
                        onchange="this.form.submit()">
                    @foreach(\App\Models\Currency::where('code', '!=', 'DEF')->orderBy('name')->get() as $currency)
                        <option value="{{ $currency->id }}"
                            @if(!empty($displayCurrency) && $displayCurrency->id == $currency->id) selected @endif>
                            {{ $currency->code }} {{ $currency->symbol }}
                        </option>
                    @endforeach
                </select>
            </form>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#"
                id="userDropdown" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <span class="ms-2 d-none d-lg-inline">
                        {{ Auth::user()->name }}
                    </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('user.edit') }}">
                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                    {{ __('Profile') }}
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}"
                        method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </div>
        </li>

        <!-- Nav Item - Sidebar toggle (mobile) — kept last so it's the first button from the right -->
        <li class="nav-item dropdown no-arrow">
            <a class="d-sm-none nav-link" data-bs-toggle="collapse"
                href="#accordionSidebar" role="button"
                aria-expanded="false" aria-controls="accordionSidebar">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        @endguest
    </ul>
</nav>
