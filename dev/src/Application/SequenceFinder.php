<?php

declare(strict_types=1);

namespace Elevator\Application;

interface SequenceFinder
{
    public function findMovements(string $buildingId): Movements;
}
    