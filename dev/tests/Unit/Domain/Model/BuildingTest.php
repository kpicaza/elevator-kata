<?php

declare(strict_types=1);

namespace Elevator\Test\Unit\Domain\Model;

use Elevator\Domain\Event\BuildingCreated;
use Elevator\Domain\Event\ElevatorCalled;
use Elevator\Domain\Event\ElevatorMoved;
use Elevator\Domain\Model\Building;
use Elevator\Domain\Model\Elevator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class BuildingTest extends TestCase
{
    private const BUILDING_ID = 'some_building_id';
    private const NUMBER_OF_FLOORS = 4;
    private const NUMBER_OF_ELEVATORS = 3;
    private array $elevators;

    public function testTheBuildingMustHaveFourFloors(): void
    {
        $building = $this->getBuilding();
        $events = $building->popEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(BuildingCreated::class, reset($events));
    }

    public function testPeopleShouldCallTheElevator(): void
    {
        $building = $this->getBuilding();
        $building->callElevatorFromFloor(0);

        $events = $building->popEvents();
        $this->assertCount(2, $events);
        $this->assertInstanceOf(ElevatorCalled::class, $events[array_key_last($events)]);
    }

    public function testPeopleShouldGoToFloorOnceInTheElevator(): void
    {
        $building = $this->getBuilding();
        $building->callElevatorFromFloor(0);
        $building->moveElevatorToFloor($this->elevators[0]->id(), 3);

        $events = $building->popEvents();
        $this->assertCount(3, $events);
        $this->assertInstanceOf(ElevatorMoved::class, $events[array_key_last($events)]);
    }

    private function getBuilding(): Building
    {
        $this->elevators = [];
        foreach (range(1, self::NUMBER_OF_ELEVATORS) as $item) {
            $this->elevators[] = Elevator::withId(Uuid::uuid4()->toString());
        }

        return Building::create(
            self::BUILDING_ID,
            self::NUMBER_OF_FLOORS,
            $this->elevators
        );
    }
}
    