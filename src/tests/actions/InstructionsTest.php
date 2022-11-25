<?php

declare(strict_types=1);

namespace challenge_test\actions;

use PHPUnit\Framework\TestCase;
use challenge\actions\Instructions;

class InstructionsTest extends TestCase
{
    private Instructions $instructions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->instructions = new Instructions(__DIR__);
    }

    public function testContext(): void
    {
        $result = $this->instructions->getContext();

        self::assertSame(
            [
                'name' => 'Test Task',
                'max_time' => '10 sec',
                'description' => 'This is just a test.',
                'steps' => ['Test 1', 'Test 2'],
            ],
            $result['task']
        );
    }
}
