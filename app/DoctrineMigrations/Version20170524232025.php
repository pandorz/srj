<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170524232025 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE utilisateur_relations');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD sous_utilisateurs_id INT DEFAULT NULL, CHANGE acces_site acces_site TINYINT(1) NOT NULL, CHANGE est_professeur est_professeur TINYINT(1) NOT NULL, CHANGE locked boolean INT NOT NULL');
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

        $this->addSql('CREATE TABLE utilisateur_relations (utilisateur_id INT NOT NULL, enfant_utilisateur_id INT NOT NULL, INDEX IDX_E30A6F8CFB88E14F (utilisateur_id), INDEX IDX_E30A6F8CAE8F9142 (enfant_utilisateur_id), PRIMARY KEY(utilisateur_id, enfant_utilisateur_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_relations ADD CONSTRAINT FK_E30A6F8CAE8F9142 FOREIGN KEY (enfant_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur_relations ADD CONSTRAINT FK_E30A6F8CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3CD9824A9');
        $this->addSql('DROP INDEX IDX_1D1C63B3CD9824A9 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP sous_utilisateurs_id, CHANGE acces_site acces_site INT NOT NULL, CHANGE est_professeur est_professeur INT NOT NULL, CHANGE boolean locked INT NOT NULL');
    }
}
