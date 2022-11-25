<?php

namespace challenge\routing;

use challenge\actions\Action;
use challenge\render\Renderer;

interface Router
{
    public function getAction(): Action;

    public function getRenderer(): Renderer;
}