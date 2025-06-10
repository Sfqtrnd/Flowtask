<?php

namespace App\Providers;

use App\Models\User;
use Gate;
use Illuminate\Support\ServiceProvider;

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
        // Gate: hanya untuk asdos
    Gate::define('asdos', function (User $user) {
      return $user->role === 'asdos';
    });

    // Gate: hanya untuk mahasiswa 
    Gate::define('mahasiswa', function (User $user) {
      return $user->role === 'mahasiswa';
    });
    }
}
