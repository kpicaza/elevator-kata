<?php

declare(strict_types=1);

namespace Elevator\Application;

use DateTimeImmutable;

final class Movements
{
    /**
     * @param Movement[] $movements
     */
    public function __construct(
        public array $movements
    ) {
    }

    public function getCurrentElevatorsPosition(DateTimeImmutable $current, array &$lastFloors, array &$totalFloors): array
    {
        $movements = array_filter(
            $this->movements,
            function (Movement $movement) use ($current): bool {
                return $movement->occurredOn->format('H:i') === $current->format('H:i');
            }
        );
        $data = [];
        foreach ($this->getElevatorIds() as $elevatorId) {
            foreach ($movements as $movement) {
                if ($movement->elevator_id === $elevatorId) {
                    $data[$elevatorId] = sprintf(
                        'Going from %s to floor %s',
                        $movement->fromFloor,
                        $movement->toFloor
                    );
                    $totalFloors[$elevatorId] = $movement->totalFloors;
                    $lastFloors[$elevatorId] = $movement->toFloor;
                    continue 2;
                }
            }

            $data[$elevatorId] = sprintf('Stay in floor %s', $lastFloors[$elevatorId] ?? 0);
        }

        return $data;
    }

    public function getElevatorIds(): array
    {
        $elevators = [];

        foreach ($this->movements as $movement) {
            if (!in_array($movement->elevator_id, $elevators)) {
                $elevators[] = $movement->elevator_id;
            }
        }

        return $elevators;
    }
}
    