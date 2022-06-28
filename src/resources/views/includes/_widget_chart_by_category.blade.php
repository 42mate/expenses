<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0">{{ __("Expenses by categories") }}</h6>
    </div>
    <div class="card-body">
        @if (count($expenses) === 0)
            <div class="text-center">
                {{  __("Good, you don't have any expense in this month.") }}
            </div>
        @else
            <canvas class="chart" type="pie"
                    data="/api/v1/charts/categories"
                    width="100%"
                    height="80px"
                    show_legend="0">
            </canvas>
        @endif
    </div>
</div>
