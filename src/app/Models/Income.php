<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Income extends Expense
{
    protected $table = 'incomes';

    protected $fillable = [
        'amount',
        'date',
        'income_source_id',
        'user_id',
        'description',
        'wallet_id',
    ];

    protected $appends = [
        'amount_formatted',
        'income_source_name',
        'income_source_idx',
        'wallet_name',
        'wallet_idx',
    ];

    public function getIncomeSourceNameAttribute()
    {
        if (! empty($this->attributes['income_source_id'])) {
            return $this->incomeSource->source;
        }

        return self::DEFAULT_SOURCE_LABEL;
    }

    public function getIncomeSourceIdxAttribute()
    {
        if (! empty($this->attributes['income_source_id'])) {
            return $this->income_source_id;
        }

        return self::DEFAULT_IDX;
    }

    public function incomeSource()
    {
        return $this->belongsTo('App\Models\IncomeSource');
    }

    /**
     * Get all receipts
     */
    public function receipts(): MorphMany
    {
        return $this->morphMany(Receipt::class, 'receiptable');
    }
}
