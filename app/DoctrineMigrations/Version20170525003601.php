<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170525003601 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cours_inscriptions (utilisateur_id INT NOT NULL, cour_id INT NOT NULL, INDEX IDX_6315213FFB88E14F (utilisateur_id), INDEX IDX_6315213FB7942F03 (cour_id), PRIMARY KEY(utilisateur_id, cour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorties_inscriptions (utilisateur_id INT NOT NULL, sortie_id INT NOT NULL, INDEX IDX_BEEF7562FB88E14F (utilisateur_id), INDEX IDX_BEEF7562CC72D953 (sortie_id), PRIMARY KEY(utilisateur_id, sortie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ateliers_inscriptions (utilisateur_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_DABC4A57FB88E14F (utilisateur_id), INDEX IDX_DABC4A5782E2CF35 (atelier_id), PRIMARY KEY(utilisateur_id, atelier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours_inscriptions ADD CONSTRAINT FK_6315213FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE cours_inscriptions ADD CONSTRAINT FK_6315213FB7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id)');
        $this->addSql('ALTER TABLE sorties_inscriptions ADD CONSTRAINT FK_BEEF7562FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE sorties_inscriptions ADD CONSTRAINT FK_BEEF7562CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE ateliers_inscriptions ADD CONSTRAINT FK_DABC4A57FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ateliers_inscriptions ADD CONSTRAINT FK_DABC4A5782E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('DROP TABLE utilisateur_cour');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE utilisateur_cour (utilisateur_id INT NOT NULL, cour_id INT NOT NULL, INDEX IDX_6E9EFA75FB88E14F (utilisateur_id), INDEX IDX_6E9EFA75B7942F03 (cour_id), PRIMARY KEY(utilisateur_id, cour_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_cour ADD CONSTRAINT FK_6E9EFA75B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_cour ADD CONSTRAINT FK_6E9EFA75FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE cours_inscriptions');
        $this->addSql('DROP TABLE sorties_inscriptions');
        $this->addSql('DROP TABLE ateliers_inscriptions');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
