<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417150155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create Event Store Table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('event_store');

        $id = $table->addColumn('id', 'integer', [
            'length' => 11,
            'unsigned' => true,
        ]);
        $id->setAutoincrement(true);
        $table->setPrimaryKey(['id']);

        $table->addColumn('event_id', 'string', [
            'length' => 36,
        ]);
        $table->addUniqueIndex(['event_id']);

        $table->addColumn('aggregate_id', 'string', [
            'length' => 36,
        ]);
        $table->addIndex(['aggregate_id']);

        $table->addColumn('event_name', 'string', [
            'length' => 140,
        ]);
        $table->addIndex(['event_name']);

        $table->addColumn('aggregate_name', 'string', [
            'length' => 140,
        ]);
        $table->addIndex(['aggregate_name']);

        $table->addColumn('payload', 'json');
        $table->addColumn('occurred_on', 'datetime');

        $table->addColumn('version', 'integer', [
            'length' => 11,
        ]);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('event_store');
    }
}
