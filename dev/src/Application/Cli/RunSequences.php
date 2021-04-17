<?php

declare(strict_types=1);

namespace Elevator\Application\Cli;

use Elevator\Application\SequenceFinder;
use Elevator\Domain\Command\CreateSequences;
use Elevator\Domain\Handler\SequenceSimulator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RunSequences extends Command
{
    const SEQUENCES = [
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
        'Sequence 3' => [
            'time' => [
                'recurrence' => 20,
                'from' => '11:00',
                'to' => '18:20',
            ],
            'path' => [
                'from' => 0,
                'to' => 3,
            ]
        ],
        'Sequence 4' => [
            'time' => [
                'recurrence' => 4,
                'from' => '14:00',
                'to' => '15:00',
            ],
            'path' => [
                'from' => 3,
                'to' => 0,
            ]
        ],
    ];

    public function __construct(
        private SequenceSimulator $sequenceSimulator,
        private SequenceFinder $sequenceFinder
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('elevator-kata:run-sequences')
            ->setDescription('Run configured Elevator sequences and draw chart.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $buildingId = Uuid::uuid4()->toString();

        // Write Sequence
        $command = CreateSequences::fromArrayOfSequences($buildingId, self::SEQUENCES);
        $this->sequenceSimulator->handle($command);

        // Read Sequence
        $movements = $this->sequenceFinder->findMovements($buildingId);
        CliRenderer::render($movements, $output);

        return Command::SUCCESS;
    }
}
    