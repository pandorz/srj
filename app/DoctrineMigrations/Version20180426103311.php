<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180426103311 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE import (id INT AUTO_INCREMENT NOT NULL, fk_group INT DEFAULT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, filepath VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, filepath_log VARCHAR(255) DEFAULT NULL, statut VARCHAR(45) DEFAULT NULL, INDEX IDX_9D4ECE1DAC2D67B0 (fk_group), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE import ADD CONSTRAINT FK_9D4ECE1DAC2D67B0 FOREIGN KEY (fk_group) REFERENCES utilisateur_droits (id)');
        $this->addSql('ALTER TABLE utilisateur ADD adherent TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur_droits DROP FOREIGN KEY FK_6604EE45700047AD');
        $this->addSql('DROP INDEX fk_id_utilisateur ON utilisateur_droits');
        $this->addSql('ALTER TABLE utilisateur_droits DROP fk_id_utilisateur');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE import');
        $this->addSql('ALTER TABLE utilisateur DROP adherent');
        $this->addSql('ALTER TABLE utilisateur_droits ADD fk_id_utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur_droits ADD CONSTRAINT FK_6604EE45700047AD FOREIGN KEY (fk_id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX fk_id_utilisateur ON utilisateur_droits (fk_id_utilisateur)');
    }
}
