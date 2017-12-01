<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171110115521 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rubrique_relations DROP FOREIGN KEY FK_143906753BD38833');
        $this->addSql('ALTER TABLE Rubrique_relations DROP FOREIGN KEY FK_14390675E44E8313');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003FBD8C4AA2');
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097CE08917');
        $this->addSql('CREATE TABLE cours_details_items (cour_id INT NOT NULL, cour_detail_id INT NOT NULL, INDEX IDX_D381CBD9B7942F03 (cour_id), INDEX IDX_D381CBD964E50B58 (cour_detail_id), PRIMARY KEY(cour_id, cour_detail_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cour_detail (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, contenu TEXT DEFAULT NULL, complet TINYINT(1) NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours_details_items ADD CONSTRAINT FK_D381CBD9B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id)');
        $this->addSql('ALTER TABLE cours_details_items ADD CONSTRAINT FK_D381CBD964E50B58 FOREIGN KEY (cour_detail_id) REFERENCES cour_detail (id)');
        $this->addSql('DROP TABLE Rubrique_relations');
        $this->addSql('DROP TABLE contenu');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE type_rubrique');
        $this->addSql('DROP INDEX nom ON cour');
        $this->addSql('ALTER TABLE cour ADD parametre_lien_inscription_id INT DEFAULT NULL AFTER date_publication, ADD parametre_lien_pdf_id INT DEFAULT NULL AFTER date_publication, ADD image_id INT DEFAULT NULL, ADD complet TINYINT(1) NOT NULL AFTER date_publication, ADD bientot_complet TINYINT(1) NOT NULL AFTER date_publication, ADD ancre VARCHAR(45) NOT NULL AFTER date_publication, ADD prix DOUBLE PRECISION NOT NULL AFTER date_publication, ADD crenau VARCHAR(255) NOT NULL AFTER date_publication, ADD condition_particuliere VARCHAR(255) DEFAULT NULL AFTER date_publication, ADD note VARCHAR(255) DEFAULT NULL AFTER date_publication, CHANGE nom titre VARCHAR(255) NOT NULL, CHANGE contenu amorce TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964FD74408E0 FOREIGN KEY (parametre_lien_inscription_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F4EF1C131 FOREIGN KEY (parametre_lien_pdf_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A71F964FD74408E0 ON cour (parametre_lien_inscription_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A71F964F4EF1C131 ON cour (parametre_lien_pdf_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A71F964F3DA5256D ON cour (image_id)');
        $this->addSql('CREATE INDEX ancre ON cour (ancre)');
        $this->addSql('ALTER TABLE utilisateur ADD image_id INT DEFAULT NULL, CHANGE est_professeur estProfesseur TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B33DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B33DA5256D ON utilisateur (image_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cours_details_items DROP FOREIGN KEY FK_D381CBD964E50B58');
        $this->addSql('CREATE TABLE Rubrique_relations (rubrique_id INT NOT NULL, enfant_rubrique_id INT NOT NULL, INDEX IDX_143906753BD38833 (rubrique_id), INDEX IDX_14390675E44E8313 (enfant_rubrique_id), PRIMARY KEY(rubrique_id, enfant_rubrique_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, fk_atelier INT DEFAULT NULL, fk_sortie INT DEFAULT NULL, fk_auteur INT NOT NULL, fk_evenement INT DEFAULT NULL, fk_rubrique INT DEFAULT NULL, date TIME NOT NULL, texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, utilisateur_modification VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_89C2003F25F4D9D0 (fk_auteur), INDEX IDX_89C2003FBD8C4AA2 (fk_rubrique), INDEX IDX_89C2003F1194250F (fk_atelier), INDEX IDX_89C2003F1C91BB62 (fk_sortie), INDEX IDX_89C2003F6A7FBF8E (fk_evenement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, fk_type INT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, route VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, slug VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci, ordre INT NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, utilisateur_modification VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX UNIQ_8FA4097C989D9B62 (slug), INDEX IDX_8FA4097CE08917 (fk_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_rubrique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, libelle VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Rubrique_relations ADD CONSTRAINT FK_143906753BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE Rubrique_relations ADD CONSTRAINT FK_14390675E44E8313 FOREIGN KEY (enfant_rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F1194250F FOREIGN KEY (fk_atelier) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F1C91BB62 FOREIGN KEY (fk_sortie) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F25F4D9D0 FOREIGN KEY (fk_auteur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F6A7FBF8E FOREIGN KEY (fk_evenement) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003FBD8C4AA2 FOREIGN KEY (fk_rubrique) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097CE08917 FOREIGN KEY (fk_type) REFERENCES type_rubrique (id)');
        $this->addSql('DROP TABLE cours_details_items');
        $this->addSql('DROP TABLE cour_detail');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964FD74408E0');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F4EF1C131');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F3DA5256D');
        $this->addSql('DROP INDEX UNIQ_A71F964FD74408E0 ON cour');
        $this->addSql('DROP INDEX UNIQ_A71F964F4EF1C131 ON cour');
        $this->addSql('DROP INDEX UNIQ_A71F964F3DA5256D ON cour');
        $this->addSql('DROP INDEX ancre ON cour');
        $this->addSql('ALTER TABLE cour ADD nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP parametre_lien_inscription_id, DROP parametre_lien_pdf_id, DROP image_id, DROP complet, DROP bientot_complet, DROP ancre, DROP titre, DROP prix, DROP crenau, DROP condition_particuliere, DROP note, CHANGE amorce contenu TEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE INDEX nom ON cour (nom)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B33DA5256D');
        $this->addSql('DROP INDEX UNIQ_1D1C63B33DA5256D ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP image_id, CHANGE estprofesseur est_professeur TINYINT(1) NOT NULL');
    }
}
