<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170619135243 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ateliers_surpervisions (utilisateur_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_D4632B5DFB88E14F (utilisateur_id), INDEX IDX_D4632B5D82E2CF35 (atelier_id), PRIMARY KEY(utilisateur_id, atelier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenements_surpervisions (utilisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_FF4643FFFB88E14F (utilisateur_id), INDEX IDX_FF4643FFFD02F13 (evenement_id), PRIMARY KEY(utilisateur_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorties_surpervisions (utilisateur_id INT NOT NULL, sortie_id INT NOT NULL, INDEX IDX_82B4BC41FB88E14F (utilisateur_id), INDEX IDX_82B4BC41CC72D953 (sortie_id), PRIMARY KEY(utilisateur_id, sortie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ateliers_surpervisions ADD CONSTRAINT FK_D4632B5DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ateliers_surpervisions ADD CONSTRAINT FK_D4632B5D82E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE evenements_surpervisions ADD CONSTRAINT FK_FF4643FFFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE evenements_surpervisions ADD CONSTRAINT FK_FF4643FFFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE sorties_surpervisions ADD CONSTRAINT FK_82B4BC41FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE sorties_surpervisions ADD CONSTRAINT FK_82B4BC41CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('DROP TABLE utilisateur_atelier');
        $this->addSql('DROP TABLE utilisateur_evenement');
        $this->addSql('DROP TABLE utilisateur_sortie');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE acl_classes CHANGE class_type class_type VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE identifier identifier VARCHAR(200) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE utilisateur_atelier (utilisateur_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_9BB0EFB1FB88E14F (utilisateur_id), INDEX IDX_9BB0EFB182E2CF35 (atelier_id), PRIMARY KEY(utilisateur_id, atelier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_evenement (utilisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_6B889D32FB88E14F (utilisateur_id), INDEX IDX_6B889D32FD02F13 (evenement_id), PRIMARY KEY(utilisateur_id, evenement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_sortie (utilisateur_id INT NOT NULL, sortie_id INT NOT NULL, INDEX IDX_5D92E979FB88E14F (utilisateur_id), INDEX IDX_5D92E979CC72D953 (sortie_id), PRIMARY KEY(utilisateur_id, sortie_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_atelier ADD CONSTRAINT FK_9BB0EFB182E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_atelier ADD CONSTRAINT FK_9BB0EFB1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_evenement ADD CONSTRAINT FK_6B889D32FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_evenement ADD CONSTRAINT FK_6B889D32FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_sortie ADD CONSTRAINT FK_5D92E979CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_sortie ADD CONSTRAINT FK_5D92E979FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE ateliers_surpervisions');
        $this->addSql('DROP TABLE evenements_surpervisions');
        $this->addSql('DROP TABLE sorties_surpervisions');
        $this->addSql('ALTER TABLE acl_classes CHANGE class_type class_type VARCHAR(191) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE identifier identifier VARCHAR(191) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
