<?php

declare(strict_types=1);

namespace challenge\actions;

interface Action
{
    public function getTemplate(): string;

    public function getContext(): iterable;
}