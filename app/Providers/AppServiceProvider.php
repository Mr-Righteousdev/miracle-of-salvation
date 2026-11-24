<?php

namespace App\Providers;

use App\Models\Ministry;
use App\Models\Setting;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        FilamentShield::enforcePolicies();

        $this->configureDefaults();

        View::composer('layouts.site', fn (\Illuminate\View\View $view) => $view->with([
            'navMinistries' => Ministry::published()->get(['name', 'slug']),
        ]));

        View::composer(['layouts.site', 'site.*'], fn (\Illuminate\View\View $view) => $view->with([
            'settings' => Setting::values(),
        ]));
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
