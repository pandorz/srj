<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171005142219 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description_courte VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, affiche TINYINT(1) NOT NULL, date_publication DATETIME DEFAULT NULL, contenu TEXT DEFAULT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_C0155143989D9B62 (slug), UNIQUE INDEX UNIQ_C01551433DA5256D (image_id), INDEX nom (nom), INDEX affiche (affiche), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C01551433DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE blog');
    }
}
