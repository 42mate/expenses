<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Expense;
use App\Models\Income;
use App\Models\IncomeSource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class TransactionExportTest extends TestCase
{
    use DatabaseTransactions;

    protected Currency $currency;

    protected function setUp(): void
    {
        parent::setUp();

        $currency = Currency::where('code', '!=', 'DEF')->first();
        if (! $currency) {
            $this->markTestSkipped('No currencies seeded.');
        }

        $this->currency = $currency;
    }

    private function actingAsUser(): User
    {
        $user = User::create([
            'name' => 'Export Tester',
            'email' => 'export-'.uniqid().'@example.com',
            'password' => bcrypt('secret'),
            'default_currency_id' => $this->currency->id,
        ]);

        $this->actingAs($user);

        return $user;
    }

    private function makeWallet(User $user): Wallet
    {
        return Wallet::create([
            'name' => 'Test Wallet',
            'user_id' => $user->id,
            'balance' => 0,
            'currency_id' => $this->currency->id,
        ]);
    }

    /**
     * The regression this guards: the Export button lost its name/value in the
     * mate/laravel-forms migration, so `action=xls` never reached the controller.
     */
    public function test_the_expense_filter_renders_an_export_button_that_submits_the_action(): void
    {
        $this->actingAsUser();

        $response = $this->get('/expense');

        $response->assertOk();
        $response->assertSee('name="action"', false);
        $response->assertSee('value="xls"', false);
    }

    public function test_the_income_filter_renders_an_export_button_that_submits_the_action(): void
    {
        $this->actingAsUser();

        $response = $this->get('/incomes');

        $response->assertOk();
        $response->assertSee('name="action"', false);
        $response->assertSee('value="xls"', false);
    }

    public function test_expenses_are_downloaded_as_a_spreadsheet(): void
    {
        Excel::fake();
        Carbon::setTestNow('2026-07-28 13:40:12');

        $user = $this->actingAsUser();
        $wallet = $this->makeWallet($user);
        $category = Category::create(['category' => 'Groceries', 'user_id' => $user->id]);

        Expense::create([
            'amount' => 154.30,
            'date' => '2026-07-12',
            'description' => 'Weekly shop',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'wallet_id' => $wallet->id,
        ]);

        $this->get('/expense?action=xls')->assertOk();

        Excel::assertDownloaded('expenses-2026-07-28_134012.xlsx', function ($export) {
            $headings = $export->headings();
            $row = $export->map($export->collection()->firstWhere('description', 'Weekly shop'));

            return $headings === ['Date', 'Category', 'Wallet', 'Description', 'Currency', 'Amount']
                && $row === [
                    '2026-07-12',
                    'Groceries',
                    'Test Wallet',
                    'Weekly shop',
                    $this->currency->code,
                    154.30,
                ];
        });

        Carbon::setTestNow();
    }

    public function test_incomes_are_downloaded_as_a_spreadsheet(): void
    {
        Excel::fake();
        Carbon::setTestNow('2026-07-28 13:40:12');

        $user = $this->actingAsUser();
        $wallet = $this->makeWallet($user);
        $source = IncomeSource::create(['source' => 'Salary', 'user_id' => $user->id]);

        Income::create([
            'amount' => 2500,
            'date' => '2026-07-01',
            'description' => 'July pay',
            'user_id' => $user->id,
            'income_source_id' => $source->id,
            'wallet_id' => $wallet->id,
        ]);

        $this->get('/incomes?action=xls')->assertOk();

        Excel::assertDownloaded('incomes-2026-07-28_134012.xlsx', function ($export) {
            $headings = $export->headings();
            $row = $export->map($export->collection()->firstWhere('description', 'July pay'));

            return $headings === ['Date', 'Income Source', 'Wallet', 'Description', 'Currency', 'Amount']
                && $row === [
                    '2026-07-01',
                    'Salary',
                    'Test Wallet',
                    'July pay',
                    $this->currency->code,
                    2500.0,
                ];
        });

        Carbon::setTestNow();
    }
}
