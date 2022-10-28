<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'category',
        'user_id',
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
            ->orderBy('category');
    }
}
