<?php

namespace App\Models;

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
        return $this->belongsTo('App\Models\User');
    }

    public function expenses()
    {
        return $this->belongsToMany('App\Models\Expense', 'expense_tags');
    }

    public function incomes()
    {
        return $this->belongsToMany('App\Models\Income', 'income_tags');
    }

    public function getNameAttribute() {
        return ucfirst($this->attributes['name']);
    }
}
