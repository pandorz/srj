<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171110210510 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour_detail ADD fk_cour INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cour_detail ADD CONSTRAINT FK_9C4549312B214871 FOREIGN KEY (fk_cour) REFERENCES cour (id)');
        $this->addSql('CREATE INDEX IDX_9C4549312B214871 ON cour_detail (fk_cour)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour_detail DROP FOREIGN KEY FK_9C4549312B214871');
        $this->addSql('DROP INDEX IDX_9C4549312B214871 ON cour_detail');
        $this->addSql('ALTER TABLE cour_detail DROP fk_cour');
    }
}
