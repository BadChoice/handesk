<?php

namespace App\Providers;

use App\Services\Bitbucket\Bitbucket;
use App\Services\IssueCreator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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

        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, current($parameters));
        });

        Validator::replacer('old_password', function ($message, $attribute, $rule, $parameters) {
            return __('passwords.change_error');
        });

        Blade::directive('icon', function ($icon) {
            return icon($icon);
        });

        Blade::directive('busy', function () {
            return  "<span class='busy'>".\FA::spin('circle-o-notch').'</span>';
        });

        Blade::directive('gravatar', function ($email) {
            return "<?php echo gravatar({$email} ?? null); ?>";
        });

        Blade::directive('paginator', function ($data) {
            return "<?php  if ( method_exists({$data}, 'links') ) {
                    echo {$data}->appends(array_except(request()->query(),['page']))->links();
                } ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(IssueCreator::class, Bitbucket::class);
    }
}
