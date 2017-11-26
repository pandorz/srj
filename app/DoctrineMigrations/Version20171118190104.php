<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171118190104 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(128) NOT NULL, nom VARCHAR(255) NOT NULL, lien VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_32FFA373989D9B62 (slug), INDEX nom (nom), INDEX slug (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C5414E7AF8F');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C541EA9FDD75');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX slug ON actualite (slug)');
        $this->addSql('CREATE INDEX slug ON atelier (slug)');
        $this->addSql('CREATE INDEX slug ON blog (slug)');
        $this->addSql('CREATE INDEX slug ON cour (slug)');
        $this->addSql('CREATE INDEX slug ON evenement (slug)');
        $this->addSql('CREATE INDEX nom ON parametre (nom)');
        $this->addSql('CREATE INDEX slug ON parametre (slug)');
        $this->addSql('CREATE INDEX slug ON sortie (slug)');
        $this->addSql('CREATE INDEX slug ON utilisateur (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP INDEX slug ON actualite');
        $this->addSql('DROP INDEX slug ON atelier');
        $this->addSql('DROP INDEX slug ON blog');
        $this->addSql('DROP INDEX slug ON cour');
        $this->addSql('DROP INDEX slug ON evenement');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C5414E7AF8F');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C541EA9FDD75');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
        $this->addSql('DROP INDEX nom ON parametre');
        $this->addSql('DROP INDEX slug ON parametre');
        $this->addSql('DROP INDEX slug ON sortie');
        $this->addSql('DROP INDEX slug ON utilisateur');
    }
}
