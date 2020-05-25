@extends('theme/master_layout')

@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('demo.model.create') }}" class="btn btn-primary float-right">Create</a>
            <h6 class="m-0 font-weight-bold text-primary">Entity</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($models as $model )
                    <tr>
                        <td>
                            <a href="{{ route('demo.model.edit', ['model' => $model->id]) }}">
                                {{ $model->id }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('demo.model.edit', ['model' => $model->id]) }}">
                                {{ $model->name }}
                            </a>
                        </td>
                        <td>
                            {{ $model->birth_date }}
                        </td>
                        <td>
                            {{ $model->description }}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
