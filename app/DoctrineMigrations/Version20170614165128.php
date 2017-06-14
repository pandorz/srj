<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170614165128 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE atelier ADD prix_membre DOUBLE PRECISION NOT NULL AFTER prix');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD prix_membre DOUBLE PRECISION NOT NULL AFTER prix');
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

        $this->addSql('ALTER TABLE acl_classes CHANGE class_type class_type VARCHAR(191) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE identifier identifier VARCHAR(191) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE atelier DROP prix_membre');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE sortie DROP prix_membre');
    }
}
