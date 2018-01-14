<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180109191559 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE classification__category DROP FOREIGN KEY FK_43629B36727ACA70');
        $this->addSql('ALTER TABLE media__media DROP FOREIGN KEY FK_5C6DD74E12469DE2');
        $this->addSql('ALTER TABLE news__post DROP FOREIGN KEY FK_7D109BC8514956FD');
        $this->addSql('ALTER TABLE classification__category DROP FOREIGN KEY FK_43629B36E25D857E');
        $this->addSql('ALTER TABLE classification__collection DROP FOREIGN KEY FK_A406B56AE25D857E');
        $this->addSql('ALTER TABLE classification__tag DROP FOREIGN KEY FK_CA57A1C7E25D857E');
        $this->addSql('ALTER TABLE news__post_tag DROP FOREIGN KEY FK_682B2051BAD26311');
        $this->addSql('ALTER TABLE news__comment DROP FOREIGN KEY FK_A90210404B89032C');
        $this->addSql('ALTER TABLE news__post_tag DROP FOREIGN KEY FK_682B20514B89032C');
        $this->addSql('DROP TABLE classification__category');
        $this->addSql('DROP TABLE classification__collection');
        $this->addSql('DROP TABLE classification__context');
        $this->addSql('DROP TABLE classification__tag');
        $this->addSql('DROP TABLE news__comment');
        $this->addSql('DROP TABLE news__post');
        $this->addSql('DROP TABLE news__post_tag');
        $this->addSql('DROP INDEX IDX_5C6DD74E12469DE2 ON media__media');
        $this->addSql('ALTER TABLE media__media DROP category_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE classification__category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, context VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, position INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_43629B36727ACA70 (parent_id), INDEX IDX_43629B36E25D857E (context), INDEX IDX_43629B36EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classification__collection (id INT AUTO_INCREMENT NOT NULL, context VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX tag_collection (slug, context), INDEX IDX_A406B56AE25D857E (context), INDEX IDX_A406B56AEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classification__context (id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classification__tag (id INT AUTO_INCREMENT NOT NULL, context VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX tag_context (slug, context), INDEX IDX_CA57A1C7E25D857E (context), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news__comment (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, url VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, message LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A90210404B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news__post (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, author_id INT DEFAULT NULL, collection_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, abstract LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, content LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, raw_content LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, content_formatter VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, publication_date_start DATETIME DEFAULT NULL, comments_enabled TINYINT(1) NOT NULL, comments_close_at DATETIME DEFAULT NULL, comments_default_status INT NOT NULL, comments_count INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7D109BC83DA5256D (image_id), INDEX IDX_7D109BC8F675F31B (author_id), INDEX IDX_7D109BC8514956FD (collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news__post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_682B20514B89032C (post_id), INDEX IDX_682B2051BAD26311 (tag_id), PRIMARY KEY(post_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36727ACA70 FOREIGN KEY (parent_id) REFERENCES classification__category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36E25D857E FOREIGN KEY (context) REFERENCES classification__context (id)');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE classification__collection ADD CONSTRAINT FK_A406B56AE25D857E FOREIGN KEY (context) REFERENCES classification__context (id)');
        $this->addSql('ALTER TABLE classification__collection ADD CONSTRAINT FK_A406B56AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE classification__tag ADD CONSTRAINT FK_CA57A1C7E25D857E FOREIGN KEY (context) REFERENCES classification__context (id)');
        $this->addSql('ALTER TABLE news__comment ADD CONSTRAINT FK_A90210404B89032C FOREIGN KEY (post_id) REFERENCES news__post (id)');
        $this->addSql('ALTER TABLE news__post ADD CONSTRAINT FK_7D109BC83DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE news__post ADD CONSTRAINT FK_7D109BC8514956FD FOREIGN KEY (collection_id) REFERENCES classification__collection (id)');
        $this->addSql('ALTER TABLE news__post ADD CONSTRAINT FK_7D109BC8F675F31B FOREIGN KEY (author_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE news__post_tag ADD CONSTRAINT FK_682B20514B89032C FOREIGN KEY (post_id) REFERENCES news__post (id)');
        $this->addSql('ALTER TABLE news__post_tag ADD CONSTRAINT FK_682B2051BAD26311 FOREIGN KEY (tag_id) REFERENCES classification__tag (id)');
        $this->addSql('ALTER TABLE media__media ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media__media ADD CONSTRAINT FK_5C6DD74E12469DE2 FOREIGN KEY (category_id) REFERENCES classification__category (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_5C6DD74E12469DE2 ON media__media (category_id)');
    }
}
