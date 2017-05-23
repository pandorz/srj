<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170523173719 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E26A0E944');
        $this->addSql('DROP INDEX IDX_B26681E26A0E944 ON evenement');
        $this->addSql('ALTER TABLE evenement ADD date_debut DATE DEFAULT NULL, ADD date_fin DATE DEFAULT NULL, DROP fk_date');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE evenement ADD fk_date INT NOT NULL, DROP date_debut, DROP date_fin');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E26A0E944 FOREIGN KEY (fk_date) REFERENCES date_calendrier (id)');
        $this->addSql('CREATE INDEX IDX_B26681E26A0E944 ON evenement (fk_date)');
    }
}
