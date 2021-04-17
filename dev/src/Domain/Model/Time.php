<?php

declare(strict_types=1);

namespace Elevator\Domain\Model;

use DateTimeImmutable;
use JetBrains\PhpStorm\Pure;

final class Time
{
    private function __construct(
        private int $recurrence,
        private DateTimeImmutable $fromHour,
        private DateTimeImmutable $toHour
    ) {
    }

    #[Pure]
    public static function fromArray(array $time): self
    {
        return new self(
            $time['recurrence'],
            DateTimeImmutable::createFromFormat('H:i', $time['from']),
            DateTimeImmutable::createFromFormat('H:i', $time['to'])
        );
    }

    public function applyRecurrence(): array
    {
        $interactionTimes = [clone $this->fromHour];
        $iterations = (($this->toHour->getTimestamp() - $this->fromHour->getTimestamp()) / 60) / $this->recurrence;

        foreach (range(1, $iterations) as $item) {
            $multiplier = $item * $this->recurrence;
            $interactionTimes[] = $this->fromHour->modify(sprintf('%s minutes', $multiplier));
        }

        return $interactionTimes;
    }
}
    