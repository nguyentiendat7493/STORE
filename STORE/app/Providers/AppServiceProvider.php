<?php

namespace App\Providers;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\SettingRepository;
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $siteMenus = collect();
            $siteSettings = [];

            if (Schema::hasTable('menus') && Schema::hasTable('menu_items')) {
                $siteMenus = Menu::query()
                    ->active()
                    ->with(['items' => fn ($query) => $query->active()->with(['children' => fn ($query) => $query->active()])])
                    ->get()
                    ->keyBy('location');
            }

            if (Schema::hasTable('settings')) {
                $siteSettings = Setting::query()
                    ->public()
                    ->pluck('value', 'key')
                    ->all();
            }

            $view->with('siteMenus', $siteMenus);
            $view->with('siteSettings', $siteSettings);
        });
    }
}
