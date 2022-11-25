<?php

declare(strict_types=1);

namespace challenge\actions;

use Exception;

class Error extends ActionBase
{

    public function __construct(private readonly Exception $exception) {}

    public function getContext(): iterable
    {
        return ['error' => $this->exception ? $this->exception->getMessage() : 'Something went wrong!'];
    }
}