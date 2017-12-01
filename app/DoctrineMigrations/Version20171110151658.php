<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171110151658 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964FBB1A0722');
        $this->addSql('DROP INDEX IDX_A71F964FBB1A0722 ON cour');
        $this->addSql('ALTER TABLE cour DROP details_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour ADD details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964FBB1A0722 FOREIGN KEY (details_id) REFERENCES cour_detail (id)');
        $this->addSql('CREATE INDEX IDX_A71F964FBB1A0722 ON cour (details_id)');
    }
}
