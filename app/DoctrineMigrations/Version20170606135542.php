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

        $this->addSql('CREATE TABLE acl_classes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_type VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_69DD750638A36066 (class_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_security_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, identifier VARCHAR(200) NOT NULL, username TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8835EE78772E836AF85E0677 (identifier, username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_object_identity_id INT UNSIGNED DEFAULT NULL, class_id INT UNSIGNED NOT NULL, object_identifier VARCHAR(100) NOT NULL, entries_inheriting TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_9407E5494B12AD6EA000B10 (object_identifier, class_id), INDEX IDX_9407E54977FA751A (parent_object_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identity_ancestors (object_identity_id INT UNSIGNED NOT NULL, ancestor_id INT UNSIGNED NOT NULL, INDEX IDX_825DE2993D9AB4A6 (object_identity_id), INDEX IDX_825DE299C671CEA1 (ancestor_id), PRIMARY KEY(object_identity_id, ancestor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_entries (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_id INT UNSIGNED NOT NULL, object_identity_id INT UNSIGNED DEFAULT NULL, security_identity_id INT UNSIGNED NOT NULL, field_name VARCHAR(50) DEFAULT NULL, ace_order SMALLINT UNSIGNED NOT NULL, mask INT NOT NULL, granting TINYINT(1) NOT NULL, granting_strategy VARCHAR(30) NOT NULL, audit_success TINYINT(1) NOT NULL, audit_failure TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4 (class_id, object_identity_id, field_name, ace_order), INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9 (class_id, object_identity_id, security_identity_id), INDEX IDX_46C8B806EA000B10 (class_id), INDEX IDX_46C8B8063D9AB4A6 (object_identity_id), INDEX IDX_46C8B806DF9183C9 (security_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acl_object_identities ADD CONSTRAINT FK_9407E54977FA751A FOREIGN KEY (parent_object_identity_id) REFERENCES acl_object_identities (id)');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id)');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
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
    }
}
