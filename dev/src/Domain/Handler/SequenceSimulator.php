<?php

declare(strict_types=1);

namespace Elevator\Domain\Handler;

use Elevator\Domain\BuildingRepository;
use Elevator\Domain\Command\CreateSequences;

final class SequenceSimulator
{
    public function __construct(
        private BuildingRepository $buildingRepository
    ) {
    }

    public function handle(CreateSequences $command): void
    {
        $building = $this->buildingRepository->create();
        $sequences = $command->sequences();

        $building->applySequences($sequences);

        $this->buildingRepository->save($building);
    }
}
    