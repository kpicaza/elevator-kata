<?php

declare(strict_types=1);

namespace Elevator\Projection;

use Doctrine\DBAL\Connection;
use Elevator\Domain\Event\AggregateChanged;
use Elevator\Domain\Event\ElevatorCalled;
use Elevator\Domain\Event\ElevatorMoved;

final class ProjectSequencesToDbalReadModel
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function onDomainEvents(AggregateChanged $event): void
    {
        if ($event instanceof ElevatorCalled) {
            $this->connection->insert('elevator_sequences_test', [
                'building_id' => $event->aggregateId(),
                'elevator_id' => $event->elevatorId(),
                'occurred_on' => $event->occurredOn()->format('Y-m-d H:i:s'),
                'from_floor' => $event->fromFloor(),
                'to_floor' => 0,
                'total_floors' => $event->totalFloors(),
            ]);
        }

        if ($event instanceof ElevatorMoved) {
            $this->connection->update('elevator_sequences_test', [
                'to_floor' => $event->toFloor(),
                'total_floors' => $event->totalFloors(),
            ], [
                'building_id' => $event->aggregateId(),
                'elevator_id' => $event->elevatorId(),
                'occurred_on' => $event->occurredOn()->format('Y-m-d H:i:s'),
            ]);
        }

    }
}
    