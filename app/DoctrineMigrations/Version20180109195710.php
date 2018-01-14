<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180109195710 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog_auteurs (blog_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_812169A9DAE07E97 (blog_id), INDEX IDX_812169A9FB88E14F (utilisateur_id), PRIMARY KEY(blog_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_tags (blog_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_8F6C18B6DAE07E97 (blog_id), INDEX IDX_8F6C18B6BAD26311 (tag_id), PRIMARY KEY(blog_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3BC4F163989D9B62 (slug), INDEX nom (nom), INDEX slug (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_auteurs ADD CONSTRAINT FK_812169A9DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE blog_auteurs ADD CONSTRAINT FK_812169A9FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE blog_tags ADD CONSTRAINT FK_8F6C18B6DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE blog_tags ADD CONSTRAINT FK_8F6C18B6BAD26311 FOREIGN KEY (tag_id) REFERENCES Tag (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog_tags DROP FOREIGN KEY FK_8F6C18B6BAD26311');
        $this->addSql('DROP TABLE blog_auteurs');
        $this->addSql('DROP TABLE blog_tags');
        $this->addSql('DROP TABLE tag');
    }
}
