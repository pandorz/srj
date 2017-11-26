<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171110145551 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cours_details_items');
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

        $this->addSql('CREATE TABLE cours_details_items (cour_id INT NOT NULL, cour_detail_id INT NOT NULL, INDEX IDX_D381CBD9B7942F03 (cour_id), INDEX IDX_D381CBD964E50B58 (cour_detail_id), PRIMARY KEY(cour_id, cour_detail_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours_details_items ADD CONSTRAINT FK_D381CBD964E50B58 FOREIGN KEY (cour_detail_id) REFERENCES cour_detail (id)');
        $this->addSql('ALTER TABLE cours_details_items ADD CONSTRAINT FK_D381CBD9B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id)');
        $this->addSql('ALTER TABLE cour_detail DROP FOREIGN KEY FK_9C4549312B214871');
        $this->addSql('DROP INDEX IDX_9C4549312B214871 ON cour_detail');
        $this->addSql('ALTER TABLE cour_detail DROP fk_cour');
    }
}
