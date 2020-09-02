@extends('theme/master_layout')

@section('content')

    <h1>Month Flow</h1>
    <div class="card-body">
        <canvas class="chart" type="bar"
                data="/api/v1/charts/expense/month"
                width="100%"
                height="80px"
                show_legend="0">
    </div>
@endsection