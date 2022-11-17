<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    static public function isEmpty() {
        $oneRecord = DB::table((with(new static)->getTable()))
            ->where('user_id', '=', Auth::id())
            ->select(['id'])
            ->limit(1)
            ->get();
        return $oneRecord->isEmpty();
    }
}
