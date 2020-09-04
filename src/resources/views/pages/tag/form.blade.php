@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1>Edit Tag</h1>

        {!! Form::model($model, ['method' => 'put', 'url' => route('tag.update', ['model' => $model->id])]) !!}

        <div class="form-group">
            <label for="name">Name:</label>
            {!! Form::text('name', null, ['class' => [ 'form-control',  ($errors->has('name') ? 'is-invalid' : '')]]) !!}
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group mt-5">
            {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('tag.index') }}">Cancel</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection