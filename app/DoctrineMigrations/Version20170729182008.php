<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170729182008 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parametre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, value VARCHAR(255) DEFAULT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_ACC79041989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE parametre');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
