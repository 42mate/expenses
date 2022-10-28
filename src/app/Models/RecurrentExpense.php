<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\Scopes\OwnerScope;

class RecurrentExpense extends Expense
{
    const PERIOD_MONTHLY = 1;

    const PERIOD_BIMONTHLY = 2;

    const PERIOD_TRIMONTHLY = 3;

    const PERIOD_BIANUAL = 6;

    const PERIOD_ANUAL = 12;

    protected $table = 'recurrent_expense';

    public $timestamps = false;

    protected $appends = [
        'category_name',
        'past_due',
    ];

    protected $fillable = [
        'amount',
        'category_id',
        'user_id',
        'description',
        'last_use_date',
        'period',
    ];

    protected $casts = [
        'last_use_date' => 'datetime:Y-m-d',
    ];

    protected $dateFormat = 'Y-m-d';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new OwnerScope);
    }

    public function getPastDueAttribute()
    {
        $next_payment_day = Carbon::parse($this->last_use_date)
            ->addMonths($this->period)
            ->floorMonth();
        $diff = $next_payment_day->diffInMonths(Carbon::now()->floorMonth());

        return round($diff / $this->period);
    }

    public function getJsonData()
    {
        return json_encode([
            'id' => $this->id,
            'description' => $this->description,
            'category_id' => $this->category->id,
            'amount' => $this->amount,
        ]);
    }

    public function usedThisMonth()
    {
        return ! is_null($this->last_use_date) 
            && date('m') === $this->last_use_date->format('m');
    }

    public static function getAllNotUsedFirst($userId)
    {
        return self::query()
            ->orderBy('last_use_date')
            ->get();
    }

    public static function getPendingToPayThisMonth($userId)
    {
        return self::query()
            ->whereRaw("
                (last_use_date IS NULL
                OR (
                    IF(
                        MOD(MONTH(last_use_date) + period, 12) = 0,
                        12,
                        MOD(MONTH(last_use_date) + period, 12)
                    ) <= MONTH(CURRENT_DATE())
                )) AND (
                    IF(
                        period = 12,
                        YEAR(last_use_date) + 1,
                        YEAR(last_use_date)
                    ) <= YEAR(CURRENT_DATE())
                )"
            )->get();
    }
}
