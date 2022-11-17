<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    protected $table = 'wallets';
    protected $with = ['currency'];

    protected $fillable = [
        'name', 'user_id', 'balance', 'currency_id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new OwnerScope);
    }

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public function newOperation(float $amount)
    {
        $this->balance = $this->balance + $amount;
        $this->save();
    }

    public function updateOperation(float $originalAmount, float $newAmount)
    {
        $this->balance = $this->balance + ($originalAmount + $newAmount);
        $this->save();
    }

    public static function getBalance(): Collection
    {
        return self::orderBy('balance')
            ->where('balance', '<>', 0)
            ->get();
    }

    static public function isEmpty() {
        $oneRecord = DB::table((with(new static)->getTable()))
            ->where('user_id', '=', Auth::id())
            ->select(['id'])
            ->limit(1)
            ->get();
        return $oneRecord->isEmpty();
    }
}
