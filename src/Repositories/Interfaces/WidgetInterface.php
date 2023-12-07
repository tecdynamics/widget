<?php

namespace Tec\Widget\Repositories\Interfaces;

use Tec\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface WidgetInterface extends RepositoryInterface
{
    public function getByTheme(string $theme): Collection;
}
