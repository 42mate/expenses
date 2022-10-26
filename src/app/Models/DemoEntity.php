<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoEntity extends Model
{
    protected $table = 'demo_entity';

    protected $fillable = [
        'name',
        'description',
        'birth_date',
    ];
}
