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
     * Incomes are categorised by income-source, so transfers are detected
     * through income_source_id rather than category_id.
     */
    protected static function transferColumn(): string
    {
        return 'income_source_id';
    }

    protected static function transferIds(): array
    {
        $names = static::transferNames();
        if (empty($names)) {
            return [];
        }

        return IncomeSource::whereIn('source', $names)->pluck('id')->all();
    }

    /**
     * Get all receipts
     */
    public function receipts(): MorphMany
    {
        return $this->morphMany(Receipt::class, 'receiptable');
    }
}
