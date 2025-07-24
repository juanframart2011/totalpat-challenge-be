<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use App\Models\Card;
use App\Policies\CardPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Card::class => CardPolicy::class,   // ← ¡aquí!
        // … otras policies
    ];
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
        //
    }
}
