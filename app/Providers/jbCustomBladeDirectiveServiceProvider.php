<?php

namespace App\Providers;

use session;
use stdClass;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class jbCustomBladeDirectiveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('isinvalid', function ($expression) {

            return "<?php 
                        if(session('errors'))
                        if((session('errors')->get($expression)[0]))
                        echo ' is-invalid ';             
            ?>";
        });
        Blade::directive('mydirective2', function ($expression) {
            return "<?php echo('dupa2 '.$expression); ?>";
        });
        //
    }
}
