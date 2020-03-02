<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200301083412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, title, start, endt, allday, repeat, user_id, timezone, location, description FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, start DATETIME NOT NULL, endt DATETIME NOT NULL, repeat VARCHAR(255) NOT NULL COLLATE BINARY, user_id INTEGER DEFAULT NULL, timezone CLOB DEFAULT NULL COLLATE BINARY, location VARCHAR(255) DEFAULT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, allday BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO event (id, title, start, endt, allday, repeat, user_id, timezone, location, description) SELECT id, title, start, endt, allday, repeat, user_id, timezone, location, description FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, title, location, start, endt, allday, timezone, repeat, description, user_id FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, start DATETIME NOT NULL, endt DATETIME NOT NULL, timezone CLOB DEFAULT NULL, repeat VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, user_id INTEGER DEFAULT NULL, allday BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO event (id, title, location, start, endt, allday, timezone, repeat, description, user_id) SELECT id, title, location, start, endt, allday, timezone, repeat, description, user_id FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
    }
}
