<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    /**
     * Names of the categories / income-sources that represent wallet-to-wallet
     * transfers. These are not real expenses or incomes, so they are excluded
     * from the dashboard widgets and the expense reports. Configurable so the
     * user can rename their transfer category without touching code.
     */
    public static function transferNames(): array
    {
        return config('expenses.transfer_names', []);
    }

    /**
     * The foreign-key column used to detect transfers on this model.
     * Overridden by Income, which categorises via income_source_id.
     */
    protected static function transferColumn(): string
    {
        return 'category_id';
    }

    /**
     * IDs of the current user's transfer categories (income-sources for Income).
     */
    protected static function transferIds(): array
    {
        $names = static::transferNames();
        if (empty($names)) {
            return [];
        }

        return Category::whereIn('category', $names)->pluck('id')->all();
    }

    /**
     * Constrain a query to exclude transfer movements. Rows with no
     * category/source (NULL) are kept — only the transfer ones are dropped.
     */
    public function scopeWithoutTransfers($query)
    {
        $ids = static::transferIds();
        if (empty($ids)) {
            return $query;
        }

        $column = $this->getTable() . '.' . static::transferColumn();

        return $query->where(function ($q) use ($column, $ids) {
            $q->whereNotIn($column, $ids)->orWhereNull($column);
        });
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

    public function getCurrencyCodeAttribute()
    {
        return $this->currency->code;
    }

    /**
     * The amount converted into the user's display currency (presentation-only).
     * Falls back to native formatting when no exchange rate is available.
     */
    public function getAmountFormattedAttribute()
    {
        $amount = floatval($this->attributes['amount'] ?? 0);
        $native = $this->currency;

        $converter = app(\App\Services\CurrencyConverter::class);
        $display = $converter->displayCurrency();

        if ($native && strtoupper($native->code) === strtoupper($display->code)) {
            return $display->symbol . ' ' . number_format($amount, 2);
        }

        $converted = $native ? $converter->convert($amount, $native->code, $display->code) : null;

        if ($converted === null) {
            // No rate for this pair — keep the native currency.
            return ($native->symbol ?? '') . ' ' . number_format($amount, 2);
        }

        return $display->symbol . ' ' . number_format($converted, 2);
    }

    /**
     * The amount in its own (native) currency — used for tooltips / reference.
     */
    public function getAmountNativeFormattedAttribute()
    {
        return $this->currency->symbol . ' ' . number_format(floatval($this->attributes['amount'] ?? 0), 2);
    }

    public function getAmountAttribute()
    {
        return !empty($this->attributes['amount']) ? floatval($this->attributes['amount']) : '';
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
    public function getCategoryNameAttribute()
    {
        if (!empty($this->attributes['category_id'])) {
            return $this->category->category;
        }

        return self::DEFAULT_CATEGORY_LABEL;
    }

    public function getWalletNameAttribute()
    {
        if (!empty($this->attributes['wallet_id'])) {
            return $this->wallet->name;
        }

        return self::DEFAULT_WALLET_LABEL;
    }

    public function getWalletIdxAttribute()
    {
        if (!empty($this->attributes['wallet_id'])) {
            return $this->wallet_id;
        }

        return self::DEFAULT_IDX;
    }

    public static function filter($args)
    {
        $q = self::query();

        if (!empty($args['wallet_id'])) {
            $q->where('wallet_id', $args['wallet_id']);
        }

        if (isset($args['wallet_id']) && $args['wallet_id'] === '0') {
            $q->where('wallet_id', null);
        }

        if (!empty($args['category_id'])) {
            $q->where('category_id', $args['category_id']);
        }

        if (isset($args['category_id']) && $args['category_id'] === '0') {
            $q->where('category_id', null);
        }

        if (!empty($args['income_source_id'])) {
            $q->where('income_source_id', $args['income_source_id']);
        }

        if (isset($args['income_source_id']) && $args['income_source_id'] === '0') {
            $q->where('income_source_id', null);
        }

        if (!empty($args['description'])) {
            $q->where('description', 'LIKE', '%' . $args['description'] . '%');
        }

        if (!empty($args['date_from'])) {
            $q->where('date', '>=', $args['date_from']);
        }

        if (!empty($args['date_to'])) {
            $q->where('date', '<=', $args['date_to']);
        }

        if (!empty($args['currency_id'])) {
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
            ->withoutTransfers()
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
            ->withoutTransfers()
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

    /**
     * Current-month totals grouped by category AND native currency code.
     * Conversion into the display currency + final per-category aggregation is
     * done by the caller via CurrencyConverter.
     */
    public static function getExpensesByCategory()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');

        $q = self::select(DB::raw(
            "IF (categories.category IS NULL,
                    ?,
                    categories.category) as category,
                 currencies.code as code,
                 SUM(expenses.amount) as total"
        ))
            ->addBinding(self::DEFAULT_CATEGORY_LABEL, 'select')
            ->leftJoin('categories', 'categories.id', '=', 'expenses.category_id')
            ->join('currencies', 'currencies.id', '=', 'expenses.currency_id')
            ->whereBetween('expenses.date', [$start, $end])
            ->withoutTransfers()
            ->groupBy(DB::raw('1, 2'));

        return $q->get();
    }

    /**
     * @throws \Exception
     */
    public function setWalletIdAttribute($value)
    {

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

    public static function aggregateByCurrency($expenses)
    {
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

    static public function isEmpty()
    {
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
    static public function updateCurrency(Wallet $wallet): void
    {
        self::where('wallet_id', $wallet->id)
            ->update(['currency_id' => $wallet->currency_id]);
    }

    static public function updateCurrencyOfNoWallets(int $currencyId): void
    {
        self::where('wallet_id', null)
            ->update(['currency_id' => $currencyId]);
    }

    /**
     * Get all receipts
     */
    public function receipts(): MorphMany
    {
        return $this->morphMany(Receipt::class, 'receiptable');
    }
}
