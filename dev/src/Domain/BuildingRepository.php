<?php

declare(strict_types=1);

namespace Elevator\Domain;

use Elevator\Domain\Model\Building;
use Elevator\Domain\Model\Elevator;
use Psr\EventDispatcher\EventDispatcherInterface;
use Ramsey\Uuid\Uuid;

final class BuildingRepository
{
    public function __construct(
        private BuildingPersistence $persistence,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function save(Building $building): void
    {
        foreach ($building->popEvents() as $event) {
            $this->persistence->save($event);
            $this->eventDispatcher->dispatch($event, 'domain.events');
        }
    }

    public function create(): Building
    {
        $elevators = [];
        foreach (range(0, 3) as $item) {
            $elevators[] = Elevator::withId(Uuid::uuid4()->toString());
        }

        return Building::create(Uuid::uuid4()->toString(), 4, $elevators);
    }
}
    