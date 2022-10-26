<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        return $this->hasMany('App\Models\Expense');
    }

    public static function allForUser()
    {
        return self::query()
            ->where('user_id', Auth::user()->id)
            ->orderBy('category');
    }
}
