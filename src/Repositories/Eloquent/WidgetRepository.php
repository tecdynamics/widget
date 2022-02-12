<?php

namespace Tec\Widget\Repositories\Eloquent;

use Tec\Support\Repositories\Eloquent\RepositoriesAbstract;
use Tec\Widget\Repositories\Interfaces\WidgetInterface;

class WidgetRepository extends RepositoriesAbstract implements WidgetInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByTheme($theme)
    {
        $data = $this->model->where('theme', $theme)->get();
        $this->resetModel();

        return $data;
    }
}
