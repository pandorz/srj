<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170807080132 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualite ADD date_publication DATETIME DEFAULT NULL AFTER affiche');
        $this->addSql('ALTER TABLE atelier ADD date_publication DATETIME DEFAULT NULL AFTER affiche, ADD url_inscription VARCHAR(255) NOT NULL AFTER prix_membre');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE cour ADD date_publication DATETIME DEFAULT NULL AFTER affiche');
        $this->addSql('ALTER TABLE evenement ADD date_publication DATETIME DEFAULT NULL AFTER affiche');
        $this->addSql('ALTER TABLE sortie ADD date_publication DATETIME DEFAULT NULL AFTER affiche, ADD url_inscription VARCHAR(255) NOT NULL AFTER prix_membre');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualite DROP date_publication');
        $this->addSql('ALTER TABLE atelier DROP date_publication, DROP url_inscription');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE cour DROP date_publication');
        $this->addSql('ALTER TABLE evenement DROP date_publication');
        $this->addSql('ALTER TABLE sortie DROP date_publication, DROP url_inscription');
    }
}
