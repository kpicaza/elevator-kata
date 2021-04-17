<?php

declare(strict_types=1);

namespace Elevator\Domain\Event;

final class BuildingCreated extends AggregateChanged
{
    public function elevators(): array
    {
        return $this->payload['elevators'];
    }
}
    