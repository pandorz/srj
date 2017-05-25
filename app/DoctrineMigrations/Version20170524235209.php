<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170524235209 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cour_date_calendrier DROP FOREIGN KEY FK_D5571015846C8D18');
        $this->addSql('DROP TABLE cour_date_calendrier');
        $this->addSql('DROP TABLE date_calendrier');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE cour ADD contenu TEXT DEFAULT NULL AFTER affiche');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cour_date_calendrier (cour_id INT NOT NULL, date_calendrier_id INT NOT NULL, INDEX IDX_D5571015B7942F03 (cour_id), INDEX IDX_D5571015846C8D18 (date_calendrier_id), PRIMARY KEY(cour_id, date_calendrier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date_calendrier (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cour_date_calendrier ADD CONSTRAINT FK_D5571015846C8D18 FOREIGN KEY (date_calendrier_id) REFERENCES date_calendrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cour_date_calendrier ADD CONSTRAINT FK_D5571015B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE cour DROP contenu');
    }
}
