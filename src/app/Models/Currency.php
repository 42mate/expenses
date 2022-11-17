<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{
    protected $table = 'currencies';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'symbol'
    ];

    use HasFactory;

    public function getNameAttribute() {
        return "({$this->attributes['symbol']}) " .$this->attributes['name'];
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
