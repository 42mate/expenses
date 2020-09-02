<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'incomes';

    protected function tags() {
        return $this->belongsToMany('App\Tags', 'income_tags');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function wallet()
    {
        return $this->belongsTo('App\Wallet');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }
}
