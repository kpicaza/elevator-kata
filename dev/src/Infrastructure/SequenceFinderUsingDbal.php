<?php

declare(strict_types=1);

namespace Elevator\Infrastructure;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Elevator\Application\Movement;
use Elevator\Application\Movements;
use Elevator\Application\SequenceFinder;

final class SequenceFinderUsingDbal implements SequenceFinder
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function findMovements(string $buildingId): Movements
    {
        $movements = $this->connection->fetchAllAssociative(
            <<<SQL
                SELECT * FROM elevator_sequences_test WHERE building_id = :building_id
            SQL,
            [
                'building_id' => $buildingId,
            ]
        );

        return new Movements(array_map(function(array $movement): Movement {
            return new Movement(
                (int)$movement['id'],
                $movement['elevator_id'],
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $movement['occurred_on']),
                (int)$movement['from_floor'],
                (int)$movement['to_floor'],
                (int)$movement['total_floors'],
            );
        }, $movements));
    }

}
    