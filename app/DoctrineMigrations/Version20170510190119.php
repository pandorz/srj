<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170510190119 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE atelier ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL, ADD utilisateur_creation VARCHAR(255) DEFAULT NULL, ADD utilisateur_modification VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contenu ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL, ADD utilisateur_creation VARCHAR(255) DEFAULT NULL, ADD utilisateur_modification VARCHAR(255) DEFAULT NULL, CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE cour ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL, ADD utilisateur_creation VARCHAR(255) DEFAULT NULL, ADD utilisateur_modification VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE date_calendrier ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL, ADD utilisateur_creation VARCHAR(255) DEFAULT NULL, ADD utilisateur_modification VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL, ADD utilisateur_creation VARCHAR(255) DEFAULT NULL, ADD utilisateur_modification VARCHAR(255) DEFAULT NULL, DROP dateCreation');
        $this->addSql('ALTER TABLE rubrique ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL, ADD utilisateur_creation VARCHAR(255) DEFAULT NULL, ADD utilisateur_modification VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL, ADD utilisateur_creation VARCHAR(255) DEFAULT NULL, ADD utilisateur_modification VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE atelier DROP timestamp_creation, DROP timestamp_modification, DROP utilisateur_creation, DROP utilisateur_modification');
        $this->addSql('ALTER TABLE contenu DROP timestamp_creation, DROP timestamp_modification, DROP utilisateur_creation, DROP utilisateur_modification, CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE cour DROP timestamp_creation, DROP timestamp_modification, DROP utilisateur_creation, DROP utilisateur_modification');
        $this->addSql('ALTER TABLE date_calendrier DROP timestamp_creation, DROP timestamp_modification');
        $this->addSql('ALTER TABLE evenement DROP timestamp_creation, DROP timestamp_modification, DROP utilisateur_creation, DROP utilisateur_modification');
        $this->addSql('ALTER TABLE image DROP timestamp_creation, DROP timestamp_modification');
        $this->addSql('ALTER TABLE inscription ADD dateCreation DATETIME NOT NULL, DROP timestamp_creation, DROP timestamp_modification, DROP utilisateur_creation, DROP utilisateur_modification');
        $this->addSql('ALTER TABLE rubrique DROP timestamp_creation, DROP timestamp_modification, DROP utilisateur_creation, DROP utilisateur_modification');
        $this->addSql('ALTER TABLE sortie DROP timestamp_creation, DROP timestamp_modification, DROP utilisateur_creation, DROP utilisateur_modification');
    }
}
