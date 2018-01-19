<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180117150808 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur CHANGE salt salt VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE website website VARCHAR(64) DEFAULT NULL, CHANGE gender gender VARCHAR(1) DEFAULT NULL, CHANGE facebook_uid facebook_uid VARCHAR(255) DEFAULT NULL, CHANGE facebook_name facebook_name VARCHAR(255) DEFAULT NULL, CHANGE twitter_uid twitter_uid VARCHAR(255) DEFAULT NULL, CHANGE twitter_name twitter_name VARCHAR(255) DEFAULT NULL, CHANGE gplus_uid gplus_uid VARCHAR(255) DEFAULT NULL, CHANGE gplus_name gplus_name VARCHAR(255) DEFAULT NULL, CHANGE token token VARCHAR(255) DEFAULT NULL, CHANGE two_step_code two_step_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tag CHANGE nom nom VARCHAR(100) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B7836C6E55B5 ON tag (nom)');
        $this->addSql('DROP INDEX uniq_3bc4f163989d9b62 ON tag');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B783989D9B62 ON tag (slug)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');


        $this->addSql('DROP INDEX UNIQ_389B7836C6E55B5 ON tag');
        $this->addSql('ALTER TABLE tag CHANGE nom nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('DROP INDEX uniq_389b783989d9b62 ON tag');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BC4F163989D9B62 ON tag (slug)');
       }
}
