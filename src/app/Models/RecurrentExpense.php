<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurrentExpense extends Expense
{
    protected $table = 'recurrent_expense';

    public $timestamps = false;

    protected $appends = [
        'category_name',
    ];

    protected $fillable = [
        'amount',
        'category_id',
        'user_id',
        'description',
        'last_use_date'
    ];

    protected $casts = [
        'last_use_date' => 'datetime:Y-m-d',
    ];

    protected $dateFormat = 'Y-m-d';

    public function getJsonData() {
        return json_encode([
            'id' => $this->id,
            'description' => $this->description,
            'category_id' => $this->category->id,
            'amount' => $this->amount,
        ]);
    }

    public function usedThisMonth() {
        return (!is_null($this->last_use_date) && date('m') === $this->last_use_date->format('m'));
    }

    public static function getAllNotUsedFirst() {
        return self::query()
            ->orderBy('last_use_date')
            ->get();
    }

    public static function getPendingToPayThisMonth() {
        return self::query()
            ->whereMonth('last_use_date', '<>', date('m'))
            ->orWhereNull('last_use_date')
            ->get();
    }
}
