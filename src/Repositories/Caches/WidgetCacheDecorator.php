<?php

namespace Tec\Widget\Repositories\Caches;

use Tec\Support\Repositories\Caches\CacheAbstractDecorator;
use Tec\Widget\Repositories\Interfaces\WidgetInterface;

class WidgetCacheDecorator extends CacheAbstractDecorator implements WidgetInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByTheme($theme)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
