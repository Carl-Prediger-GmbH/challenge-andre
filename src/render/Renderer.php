<?php

declare(strict_types=1);

namespace challenge\render;

use challenge\actions\Action;

interface Renderer
{
    public function render(Action $action): void;
}