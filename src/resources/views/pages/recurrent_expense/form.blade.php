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
                @if (empty($model))
                    {!! Form::open(['url' => route('recurrent_expense.store')]) !!}
                @else
                    {!! Form::model($model, ['method' => 'put', 'url' => route('recurrent_expense.update', ['recurrent_expense' => $model->id])]) !!}
                @endif

                <div class="form-group">
                    {!! Form::label('Amount:', null, ['class' => 'font-weight-bold']) !!}
                    {!! Form::number('amount', null, ['step' => '.01', 'class' => [ 'form-control',  ($errors->has('amount') ? 'is-invalid' : '')]]) !!}
                    @error('amount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('Description:', null, ['class' => 'font-weight-bold']) !!}
                    {!! Form::text('description', null, ['class' => [ 'form-control',  ($errors->has('description') ? 'is-invalid' : '')]]) !!}
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('Last payment date:', null, ['class' => 'font-weight-bold']) !!}
                    {!! Form::date('last_use_date', (empty($model->last_use_date) ? '' : $model->last_use_date->format('Y-m-d')), ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}
                    @error('last_use_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div>
                        <label for="email" class="font-weight-bold">Category:</label>
                        <span class="mt-1 mb-1 float-right">
                        <a href="{{ route('category.create', ['gt=expense.create']) }}"><i class="fas fa-plus"></i> {{ __('Add Category') }}</a>
                    </span>
                    </div>
                    <x-categories-drop-down name="category_id" useAsLabel="category" selected="{{ empty($model) ? 0 : $model->category_id }}"/>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div>
                        <label for="period" class="font-weight-bold">Periodicity:</label>
                    </div>

                    {{
                        Form::select('period',
                            [
                                '1' => 'Monthly',
                                '2' => 'Bimonthly',
                                '3' => 'Trimonthly',
                                '6' => 'Bianual',
                                '12' => 'Anual',
                            ],
                            (empty($model->period) ? 1 : $model->period),
                            ['class' => [ 'form-control',  ($errors->has('period') ? 'is-invalid' : '')]]
                        )
                    }}
                    @error('period')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group mt-5">
                    {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                    <a class="btn btn-warning" href="{{ route('recurrent_expense.index') }}">Cancel</a>
                    @if (!empty($model) and !empty($model->id))
                        <a href="#" class="btn btn-danger float-right"
                           onclick="event.preventDefault(); document.getElementById('delete-form-{{ $model->id }}').submit();">
                            Delete
                        </a>
                    @endif
                </div>
                {!! Form::close() !!}

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
