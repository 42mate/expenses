@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1>
            @if (empty($model->id)) {{ __('Add') }} @else {{ __('Edit') }} @endif  {{ __('Expense') }}
            <button type="button" class="btn btn-info float-end sidebarCollapse btn-sm">
                <span><i class="far fa-calendar-alt"></i>  {{ __('Recurrent') }}</span>
            </button>
        </h1>
        <x-help>
            <div class="mb-2">
                {{ __('Expenses are transactions where you spend money.') }}
            </div>
            <div class="mb-2">
                {{ __('A expense can have a specific category, this helps to have better expense reports.') }}
            </div>
            <div class="mb-2">
                {{ __('A expense can be related to a Wallet, if you select a wallet the expense amount will be discounted from the wallet balance.') }}
            </div>
            <div class="mb-2">
                {{ __('The wallet currency will be applied to the expense, So if the wallets is of US dollars and the expense amount is 100, it will represent 100 US Dolars') }}
            </div>
            <div class="mb-2">
                {{ __('If you do not select a wallet, the default currency will be used.') }}
            </div>
        </x-help>
        <div class="side-wrapper">
            {!! forms()->create('expense', !empty($model) ? $model : null) !!}
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    {!! forms()->field(__('Date') . ': *', 'date', 'date', (empty($model->date) ? Carbon\Carbon::now()->format('Y-m-d'): $model->date->format('Y-m-d'))) !!}
                    {!! forms()->field(__('Amount') , 'amount', 'text', ($model->amount ?: '')) !!}
                    {!! forms()->field(__('Description') , 'description', 'text', ($model->description ?: '')) !!}
                    {{ forms()->hidden('recurrent_expense_id', ($model->recurrent_expense_id ?: 0)) }}
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <div class="field-label-row">
                            <label for="category_id" class="form-label">{{ __('Category') }}: *</label>
                            <a href="#" class="field-action" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                <i class="fas fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>
                        <x-categories-drop-down name="category_id"
                            addEmpty="true"
                            use_as_label="category"
                            selected="{{ empty($model) ? 0 : $model->category_id }}"
                        />
                    </div>

                    <div class="form-group mb-3">
                        <div class="field-label-row">
                            <label for="wallet_id" class="form-label">{{ __('Wallet') }}:</label>
                            <a href="#" class="field-action" data-bs-toggle="modal" data-bs-target="#walletModal">
                                <i class="fas fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>

                        <x-wallet-drop-down name="wallet_id"
                            selected="{{ empty($model) ? 0 : $model->wallet_id }}"
                            add_empty="true"
                            currency_id="{{ $restrict_wallet_currency_id ?? '' }}"
                        />
                        @if (!empty($restrict_wallet_currency_id))
                            <small class="text-muted">
                                {{ __('Only wallets in the recurrent payment currency are available') }}
                                @php($__restrictCurrency = \App\Models\Currency::find($restrict_wallet_currency_id))
                                @if ($__restrictCurrency) ({{ $__restrictCurrency->code }}) @endif
                            </small>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        @include('includes._receipts')
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        {!! forms()->submit('Save') !!}
                        <a class="btn btn-warning" href="{{ route('expense.index') }}">
                            {{ __('Cancel') }}
                        </a>
                        @if (!empty($model) and !empty($model->id))
                            <a href="{{ route('expense.delete', ['expense' => $model->id]) }}"
                               class="btn btn-danger float-end as-submit" method="DELETE">
                               {{ __('Delete') }}
                            </a>
                        @endif
                    </div>
                </div>
                {!! forms()->end() !!}
            </div>
            <div class="sidepanel" id="fill-from-recurrent">
                @include('includes._recurrent_expense')
            </div>
        </div>
    </div>
<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">{{ __('Add Category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="category-modal-error" class="alert alert-danger d-none"></div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold">{{ __('Name') }}</label>
                    <input type="text" id="modal-category-name" class="form-control" placeholder="{{ __('Category name') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="save-category-btn">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Wallet Modal -->
<div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="walletModalLabel">{{ __('Add Wallet') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="wallet-modal-error" class="alert alert-danger d-none"></div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold">{{ __('Name') }}</label>
                    <input type="text" id="modal-wallet-name" class="form-control" placeholder="{{ __('Wallet name') }}">
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold">{{ __('Currency') }}</label>
                    <x-currencies-drop-down name="modal_currency_id" id="modal-wallet-currency" use_as_label="name" addEmpty="true" />
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold">{{ __('Balance') }}</label>
                    <input type="number" id="modal-wallet-balance" class="form-control" step="0.01" value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="save-wallet-btn">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Category modal
    $('#save-category-btn').click(function () {
        const name = $('#modal-category-name').val();
        $('#category-modal-error').addClass('d-none');

        $.ajax({
            url: '{{ route('ajax.category.store') }}',
            method: 'POST',
            data: { category: name, _token: csrfToken },
            success: function (response) {
                const select = $('select[name="category_id"]');
                select.append(new Option(response.name, response.id, true, true));
                select.trigger('change');
                $('#categoryModal').modal('hide');
                $('#modal-category-name').val('');
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                const msg = errors ? Object.values(errors).flat().join('<br>') : '{{ __('An error occurred.') }}';
                $('#category-modal-error').html(msg).removeClass('d-none');
            }
        });
    });

    // Wallet modal
    $('#save-wallet-btn').click(function () {
        const name = $('#modal-wallet-name').val();
        const currency_id = $('#modal-wallet-currency').val();
        const balance = $('#modal-wallet-balance').val();
        $('#wallet-modal-error').addClass('d-none');

        $.ajax({
            url: '{{ route('ajax.wallet.store') }}',
            method: 'POST',
            data: { name: name, currency_id: currency_id, balance: balance, _token: csrfToken },
            success: function (response) {
                const select = $('select[name="wallet_id"]');
                select.append(new Option(response.name, response.id, true, true));
                select.trigger('change');
                $('#walletModal').modal('hide');
                $('#modal-wallet-name').val('');
                $('#modal-wallet-balance').val('0');
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                const msg = errors ? Object.values(errors).flat().join('<br>') : '{{ __('An error occurred.') }}';
                $('#wallet-modal-error').html(msg).removeClass('d-none');
            }
        });
    });

    // Clear errors when modals are closed
    $('#categoryModal, #walletModal').on('hidden.bs.modal', function () {
        $(this).find('.alert').addClass('d-none');
    });
});
</script>
@endpush
