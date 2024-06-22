<?php

namespace App\Providers;

use App\Constants\LogType;
use Illuminate\Support\ServiceProvider;

class LogTypeInitializer extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        LogType::boot();
    }
}
