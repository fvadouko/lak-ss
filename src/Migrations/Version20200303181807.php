<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303181807 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE event ADD COLUMN year INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD COLUMN month VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD COLUMN week INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE pointeuses ADD COLUMN year INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE pointeuses ADD COLUMN month VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE pointeuses ADD COLUMN week INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE pointeuses ADD COLUMN overtimes INTEGER DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, firstname, lastname, designation, picture, created_at, passwords, hourlyrate FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, lastname VARCHAR(255) NOT NULL COLLATE BINARY, designation VARCHAR(255) NOT NULL COLLATE BINARY, picture VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, passwords CLOB DEFAULT NULL COLLATE BINARY, hourlyrate INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, firstname, lastname, designation, picture, created_at, passwords, hourlyrate) SELECT id, firstname, lastname, designation, picture, created_at, passwords, hourlyrate FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, title, location, start, endt, allday, timezone, repeat, description, user_id FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, start DATETIME NOT NULL, endt DATETIME NOT NULL, allday BOOLEAN DEFAULT NULL, timezone CLOB DEFAULT NULL, repeat VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, user_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO event (id, title, location, start, endt, allday, timezone, repeat, description, user_id) SELECT id, title, location, start, endt, allday, timezone, repeat, description, user_id FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pointeuses AS SELECT id, arrivals, departures, user_id FROM pointeuses');
        $this->addSql('DROP TABLE pointeuses');
        $this->addSql('CREATE TABLE pointeuses (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, arrivals DATETIME NOT NULL, departures DATETIME DEFAULT NULL, user_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO pointeuses (id, arrivals, departures, user_id) SELECT id, arrivals, departures, user_id FROM __temp__pointeuses');
        $this->addSql('DROP TABLE __temp__pointeuses');
        $this->addSql('ALTER TABLE user ADD COLUMN image_id INTEGER DEFAULT NULL');
    }
}
