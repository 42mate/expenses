@extends('theme.master_layout')

@section('content')
    <div class="container">
        <div class="col-md-6">
            <h3 class="mb-5">Add Expense</h3>

            <div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br/>
                    @endif
                </div>

                <form method="post" action="{{ route('expense.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="last_name">Description:</label>
                        <input type="text" class="form-control" name="description"/>
                    </div>

                    <div class="form-group">
                        <label for="first_name">Amount:</label>
                        <input type="number" class="form-control" name="amount"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Category:</label>
                        <x-categories-drop-down name="category_id" selected="0"/>
                    </div>

                    <div class="form-group">
                        <label for="email">Date:</label>
                        {!! Form::date('date', Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) !!}
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection