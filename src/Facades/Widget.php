<?php

namespace Tec\Widget\Facades;

use Tec\Widget\WidgetGroup;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Tec\Widget\Factories\WidgetFactory registerWidget(string $widget)
 * @method static array getWidgets()
 * @method static \Illuminate\Support\HtmlString|string|null run()
 *
 * @see \Tec\Widget\Factories\WidgetFactory
 */
class Widget extends Facade
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
