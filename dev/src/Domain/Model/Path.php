<?php

declare(strict_types=1);

namespace Elevator\Domain\Model;

use JetBrains\PhpStorm\Pure;

final class Path
{
    private function __construct(
        private int $fromFloor,
        private int $toFloor
    ) {
    }

    #[Pure]
    public static function fromArray(array $path): self
    {
        return new self($path['from'], $path['to']);
    }

    public function from(): int
    {
        return $this->fromFloor;
    }

    public function to(): int
    {
        return $this->toFloor;
    }
}
    