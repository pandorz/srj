<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170525005840 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE inscription');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3727ACA70');
        $this->addSql('DROP INDEX IDX_1D1C63B3727ACA70 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE parent_id sous_utilisateurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3CD9824A9 FOREIGN KEY (sous_utilisateurs_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3CD9824A9 ON utilisateur (sous_utilisateurs_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, fk_atelier INT DEFAULT NULL, fk_sortie INT DEFAULT NULL, fk_utilisateur INT NOT NULL, nbPlace INT NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, utilisateur_modification VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_5E90F6D674EACF87 (fk_utilisateur), INDEX IDX_5E90F6D61C91BB62 (fk_sortie), INDEX IDX_5E90F6D61194250F (fk_atelier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D61194250F FOREIGN KEY (fk_atelier) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D61C91BB62 FOREIGN KEY (fk_sortie) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D674EACF87 FOREIGN KEY (fk_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3CD9824A9');
        $this->addSql('DROP INDEX IDX_1D1C63B3CD9824A9 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE sous_utilisateurs_id parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3727ACA70 FOREIGN KEY (parent_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3727ACA70 ON utilisateur (parent_id)');
    }
}
