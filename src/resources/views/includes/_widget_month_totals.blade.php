<div class="mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div
                        class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        {{ __('Today') }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        $ {{ $today }}</div>
                </div>
                <div class="col-auto">
                    <i class="far fa-calendar-plus fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div
                        class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        {{ __('Month') }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        $ {{ $month }}</div>
                </div>
                <div class="col-auto">
                    <i class="far fa-calendar-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div
                        class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        {{ __('Last Month') }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        $ {{ $last_month }}</div>
                </div>
                <div class="col-auto">
                    <i class="far fa-calendar-check fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
