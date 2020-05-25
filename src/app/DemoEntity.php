<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemoEntity extends Model
{
    protected $table = 'demo_entity';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'birth_date'
    ];
}
