<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180114123116 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_549281973DA5256D');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_549281973DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB18233DA5256D');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB18233DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F3DA5256D');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E3DA5256D');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE kouryukai DROP FOREIGN KEY FK_6D679F4D3DA5256D');
        $this->addSql('ALTER TABLE kouryukai ADD CONSTRAINT FK_6D679F4D3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F23DA5256D');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F23DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B33DA5256D');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B33DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_549281973DA5256D');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_549281973DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB18233DA5256D');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB18233DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F3DA5256D');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E3DA5256D');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE kouryukai DROP FOREIGN KEY FK_6D679F4D3DA5256D');
        $this->addSql('ALTER TABLE kouryukai ADD CONSTRAINT FK_6D679F4D3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F23DA5256D');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F23DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B33DA5256D');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B33DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
    }
}
