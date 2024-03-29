<?php

namespace Tec\Widget\Facades;

use Illuminate\Support\Facades\Facade;
use Tec\Widget\WidgetGroup;

/**
 * @method static \Tec\Widget\Factories\WidgetFactory registerWidget(string $widget)
 * @method static array getWidgets()
 * @method static \Illuminate\Support\HtmlString|string|null run()
 * @deprecated
 * @see \Tec\Widget\Factories\WidgetFactory
 */
class WidgetFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Tec.widget';
    }

    public static function group(string $name): WidgetGroup
    {
        return app('Tec.widget-group-collection')->group($name);
    }
}
