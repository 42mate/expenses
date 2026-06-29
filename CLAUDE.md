# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

Expenses is a Laravel 11 application for tracking personal expenses and incomes across multiple wallets and currencies. The actual application lives in `src/` (a standard Laravel project); the repository root only holds the Lando config, deploy script, and docs.

## Development environment

Development runs entirely through **Lando** (Docker). PHP 8.3, Node 16, MySQL, and a Mailhog mail catcher are defined in `.lando.yml`. Almost every command must be run via Lando tooling — there is no host-level PHP/composer expected.

```bash
cd src
cp .env.local .env        # local .env is pre-wired for Lando
lando start
lando composer install
lando npm install
lando artisan migrate
lando artisan db:seed                       # sample data
lando artisan db:seed CurrenciesSeeder      # currencies (required — seeded separately)
```

Common tooling (all proxied into containers):
- `lando artisan <cmd>` — Laravel CLI (runs in `/app/src`)
- `lando composer <cmd>`
- `lando npm <cmd>`
- `lando mysql laravel` — open a MySQL shell on the app database
- `lando npm-logs` — tail the Vue/asset compile log from the node container

App URL: `https://expenses.lndo.site`. phpMyAdmin: `https://sqlexpenses.lndo.site`. Mailhog is reachable via the Lando-reported service URL.

## Frontend assets

Assets are built with **Laravel Mix** (not Vite), config in `src/webpack.mix.js`. The node container runs `npm run watch` automatically on `lando start`. Manual builds:
- `lando npm run dev` — one-off development build
- `lando npm run watch` — rebuild on change
- `lando npm run prod` — production build

Stack: Bootstrap 5, jQuery, Chart.js 2 (dashboard/report charts), FilePond (receipt uploads), pdfmake/jszip (PDF/export generation).

## Testing

PHPUnit (with Pest installed) configured in `src/phpunit.xml`. Tests run against a **real MySQL database** (`DB_CONNECTION=mysql`, host `database`), not sqlite — so they must run inside Lando.

```bash
lando artisan test                          # all tests
lando artisan test --testsuite=Unit         # Unit suite only
lando artisan test --testsuite=Feature      # Feature suite only
lando artisan test --filter=UsersTest       # single test class/method
```

Test suites live in `src/tests/Unit` and `src/tests/Feature`. `tests/ApiBaseTest.php` is the base class for API tests.

## Code style

`src/.styleci.yml` uses the **Laravel preset** (StyleCI) with `unused_use` disabled. `laravel/pint` is available as a dev dependency: `lando composer exec pint`.

## Architecture

### Multi-tenancy via global scope
Every user-owned model (`Expense`, `Wallet`, `Category`, `Income`, `IncomeSource`, `RecurrentExpense`) applies `App\Models\Scopes\OwnerScope` in its `booted()` method. This scope **automatically filters every query to the authenticated user** (`where user_id = Auth::id()`) and **throws `UserNotDefinedException` if no user is logged in**. Consequences to keep in mind:
- You almost never need to manually filter by `user_id` when querying these models — the scope does it.
- Querying these models outside an authenticated context (e.g. in a console command or seeder without an acting user) will throw. Use `withoutGlobalScope` or raw `DB` queries there.

### Currency derives from wallet
Currency is not chosen directly on an expense. `Expense::setWalletIdAttribute()` derives `currency_id` from the selected wallet (or the user's `default_currency_id` / currency 1 when no wallet). Because of this:
- Changing a wallet's currency must cascade to its transactions — see `Expense::updateCurrency()` and `updateCurrencyOfNoWallets()`.
- A "no wallet" / "no category" concept is modeled with `DEFAULT_IDX = 0` and `DEFAULT_*_LABEL` constants, representing a NULL FK as a selectable/displayable default in filters and the UI.

### Expense as the aggregation hub
`app/Models/Expense.php` is the largest model and centralizes most reporting logic via static methods: `filter()` (builds the index query from request args), `totalByDateRange()`, `monthTotal()`/`weekTotal()`/`todayTotal()`/`lastMonthTotal()`, `getTotalByMonth()`, `getExpensesByCategory()`, and `aggregateByCurrency()`. These use raw `DB::raw` SQL with currency joins and feed the dashboard and reports. `RecurrentExpense extends Expense` (table `recurrent_expense`) and inherits this behavior; creating an expense from a recurrent template is wired through `ExpenseController::create()` via a `recurrent_expense` query param.

### Receipts (polymorphic + FilePond)
Receipts are a polymorphic `MorphMany` on `Expense` (`receiptable`). Upload flow: FilePond posts to `FilePondController` (`fp/up`, `fp/load`), which stores a temp file; on expense save, `Receipt::bindReceiptsToExpense()` moves temp files to permanent storage on the `public` disk under `receipts/`. Run `lando artisan storage:link` if receipt URLs 404.

### Routing & controllers
- **Web routes** (`routes/web.php`): all app pages, behind `auth` middleware except the public home. Uses string controller references (`'ExpenseController@index'`). Also exposes session-auth'd JSON endpoints under `/api/transactions/...` (handled by `Api\TransactionsData`) that feed the Chart.js dashboards.
- **API routes** (`routes/api.php`): token auth (`auth:api`). Category CRUD is exposed through **Laravel Orion** (`tailflow/laravel-orion`) — `Api\CategoryController` overrides `buildIndexFetchQuery`/`performStore`/`performUpdate` to enforce user ownership. Login/user creation via `Api\UserController`.

### Key packages
- `maatwebsite/excel` — XLS export (see `app/Exports`, triggered by `?action=xls` on the expense index)
- `spatie/laravel-html`, `mate/laravel-forms` — server-side form/HTML building in Blade
- `dcblogdev/laravel-db-sync` — DB sync between environments
- `doctrine/dbal` — required for column-altering migrations

### Views
Blade views in `src/resources/views/pages/<entity>/`, with a shared theme under `theme/`, reusable partials in `components/`/`includes/`, and a separate public landing area under `pages/public/`.

## Deployment

`bash script/deploy.sh` (run from repo root) rsyncs source + built assets to the configured servers over SSH — it does **not** copy `.env`, `storage`, or `node_modules`. Requires a `.server_env` file (copy from `.server_env.example`) and pre-configured SSH keys. Production `.env` is managed manually on the server. Build assets locally with `lando npm run prod` before deploying.
