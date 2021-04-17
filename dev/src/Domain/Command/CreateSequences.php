<?php

declare(strict_types=1);

namespace Elevator\Domain\Command;

use Elevator\Domain\Model\Sequence;
use Elevator\Domain\Model\Sequences;

final class CreateSequences
{
    private function __construct(
        private string $buildingId,
        private Sequences $sequences
    ) {
    }

    public static function fromArrayOfSequences(string $buildingId, array $sequences): self
    {
        return new self(
            $buildingId,
            new Sequences(array_map(static fn(array $sequence) => Sequence::fromArray($sequence), $sequences))
        );
    }

    public function sequences(): Sequences
    {
        return $this->sequences;
    }

    public function buildingId(): string
    {
        return $this->buildingId;
    }
}
