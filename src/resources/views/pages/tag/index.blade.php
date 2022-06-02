@extends('theme.master_layout')

@section('content')
    <div class="col-md-8">
        <h1 class="mb-5">
            <i class="fas fa-tags"></i> {{ __('Tags') }}
        </h1>

        <div class="">
                @forelse ($tags as $tag)
                    @if ($loop->first)
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            @endif
                    <tr class="">
                        <td class="">
                            {{ $tag->name }}
                        </td>
                        <td class="text-right">
                            <a href="{{ route('tag.edit', ['model' => $tag->id]) }}" class="btn-primary btn btn-sm">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('tag.delete', ['model' => $tag->id]) }}" class="d-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                            </form>
                        </td>
                    </tr>
                    @if ($loop->last)
                        </table>
                    @endif
                @empty
                <div class="text-center">
                    <p>{{ __("You don't have any tag") }}</p>
                    <div>
                        <a href="{{ route('tag.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>  {{ __('Add') }}
                        </a>
                    </div>
                </div>
                @endforelse
        </div>
    </div>
@endsection
