<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use BladeUI\Icons\Factory;

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
        $this->app->afterResolving(Factory::class, function (Factory $factory) {
            $factory->add('custom', [
                'path' => resource_path('svg'),
                'prefix' => 'custom',
            ]);
        });
        Filament::registerRenderHook(
            'filament.sidebar.items',
            fn () => view('custom-navigation-icon'),
        );
    }
}




