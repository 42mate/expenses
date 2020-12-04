<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        @guest
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="{{ route('register') }}" >
                    Register
                </a>
            </li>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="{{ route('login') }}" >
                    Sign In
                </a>
            </li>
        @else

        <li  class="nav-item dropdown no-arrow">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>&nbsp; Dashboard</span>
            </a>
        </li>
        <li  class="nav-item dropdown no-arrow">
            <a class="nav-link" href="{{ route('expense.create') }}">
                <i class="fas fa-money-bill-wave"></i>
                <span>&nbsp; Add Expense</span>
            </a>
        </li>

        <li  class="nav-item dropdown no-arrow">
            <a class="d-sm-none nav-link" data-toggle="collapse" href="#accordionSidebar" role="button" aria-expanded="false" aria-controls="accordionSidebar">
                <i class="fas fa-bars"></i>
            </a>
        </li>


        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name }}
                </span>
                <i class="fas fa-user"></i>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('user.edit') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </a>
            </div>
        </li>
        @endguest
    </ul>

</nav>
<!-- End of Topbar -->
