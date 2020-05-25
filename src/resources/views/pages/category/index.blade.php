@extends('theme.master_layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Categories
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table ">
                        @forelse ($categories as $category)
                            @if ($loop->first)
                                <div class="row head font-weight-bold">
                                    <div class="col-md-8">Category</div>
                                    <div class="col-md-4 text-right">Actions</div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-8">{{ $category->category }}</div>
                                <div class="col-md-4 text-right">
                                    Edit
                                </div>
                            </div>
                        @empty
                            <div class="text-center">
                                <p>You don't have any category</p>
                                <div>
                                    <a href="{{ route('category.create') }}" class="btn btn-primary">
                                        + Add
                                    </a>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
