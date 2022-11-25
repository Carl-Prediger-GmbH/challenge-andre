<?php

declare(strict_types=1);

namespace challenge\routing;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

use challenge\actions\Action;
use challenge\actions\Error as ErrorAction;
use challenge\render\Renderer;
use challenge\render\TwigHtmlRenderer;

class HttpRouter implements Router
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly ContainerInterface $paths,
        private readonly ContainerInterface $di,
    ) {}

    public function getAction(): Action
    {
        try {
            $path = $this->request->getUri()->getPath();
            $action = $this->paths->get($path);
            if ($action instanceof Action) {
                return $action;
            }
            return new ErrorAction(new Exception('invalid route'));
        } catch (Exception $e) {
            return new ErrorAction($e);
        }
    }

    public function getRenderer(): Renderer
    {
        return $this->di->get(TwigHtmlRenderer::class);
    }
}