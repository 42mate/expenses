@extends('theme.master_layout')

@section('content')
            <div class="col-md-8">
                <div class="">
                    <h1>Add Category</h1>
                    <div>
                        <form method="post" action="{{ route('category.store') }}">
                            @csrf


                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection