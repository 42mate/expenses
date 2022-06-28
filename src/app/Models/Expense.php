<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    protected $table = 'expenses';

    //The human readable name for the default related Category or Wallet.
    public const DEFAULT_LABEL = 'Default';

    //In the db will be NULL, but we need a value to represent and use it in the filters
    public const DEFAULT_IDX = 0;

    protected $appends = [
        'amount_formatted',
        'category_name',
        'category_idx',
        'wallet_name',
        'wallet_idx',
        'tags_formatted'
    ];

    protected $fillable = [
        'amount',
        'date',
        'category_id',
        'user_id',
        'description',
        'wallet_id'
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    protected $dateFormat = 'Y-m-d';

    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'expense_tags');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function wallet()
    {
        return $this->belongsTo('App\Models\Wallet');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
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

    /**
     * Gets the category id from the database or -1
     *
     * We need this special method because if the category_id is null
     * we need to show the default category that is not a database entry.
     *
     * @return integer
     */
    public function getCategoryIdxAttribute() {
        if (!empty($this->attributes['category_id'])) {
            return $this->category_id;
        }
        return self::DEFAULT_IDX;
    }

    /**
     * Gets the category name to be printable to the user.
     *
     * We need this special method because if the category_id is null
     * we need to show the default category that is not a database entry.
     *
     * @return string
     */
    public function getCategoryNameAttribute() {
        if (!empty($this->attributes['category_id'])) {
            return $this->category->category;
        }
        return self::DEFAULT_LABEL;
    }

    public function getWalletNameAttribute() {
        if (!empty($this->attributes['wallet_id'])) {
            return $this->wallet->name;
        }
        return self::DEFAULT_LABEL;
    }


    public function getWalletIdxAttribute() {
        if (!empty($this->attributes['wallet_id'])) {
            return $this->wallet_id;
        }
        return self::DEFAULT_IDX;
    }

    public static function filter($userId, $args) {
        $q = self::query();

        $q->where('user_id', $userId);

        if (!empty($args['wallet_id'])) {
            $q->where('wallet_id', $args['wallet_id']);
        }

        if (isset($args['wallet_id']) && $args['wallet_id'] === "0") {
            $q->where('wallet_id', null);
        }

        if (!empty($args['category_id'])) {
            $q->where('category_id', $args['category_id']);
        }

        if (isset($args['category_id']) && $args['category_id'] === "0") {
            $q->where('category_id', null);
        }

        if (!empty($args['description'])) {
            $q->where('description', 'LIKE', '%'. $args['description'] . '%');
        }

        if (!empty($args['date_from'])) {
            $q->where('date', '>=',  $args['date_from']);
        }

        if (!empty($args['date_to'])) {
            $q->where('date', '<=',  $args['date_to']);
        }

        if (!empty($args['tags'])) {
            $q->whereHas('tags', function(Builder $q) use ($args) {
                $q->where('name', $args['tags']);
            });
        }

        $q->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC');

        return $q;
    }

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
        return DB::select('SELECT DATE_FORMAT(e.date, "%Y-%c") as `month`,  SUM(e.amount) as total
            FROM  expenses e
            WHERE e.user_id = ?
            GROUP BY 1
            ORDER BY STR_TO_DATE(1, "%d-%m-%Y") ASC', [
            $userId
        ]);
    }

    public static function getExpensesByCategory($userId) {
        return DB::select('SELECT IF(c.category IS NULL, ?, c.category) as category, SUM(e.amount) as total
            FROM expenses e LEFT JOIN categories c ON e.category_id = c.id
            WHERE e.date BETWEEN ? AND ?
            AND e.user_id = ?
            GROUP BY 1
            ORDER BY 1 DESC', [
                self::DEFAULT_LABEL,
                Carbon::now()->startOfMonth()->format('Y-m-d'),
                Carbon::now()->endOfMonth()->format('Y-m-d'),
                $userId
        ]);
    }
}

