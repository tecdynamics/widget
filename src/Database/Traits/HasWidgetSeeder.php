<?php

namespace Tec\Widget\Database\Traits;

use Tec\Widget\Models\Widget;

trait HasWidgetSeeder
{
    protected function createWidgets(array $data, bool $truncate = true): void
    {
        if ($truncate) {
            Widget::query()->truncate();
        }

        $theme = Widget::getThemeName();

        foreach ($data as $item) {
            $item['theme'] = $theme;

            Widget::query()->create($item);
        }
    }
}
