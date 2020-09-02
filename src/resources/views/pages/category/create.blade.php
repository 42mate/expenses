@extends('theme.master_layout')

@section('content')
            <div class="col-md-8">
                <div class="">
                    <h1>Add Category</h1>
                    <div>
                        <form method="post" action="{{ route('category.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="category">Category Name:</label>
                                {!! Form::text('category', null, ['class' => [ 'form-control',  ($errors->has('category') ? 'is-invalid' : '')]]) !!}
                                @error('category')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection