@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1> @if (empty($model)) Add @else Edit @endif Expense</h1>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                @if (empty($model))
                    {!! Form::open(['url' => route('expense.store')]) !!}
                @else
                    {!! Form::model($model, ['method' => 'put', 'url' => route('expense.update', ['expense' => $model->id])]) !!}
                @endif

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
                    {!! Form::date('date', (empty($model) ? Carbon\Carbon::now()->format('Y-m-d') : \Carbon\Carbon::parse($model->date)->format('Y-m-d')), ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}
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

                <div class="form-group mt-5">
                    {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                    <a class="btn btn-warning" href="{{ route('expense.index') }}">Cancel</a>
                </div>
                {!! Form::close() !!}
            </div>

            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <label>Fill from a recurrent payment</label>

                <table width="100%" class="table table-bordered" >
                    <thead>
                        <tr>
                            <th></th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($recurrent_expenses as $recurrent)
                    <tr>
                        <td>
                            <span class="btn btn-primary fill-expense" data-expense="{{ $recurrent->getJsonData() }}">Use</span>
                        </td>
                        <td>
                            {{ $recurrent->category->category }}
                        </td>
                        <td>
                            {{ $recurrent->description }}
                        </td>
                        <td>
                            {{ $recurrent->amount_formatted }}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
