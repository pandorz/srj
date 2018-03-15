<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180208104059 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cour_report (id INT AUTO_INCREMENT NOT NULL, fk_cour INT DEFAULT NULL, date_annule DATE DEFAULT NULL, date_report DATE DEFAULT NULL, heure_debut TIME DEFAULT NULL, heure_fin TIME DEFAULT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, INDEX IDX_766C41262B214871 (fk_cour), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cour_report ADD CONSTRAINT FK_766C41262B214871 FOREIGN KEY (fk_cour) REFERENCES cour (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cour_report');
    }
}
