<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170606135542 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE acl_classes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_type VARCHAR(191) NOT NULL, UNIQUE INDEX UNIQ_69DD750638A36066 (class_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_security_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, identifier VARCHAR(191) NOT NULL, username TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8835EE78772E836AF85E0677 (identifier, username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_object_identity_id INT UNSIGNED DEFAULT NULL, class_id INT UNSIGNED NOT NULL, object_identifier VARCHAR(100) NOT NULL, entries_inheriting TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_9407E5494B12AD6EA000B10 (object_identifier, class_id), INDEX IDX_9407E54977FA751A (parent_object_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identity_ancestors (object_identity_id INT UNSIGNED NOT NULL, ancestor_id INT UNSIGNED NOT NULL, INDEX IDX_825DE2993D9AB4A6 (object_identity_id), INDEX IDX_825DE299C671CEA1 (ancestor_id), PRIMARY KEY(object_identity_id, ancestor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_entries (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_id INT UNSIGNED NOT NULL, object_identity_id INT UNSIGNED DEFAULT NULL, security_identity_id INT UNSIGNED NOT NULL, field_name VARCHAR(50) DEFAULT NULL, ace_order SMALLINT UNSIGNED NOT NULL, mask INT NOT NULL, granting TINYINT(1) NOT NULL, granting_strategy VARCHAR(30) NOT NULL, audit_success TINYINT(1) NOT NULL, audit_failure TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4 (class_id, object_identity_id, field_name, ace_order), INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9 (class_id, object_identity_id, security_identity_id), INDEX IDX_46C8B806EA000B10 (class_id), INDEX IDX_46C8B8063D9AB4A6 (object_identity_id), INDEX IDX_46C8B806DF9183C9 (security_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acl_object_identities ADD CONSTRAINT FK_9407E54977FA751A FOREIGN KEY (parent_object_identity_id) REFERENCES acl_object_identities (id)');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE TABLE media__gallery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, context VARCHAR(64) NOT NULL, default_format VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media__gallery_media (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, media_id INT DEFAULT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_80D4C5414E7AF8F (gallery_id), INDEX IDX_80D4C541EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media__media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, enabled TINYINT(1) NOT NULL, provider_name VARCHAR(255) NOT NULL, provider_status INT NOT NULL, provider_reference VARCHAR(255) NOT NULL, provider_metadata LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', width INT DEFAULT NULL, height INT DEFAULT NULL, length NUMERIC(10, 0) DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL, content_size INT DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, context VARCHAR(64) DEFAULT NULL, cdn_is_flushable TINYINT(1) DEFAULT NULL, cdn_flush_identifier VARCHAR(64) DEFAULT NULL, cdn_flush_at DATETIME DEFAULT NULL, cdn_status INT DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, affiche TINYINT(1) NOT NULL, annule TINYINT(1) NOT NULL, date DATE DEFAULT NULL, date_limite DATE DEFAULT NULL, nb_place INT NOT NULL, contenu TEXT DEFAULT NULL, reserveMembre TINYINT(1) NOT NULL, prix DOUBLE PRECISION NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_E1BB1823989D9B62 (slug), UNIQUE INDEX UNIQ_E1BB18233DA5256D (image_id), INDEX nom (nom), INDEX affiche (affiche), INDEX annule (annule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, fk_auteur INT NOT NULL, fk_rubrique INT DEFAULT NULL, fk_atelier INT DEFAULT NULL, fk_sortie INT DEFAULT NULL, fk_evenement INT DEFAULT NULL, date TIME NOT NULL, texte MEDIUMTEXT NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, INDEX IDX_89C2003F25F4D9D0 (fk_auteur), INDEX IDX_89C2003FBD8C4AA2 (fk_rubrique), INDEX IDX_89C2003F1194250F (fk_atelier), INDEX IDX_89C2003F1C91BB62 (fk_sortie), INDEX IDX_89C2003F6A7FBF8E (fk_evenement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cour (id INT AUTO_INCREMENT NOT NULL, fk_professeur INT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, annule TINYINT(1) NOT NULL, affiche TINYINT(1) NOT NULL, contenu TEXT DEFAULT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_A71F964F989D9B62 (slug), INDEX IDX_A71F964FE7CB980A (fk_professeur), INDEX nom (nom), INDEX affiche (affiche), INDEX annule (annule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, affiche TINYINT(1) NOT NULL, annule TINYINT(1) NOT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, contenu TEXT DEFAULT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_B26681E989D9B62 (slug), UNIQUE INDEX UNIQ_B26681E3DA5256D (image_id), INDEX nom (nom), INDEX affiche (affiche), INDEX annule (annule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, fk_type INT NOT NULL, nom VARCHAR(255) NOT NULL, route VARCHAR(255) DEFAULT NULL, slug VARCHAR(128) NOT NULL, ordre INT NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8FA4097C989D9B62 (slug), INDEX IDX_8FA4097CE08917 (fk_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Rubrique_relations (rubrique_id INT NOT NULL, enfant_rubrique_id INT NOT NULL, INDEX IDX_143906753BD38833 (rubrique_id), INDEX IDX_14390675E44E8313 (enfant_rubrique_id), PRIMARY KEY(rubrique_id, enfant_rubrique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, affiche TINYINT(1) NOT NULL, annule TINYINT(1) NOT NULL, date DATE DEFAULT NULL, date_limite DATE DEFAULT NULL, nb_place INT NOT NULL, contenu TEXT DEFAULT NULL, reserve_membre TINYINT(1) NOT NULL, prix DOUBLE PRECISION NOT NULL, timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, utilisateur_creation VARCHAR(255) DEFAULT NULL, utilisateur_modification VARCHAR(255) DEFAULT NULL, version INT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_3C3FD3F2989D9B62 (slug), UNIQUE INDEX UNIQ_3C3FD3F23DA5256D (image_id), INDEX nom (nom), INDEX affiche (affiche), INDEX annule (annule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_rubrique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, sous_utilisateurs_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, date_of_birth DATETIME DEFAULT NULL, firstname VARCHAR(64) DEFAULT NULL, lastname VARCHAR(64) DEFAULT NULL, website VARCHAR(64) DEFAULT NULL, biography VARCHAR(1000) DEFAULT NULL, gender VARCHAR(1) DEFAULT NULL, locale VARCHAR(8) DEFAULT NULL, timezone VARCHAR(64) DEFAULT NULL, phone VARCHAR(64) DEFAULT NULL, facebook_uid VARCHAR(255) DEFAULT NULL, facebook_name VARCHAR(255) DEFAULT NULL, facebook_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', twitter_uid VARCHAR(255) DEFAULT NULL, twitter_name VARCHAR(255) DEFAULT NULL, twitter_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', gplus_uid VARCHAR(255) DEFAULT NULL, gplus_name VARCHAR(255) DEFAULT NULL, gplus_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', token VARCHAR(255) DEFAULT NULL, two_step_code VARCHAR(255) DEFAULT NULL, nom VARCHAR(100) DEFAULT NULL, prenom VARCHAR(100) DEFAULT NULL, slug VARCHAR(128) NOT NULL, acces_site TINYINT(1) NOT NULL, boolean INT NOT NULL, est_professeur TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B392FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1D1C63B3A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_1D1C63B3C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_1D1C63B3989D9B62 (slug), INDEX IDX_1D1C63B3CD9824A9 (sous_utilisateurs_id), INDEX email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours_inscriptions (utilisateur_id INT NOT NULL, cour_id INT NOT NULL, INDEX IDX_6315213FFB88E14F (utilisateur_id), INDEX IDX_6315213FB7942F03 (cour_id), PRIMARY KEY(utilisateur_id, cour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorties_inscriptions (utilisateur_id INT NOT NULL, sortie_id INT NOT NULL, INDEX IDX_BEEF7562FB88E14F (utilisateur_id), INDEX IDX_BEEF7562CC72D953 (sortie_id), PRIMARY KEY(utilisateur_id, sortie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ateliers_inscriptions (utilisateur_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_DABC4A57FB88E14F (utilisateur_id), INDEX IDX_DABC4A5782E2CF35 (atelier_id), PRIMARY KEY(utilisateur_id, atelier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_atelier (utilisateur_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_9BB0EFB1FB88E14F (utilisateur_id), INDEX IDX_9BB0EFB182E2CF35 (atelier_id), PRIMARY KEY(utilisateur_id, atelier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_evenement (utilisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_6B889D32FB88E14F (utilisateur_id), INDEX IDX_6B889D32FD02F13 (evenement_id), PRIMARY KEY(utilisateur_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_sortie (utilisateur_id INT NOT NULL, sortie_id INT NOT NULL, INDEX IDX_5D92E979FB88E14F (utilisateur_id), INDEX IDX_5D92E979CC72D953 (sortie_id), PRIMARY KEY(utilisateur_id, sortie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user_user_group (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_B3C77447A76ED395 (user_id), INDEX IDX_B3C77447FE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_droits (id INT AUTO_INCREMENT NOT NULL, fk_id_utilisateur INT DEFAULT NULL, name VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', timestamp_creation DATETIME DEFAULT NULL, timestamp_modification DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_6604EE455E237E06 (name), INDEX fk_id_utilisateur (fk_id_utilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB18233DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F25F4D9D0 FOREIGN KEY (fk_auteur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003FBD8C4AA2 FOREIGN KEY (fk_rubrique) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F1194250F FOREIGN KEY (fk_atelier) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F1C91BB62 FOREIGN KEY (fk_sortie) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F6A7FBF8E FOREIGN KEY (fk_evenement) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964FE7CB980A FOREIGN KEY (fk_professeur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097CE08917 FOREIGN KEY (fk_type) REFERENCES type_rubrique (id)');
        $this->addSql('ALTER TABLE Rubrique_relations ADD CONSTRAINT FK_143906753BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE Rubrique_relations ADD CONSTRAINT FK_14390675E44E8313 FOREIGN KEY (enfant_rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F23DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3CD9824A9 FOREIGN KEY (sous_utilisateurs_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE cours_inscriptions ADD CONSTRAINT FK_6315213FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE cours_inscriptions ADD CONSTRAINT FK_6315213FB7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id)');
        $this->addSql('ALTER TABLE sorties_inscriptions ADD CONSTRAINT FK_BEEF7562FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE sorties_inscriptions ADD CONSTRAINT FK_BEEF7562CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE ateliers_inscriptions ADD CONSTRAINT FK_DABC4A57FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ateliers_inscriptions ADD CONSTRAINT FK_DABC4A5782E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE utilisateur_atelier ADD CONSTRAINT FK_9BB0EFB1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_atelier ADD CONSTRAINT FK_9BB0EFB182E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_evenement ADD CONSTRAINT FK_6B889D32FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_evenement ADD CONSTRAINT FK_6B889D32FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_sortie ADD CONSTRAINT FK_5D92E979FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_sortie ADD CONSTRAINT FK_5D92E979CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fos_user_user_group ADD CONSTRAINT FK_B3C77447A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fos_user_user_group ADD CONSTRAINT FK_B3C77447FE54D947 FOREIGN KEY (group_id) REFERENCES utilisateur_droits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_droits ADD CONSTRAINT FK_6604EE45700047AD FOREIGN KEY (fk_id_utilisateur) REFERENCES utilisateur (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9');
        $this->addSql('ALTER TABLE acl_object_identities DROP FOREIGN KEY FK_9407E54977FA751A');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6');
        $this->addSql('DROP TABLE acl_classes');
        $this->addSql('DROP TABLE acl_security_identities');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_entries');
        $this->addSql('ALTER TABLE Rubrique_relations DROP FOREIGN KEY FK_143906753BD38833');
        $this->addSql('ALTER TABLE Rubrique_relations DROP FOREIGN KEY FK_14390675E44E8313');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB18233DA5256D');
        $this->addSql('ALTER TABLE ateliers_inscriptions DROP FOREIGN KEY FK_DABC4A57FB88E14F');
        $this->addSql('ALTER TABLE ateliers_inscriptions DROP FOREIGN KEY FK_DABC4A5782E2CF35');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F25F4D9D0');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003FBD8C4AA2');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F1194250F');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F1C91BB62');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F6A7FBF8E');
        $this->addSql('ALTER TABLE contenu CHANGE texte texte MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964FE7CB980A');
        $this->addSql('ALTER TABLE cours_inscriptions DROP FOREIGN KEY FK_6315213FFB88E14F');
        $this->addSql('ALTER TABLE cours_inscriptions DROP FOREIGN KEY FK_6315213FB7942F03');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E3DA5256D');
        $this->addSql('ALTER TABLE fos_user_user_group DROP FOREIGN KEY FK_B3C77447A76ED395');
        $this->addSql('ALTER TABLE fos_user_user_group DROP FOREIGN KEY FK_B3C77447FE54D947');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C5414E7AF8F');
        $this->addSql('ALTER TABLE media__gallery_media DROP FOREIGN KEY FK_80D4C541EA9FDD75');
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097CE08917');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F23DA5256D');
        $this->addSql('ALTER TABLE sorties_inscriptions DROP FOREIGN KEY FK_BEEF7562FB88E14F');
        $this->addSql('ALTER TABLE sorties_inscriptions DROP FOREIGN KEY FK_BEEF7562CC72D953');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3CD9824A9');
        $this->addSql('ALTER TABLE utilisateur_atelier DROP FOREIGN KEY FK_9BB0EFB1FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_atelier DROP FOREIGN KEY FK_9BB0EFB182E2CF35');
        $this->addSql('ALTER TABLE utilisateur_droits DROP FOREIGN KEY FK_6604EE45700047AD');
        $this->addSql('ALTER TABLE utilisateur_evenement DROP FOREIGN KEY FK_6B889D32FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_evenement DROP FOREIGN KEY FK_6B889D32FD02F13');
        $this->addSql('ALTER TABLE utilisateur_sortie DROP FOREIGN KEY FK_5D92E979FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_sortie DROP FOREIGN KEY FK_5D92E979CC72D953');
        $this->addSql('DROP TABLE Rubrique_relations');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE ateliers_inscriptions');
        $this->addSql('DROP TABLE contenu');
        $this->addSql('DROP TABLE cour');
        $this->addSql('DROP TABLE cours_inscriptions');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE fos_user_user_group');
        $this->addSql('DROP TABLE media__gallery_media');
        $this->addSql('DROP TABLE media__gallery');
        $this->addSql('DROP TABLE media__media');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE type_rubrique');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE sorties_inscriptions');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_atelier');
        $this->addSql('DROP TABLE utilisateur_droits');
        $this->addSql('DROP TABLE utilisateur_evenement');
        $this->addSql('DROP TABLE utilisateur_sortie');

    }
}
