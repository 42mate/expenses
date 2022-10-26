<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class IncomeSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'user_id',
    ];

    public function income()
    {
        return $this->hasOne('App\Models\Income');
    }

    public static function allForUser()
    {
        return self::query()
            ->where('user_id', Auth::user()->id)
            ->orderBy('source');
    }

}
