@extends('theme.master_layout')

@section('content')
    <h1>Add Wallet</h1>

    <div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="post" action="{{ route('wallet.store') }}">
            @csrf
            <div class="form-group">
                {!! Form::label('Name:', null, ['class' => 'font-weight-bold']) !!}
                {!! Form::text('name', null, ['maxlength' => "100", 'class' => [ 'form-control',  ($errors->has('name') ? 'is-invalid' : '')]]) !!}
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection