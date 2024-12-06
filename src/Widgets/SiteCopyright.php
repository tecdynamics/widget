<?php

namespace Tec\Widget\Widgets;

use Tec\Base\Facades\Html;
use Tec\Base\Forms\FieldOptions\HtmlFieldOption;
use Tec\Base\Forms\Fields\HtmlField;
use Tec\Theme\Supports\ThemeSupport;
use Tec\Widget\AbstractWidget;
use Tec\Widget\Forms\WidgetForm;
use Illuminate\Support\Collection;

class SiteCopyright extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Site Copyright'),
            'description' => __('Copyright text at the bottom footer.'),
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'description',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content(
                        __('Go to :link to change the copyright text.', [
                            'link' => Html::link(route('theme.options'), __('Theme options')),
                        ])
                    )
                    ->toArray()
            );
    }

    protected function data(): array|Collection
    {
        return [
            'copyright' => ThemeSupport::getSiteCopyright(),
        ];
    }
}
