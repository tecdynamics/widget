<?php

namespace Tec\Widget\Facades;

use Tec\Widget\WidgetGroup;
use Illuminate\Support\Facades\Facade;

class WidgetFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tec.widget';
    }

    /**
     * Get the widget group object.
     *
     * @param string $name
     *
     * @return WidgetGroup
     */
    public static function group($name)
    {
        return app('tec.widget-group-collection')->group($name);
    }
}
