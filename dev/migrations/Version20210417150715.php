<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417150715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create elevator_sequences_test table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('elevator_sequences_test');

        $id = $table->addColumn('id', 'integer', [
            'length' => 11,
            'unsigned' => true,
        ]);

        $id->setAutoincrement(true);
        $table->setPrimaryKey(['id']);
        $table->addColumn('building_id', 'string', [
            'length' => 36,
        ]);
        $table->addColumn('elevator_id', 'string', [
            'length' => 36,
        ]);
        $table->addColumn('occurred_on', 'datetime');
        $table->addColumn('from_floor', 'integer', [
            'length' => 1,
        ]);
        $table->addColumn('to_floor', 'integer', [
            'length' => 1,
        ]);
        $table->addColumn('total_floors', 'integer', [
            'length' => 3,
        ]);


    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('elevator_sequences_test');
    }
}
