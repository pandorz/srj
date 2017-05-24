<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170524234329 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3CD9824A9');
        $this->addSql('DROP INDEX IDX_1D1C63B3CD9824A9 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE sous_utilisateurs_id parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3727ACA70 FOREIGN KEY (parent_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3727ACA70 ON utilisateur (parent_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3727ACA70');
        $this->addSql('DROP INDEX IDX_1D1C63B3727ACA70 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE parent_id sous_utilisateurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3CD9824A9 FOREIGN KEY (sous_utilisateurs_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3CD9824A9 ON utilisateur (sous_utilisateurs_id)');
    }
}
