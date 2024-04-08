<?php

namespace Tec\Widget\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Tec\Widget\WidgetGroup group(string $sidebarId)
 * @method static \Tec\Widget\WidgetGroupCollection setGroup(array $args)
 * @method static \Tec\Widget\WidgetGroupCollection removeGroup(string $groupId)
 * @method static array getGroups()
 * @method static string render(string $sidebarId)
 * @method static void load(bool $force = false)
 * @method static \Illuminate\Support\Collection getData()
 *
 * @see \Tec\Widget\WidgetGroupCollection
 */
class WidgetGroup extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tec.widget-group-collection';
    }
}
