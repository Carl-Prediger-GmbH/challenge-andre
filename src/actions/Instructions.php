<?php

declare(strict_types=1);

namespace challenge\actions;

use Symfony\Component\Yaml\Yaml;

class Instructions extends ActionBase
{
    private string $data_path;

    public function __construct(?string $path = null) {
        $this->data_path = $path ?? DATA_PATH;
    }

    public function getContext(): iterable
    {
        return $this->getInstructions();
    }

    /**
     * @return array {
     *  task: array {
     *      name: <string>,
     *      max_time: <string>,
     *      description: <string>,
     *      ?steps: <?iterable: <int, string>>
     *  }
     * }
     */
    private function getInstructions(): array
    {
        return Yaml::parseFile($this->getInstructionsFile());
    }

    private function getInstructionsFile(): string
    {
        return $this->data_path . DIRECTORY_SEPARATOR . 'instructions.yaml';
    }
}