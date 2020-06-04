<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{

    protected $table = 'expenses';

    public function category() {
        return $this->belongsTo('App\Category');
    }

    protected $fillable = [
        'amount',
        'date',
        'category_id',
        'user_id',
        'description',
    ];

    public static function byUser($userId)
    {
        return self::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(50);
    }

    public static function byUserCurrentMonth($userId)
    {
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::tomorrow()->format('Y-m-d');

        return self::whereBetween('date', [$from, $to])
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function todayTotal($userId)
    {
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::tomorrow()->format('Y-m-d');

        return self::totalByDateRange($userId, $from, $to);
    }

    public static function weekTotal($userId)
    {
        $from = Carbon::now()->startOfWeek()->format('Y-m-d');
        $to = Carbon::tomorrow()->format('Y-m-d');

        return self::totalByDateRange($userId, $from, $to);
    }

    public static function monthTotal($userId)
    {
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::tomorrow()->format('Y-m-d');

        return self::totalByDateRange($userId, $from, $to);
    }

    public static function lastMonthTotal($userId)
    {
        $from = Carbon::now()->startOfMonth()->sub('1 month')->format('Y-m-d');
        $to = Carbon::now()->startOfMonth()->sub('1 day')->format('Y-m-d');

        return self::totalByDateRange($userId, $from, $to);
    }

    public static function totalByDateRange($userId, $from, $to)
    {
        $expenses = self::whereBetween('date', [$from, $to])
            ->where('user_id', $userId);

        return $expenses->sum('amount');
    }

    public static function getExpensesByCategory($userId) {
        return DB::select('SELECT c.category, SUM(e.amount) as total 
            FROM categories c INNER JOIN expenses e ON e.category_id = c.id
            WHERE e.date BETWEEN ? AND ?
            AND e.user_id = ?
            GROUP BY 1
            ORDER BY 2', [
            Carbon::now()->startOfMonth()->format('Y-m-d'),
            Carbon::tomorrow()->format('Y-m-d'),
            $userId
        ]);
    }
}
