@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1>
            @if (empty($model->id)) {{ __('Add') }}
            @else {{ __('Edit') }}
            @endif {{ __('Income') }}
        </h1>

        <x-help>
            {{ __('Incomes are transactions where get money.') }} <br />
            {{ __('A income can have a specific source, this helps to have better reports.') }} <br />
            {{ __('A income can be related to a Wallet, if you select a wallet the expense amount will be added the wallet balance.') }} <br />
            {{ __('The wallet currency will be applied to the income, So if the wallets is of US dollars and the income amount is 100, it will represent 100 US Dolars') }} <br />
            {{ __('If you do not select a wallet, the default currency will be used.') }}
        </x-help>

        <div class="side-wrapper">
            {!! forms()->create('incomes', !empty($model) ? $model : null) !!}

            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    {!! forms()->field(__('Date'), 'date', 'date', (empty($model->date) ? Carbon\Carbon::now()->format('Y-m-d') : $model->date->format('Y-m-d')),) !!}
                    {!! forms()->field(__('Amount'), 'amount', 'text') !!}
                    {!! forms()->field(__('Description'), 'description') !!}
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <div class="field-label-row">
                            <label for="income_source_id" class="form-label">{{ __('Income Source') }}:</label>
                            <a href="#" class="field-action" data-bs-toggle="modal" data-bs-target="#incomeSourceModal">
                                <i class="fas fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>
                        <x-income-source-drop-down name="income_source_id"
                            addEmpty="true"
                            use_as_label="source"
                            selected="{{ empty($model) ? 0 : $model->income_source_id }}"
                        />
                    </div>

                    <div class="form-group">
                        <div class="field-label-row">
                            <label for="wallet_id" class="form-label">{{ __('Wallet') }}:</label>
                            <a href="#" class="field-action" data-bs-toggle="modal" data-bs-target="#walletModal">
                                <i class="fas fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>

                        <x-wallet-drop-down name="wallet_id"
                            selected="{{ empty($model) ? 0 : $model->wallet_id }}"
                            add_empty="true"
                        />
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        {!! forms()->submit(__('Save')) !!}
                        <a class="btn btn-warning" href="{{ route('incomes.index') }}">
                            {{ __('Cancel') }}
                        </a>
                        @if (!empty($model) and !empty($model->id))
                            <a href="{{ route('incomes.destroy', ['income' => $model->id]) }}"
                               class="btn btn-danger float-end as-submit"
                               method="DELETE">
                                {{ __('Delete') }}
                            </a>
                        @endif
                    </div>
                </div>
                {!! forms()->end() !!}
            </div>
        </div>
    </div>

<!-- Income Source Modal -->
<div class="modal fade" id="incomeSourceModal" tabindex="-1" aria-labelledby="incomeSourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="incomeSourceModalLabel">{{ __('Add Income Source') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="income-source-modal-error" class="alert alert-danger d-none"></div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold">{{ __('Name') }}</label>
                    <input type="text" id="modal-income-source-name" class="form-control" placeholder="{{ __('Income source name') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="save-income-source-btn">{{ __('Save') }}</button>
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

    // Income Source modal
    $('#save-income-source-btn').click(function () {
        const source = $('#modal-income-source-name').val();
        $('#income-source-modal-error').addClass('d-none');

        $.ajax({
            url: '{{ route('ajax.income_source.store') }}',
            method: 'POST',
            data: { source: source, _token: csrfToken },
            success: function (response) {
                const select = $('select[name="income_source_id"]');
                select.append(new Option(response.name, response.id, true, true));
                select.trigger('change');
                $('#incomeSourceModal').modal('hide');
                $('#modal-income-source-name').val('');
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                const msg = errors ? Object.values(errors).flat().join('<br>') : '{{ __('An error occurred.') }}';
                $('#income-source-modal-error').html(msg).removeClass('d-none');
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
    $('#incomeSourceModal, #walletModal').on('hidden.bs.modal', function () {
        $(this).find('.alert').addClass('d-none');
    });
});
</script>
@endpush
