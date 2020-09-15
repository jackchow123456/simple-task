<?php
/**
 * Created by PhpStorm.
 * User: zhouminjie
 * Date: 2020-09-14
 * Time: 17:22
 */

namespace JackChow\SimpleTask;

use Illuminate\Support\ServiceProvider;

class SimpleTaskServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerPublishing();
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/config' => config_path()], 'simple-task-config');
            $this->publishes([__DIR__ . '/database/migrations' => database_path('migrations')], 'simple-task-migrations');
        }
    }
}