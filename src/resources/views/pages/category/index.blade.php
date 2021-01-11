@extends('theme.master_layout')

@section('content')
    <div class="col-md-8">
        <h1 class="mb-5">
            <i class="fas fa-tasks"></i> {{ __('Categories') }}
            <div class="add_control">
                <a href="{{ route('category.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add category") }}
                </a>
            </div>
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
                            <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                               class="btn-primary btn">
                                Edit
                            </a>


                            <form method="POST" action="{{ route('category.delete', ['category' => $category->id]) }}"
                                  class="d-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <p>You don't have any category</p>
                        <div>
                            <a href="{{ route('category.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add
                            </a>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
@endsection
