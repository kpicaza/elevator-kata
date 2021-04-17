<?php

declare(strict_types=1);

namespace Elevator\Domain\Model;

use Elevator\Domain\Event\AggregateChanged;
use Elevator\Domain\Event\BuildingCreated;
use Elevator\Domain\Event\ElevatorCalled;
use Elevator\Domain\Event\ElevatorMoved;

final class Building
{
    /** @var AggregateChanged[]  */
    private array $events = [];

    private function __construct(
        private string $buildingId,
        private int $floors,
        private array $elevators
    ){
    }

    public static function create(string $buildingId, int $floors, array $elevators): self
    {
        $self = new self($buildingId, $floors, $elevators);
        $self->recordThat(BuildingCreated::occur($self->buildingId, [
            'number_of_floors' => $self->floors,
            'number_of_elevators' => $self->elevators
        ]));

        return $self;
    }

    public function callElevatorFromFloor(int $floor): void
    {
        $freeElevators = array_filter(
            $this->elevators,
            fn(Elevator $elevator) => false === $elevator->isRunning()
        );
        $freeElevator = reset($freeElevators);
        $freeElevator->start();

        $this->recordThat(ElevatorCalled::occur($this->buildingId, [
            'elevator' => $freeElevator,
            'from_floor' => $floor,
        ]));
    }

    public function moveElevatorToFloor(string $elevatorId, int $floor): void
    {
        $usedElevators = array_filter(
            $this->elevators,
            fn(Elevator $elevator) => $elevator->id() === $elevatorId
        );
        $usedElevator = reset($usedElevators);
        $this->recordThat(ElevatorMoved::occur($this->buildingId, [
            'elevator' => $usedElevator,
            'to_floor' => $floor,
        ]));

    }

    private function recordThat(AggregateChanged $occur): void
    {
        $this->events[] = $occur;
    }

    public function popEvents(): array
    {
        $events = array_map(static fn($event) => $event, $this->events);
        $this->events = [];

        return $events;
    }
}
    