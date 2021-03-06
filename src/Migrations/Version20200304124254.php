<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304124254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_34DCD1768BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__person AS SELECT id, city_id, first_name, lastname, gender, birth_date FROM person');
        $this->addSql('DROP TABLE person');
        $this->addSql('CREATE TABLE person (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL COLLATE BINARY, gender BOOLEAN NOT NULL, birth_date DATETIME NOT NULL, last_name VARCHAR(255) NOT NULL, CONSTRAINT FK_34DCD1768BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO person (id, city_id, first_name, last_name, gender, birth_date) SELECT id, city_id, first_name, lastname, gender, birth_date FROM __temp__person');
        $this->addSql('DROP TABLE __temp__person');
        $this->addSql('CREATE INDEX IDX_34DCD1768BAC62AF ON person (city_id)');
        $this->addSql('DROP INDEX IDX_AB91DAB4D8355341');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contracted_disease AS SELECT id, disease_id, contracted_at FROM contracted_disease');
        $this->addSql('DROP TABLE contracted_disease');
        $this->addSql('CREATE TABLE contracted_disease (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, disease_id INTEGER NOT NULL, contracted_at DATETIME NOT NULL, CONSTRAINT FK_AB91DAB4D8355341 FOREIGN KEY (disease_id) REFERENCES disease (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO contracted_disease (id, disease_id, contracted_at) SELECT id, disease_id, contracted_at FROM __temp__contracted_disease');
        $this->addSql('DROP TABLE __temp__contracted_disease');
        $this->addSql('CREATE INDEX IDX_AB91DAB4D8355341 ON contracted_disease (disease_id)');
        $this->addSql('DROP INDEX IDX_DC7CF2AB217BBB47');
        $this->addSql('DROP INDEX IDX_DC7CF2AB58C91D10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contracted_disease_person AS SELECT contracted_disease_id, person_id FROM contracted_disease_person');
        $this->addSql('DROP TABLE contracted_disease_person');
        $this->addSql('CREATE TABLE contracted_disease_person (contracted_disease_id INTEGER NOT NULL, person_id INTEGER NOT NULL, PRIMARY KEY(contracted_disease_id, person_id), CONSTRAINT FK_DC7CF2AB58C91D10 FOREIGN KEY (contracted_disease_id) REFERENCES contracted_disease (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DC7CF2AB217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO contracted_disease_person (contracted_disease_id, person_id) SELECT contracted_disease_id, person_id FROM __temp__contracted_disease_person');
        $this->addSql('DROP TABLE __temp__contracted_disease_person');
        $this->addSql('CREATE INDEX IDX_DC7CF2AB217BBB47 ON contracted_disease_person (person_id)');
        $this->addSql('CREATE INDEX IDX_DC7CF2AB58C91D10 ON contracted_disease_person (contracted_disease_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_AB91DAB4D8355341');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contracted_disease AS SELECT id, disease_id, contracted_at FROM contracted_disease');
        $this->addSql('DROP TABLE contracted_disease');
        $this->addSql('CREATE TABLE contracted_disease (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, disease_id INTEGER NOT NULL, contracted_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO contracted_disease (id, disease_id, contracted_at) SELECT id, disease_id, contracted_at FROM __temp__contracted_disease');
        $this->addSql('DROP TABLE __temp__contracted_disease');
        $this->addSql('CREATE INDEX IDX_AB91DAB4D8355341 ON contracted_disease (disease_id)');
        $this->addSql('DROP INDEX IDX_DC7CF2AB58C91D10');
        $this->addSql('DROP INDEX IDX_DC7CF2AB217BBB47');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contracted_disease_person AS SELECT contracted_disease_id, person_id FROM contracted_disease_person');
        $this->addSql('DROP TABLE contracted_disease_person');
        $this->addSql('CREATE TABLE contracted_disease_person (contracted_disease_id INTEGER NOT NULL, person_id INTEGER NOT NULL, PRIMARY KEY(contracted_disease_id, person_id))');
        $this->addSql('INSERT INTO contracted_disease_person (contracted_disease_id, person_id) SELECT contracted_disease_id, person_id FROM __temp__contracted_disease_person');
        $this->addSql('DROP TABLE __temp__contracted_disease_person');
        $this->addSql('CREATE INDEX IDX_DC7CF2AB58C91D10 ON contracted_disease_person (contracted_disease_id)');
        $this->addSql('CREATE INDEX IDX_DC7CF2AB217BBB47 ON contracted_disease_person (person_id)');
        $this->addSql('DROP INDEX IDX_34DCD1768BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__person AS SELECT id, city_id, first_name, last_name, gender, birth_date FROM person');
        $this->addSql('DROP TABLE person');
        $this->addSql('CREATE TABLE person (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, gender BOOLEAN NOT NULL, birth_date DATETIME NOT NULL, lastname VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO person (id, city_id, first_name, lastname, gender, birth_date) SELECT id, city_id, first_name, last_name, gender, birth_date FROM __temp__person');
        $this->addSql('DROP TABLE __temp__person');
        $this->addSql('CREATE INDEX IDX_34DCD1768BAC62AF ON person (city_id)');
    }
}
