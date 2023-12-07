<?php

namespace Tec\Widget\Repositories\Eloquent;

use Tec\Support\Repositories\Eloquent\RepositoriesAbstract;
use Tec\Widget\Repositories\Interfaces\WidgetInterface;
use Illuminate\Database\Eloquent\Collection;

class WidgetRepository extends RepositoriesAbstract implements WidgetInterface
{
    public function getByTheme(string $theme): Collection
    {
        $data = $this->model->where('theme', $theme)->get();
        $this->resetModel();

        return $data;
    }
}
