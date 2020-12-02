<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecurrentExpense extends Expense
{
    protected $table = 'recurrent_expense';

    public $timestamps = false;

    protected $appends = [
        'category_name',
    ];

    protected $fillable = [
        'amount',
        'category_id',
        'user_id',
        'description',
    ];

    public function getJsonData() {
        return json_encode([
            'description' => $this->description,
            'category_id' => $this->category->id,
            'amount' => $this->amount,
        ]);
    }

}
