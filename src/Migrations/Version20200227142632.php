<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200227142632 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, title, location, start, endt, allday, timezone, repeat, employees, description, user_id FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, location VARCHAR(255) NOT NULL COLLATE BINARY, start DATETIME NOT NULL, endt DATETIME NOT NULL, allday BOOLEAN NOT NULL, timezone BOOLEAN NOT NULL, repeat VARCHAR(255) NOT NULL COLLATE BINARY, employees CLOB NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, user_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO event (id, title, location, start, endt, allday, timezone, repeat, employees, description, user_id) SELECT id, title, location, start, endt, allday, timezone, repeat, employees, description, user_id FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('ALTER TABLE user ADD COLUMN passwords CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN hourlyrate INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE event ADD COLUMN arrivals DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD COLUMN departures DATETIME DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, firstname, lastname, designation, picture, created_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, designation VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO user (id, firstname, lastname, designation, picture, created_at) SELECT id, firstname, lastname, designation, picture, created_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
