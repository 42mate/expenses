<div class="card shadow mb-4">
    <div class="card-header">
        This month expenses
    </div>
    <div class="card-body">
        <div>
            <table class="table display responsive table-home"
                   width="100%" cellspacing="0">

                @foreach ($expenses as $expense)
                    @if ($loop->first)
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th class="d-block d-sm-table-cell">Category</th>
                            <th class="d-block d-sm-table-cell font-weight-bold text-right">
                                Amount
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                    @endif
                    <tr>
                        <td>
                            {{ $expense->date->format('Y-m-d') }}
                        </td>
                        <td class="d-block d-sm-table-cell">
                            <a href="{{ route('expense.index', ['category_id' => $expense->category->id]) }}">
                                {{ $expense->category->category }}
                            </a>
                        </td>
                        <td class="d-block d-sm-table-cell font-weight-bold text-right">
                            {{ $expense->amount_formatted }}
                        </td>
                        <td>
                            <a href="{{ route('expense.edit', [$expense->id]) }}"
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @if ($loop->last)
                    @endif
                @endforeach
            </table>
            @if ($expenses->count() == 0)
                <div>
                    <p class="text-center">Good, you don't have any expense in
                        this
                        month.</p>
                    <div class="text-center">
                        <a href="{{ route('expense.create') }}"
                           class="btn btn-primary">
                            Add your first expense
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
