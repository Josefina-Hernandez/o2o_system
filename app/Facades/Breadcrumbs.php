<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\BreadcrumbsService
 */
class Breadcrumbs extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Services\BreadcrumbsService::class;
    }
}