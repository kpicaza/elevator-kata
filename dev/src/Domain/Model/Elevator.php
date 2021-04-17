<?php

declare(strict_types=1);

namespace Elevator\Domain\Model;

final class Elevator
{
    private function __construct(
        private string $elevatorId,
        private bool $isRunning = false,
        private int $currentFloor = 0,
        private int $totalFloors = 0
    ) {
    }

    public static function withId(string $elevatorId): self
    {
        return new self($elevatorId);
    }

    public function start(int $floor): void
    {
        $this->setFloors($floor);
        $this->isRunning = true;
    }

    public function stop(int $floor): void
    {
        $this->setFloors($floor);
        $this->isRunning = false;
    }

    private function setFloors(int $floor): void
    {
        if ($this->currentFloor > $floor) {
            $this->totalFloors += ($this->currentFloor - $floor);
        } else {
            $this->totalFloors += ($floor - $this->currentFloor);
        }

        $this->currentFloor = $floor;
    }

    public function isRunning(): bool
    {
        return $this->isRunning;
    }

    public function id(): string
    {
        return $this->elevatorId;
    }

    public function totalFloors(): int
    {
        return $this->totalFloors;
    }

    public function currentFloor(): int
    {
        return $this->currentFloor;
    }

}
    