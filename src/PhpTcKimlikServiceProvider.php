<?php


namespace IsaEken\PhpTcKimlik;

use Illuminate\Support\ServiceProvider;

/**
 * Class PhpTcKimlikServiceProvider
 *
 * @package IsaEken\PhpTcKimlik
 */
class PhpTcKimlikServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/../resources/lang" => resource_path("lang/vendor/phpTcKimlik"),
        ]);

        $this->loadTranslationsFrom(__DIR__ . "/../resources/lang/", "phpTcKimlik");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
