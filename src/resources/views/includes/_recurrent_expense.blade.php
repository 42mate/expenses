<div class="mb-4">
    <label class="font-weight-bold"> {{ __('Use a recurrent expense.') }}</label>
    <button type="button"
            class="btn btn-danger font-weight-bold float-end sidebarCollapse">
        <span>X</span>
    </button>
</div>

<table width="100%" class="table">
    <thead>
    <tr>
        <th class=""></th>
        <th class="d-block d-sm-table-cell">{{ __('Description') }}</th>
        <th class="d-block d-sm-table-cell">{{ __('Last Payment') }}</th>
        <th class="d-block d-sm-table-cell">{{ __('Amount') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($recurrent_expenses as $recurrent)
        <tr @class(['paid' => $recurrent->usedThisMonth()])>
            <td class="">
                                <span class="btn btn-info fill-expense btn-sm"
                                      data-expense="{{ $recurrent->getJsonData() }}">
                                      {{ __('Use') }}
                                </span>
            </td>
            <td class="d-block d-sm-table-cell">
                {{ $recurrent->description }}
            </td>
            <td class="d-block d-sm-table-cell">
                {{
                    empty($recurrent->last_use_date)
                        ? __('Never') :
                        $recurrent->last_use_date->format('m/d/Y')
                }}
            </td>
            <td class="d-block d-sm-table-cell">
                <strong>{{ $recurrent->amount_formatted }}</strong>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
