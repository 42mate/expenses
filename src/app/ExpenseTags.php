<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseTags extends Model
{
    protected $table = 'expense_tags';

    protected $fillable = [
        'expense_id',
        'tag_id',
        'user_id'
    ];

    public $timestamps = false;

    /**
     * Deletes tags by the expense
     *
     * @param $expenseId
     */
    static public function clear($expenseId) {
        self::where('expense_id', $expenseId)
            ->delete();
    }
}
