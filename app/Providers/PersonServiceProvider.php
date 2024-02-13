<?php

namespace App\Providers;

use App\La8\Interfaces\IPersonRepository;
use App\La8\Repository\PersonRespository;
use Illuminate\Support\ServiceProvider;

class PersonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(IPersonRepository::class,PersonRespository::class);
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
