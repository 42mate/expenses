<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CurrencyConverter::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Make the display currency + converter available to every view so
        // amounts can be presented in the user's chosen currency everywhere.
        View::composer('*', function ($view) {
            $converter = app(CurrencyConverter::class);
            $view->with('currencyConverter', $converter);
            $view->with('displayCurrency', $converter->displayCurrency());
        });
    }
}
