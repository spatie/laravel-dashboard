<?php

namespace Spatie\Dashboard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Dashboard\Dashboard
 */
class DashboardFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'dashboard';
    }
}
