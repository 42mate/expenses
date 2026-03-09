<div class="spacer"></div>
<div class="d-flex flex-row-reverse">
    <div class="d-table mt-3 mb-3">
        @foreach($totals as $total)
            <div class="small font-weight-bold text-end d-table-row">
                <span  class="text-end d-table-cell ">
                    {{ $total['currency']->code }}&nbsp;{{ $total['currency']->symbol }} {{ number_format($total['sum'], 2) }}
                </span>
            </div>
        @endforeach
    </div>
</div>
