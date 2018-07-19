<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComponentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Form::component('feRadio', 'components.radio', ['name', 'options', 'selected', 'attributes']);
        \Form::component('feCheckbox', 'components.checkbox', ['name', 'options', 'selected', 'attributes']);
        \Form::component('switch', 'components.switch', ['name', 'value', 'checked', 'attributes']);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
