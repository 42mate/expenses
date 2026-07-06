<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    // Rest omitted for brevity

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'default_currency_id',
        'display_currency_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public function incomes()
    {
        return $this->hasMany('App\Models\Income');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
    }

    public function wallets()
    {
        return $this->hasMany('App\Models\Wallet');
    }

    public function displayCurrency()
    {
        return $this->belongsTo(Currency::class, 'display_currency_id');
    }

    /**
     * The currency every amount is converted to for this user's display.
     * Falls back: display_currency_id -> default_currency_id -> currency 1.
     */
    public function resolveDisplayCurrency(): Currency
    {
        $id = $this->display_currency_id ?: $this->default_currency_id ?: 1;

        return Currency::find($id)
            ?? Currency::find(1)
            ?? new Currency(['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$']);
    }

    /**
     * If the user has no transactions created,
     *   we consider that is a new user.
     * @return bool
     */
    public function isANewUser() : bool {
        if (Income::isEmpty() || Expense::isEmpty()) {
            return true;
        }
        return false;
    }
}
