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

    public static function occur(string $aggregateId, array $payload = []): static
    {
        return new static(
            Uuid::uuid4()->toString(),
            $aggregateId,
            $payload,
            new DateTimeImmutable()
        );
    }
}
    