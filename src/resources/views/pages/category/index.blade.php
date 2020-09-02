@extends('theme.master_layout')

@section('content')
            <div class="col-md-8">
                <h1 class="mb-5">
                    Categories
                </h1>

                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table ">
                        @forelse ($categories as $category)
                            <div class="row mb-1">
                                <div class="col-md-8">{{ $category->category }}</div>
                                <div class="col-md-4 text-right">
                                    <span class="btn-primary btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center">
                                <p>You don't have any category</p>
                                <div>
                                    <a href="{{ route('category.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i>  Add
                                    </a>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
@endsection
