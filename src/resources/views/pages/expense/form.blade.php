@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1>
            @if (empty($model->id)) Add @else Edit @endif Expense
            <button type="button"  class="btn btn-info float-right sidebarCollapse">
                <span><i class="far fa-calendar-alt"></i> Recurrent</span>
            </button>
        </h1>
        <div class="side-wrapper">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                    @if (empty($model) or empty($model->id))
                        @php
                            $route = route('expense.store');
                            $method = 'POST';
                        @endphp
                    @else
                        @php
                            $route = route('expense.update', ['expense' => $model->id]);
                            $method = 'PUT';
                        @endphp
                    @endif
                    {!! Form::model($model, ['method' => $method, 'url' => $route]) !!}
                    <div class="form-group">
                        {!! Form::label('Amount:', null, ['class' => 'font-weight-bold']) !!}
                        {!! Form::number('amount', null, ['step' => '.01', 'class' => [ 'form-control',  ($errors->has('amount') ? 'is-invalid' : '')]]) !!}
                        @error('amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('Date:', null, ['class' => 'font-weight-bold']) !!}
                        {!! Form::date('date', (empty($model->date) ? Carbon\Carbon::now()->format('Y-m-d') : $model->date->format('Y-m-d')), ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}
                        @error('date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('Description:', null, ['class' => 'font-weight-bold']) !!}
                        {!! Form::text('description', null, ['class' => [ 'form-control',  ($errors->has('description') ? 'is-invalid' : '')]]) !!}
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div>
                            <label for="email" class="font-weight-bold">Category:</label>
                            <span class="mt-1 mb-1 float-right">
                        <a href="{{ route('category.create', ['gt=expense.create']) }}"><i class="fas fa-plus"></i> {{ __('Add Category') }}</a>
                    </span>
                        </div>
                        <x-categories-drop-down name="category_id" selected="{{ empty($model) ? 0 : $model->category_id }}"/>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div>
                            <label for="email" class="font-weight-bold">Wallet:</label>
                            <span class="mt-1 mb-1 float-right">
                        <a href="{{ route('wallet.create', ['gt=expense.create']) }}"><i class="fas fa-plus"></i> {{ __('Add Wallet') }}</a>
                    </span>
                        </div>
                        <x-wallet-drop-down name="wallet_id" selected="{{ empty($model) ? 0 : $model->wallet_id }}"/>
                        @error('wallet_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('Tags:', null, ['class' => 'font-weight-bold']) !!}

                        <tags-input :tags="{{ !empty($request_tags) ? $request_tags : (empty($model->tags) ? '[]' : $model->tags) }}"></tags-input>

                        @error('tags')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror


                    </div>
                    <div>
                        {{ Form::hidden('recurrent_expense_id', (empty($model->recurrent_expense_id) ? 0 : $model->recurrent_expense_id)) }}
                    </div>
                    <div class="form-group mt-5">
                        {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                        <a class="btn btn-warning" href="{{ route('expense.index') }}">Cancel</a>
                        <a href="{{ route('expense.delete', ['expense' => $model->id]) }}" class="btn btn-danger float-right"
                           onclick="event.preventDefault(); document.getElementById('delete-form-{{ $model->id }}').submit();">
                            Delete
                        </a>
                    </div>

                    {!! Form::close() !!}

                    <form id="delete-form-{{ $model->id }}" action="{{ route('expense.delete', ['expense' => $model->id]) }}"
                          method="POST" style="display: none;">
                        {{ method_field('DELETE') }}
                        @csrf
                    </form>
                </div>
            </div>
            <div class="sidepanel" id="fill-from-recurrent">
                <div class="mb-4">
                    <label class="font-weight-bold">Use a recurrent expense.</label>
                    <button type="button" class="btn btn-danger font-weight-bold float-right sidebarCollapse">
                        <span>X</span>
                    </button>
                </div>

                <table width="100%" class="table table-bordered" >
                    <thead>
                    <tr>
                        <th class=""></th>
                        <th class="d-block d-sm-table-cell">Category</th>
                        <th class="d-block d-sm-table-cell">Description</th>
                        <th class="d-block d-sm-table-cell">Last Payment</th>
                        <th class="d-block d-sm-table-cell">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recurrent_expenses as $recurrent)
                        <tr @if ($recurrent->usedThisMonth())
                            style="background-color: rgb(247 247 247 / 22%)"
                            @endif>
                            <td class="">
                                <span class="btn btn-info fill-expense" data-expense="{{ $recurrent->getJsonData() }}">Use</span>
                            </td>
                            <td class="d-block d-sm-table-cell">
                                {{ $recurrent->category->category }}
                            </td>
                            <td class="d-block d-sm-table-cell">
                                {{ $recurrent->description }}
                            </td>
                            <td class="d-block d-sm-table-cell">
                                {{ empty($recurrent->last_use_date) ? 'Never' : $recurrent->last_use_date->format('m/d/Y') }}
                            </td>
                            <td class="d-block d-sm-table-cell">
                                <strong>{{ $recurrent->amount_formatted }}</strong>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
