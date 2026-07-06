@extends('theme.master_layout')

@section('content')
    <div class="">
        <h1>
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

            <form method="GET" action="{{ route('category.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="{{ __('Search by name...') }}" value="{{ $name ?? '' }}">
                    <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
                    @if (!empty($name))
                        <a href="{{ route('category.index') }}" class="btn btn-secondary">{{ __('Clear') }}</a>
                    @endif
                </div>
            </form>

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
                        <td class=" text-end">
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
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-2">
                                    {{ __('Categories will help you to classified and organize your expenses, some categories can be Groceries, Taxes, Car, Services, etc.') }}
                                </div>
                                <div class="mb-2">
                                    {{ __('Categories are optional, but we recommend you to create categories depending on your primary kind of expense.') }}
                                </div>
                                <div class="mb-2">
                                    {{ __('Categories are set when you create a Expense.') }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('category.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add your first category') }}
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
