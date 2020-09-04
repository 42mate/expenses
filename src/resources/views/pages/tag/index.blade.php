@extends('theme.master_layout')

@section('content')
    <div class="col-md-8">
        <h1 class="mb-5">
            <i class="fas fa-tags"></i> {{ __('Tags') }}
        </h1>

        <div class="">
            <div class="table ">
                @forelse ($tags as $tag)
                    <div class="row mb-1">
                        <div class="col-md-8">
                            <a href="{{ route('expense.index', ['tags' => $tag->name]) }}">
                                {{ $tag->name }}
                            </a>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('tag.edit', ['model' => $tag->id]) }}" class="btn-primary btn">
                                <i class="fas fa-edit"></i> Edit
                            </a>


                            <form method="POST" action="{{ route('tag.delete', ['model' => $tag->id]) }}" class="d-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </div>
                    </div>
                @empty

                @endforelse

            </div>
        </div>
    </div>
@endsection
