<?php

namespace App\Providers;

use App\Services\Pop3\Pop3;
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
        require_once(base_path() . '/helpers/helpers.php');
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

        Blade::directive("busy", function(){
                return  "<span class='busy'>" . \FA::spin('circle-o-notch') . "</span>";
        });

        Blade::directive("gravatar", function($email, $size = 30){
            $email = md5( strtolower(trim($email)) );
            //$gravatarURL = "https://www.gravatar.com/avatar/" . $email."?s=".$size."&d=mm";
            $defaultImage = urlencode("http://revo.works/images/logo.png");
            $gravatarURL = "https://www.gravatar.com/avatar/" . $email."?s=".$size."&default={$defaultImage}";
            return '<img id = '.$email.''.$size.' class="gravatar" src="'.$gravatarURL.'" width="'.$size.'">';
        });

        Blade::directive("paginator", function ($data) {
            return "<?php  if ( method_exists({$data}, 'links') ) {
                    echo {$data}->appends(array_except(request()->query(),['page']))->links();
                } ?>";
        });
    }
}
