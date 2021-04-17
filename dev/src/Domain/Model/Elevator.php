<?php

declare(strict_types=1);

namespace Elevator\Domain\Model;

final class Elevator
{
    private function __construct(
        private string $elevatorId,
        private int $floor = 0,
        private bool $isRunning = false
    ) {
    }

    public static function withId(string $elevatorId): self
    {
        return new self($elevatorId);
    }

    public function start(): void
    {
        $this->isRunning = true;
    }

    public function stop(): void
    {
        $this->isRunning = false;
    }

    public function isRunning(): bool
    {
        return $this->isRunning;
    }

    public function id(): string
    {
        return $this->elevatorId;
    }

}
    