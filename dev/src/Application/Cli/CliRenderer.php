<?php

declare(strict_types=1);

namespace Elevator\Application\Cli;

use Elevator\Application\Movements;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

final class CliRenderer
{
    public static function render(Movements $movements, OutputInterface $output): void
    {
        $elevatorIds = $movements->getElevatorIds();

        $table = new Table($output);
        $table->setHeaders(array_merge(['hour'], $elevatorIds));

        $start = \DateTimeImmutable::createFromFormat('H:i', '09:00');
        $end = \DateTimeImmutable::createFromFormat('H:i', '20:00');
        $current = clone $start;
        $lastFloor = [];
        $totalFloors = [];
        foreach ($elevatorIds as $elevatorId) {
            $lastFloor[$elevatorId] = 0;
            $totalFloors[$elevatorId] = 0;
        }
        while ($current <= $end) {
            $elevators = $movements->getCurrentElevatorsPosition($current, $lastFloor, $totalFloors);
            $table->addRow(array_merge([$current->format("H:i")], array_values($elevators)));
            $current = $current->modify("+1 minutes");
        }

        $table->addRow(new TableSeparator());
        $table->addRow(array_merge([null], $totalFloors));

        $table->render();
    }
}
    