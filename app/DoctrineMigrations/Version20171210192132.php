<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171210192132 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fos_user_group');
        $this->addSql('DROP TABLE fos_user_user');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fos_user_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, roles LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_583D1F3E5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, username_canonical VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, email_canonical VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL COLLATE utf8mb4_unicode_ci, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, date_of_birth DATETIME DEFAULT NULL, firstname VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, lastname VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, website VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, biography VARCHAR(1000) DEFAULT NULL COLLATE utf8mb4_unicode_ci, gender VARCHAR(1) DEFAULT NULL COLLATE utf8mb4_unicode_ci, locale VARCHAR(8) DEFAULT NULL COLLATE utf8mb4_unicode_ci, timezone VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, phone VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, facebook_uid VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, facebook_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, facebook_data LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:json)\', twitter_uid VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, twitter_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, twitter_data LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:json)\', gplus_uid VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, gplus_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, gplus_data LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:json)\', token VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, two_step_code VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX UNIQ_C560D76192FC23A8 (username_canonical), UNIQUE INDEX UNIQ_C560D761A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_C560D761C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }
}
