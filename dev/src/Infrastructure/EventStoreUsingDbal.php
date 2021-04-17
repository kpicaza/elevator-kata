<?php

declare(strict_types=1);

namespace Elevator\Infrastructure;

use Doctrine\DBAL\Connection;
use Elevator\Domain\BuildingPersistence;
use Elevator\Domain\Event\AggregateChanged;
use Elevator\Domain\Model\Building;

final class EventStoreUsingDbal implements BuildingPersistence
{
    public function __construct(
        private Connection $connection
    ) {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS event_store (
                
            )
        SQL;

    }

    public function save(AggregateChanged $event): void
    {
        $this->connection->insert('event_store', [
            'event_id' => $event->id(),
            'aggregate_id' => $event->aggregateId(),
            'event_name' => get_class($event),
            'aggregate_name' => Building::class,
            'payload' => json_encode($event->payload()),
            'occurred_on' => $event->occurredOn()->format('Y-m-d H:i:s'),
            'version' => 1,
        ]);
    }
}
    