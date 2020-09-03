<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

    protected $fillable = [
        'category',
        'user_id',
    ];

    /**
     * Get the expenses for the category.
     */
    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }
}
