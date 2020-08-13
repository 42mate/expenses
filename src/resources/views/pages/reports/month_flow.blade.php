@extends('theme/master_layout')

@section('content')
    <div class="card">
        <div class="card-header">
            Month Flow
        </div>
        <div class="card-body">
            <canvas class="chart" type="bar"
                    data="/api/v1/charts/expense/month"
                    width="100%"
                    height="80px"
                    show_legend="0">
        </div>
    </div>
@endsection