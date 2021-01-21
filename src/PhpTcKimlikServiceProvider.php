<?php


namespace IsaEken\PhpTcKimlik;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use IsaEken\TurkeyIdValidator;

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
        $this->bootValidator();
    }

    protected function bootValidator()
    {
        Validator::extend('tc', function ($attribute, $value, $parameters, $validator) {
            return PhpTcKimlik::verifyIdentity($value);
        });

        Validator::extend('tc-name', function ($attribute, $value, $parameters, $validator) {
            return PhpTcKimlik::verifyName($value);
        });

        Validator::extend('tc-year', function ($attribute, $value, $parameters, $validator) {
            return PhpTcKimlik::verifyIdentity($value);
        });
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
