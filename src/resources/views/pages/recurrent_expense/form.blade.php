@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1> @if (empty($model)) Add @else Edit @endif Recurrent Expense</h1>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                @if (empty($model))
                    {!! Form::open(['url' => route('recurrent_expense.store')]) !!}
                @else
                    {!! Form::model($model, ['method' => 'put', 'url' => route('recurrent_expense.update', ['recurrent_expense' => $model->id])]) !!}
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

                <div class="form-group mt-5">
                    {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                    <a class="btn btn-warning" href="{{ route('recurrent_expense.index') }}">Cancel</a>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection
