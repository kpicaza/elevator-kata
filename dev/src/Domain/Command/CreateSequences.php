<?php

declare(strict_types=1);

namespace Elevator\Domain\Command;

use Elevator\Domain\Model\Sequence;

final class CreateSequences
{
    /**
     * @param Sequence[] $sequences
     */
    private function __construct(
        private array $sequences
    ) {
    }

    public static function fromArrayOfSequences(array $sequences): self
    {
        return new self(
            array_map(static fn(array $sequence) => Sequence::fromArray($sequence), $sequences)
        );
    }

    /**
     * @return Sequence[]
     */
    public function sequences(): array
    {
        return $this->sequences;
    }
}
