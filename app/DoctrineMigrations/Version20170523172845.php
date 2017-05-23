<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170523172845 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE evenement CHANGE affiche affiche TINYINT(1) NOT NULL, CHANGE annule annule TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP timestamp_creation, DROP timestamp_modification');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE evenement CHANGE affiche affiche INT NOT NULL, CHANGE annule annule INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD timestamp_creation DATETIME DEFAULT NULL, ADD timestamp_modification DATETIME DEFAULT NULL');
    }
}
