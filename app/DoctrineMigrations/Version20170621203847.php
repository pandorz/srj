<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170621203847 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualitess_surpervisions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE actualitess_surpervisions ADD PRIMARY KEY (actualite_id, utilisateur_id)');
        $this->addSql('ALTER TABLE ateliers_surpervisions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ateliers_surpervisions ADD PRIMARY KEY (atelier_id, utilisateur_id)');
        $this->addSql('ALTER TABLE ateliers_inscriptions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ateliers_inscriptions ADD PRIMARY KEY (atelier_id, utilisateur_id)');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE evenements_surpervisions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE evenements_surpervisions ADD PRIMARY KEY (evenement_id, utilisateur_id)');
        $this->addSql('ALTER TABLE sorties_surpervisions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sorties_surpervisions ADD PRIMARY KEY (sortie_id, utilisateur_id)');
        $this->addSql('ALTER TABLE sorties_inscriptions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sorties_inscriptions ADD PRIMARY KEY (sortie_id, utilisateur_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualitess_surpervisions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE actualitess_surpervisions ADD PRIMARY KEY (utilisateur_id, actualite_id)');
        $this->addSql('ALTER TABLE ateliers_inscriptions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ateliers_inscriptions ADD PRIMARY KEY (utilisateur_id, atelier_id)');
        $this->addSql('ALTER TABLE ateliers_surpervisions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ateliers_surpervisions ADD PRIMARY KEY (utilisateur_id, atelier_id)');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE evenements_surpervisions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE evenements_surpervisions ADD PRIMARY KEY (utilisateur_id, evenement_id)');
        $this->addSql('ALTER TABLE sorties_inscriptions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sorties_inscriptions ADD PRIMARY KEY (utilisateur_id, sortie_id)');
        $this->addSql('ALTER TABLE sorties_surpervisions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sorties_surpervisions ADD PRIMARY KEY (utilisateur_id, sortie_id)');
    }
}
