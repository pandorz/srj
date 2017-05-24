<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170524212238 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E3DA5256D');
        $this->addSql('ALTER TABLE evenement ADD version INT DEFAULT 1 NOT NULL AFTER id');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX nom ON evenement (nom)');
        $this->addSql('CREATE INDEX affiche ON evenement (affiche)');
        $this->addSql('CREATE INDEX annule ON evenement (annule)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E3DA5256D');
        $this->addSql('DROP INDEX nom ON evenement');
        $this->addSql('DROP INDEX affiche ON evenement');
        $this->addSql('DROP INDEX annule ON evenement');
        $this->addSql('ALTER TABLE evenement DROP version');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
    }
}
