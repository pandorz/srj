<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171205104015 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE kouryukai (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, affiche TINYINT(1) NOT NULL, annule TINYINT(1) NOT NULL, date DATETIME DEFAULT NULL, date_limite DATETIME DEFAULT NULL, date_publication DATETIME DEFAULT NULL, url_inscription VARCHAR(255) DEFAULT NULL, nb_place INT DEFAULT NULL, contenu TEXT DEFAULT NULL, reserve_membre TINYINT(1) NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_6D679F4D989D9B62 (slug), UNIQUE INDEX UNIQ_6D679F4D3DA5256D (image_id), INDEX nom (nom), INDEX slug (slug), INDEX affiche (affiche), INDEX annule (annule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kouryukais_surpervisions (kouryukai_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_CB07BA153B0CB9E0 (kouryukai_id), INDEX IDX_CB07BA15FB88E14F (utilisateur_id), PRIMARY KEY(kouryukai_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kouryukais_inscriptions (kouryukai_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_64AE6C843B0CB9E0 (kouryukai_id), INDEX IDX_64AE6C84FB88E14F (utilisateur_id), PRIMARY KEY(kouryukai_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kouryukai ADD CONSTRAINT FK_6D679F4D3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE kouryukais_surpervisions ADD CONSTRAINT FK_CB07BA153B0CB9E0 FOREIGN KEY (kouryukai_id) REFERENCES kouryukai (id)');
        $this->addSql('ALTER TABLE kouryukais_surpervisions ADD CONSTRAINT FK_CB07BA15FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE kouryukais_inscriptions ADD CONSTRAINT FK_64AE6C843B0CB9E0 FOREIGN KEY (kouryukai_id) REFERENCES kouryukai (id)');
        $this->addSql('ALTER TABLE kouryukais_inscriptions ADD CONSTRAINT FK_64AE6C84FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C5414E7AF8F');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C541EA9FDD75');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE kouryukais_surpervisions DROP FOREIGN KEY FK_CB07BA153B0CB9E0');
        $this->addSql('ALTER TABLE kouryukais_inscriptions DROP FOREIGN KEY FK_64AE6C843B0CB9E0');
        $this->addSql('DROP TABLE kouryukai');
        $this->addSql('DROP TABLE kouryukais_surpervisions');
        $this->addSql('DROP TABLE kouryukais_inscriptions');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C5414E7AF8F');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C541EA9FDD75');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE CASCADE');
    }
}
