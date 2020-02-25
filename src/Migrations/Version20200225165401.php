<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225165401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE usuarios1');
        $this->addSql('DROP INDEX IDX_EF687F2E8608214');
        $this->addSql('DROP INDEX UNIQ_EF687F2E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__usuarios AS SELECT id, ciudad_id, email, password, roles FROM usuarios');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('CREATE TABLE usuarios (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ciudad_id INTEGER NOT NULL, email VARCHAR(180) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , foto VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_EF687F2E8608214 FOREIGN KEY (ciudad_id) REFERENCES ciudad (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO usuarios (id, ciudad_id, email, password, roles) SELECT id, ciudad_id, email, password, roles FROM __temp__usuarios');
        $this->addSql('DROP TABLE __temp__usuarios');
        $this->addSql('CREATE INDEX IDX_EF687F2E8608214 ON usuarios (ciudad_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EF687F2E7927C74 ON usuarios (email)');
        $this->addSql('DROP INDEX IDX_92186A8C303ACA92');
        $this->addSql('DROP INDEX IDX_92186A8CF01D3B25');
        $this->addSql('CREATE TEMPORARY TABLE __temp__usuarios_cartas AS SELECT usuarios_id, cartas_id FROM usuarios_cartas');
        $this->addSql('DROP TABLE usuarios_cartas');
        $this->addSql('CREATE TABLE usuarios_cartas (usuarios_id INTEGER NOT NULL, cartas_id INTEGER NOT NULL, PRIMARY KEY(usuarios_id, cartas_id), CONSTRAINT FK_92186A8CF01D3B25 FOREIGN KEY (usuarios_id) REFERENCES usuarios (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_92186A8C303ACA92 FOREIGN KEY (cartas_id) REFERENCES cartas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO usuarios_cartas (usuarios_id, cartas_id) SELECT usuarios_id, cartas_id FROM __temp__usuarios_cartas');
        $this->addSql('DROP TABLE __temp__usuarios_cartas');
        $this->addSql('CREATE INDEX IDX_92186A8C303ACA92 ON usuarios_cartas (cartas_id)');
        $this->addSql('CREATE INDEX IDX_92186A8CF01D3B25 ON usuarios_cartas (usuarios_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE usuarios1 (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ciudad_id INTEGER NOT NULL, email VARCHAR(180) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        )');
        $this->addSql('DROP INDEX UNIQ_EF687F2E7927C74');
        $this->addSql('DROP INDEX IDX_EF687F2E8608214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__usuarios AS SELECT id, ciudad_id, email, roles, password FROM usuarios');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('CREATE TABLE usuarios (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ciudad_id INTEGER NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO usuarios (id, ciudad_id, email, roles, password) SELECT id, ciudad_id, email, roles, password FROM __temp__usuarios');
        $this->addSql('DROP TABLE __temp__usuarios');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EF687F2E7927C74 ON usuarios (email)');
        $this->addSql('CREATE INDEX IDX_EF687F2E8608214 ON usuarios (ciudad_id)');
        $this->addSql('DROP INDEX IDX_92186A8CF01D3B25');
        $this->addSql('DROP INDEX IDX_92186A8C303ACA92');
        $this->addSql('CREATE TEMPORARY TABLE __temp__usuarios_cartas AS SELECT usuarios_id, cartas_id FROM usuarios_cartas');
        $this->addSql('DROP TABLE usuarios_cartas');
        $this->addSql('CREATE TABLE usuarios_cartas (usuarios_id INTEGER NOT NULL, cartas_id INTEGER NOT NULL, PRIMARY KEY(usuarios_id, cartas_id))');
        $this->addSql('INSERT INTO usuarios_cartas (usuarios_id, cartas_id) SELECT usuarios_id, cartas_id FROM __temp__usuarios_cartas');
        $this->addSql('DROP TABLE __temp__usuarios_cartas');
        $this->addSql('CREATE INDEX IDX_92186A8CF01D3B25 ON usuarios_cartas (usuarios_id)');
        $this->addSql('CREATE INDEX IDX_92186A8C303ACA92 ON usuarios_cartas (cartas_id)');
    }
}
