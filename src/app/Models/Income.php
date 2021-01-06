<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'incomes';

    protected function tags() {
        return $this->belongsToMany('App\Tags', 'income_tags');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function wallet()
    {
        return $this->belongsTo('App\Models\Wallet');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
}
