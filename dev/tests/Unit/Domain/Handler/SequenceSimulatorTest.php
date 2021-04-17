<?php

declare(strict_types=1);

namespace Elevator\Test\Unit\Domain\Handler;

use Elevator\Domain\BuildingPersistence;
use Elevator\Domain\BuildingRepository;
use Elevator\Domain\Command\CreateSequences;
use Elevator\Domain\Event\AggregateChanged;
use Elevator\Domain\Handler\SequenceSimulator;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

final class SequenceSimulatorTest extends TestCase
{
    private const SEQUENCES = [
        'Sequence 1' => [
            'time' => [
                'recurrence' => 5,
                'from' => '09:00',
                'to' => '11:00',
            ],
            'path' => [
                'from' => 0,
                'to' => 2,
            ]
        ],
        'Sequence 2' => [
            'time' => [
                'recurrence' => 10,
                'from' => '09:00',
                'to' => '10:00',
            ],
            'path' => [
                'from' => 0,
                'to' => 1,
            ]
        ],
    ];

    /** @dataProvider getSequences */
    public function testItShouldRunGivenElevatorSequences(array ...$sequences): void
    {
        $buildingPersistence = $this->createMock(BuildingPersistence::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        // 61 comes from:
        // 1 building creation,
        // 24 calls from sequence 1,
        // 24 moves from sequence 1
        // 6 calls from sequence 2,
        // 6 moves from sequence 2
        $buildingPersistence->expects($this->exactly(61))
            ->method('save')
            ->with($this->isInstanceOf(AggregateChanged::class));
        $eventDispatcher->expects($this->exactly(61))
            ->method('dispatch')
            ->with($this->isInstanceOf(AggregateChanged::class));
        $buildingRepository = new BuildingRepository($buildingPersistence, $eventDispatcher);
        $command = CreateSequences::fromArrayOfSequences($sequences);

        $handler = new SequenceSimulator($buildingRepository);

        $handler->handle($command);
    }

    public function getSequences(): array
    {
        return [
            self::SEQUENCES
        ];
    }
}
    