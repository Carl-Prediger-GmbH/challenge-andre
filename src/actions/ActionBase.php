<?php

declare(strict_types=1);

namespace challenge\actions;

abstract class ActionBase implements Action
{
    public function getTemplate(): string
    {
        return \strtolower($this->getClassName());
    }

    public function getContext(): iterable
    {
        return ['title' => $this->getClassName()];
    }

    private function getClassName(): string
    {
        return (new \ReflectionClass(\get_called_class()))->getShortName();
    }
}