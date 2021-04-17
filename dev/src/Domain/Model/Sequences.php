<?php

declare(strict_types=1);

namespace Elevator\Domain\Model;

final class Sequences
{
    /**
     * Sequences constructor.
     * @param Sequence[] $sequences
     * @param array $sequenceMap
     */
    public function __construct(
        private array $sequences,
        private array $sequenceMap = []
    ) {
        foreach ($this->sequences as $sequence) {
            foreach ($sequence->time()->applyRecurrence() as $item) {
                if (array_key_exists($item->format('H:i'), $this->sequenceMap)) {
                    $this->sequenceMap[$item->format('H:i')][] = $sequence->path();
                } else {
                    $this->sequenceMap[$item->format('H:i')] = [$sequence->path()];
                }
            }
        }
    }

    public function run(): array
    {
        return $this->sequenceMap;
    }
}
    