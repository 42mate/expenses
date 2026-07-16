<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Transfer category / income-source names
    |--------------------------------------------------------------------------
    |
    | Movements filed under these names represent money moving between the
    | user's own wallets (transfers), not real spending or earning. They are
    | excluded from the dashboard expense/income widgets and from the expense
    | reports (month-flow line chart and by-category pie chart). They still
    | appear in the expense/income listings.
    |
    | The same names are matched against expense categories (categories.category)
    | and income sources (income_sources.source). Matching is case-insensitive
    | when the database collation is (as is the default in MySQL).
    |
    */
    'transfer_names' => ['Transferencia'],
];
