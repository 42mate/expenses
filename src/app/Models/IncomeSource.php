<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomeSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
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

    public function income()
    {
        return $this->hasOne('App\Models\Income');
    }

    public static function allForUser()
    {
        return self::query()->orderBy('source');
    }

}
