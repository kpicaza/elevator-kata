<?php

declare(strict_types=1);

namespace Elevator\Domain\Event;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

abstract class AggregateChanged
{
    public function __construct(
        protected string $eventId,
        protected string $aggregateId,
        protected array $payload,
        protected DateTimeImmutable $occurredOn
    ) {
    }

    public static function occur(string $aggregateId, array $payload = [], ?DateTimeImmutable $hour = null): static
    {
        return new static(
            Uuid::uuid4()->toString(),
            $aggregateId,
            $payload,
            $hour ?: new DateTimeImmutable()
        );
    }

    final public function id(): string
    {
        return $this->eventId;
    }

    final public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    final public function payload(): array
    {
        return $this->payload;
    }

    final public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
    