@extends('theme/master_layout')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    <div class="card-body">
                        <div class="row">
                            <x-expense-widget title="Expenses"/>
                            <x-expense-widget title="Incomes"/>
                            <x-wallet-balance-widget />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
