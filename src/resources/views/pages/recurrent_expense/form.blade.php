@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1>
            @if (empty($model->id)) {{ __('Add') }}
            @else {{ __('Edit') }}
            @endif {{ __('Recurrent Expense') }}
        </h1>

        <x-help>
            {{ __('Recurrent expenses are expenses that you do on a given period of time.') }} <br />
            {{ __('For example the power bill, the water service, the credit card payment, the social club membership.') }} <br />
            {{ __('You just need to set all the expense data, the last payment and the periodicity of the expense') }} <br />
            {{ __('In pending payment you can see the month agenda of pending payment and from there create the expense record') }}
        </x-help>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                {!! forms()->create('recurrent_expense', !empty($model)? $model : null) !!}

                {!! forms()->field(__('Amount'), 'amount', 'number')->attribute('step', '.01') !!}
                {!! forms()->field(__('Description'), 'description') !!}
                {!! forms()->field(__('Last payment date'), 'last_use_date', 'date', (empty($model->last_use_date) ? '' : $model->last_use_date->format('Y-m-d'))) !!}

                <div class="form-group mb-3">
                    <div>
                        <label for="category_id" class="strong">{{ __('Category') }}</label>
                        <span class="mt-1 mb-1 float-end">
                            <a href="{{ route('category.create', ['gt=expense.create']) }}">
                                <i class="fas fa-plus"></i> {{ __('Add Category') }}'
                            </a>
                        </span>
                    </div>
                    <x-categories-drop-down name="category_id" useAsLabel="category" selected="{{ empty($model) ? 0 : $model->category_id }}"/>
                </div>

                {{
                    forms()->field(__('Periodicity'), 'period', 'select', null,
                        [
                            '1' => 'Monthly',
                            '2' => 'Bimonthly',
                            '3' => 'Trimonthly',
                            '6' => 'Bianual',
                            '12' => 'Anual',
                        ]
                    )
                }}

                <div class="form-group mb-3">
                    <label class="strong">{{ __('State') }}</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="paused" id="paused" value="1"
                            {{ (!empty($model) && $model->paused) ? 'checked' : '' }}>
                        <label class="form-check-label" for="paused">{{ __('Paused') }}</label>
                    </div>
                </div>

                <div class="form-group mb-3">
                    {!! forms()->submit('Save', ['class' => 'btn btn-primary']) !!}
                    <a class="btn btn-warning" href="{{ route('recurrent_expense.index') }}">Cancel</a>
                    @if (!empty($model) and !empty($model->id))
                        <a href="#" class="btn btn-danger float-end"
                           onclick="event.preventDefault(); document.getElementById('delete-form-{{ $model->id }}').submit();">
                            Delete
                        </a>
                    @endif
                </div>

                {!! forms()->end() !!}

                @if (!empty($model) and !empty($model->id))
                    <form id="delete-form-{{ $model->id }}" action="{{ route('recurrent_expense.delete', ['recurrent_expense' => $model->id]) }}"
                          method="POST" style="display: none;">
                        {{ method_field('DELETE') }}
                        @csrf
                    </form>
                @endif
            </div>

        </div>
    </div>
@endsection
