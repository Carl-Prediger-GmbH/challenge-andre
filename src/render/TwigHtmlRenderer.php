<?php

declare(strict_types=1);

namespace challenge\render;

use Twig\Environment;
use Twig\Error\Error;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use challenge\actions\Action;
use challenge\actions\Error as ErrorAction;

class TwigHtmlRenderer implements Renderer
{
    public function __construct(private readonly Environment $environment) {}

    public function render(Action $action): void
    {
        try {
            echo $this->renderAction($action);
        } catch (Error $error) {
            echo $this->renderAction(new ErrorAction($error));
        }
    }

    /**
     * @param Action $action
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function renderAction(Action $action): string
    {
        $template = $action->getTemplate() . '.html';
        return $this->environment->render($template, $action->getContext());
    }
}