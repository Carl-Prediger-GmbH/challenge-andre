<?php

declare(strict_types=1);

namespace challenge;

use challenge\routing\Router;

class Application
{
    public function __construct(private readonly Router $router) {}

    public function execute(): void
    {
        $renderer = $this->router->getRenderer();
        $action = $this->router->getAction();
        $renderer->render($action);
    }
}