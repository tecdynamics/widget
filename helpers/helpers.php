<?php

use Tec\Widget\Facades\Widget;
use Tec\Widget\Facades\WidgetGroup;
use Tec\Widget\Factories\WidgetFactory;
use Tec\Widget\WidgetGroupCollection;

if (! function_exists('register_widget')) {
    function register_widget(string $widgetId): WidgetFactory
    {
        return Widget::registerWidget($widgetId);
    }
}

if (! function_exists('register_sidebar')) {
    function register_sidebar(array $args): WidgetGroupCollection
    {
        return WidgetGroup::setGroup($args);
    }
}

if (! function_exists('remove_sidebar')) {
    function remove_sidebar(string $sidebarId): WidgetGroupCollection
    {
        return WidgetGroup::removeGroup($sidebarId);
    }
}

if (! function_exists('dynamic_sidebar')) {
    function dynamic_sidebar(string $sidebarId,$data=[]): string
    {
        return WidgetGroup::render($sidebarId,$data);
    }
}
