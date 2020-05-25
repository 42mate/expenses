@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"> @if (empty($model)) Create @else Edit @endif Entity</h1>

    @if (!$errors->isEmpty())
    <div class="alert alert-danger">The form contains some errors, please verify</div>
    @endif

    @if (empty($model))
        {!! Form::open(['url' => route('demo.model.store')]) !!}
    @else
        {!! Form::model($model, ['method' => 'put', 'url' => route('demo.model.update', ['model' => $model->id])]) !!}
    @endif
        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', null, ['class' => [ 'form-control',  ($errors->has('name') ? 'is-invalid' : '')]]) !!}
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    <div class="form-group">
        {!! Form::label('Description') !!}
        {!! Form::textarea('description', null, ['class' => [ 'form-control',  ($errors->has('description') ? 'is-invalid' : '')]]) !!}
        @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group">
        {!! Form::label('Date of birth') !!}
        {!! Form::date('birth_date', null, ['class' => [ 'form-control',  ($errors->has('birth_date') ? 'is-invalid' : '')]]) !!}
        @error('birth_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div>
        {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
        <a class="btn btn-warning" href="{{ route('demo.model.index') }}">Cancel</a>
    </div>
    {!! Form::close() !!}
@endsection