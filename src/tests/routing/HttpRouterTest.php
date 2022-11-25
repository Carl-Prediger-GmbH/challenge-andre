<?php

declare(strict_types=1);

namespace challenge_test\routing;

use GuzzleHttp\Psr7\Uri;
use challenge\actions\Action;
use challenge\render\Renderer;
use challenge\render\TwigHtmlRenderer;
use PHPUnit\Framework\MockObject\MockClass;
use PHPUnit\Framework\TestCase;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

use challenge\routing\HttpRouter;

class HttpRouterTest extends TestCase
{
    protected RequestInterface|MockClass $requestMock;

    protected ContainerInterface|MockClass $pathsMock;

    protected ContainerInterface|MockClass $objectsMock;

    protected HttpRouter $router;

    protected function setUp(): void
    {
        $this->requestMock = self::createMock(RequestInterface::class);
        $this->pathsMock = self::createMock(ContainerInterface::class);
        $this->objectsMock = self::createMock(ContainerInterface::class);

        $this->router = new HttpRouter($this->requestMock, $this->pathsMock, $this->objectsMock);
    }

    public function testGetAction(): void
    {
        $actionMock = self::createMock(Action::class);
        $uriMock = self::createMock(Uri::class);
        $this->requestMock->expects(self::once())->method('getUri')->willReturn($uriMock);
        $uriMock->expects(self::once())->method('getPath')->willReturn('foo/bar');
        $this->pathsMock->expects(self::once())->method('get')->with('foo/bar')->willReturn($actionMock);

        $result = $this->router->getAction();

        self::assertSame($actionMock, $result);
    }

    public function testGetRenderer(): void
    {
        $rendererMock = self::createMock(Renderer::class);
        $this->objectsMock->expects(self::once())->method('get')->with(TwigHtmlRenderer::class)->willReturn($rendererMock);

        $result = $this->router->getRenderer();

        self::assertSame($rendererMock, $result);
    }
}
