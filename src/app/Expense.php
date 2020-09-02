<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Tag;
use App\ExpenseTags;

class Expense extends Model
{

    protected $table = 'expenses';

    protected $appends = [
        'amount_formatted',
        'category_name',
        'wallet',
        'tags_formatted'
    ];

    protected function tags() {
        return $this->belongsToMany('App\Tag', 'expense_tags');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function wallet()
    {
        return $this->belongsTo('App\Wallet');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function getDateAttribute() {
        return date('Y-m-d', strtotime($this->attributes['date']));
    }

    public function getAmountFormattedAttribute() {
        return '$ ' . $this->attributes['amount'];
    }

    public function getTagsFormattedAttribute() {

        $out = [];
        foreach ($this->tags()->get() as $tag) {
            $out[] = $tag->name;
        }
        return implode(', ', $out);
    }

    public function getCategoryNameAttribute() {
        return $this->category->category;
    }

    public function getWalletAttribute() {
        return isset($this->wallet()->first()->name) ? $this->wallet()->first()->name : 'No wallet';
    }

    protected $fillable = [
        'amount',
        'date',
        'category_id',
        'user_id',
        'description',
        'wallet_id'
    ];

    public static function byUser($userId)
    {
        return self::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();
    }

    public static function byUserCurrentMonth($userId)
    {
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth('Y-m-d');

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
        $to = Carbon::now()->endOfWeek()->format('Y-m-d');

        return self::totalByDateRange($userId, $from, $to);
    }

    public static function monthTotal($userId)
    {
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth()->format('Y-m-d');

        return self::totalByDateRange($userId, $from, $to);
    }

    public static function lastMonthTotal($userId)
    {
        $from = Carbon::now()->startOfMonth()->sub('1 month')->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->startOfMonth()->sub('1 day')->endOfMonth()->format('Y-m-d');

        return self::totalByDateRange($userId, $from, $to);
    }

    public static function totalByDateRange($userId, $from, $to)
    {
        $expenses = self::whereBetween('date', [$from, $to])
            ->where('user_id', $userId);

        return $expenses->sum('amount');
    }

    public static function getTotalByMonth($userId) {
        return DB::select('SELECT DATE_FORMAT(e.date, "%Y/%c") as `month` , SUM(e.amount) as total 
            FROM  expenses e
            WHERE e.user_id = ?
            GROUP BY 1
            ORDER BY 1 ASC', [
            $userId
        ]);
    }

    public static function getExpensesByCategory($userId) {
        return DB::select('SELECT c.category, SUM(e.amount) as total 
            FROM categories c INNER JOIN expenses e ON e.category_id = c.id
            WHERE e.date BETWEEN ? AND ?
            AND e.user_id = ?
            GROUP BY 1
            ORDER BY 1 DESC
            LIMIT 24', [
            Carbon::now()->startOfMonth()->format('Y-m-d'),
            Carbon::now()->endOfMonth()->format('Y-m-d'),
            $userId
        ]);
    }

    public function updateTags($userId, $tags) {
        $iTags = json_decode($tags);

        ExpenseTags::clear($this->id);

        foreach ($iTags as $iTag) {
            if (!isset($iTag->id)) {
                $tag = Tag::firstOrNew([
                    'name' => $iTag->name,
                    'user_id' => $userId,
                ]);

                $tag->save();
            }
            else {
                $tag = Tag::find($iTag->id);
            }

            ExpenseTags::create([
                'tag_id' => $tag->id,
                'expense_id' => $this->id,
                'user_id' => $userId,
            ]);
        }
    }
}
