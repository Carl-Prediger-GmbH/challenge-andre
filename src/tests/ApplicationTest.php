<?php

declare(strict_types=1);

namespace challenge_test;

use PHPUnit\Framework\MockObject\MockClass;
use PHPUnit\Framework\TestCase;

use challenge\Application;
use challenge\actions\Action;
use challenge\render\Renderer;
use challenge\routing\Router;

class ApplicationTest extends TestCase
{
    protected Router|MockClass $routerMock;

    protected Application $application;

    protected function setUp(): void
    {
        $this->routerMock = self::createMock(Router::class);

        $this->application = new Application($this->routerMock);
    }

    public function testExecute(): void
    {
        $actionMock = self::createMock(Action::class);
        $this->routerMock->expects(self::once())->method('getAction')->willReturn($actionMock);
        $rendererMock = self::createMock(Renderer::class);
        $this->routerMock->expects(self::once())->method('getRenderer')->willReturn($rendererMock);
        $rendererMock->expects(self::once())->method('render')->with($actionMock);

        $this->application->execute();
    }
}
