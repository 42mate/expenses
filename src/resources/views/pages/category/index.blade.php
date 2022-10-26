@extends('theme.master_layout')

@section('content')
    <div class="">
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

            <div class="">
                @forelse ($categories as $category)
                    @if ($loop->first)
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                    @endif
                    <tr class="">
                        <td class="">{{ $category->category }}</td>
                        <td class=" text-right">
                            <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                               class="btn-primary btn btn-sm">
                               {{ __('Edit') }}
                            </a>
                            <form method="POST" action="{{ 
                                    route('category.delete', ['category' => $category->id]) }}"
                                    class="d-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="submit" class="btn btn-danger btn-sm" value="{{ __('Delete') }}">
                            </form>
                        </td>
                    </tr>
                    @if ($loop->last)
                        </table>
                    @endif
                @empty
                    <div class="text-center">
                        <p>{{ __("You don't have any category") }}</p>
                        <div>
                            <a href="{{ route('category.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
