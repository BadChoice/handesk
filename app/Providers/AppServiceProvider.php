<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::directive("icon", function ($icon) {
            return icon($icon);
        });

        Blade::directive("paginator", function ($data) {
            return "<?php  if ( method_exists({$data}, 'links') ) {
                    echo {$data}->appends(array_except(request()->query(),['page']))->links();
                } ?>";
        });
    }
}
