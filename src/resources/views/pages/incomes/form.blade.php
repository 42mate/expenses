@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1>
            @if (empty($model->id)) {{ __('Add') }} 
            @else {{ __('Edit') }} 
            @endif {{ __('Income') }}
        </h1>
        <div class="side-wrapper">
            @if (empty($model) or empty($model->id))
                @php
                    $route = route('incomes.store');
                    $method = 'POST';
                @endphp
            @else
                @php
                    $route = route('incomes.update', ['income' => $model->id]);
                    $method = 'PUT';
                @endphp
            @endif
            {!! Form::model($model, ['method' => $method, 'url' => $route]) !!}
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    <div class="form-group">
                        {!! Form::label(__('Date') . ': *', null, ['class' => 'font-weight-bold']) !!}
                        {!! Form::date('date', 
                            (empty($model->date) 
                            ? Carbon\Carbon::now()->format('Y-m-d') 
                            : $model->date->format('Y-m-d')), 
                            ['class' => [ 'form-control',  
                                ($errors->has('date') ? 'is-invalid' : '')]]) !!}
                        @error('date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label(__('Amount') . ': *', null, ['class' => 'font-weight-bold']) !!}
                        {!! Form::number('amount', null, 
                            ['step' => '.01', 
                             'class' => [ 'form-control',  
                                ($errors->has('amount') ? 'is-invalid' : '')]]) !!}
                        @error('amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label(__('Description') . ':', null, ['class' => 'font-weight-bold']) !!}
                        {!! Form::text('description', null, 
                            ['class' => [ 'form-control',  
                                ($errors->has('description') ? 'is-invalid' : '')]]) !!}
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <div>
                            <label for="email" class="font-weight-bold">{{ __('Income Source') }}:</label>
                            <span class="mt-1 mb-1 float-right">
                                <a href="{{ route('income_source.create', ['gt=income.create']) }}">
                                    <i class="fas fa-plus"></i> {{ __('Add Income Source') }}
                                </a>
                            </span>
                        </div>
                        <x-income-source-drop-down name="income_source_id"
                            addEmpty="true"
                            use_as_label="source"
                            selected="{{ empty($model) ? 0 : $model->income_source_id }}"
                        />
                        @error('income_source_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div>
                            <label for="email" class="font-weight-bold">{{ __('Wallet') }}:</label>
                            <span class="mt-1 mb-1 float-right">
                                <a href="{{ route('wallet.create', ['gt=income.create']) }}">
                                    <i class="fas fa-plus"></i> {{ __('Add Wallet') }}
                                </a>
                            </span>
                        </div>

                        <x-wallet-drop-down name="wallet_id"
                            selected="{{ empty($model) ? 0 : $model->wallet_id }}"
                            add_empty="true"
                        />

                        @error('wallet_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        {!! Form::submit(__('Send'), ['class' => 'btn btn-primary']) !!}
                        <a class="btn btn-warning" href="{{ route('incomes.index') }}">
                            {{ __('Cancel') }}
                        </a>
                        @if (!empty($model) and !empty($model->id))
                            <a href="{{ route('incomes.destroy', ['income' => $model->id]) }}"
                               class="btn btn-danger float-right"
                               onclick="event.preventDefault(); 
                               document.getElementById('delete-form-{{ $model->id }}').submit();">
                                {{ __('Delete') }}
                            </a>
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}

                @if (!empty($model) and !empty($model->id))
                    <form id="delete-form-{{ $model->id }}"
                          action="{{ route('incomes.destroy', ['income' => $model->id]) }}"
                          method="POST" style="display: none;">
                        {{ method_field('DELETE') }}
                        @csrf
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
