<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'name', 'user_id'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function expenses()
    {
        return $this->belongsToMany('App\Expense', 'expense_tags');
    }

    public function incomes()
    {
        return $this->belongsToMany('App\Income', 'income_tags');
    }
}
