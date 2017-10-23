<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171006124356 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE atelier ADD adresse VARCHAR(255) DEFAULT NULL AFTER url_inscription, ADD code_postal VARCHAR(6) DEFAULT NULL AFTER url_inscription, ADD ville VARCHAR(60) DEFAULT NULL AFTER url_inscription, ADD coord_geo_latitude DOUBLE PRECISION DEFAULT NULL AFTER url_inscription, ADD coord_geo_longitude DOUBLE PRECISION DEFAULT NULL AFTER url_inscription');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE atelier DROP adresse, DROP code_postal, DROP ville, DROP coord_geo_latitude, DROP coord_geo_longitude');
    }
}
