@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <h1> @if (empty($model)) Add @else Edit @endif Category</h1>

    <div class="col-md-8">

        @if (empty($model))
            {!! Form::open(['url' => route('category.store')]) !!}
        @else
            {!! Form::model($model, ['method' => 'put', 'url' => route('category.update', ['category' => $model->id])]) !!}
        @endif

        <div class="form-group">
            <label for="category">Name:</label>
            {!! Form::text('category', null, ['class' => [ 'form-control',  ($errors->has('category') ? 'is-invalid' : '')]]) !!}
            @error('category')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group mt-5">
            {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('category.index') }}">Cancel</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
