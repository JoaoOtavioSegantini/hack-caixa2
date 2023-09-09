<?php

namespace App\Providers;

use App\Repositories\Eloquent\PostagemEloquentRepositorio;
use Core\Domain\Repository\RepositorioPostagemInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            RepositorioPostagemInterface::class,
            PostagemEloquentRepositorio::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
