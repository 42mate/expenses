@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->

    <div class="col-md-6">
        <h1 class="h3 mb-5"> @if (empty($model)) Add a new @else Edit @endif Expense</h1>

        @if (!$errors->isEmpty())
            <div class="alert alert-danger">There are some errors, please verify</div>
        @endif

        @if (empty($model))
            {!! Form::open(['url' => route('expense.store')]) !!}
        @else
            {!! Form::model($model, ['method' => 'put', 'url' => route('expense.update', ['expense' => $model->id])]) !!}
        @endif
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
            {!! Form::label('Amount:', null, ['class' => 'font-weight-bold']) !!}
            {!! Form::number('amount', null, ['step' => '.01', 'class' => [ 'form-control',  ($errors->has('amount') ? 'is-invalid' : '')]]) !!}
            @error('amount')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="font-weight-bold">Category:</label>
            <x-categories-drop-down name="category_id" selected="{{ empty($model) ? 0 : $model->category_id }}"/>
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

        <div class="form-group mt-5">
            {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('expense.index') }}">Cancel</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection