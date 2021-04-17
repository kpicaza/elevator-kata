<?php

declare(strict_types=1);

namespace Elevator\Domain\Event;

use Elevator\Domain\Model\Elevator;

final class ElevatorMoved extends AggregateChanged
{
    public function elevatorId(): string
    {
        /** @var Elevator $elevator */
        $elevator = $this->payload['elevator'];

        return $elevator->id();
    }

    public function totalFloors(): int
    {
        /** @var Elevator $elevator */
        $elevator = $this->payload['elevator'];

        return $elevator->totalFloors();
    }

    public function toFloor(): int
    {
        return $this->payload['to_floor'];
    }
}
    