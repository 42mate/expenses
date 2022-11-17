<div class="d-flex flex-row-reverse">
    <div class="d-table mt-3 mb-3">
        @foreach($totals as $total)
            <div class="small font-weight-bold text-right d-table-row">
                <span class="text-right d-table-cell ">&nbsp;{{ $total['currency']->symbol }} {{ $total['sum'] }}</span>
            </div>
        @endforeach
    </div>
</div>
