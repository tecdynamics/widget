<?php

namespace Tec\Widget\Forms;

use Tec\Base\Forms\FormAbstract;
use Tec\Base\Models\BaseModel;

class WidgetForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(BaseModel::class)
            ->contentOnly();
    }

    public function renderForm(array $options = [], $showStart = false, $showFields = true, $showEnd = false): string
    {
        return parent::renderForm($options, $showStart, $showFields, $showEnd);
    }
}
