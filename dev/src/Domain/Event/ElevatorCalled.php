<?php

declare(strict_types=1);

namespace Elevator\Domain\Event;

use Elevator\Domain\Model\Elevator;

final class ElevatorCalled extends AggregateChanged
{
    public function elevatorId(): string
    {
        /** @var Elevator $elevator */
        $elevator = $this->payload['elevator'];

        return $elevator->id();
    }

    public function fromFloor(): int
    {
        return $this->payload['from_floor'];
    }
}
    