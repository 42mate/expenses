<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Illuminate\Support\Carbon;

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
            'category_id' => $this->category_id,
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
            ->where('paused', false)
            ->orderBy('last_use_date')
            ->get();
    }

    public static function getPendingToPayThisMonth($userId)
    {
        $time = Carbon::now()->endOfMonth()->format('Y-m-d');

        return self::query()
            ->where('paused', false)
            ->whereRaw('DATE_ADD(last_use_date, INTERVAL period MONTH) < "' . $time . '"')
            ->get();
    }

    public static function getPendingPausedToPayThisMonth($userId)
    {
        $time = Carbon::now()->endOfMonth()->format('Y-m-d');

        return self::query()
            ->where('paused', true)
            ->whereRaw('DATE_ADD(last_use_date, INTERVAL period MONTH) < "' . $time . '"')
            ->get();
    }
}
