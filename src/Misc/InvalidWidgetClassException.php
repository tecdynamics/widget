<?php

namespace Tec\Widget\Misc;

use Tec\Widget\AbstractWidget;
use Exception;

class InvalidWidgetClassException extends Exception
{
    protected $message = 'Widget class must extend class ' . AbstractWidget::class;
}
