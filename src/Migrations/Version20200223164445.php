<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200223164445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE cartas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, ataque INTEGER NOT NULL, defensa INTEGER NOT NULL, descripcion VARCHAR(255) NOT NULL, foto VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE usuarios (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EF687F2E7927C74 ON usuarios (email)');
        $this->addSql('CREATE TABLE usuarios_cartas (usuarios_id INTEGER NOT NULL, cartas_id INTEGER NOT NULL, PRIMARY KEY(usuarios_id, cartas_id))');
        $this->addSql('CREATE INDEX IDX_92186A8CF01D3B25 ON usuarios_cartas (usuarios_id)');
        $this->addSql('CREATE INDEX IDX_92186A8C303ACA92 ON usuarios_cartas (cartas_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE cartas');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE usuarios_cartas');
    }
}
