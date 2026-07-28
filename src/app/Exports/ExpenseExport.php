<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Spreadsheet export for the expense and income listings. The columns mirror
 * the on-screen table; incomes only differ in the second column, which is
 * labelled and populated from the income source instead of the category.
 */
class ExpenseExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(
        protected Collection $data,
        protected string $groupHeading = 'Category',
    ) {}

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            __('Date'),
            __($this->groupHeading),
            __('Wallet'),
            __('Description'),
            __('Currency'),
            __('Amount'),
        ];
    }

    /**
     * @param  \App\Models\Expense  $row
     */
    public function map($row): array
    {
        return [
            optional($row->date)->format('Y-m-d'),
            $row instanceof Income ? $row->income_source_name : $row->category_name,
            $row->wallet_name,
            $row->description,
            $row->currency?->code,
            // The native amount, unformatted, so the spreadsheet can total it.
            floatval($row->getRawOriginal('amount')),
        ];
    }
}
