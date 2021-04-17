<?php

declare(strict_types=1);

namespace Elevator\Domain\Model;

final class Sequence
{
    private function __construct(
        private Time $time,
        private Path $path
    ){
    }

    public static function fromArray(array $sequence): self
    {
        return new self(
            Time::fromArray($sequence['time']),
            Path::fromArray($sequence['path'])
        );
    }

    public function run(): array
    {
        return $this->time->applyRecurrence();
    }

    public function path(): Path
    {
        return $this->path;
    }
}
    