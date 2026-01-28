<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Transaction;
use App\Observers\TransactionObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        //
        \Carbon\Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.utf8'); // kalau server mendukung
        Transaction::observe(TransactionObserver::class);

    }

}
