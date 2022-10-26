@extends('theme.master_layout')

@section('content')
    <div class="">
        <h1 class="mb-5">
            {{ __('Income Source') }}
            <div class="add_control">
                <a href="{{ route('income_source.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add income source") }}
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
                @forelse ($income_sources as $income_source)
                    @if ($loop->first)
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                    @endif
                    <tr class="">
                        <td class="">{{ $income_source->source }}</td>
                        <td class=" text-right">
                            <a href="{{ route('income_source.edit', ['income_source' => $income_source->id]) }}"
                               class="btn-primary btn btn-sm">
                                {{__('Edit')}}
                            </a>


                            <form method="POST" action="{{ route('income_source.destroy', ['income_source' => $income_source->id]) }}"
                                  class="d-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="submit" class="btn btn-danger btn-sm" value="{{__('Delete')}}">
                            </form>
                        </td>
                    </tr>
                    @if ($loop->last)
                        </table>
                    @endif
                @empty
                    <div class="text-center">
                        <p>{{ __('You don\'t have any income source') }}</p>
                        <div>
                            <a href="{{ route('income_source.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
@endsection
