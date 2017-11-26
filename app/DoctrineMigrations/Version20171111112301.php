<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171111112301 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cours_professeurs (cour_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_D07D2127B7942F03 (cour_id), INDEX IDX_D07D2127FB88E14F (utilisateur_id), PRIMARY KEY(cour_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours_professeurs ADD CONSTRAINT FK_D07D2127B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id)');
        $this->addSql('ALTER TABLE cours_professeurs ADD CONSTRAINT FK_D07D2127FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964FE7CB980A');
        $this->addSql('DROP INDEX IDX_A71F964FE7CB980A ON cour');
        $this->addSql('ALTER TABLE cour DROP fk_professeur');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cours_professeurs');
        $this->addSql('ALTER TABLE cour ADD fk_professeur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964FE7CB980A FOREIGN KEY (fk_professeur) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_A71F964FE7CB980A ON cour (fk_professeur)');
    }
}
