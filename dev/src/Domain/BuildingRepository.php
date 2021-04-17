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

    public function create(?string $buildingId = null): Building
    {
        $elevators = [];
        foreach (range(1, 3) as $item) {
            $elevators[] = Elevator::withId(sprintf('Elevator %s', $item));
        }

        return Building::create($buildingId ?: Uuid::uuid4()->toString(), 4, $elevators);
    }
}
    