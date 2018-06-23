<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180602141116 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour_detail DROP FOREIGN KEY FK_9C4549312B214871');
        $this->addSql('ALTER TABLE cour_detail ADD CONSTRAINT FK_9C4549312B214871 FOREIGN KEY (fk_cour) REFERENCES cour (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour_detail DROP FOREIGN KEY FK_9C4549312B214871');
        $this->addSql('ALTER TABLE cour_detail ADD CONSTRAINT FK_9C4549312B214871 FOREIGN KEY (fk_cour) REFERENCES cour (id)');
    }
}
