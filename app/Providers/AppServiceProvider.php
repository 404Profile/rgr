<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\SendOrderConfirmation;
use App\Listeners\UpdateProductQuantity;
use App\Models\Brand;
use App\Models\Category;
use App\Models\News;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use App\Policies\BrandPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\NewsPolicy;
use App\Policies\OrderPolicy;
use App\Policies\PagePolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        Brand::class => BrandPolicy::class,
        News::class => NewsPolicy::class,
        Order::class => OrderPolicy::class,
        Page::class => PagePolicy::class,
        User::class => UserPolicy::class,
    ];

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [
            SendOrderConfirmation::class,
            UpdateProductQuantity::class,
        ],
    ];

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
        Schema::defaultStringLength(191);

        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }

        Inertia::share([
            'locale' => fn () => App::getLocale(),
            'language' => fn () => $this->translations(
                resource_path('lang/'. App::getLocale() .'.json')
            ),
        ]);
    }

    private function translations(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }

        return json_decode(file_get_contents($path), true);
    }

}
