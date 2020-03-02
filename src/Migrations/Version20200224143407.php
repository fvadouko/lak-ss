<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200224143407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE event ADD COLUMN arrivals DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD COLUMN departures DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, title, location, start, endt, allday, timezone, repeat, employees, description, user_id FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, start DATETIME NOT NULL, endt DATETIME NOT NULL, allday BOOLEAN NOT NULL, timezone BOOLEAN NOT NULL, repeat VARCHAR(255) NOT NULL, employees CLOB NOT NULL, description CLOB NOT NULL, user_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO event (id, title, location, start, endt, allday, timezone, repeat, employees, description, user_id) SELECT id, title, location, start, endt, allday, timezone, repeat, employees, description, user_id FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
    }
}
