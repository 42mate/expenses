<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    protected $table = 'expenses';
    protected $with = ['currency'];

    //The human readable name for the default related Category or Wallet.
    public const DEFAULT_LABEL = 'Default';
    public const DEFAULT_CATEGORY_LABEL = 'No category';
    public const DEFAULT_SOURCE_LABEL = 'No source';
    public const DEFAULT_WALLET_LABEL = 'No wallet';

    //In the db will be NULL, but we need a value to represent and use it in the filters
    public const DEFAULT_IDX = 0;

    protected $appends = [
        'amount_formatted',
        'category_name',
        'category_idx',
        'wallet_name',
        'wallet_idx',
        'currency_code',
    ];

    protected $fillable = [
        'amount',
        'date',
        'category_id',
        'user_id',
        'description',
        'wallet_id',
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

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    protected $dateFormat = 'Y-m-d';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function wallet()
    {
        return $this->belongsTo('App\Models\Wallet');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function getCurrencyCodeAttribute() {
        return  $this->currency->code;
    }

    public function getAmountFormattedAttribute()
    {
        return $this->currency->symbol . ' '. floatval($this->attributes['amount']);
    }

    public function getAmountAttribute() {
        return !empty($this->attributes['amount']) ? floatval( $this->attributes['amount']) : '';
    }

    /**
     * Gets the category id from the database or -1
     *
     * We need this special method because if the category_id is null
     * we need to show the default category that is not a database entry.
     *
     * @return int
     */
    public function getCategoryIdxAttribute()
    {
        if (! empty($this->attributes['category_id'])) {
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
    public function getCategoryNameAttribute()
    {
        if (! empty($this->attributes['category_id'])) {
            return $this->category->category;
        }

        return self::DEFAULT_CATEGORY_LABEL;
    }

    public function getWalletNameAttribute()
    {
        if (! empty($this->attributes['wallet_id'])) {
            return $this->wallet->name;
        }

        return self::DEFAULT_WALLET_LABEL;
    }

    public function getWalletIdxAttribute()
    {
        if (! empty($this->attributes['wallet_id'])) {
            return $this->wallet_id;
        }

        return self::DEFAULT_IDX;
    }

    public static function filter($args)
    {
        $q = self::query();

        if (! empty($args['wallet_id'])) {
            $q->where('wallet_id', $args['wallet_id']);
        }

        if (isset($args['wallet_id']) && $args['wallet_id'] === '0') {
            $q->where('wallet_id', null);
        }

        if (! empty($args['category_id'])) {
            $q->where('category_id', $args['category_id']);
        }

        if (isset($args['category_id']) && $args['category_id'] === '0') {
            $q->where('category_id', null);
        }

        if (! empty($args['income_source_id'])) {
            $q->where('income_source_id', $args['income_source_id']);
        }

        if (isset($args['income_source_id']) && $args['income_source_id'] === '0') {
            $q->where('income_source_id', null);
        }

        if (! empty($args['description'])) {
            $q->where('description', 'LIKE', '%'.$args['description'].'%');
        }

        if (! empty($args['date_from'])) {
            $q->where('date', '>=', $args['date_from']);
        }

        if (! empty($args['date_to'])) {
            $q->where('date', '<=', $args['date_to']);
        }

        if (! empty($args['currency_id'])) {
            $q->where('currency_id', '=', $args['currency_id']);
        }


        $q->with(['category', 'wallet', 'currency']);

        $q->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC');

        return $q;
    }

    public static function byUser()
    {
        return self::orderBy('date', 'desc')
            ->get();
    }

    public static function byUserCurrentMonth()
    {
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth('Y-m-d');

        return self::whereBetween('date', [$from, $to])
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function getTotals()
    {
        return self::monthTotal();
    }

    public static function todayTotal()
    {
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::tomorrow()->format('Y-m-d');

        return self::totalByDateRange($from, $to);
    }

    public static function weekTotal()
    {
        $from = Carbon::now()->startOfWeek()->format('Y-m-d');
        $to = Carbon::now()->endOfWeek()->format('Y-m-d');

        return self::totalByDateRange($from, $to);
    }

    public static function monthTotal()
    {
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth()->format('Y-m-d');

        return self::totalByDateRange($from, $to);
    }

    public static function lastMonthTotal()
    {
        $from = Carbon::now()->startOfMonth()->sub('1 month')->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->startOfMonth()->sub('1 day')->endOfMonth()->format('Y-m-d');

        return self::totalByDateRange($from, $to);
    }

    public static function totalByDateRange($from, $to)
    {
        $expenses = self::whereBetween('date', [$from, $to])
            ->selectRaw('DATE_FORMAT(date, "%Y-%c") as `month`,
                    currencies.name as name,
                    currencies.code as code,
                    currencies.symbol as symbol, SUM(amount) as total')
            ->join('currencies', (with(new static)->getTable()) . '.currency_id', '=', 'currencies.id')
            ->groupBy(DB::raw('1, 2, 3, 4'));

        return $expenses->get();
    }

    public static function getTotalByMonth()
    {
        return self::query()
            ->select(DB::raw('DATE_FORMAT(date, "%Y-%c") as `month`,
                    currencies.name as name,
                    currencies.code as code,
                    currencies.symbol as symbol,
                    SUM(amount) as total')
            )->join('currencies', (with(new static)->getTable()) . '.currency_id', '=', 'currencies.id')
            ->whereBetween('date', [date('Y-m-d', strtotime('now -12 months')), date('Y-m-d')])
            ->groupBy(DB::raw('1, 2, 3, 4'))
            ->orderBy(DB::raw('STR_TO_DATE(1, "%d-%m-%Y")'))
            ->get();
    }

    public static function getExpensesByCategory($currencyId = 1)
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');

        $q = self::select(DB::raw(
            "IF (categories.category IS NULL,
                    '" . self::DEFAULT_CATEGORY_LABEL . "',
                    categories.category) as category,
                 SUM(expenses.amount) as total"
        ))
            ->leftJoin('categories', 'categories.id', '=', 'expenses.category_id')
            ->whereBetween('expenses.date', [$start, $end])
            ->where('currency_id', $currencyId)
            ->groupBy(DB::raw('1'))
            ->orderBy(DB::raw('1'), 'DESC');

        return $q->get();
    }

    /**
     * @throws \Exception
     */
    public function setWalletIdAttribute($value) {

        if ($value === null) {
            $defaultCurrencyId = Auth::user()->default_currency_id;
            if ($defaultCurrencyId === null) {
                $defaultCurrencyId = 1;
            }
            $this->attributes['currency_id'] = $defaultCurrencyId;
        } else {
            $wallet = Wallet::findOrFail($value);
            $this->attributes['currency_id'] = $wallet->currency->id;
        }

        $this->attributes['wallet_id'] = $value;
    }

    public static function aggregateByCurrency($expenses) {
        $aggregate = [];
        foreach ($expenses as $expense) {
            if (empty($aggregate[$expense->currency_id])) {
                $aggregate[$expense->currency_id] = [
                    'currency' => $expense->currency,
                    'sum' => 0,
                ];
            }
            $aggregate[$expense->currency_id]['sum'] += $expense->amount;

        }
        return $aggregate;
    }

    static public function isEmpty() {
        $oneRecord = DB::table((with(new static)->getTable()))
            ->where('user_id', '=', Auth::id())
            ->select(['id'])
            ->limit(1)
            ->get();
        return $oneRecord->isEmpty();
    }

    /**
     * It will change on all transactions related to the wallet, the
     * new currency of the wallet.
     *
     * @param Wallet $wallet
     *
     * @return void
     */
    static public function updateCurrency(Wallet $wallet) : void {
        self::where('wallet_id', $wallet->id)
            ->update(['currency_id' => $wallet->currency_id]);
    }

    static public function updateCurrencyOfNoWallets(int $currencyId) : void {
        self::where('wallet_id', null)
            ->update(['currency_id' => $currencyId]);
    }
}
