<?php

declare(strict_types=1);

namespace Elevator\Domain\Handler;

use DateTimeImmutable;
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
        $building = $this->buildingRepository->create($command->buildingId());
        $sequences = $command->sequences();

        foreach ($sequences->run() as $time => $paths) {
            $hour = DateTimeImmutable::createFromFormat('H:i', $time);
            $elevators = [];
            foreach ($paths as $key => $path) {
                $elevator = $building->callElevatorFromFloor($path->from(), $hour);
                $elevators[$key] = $elevator;
            }
            foreach ($paths as $key => $path) {
                $elevator = $elevators[$key];
                $building->moveElevatorToFloor(
                    $elevator->id(),
                    $path->to(),
                    $hour
                );
            }

        }

        $this->buildingRepository->save($building);
    }
}
    