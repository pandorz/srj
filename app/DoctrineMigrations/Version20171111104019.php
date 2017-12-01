<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171111104019 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F4EF1C131');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964FD74408E0');
        $this->addSql('DROP INDEX UNIQ_A71F964FD74408E0 ON cour');
        $this->addSql('DROP INDEX UNIQ_A71F964F4EF1C131 ON cour');
        $this->addSql('ALTER TABLE cour ADD lien_inscription VARCHAR(255) DEFAULT NULL, ADD lien_pdf VARCHAR(255) DEFAULT NULL, DROP parametre_lien_pdf_id, DROP parametre_lien_inscription_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour ADD parametre_lien_pdf_id INT DEFAULT NULL, ADD parametre_lien_inscription_id INT DEFAULT NULL, DROP lien_inscription, DROP lien_pdf');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F4EF1C131 FOREIGN KEY (parametre_lien_pdf_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964FD74408E0 FOREIGN KEY (parametre_lien_inscription_id) REFERENCES parametre (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A71F964FD74408E0 ON cour (parametre_lien_inscription_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A71F964F4EF1C131 ON cour (parametre_lien_pdf_id)');
    }
}
