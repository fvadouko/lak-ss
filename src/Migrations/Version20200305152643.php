<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200305152643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, firstname, lastname, designation, picture, created_at, passwords, hourlyrate FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, lastname VARCHAR(255) NOT NULL COLLATE BINARY, designation VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, passwords CLOB DEFAULT NULL COLLATE BINARY, hourlyrate INTEGER DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, firstname, lastname, designation, picture, created_at, passwords, hourlyrate) SELECT id, firstname, lastname, designation, picture, created_at, passwords, hourlyrate FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, firstname, lastname, designation, picture, passwords, hourlyrate, created_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, designation VARCHAR(255) NOT NULL, passwords CLOB DEFAULT NULL, hourlyrate INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO user (id, firstname, lastname, designation, picture, passwords, hourlyrate, created_at) SELECT id, firstname, lastname, designation, picture, passwords, hourlyrate, created_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
