<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'name', 'user_id', 'balance'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public function newOperation(float $amount) {
        $this->balance = $this->balance + $amount;
        $this->save();
    }

    public function updateOperation(float $originalAmount, float $newAmount) {;
        $this->balance = $this->balance + ($originalAmount + $newAmount);
        $this->save();
    }

    public static function getBalance(int $userId) : array {
        $wallets = self::where('user_id', $userId)->get();
        $balances = [];
        $total = 0;
        
        foreach ($wallets as $wallet) {
            $balances[] = [
                'wallet' => $wallet->name,
                'balance' => $wallet->balance,
            ];
            $total += $wallet->balance;
        }

        $balances['total'] = [
            'wallet' => __('Total'),
            'balance' => $total,
        ];

        return $balances;
    }

}
