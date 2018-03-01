<?php

namespace Roshangara\Statusable;

use Illuminate\Support\ServiceProvider;

class StatusableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }
}
