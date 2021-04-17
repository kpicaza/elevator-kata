<?php

declare(strict_types=1);

namespace Elevator\Domain;

use Elevator\Domain\Event\AggregateChanged;

interface BuildingPersistence
{
    public function save(AggregateChanged $event): void;
}
