<?php

declare(strict_types=1);

namespace Elevator\Application;

use DateTimeImmutable;

final class Movement
{
    public function __construct(
        public int $id,
        public string $elevator_id,
        public DateTimeImmutable $occurredOn,
        public int $fromFloor,
        public int $toFloor,
        public int $totalFloors,
    ) {
    }
}
    