<?php

namespace Tec\Widget\Widgets;

use Tec\Widget\AbstractWidget;

class Text extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => trans('packages/widget::widget.widget_text'),
            'description' => trans('packages/widget::widget.widget_text_description'),
            'content' => null,
        ]);

        $this->setFrontendTemplate('packages/widget::widgets.text.frontend');
        $this->setBackendTemplate('packages/widget::widgets.text.backend');
    }

    public function getWidgetDirectory(): string
    {
        return 'text';
    }
}
