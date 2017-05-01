<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170501181715 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, fk_date INT NOT NULL, fk_date_limite INT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, affiche INT NOT NULL, annule INT NOT NULL, nb_place INT NOT NULL, reserveMembre INT NOT NULL, prix DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_E1BB1823989D9B62 (slug), INDEX IDX_E1BB182326A0E944 (fk_date), INDEX IDX_E1BB18232F551E3D (fk_date_limite), UNIQUE INDEX UNIQ_E1BB18233DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, fk_auteur INT NOT NULL, fk_rubrique INT DEFAULT NULL, fk_atelier INT DEFAULT NULL, fk_sortie INT DEFAULT NULL, fk_evenement INT DEFAULT NULL, date TIME NOT NULL, texte MEDIUMTEXT NOT NULL, INDEX IDX_89C2003F25F4D9D0 (fk_auteur), INDEX IDX_89C2003FBD8C4AA2 (fk_rubrique), INDEX IDX_89C2003F1194250F (fk_atelier), INDEX IDX_89C2003F1C91BB62 (fk_sortie), INDEX IDX_89C2003F6A7FBF8E (fk_evenement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cour (id INT AUTO_INCREMENT NOT NULL, fk_professeur INT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, annule INT NOT NULL, affiche INT NOT NULL, UNIQUE INDEX UNIQ_A71F964F989D9B62 (slug), INDEX IDX_A71F964FE7CB980A (fk_professeur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cour_date_calendrier (cour_id INT NOT NULL, date_calendrier_id INT NOT NULL, INDEX IDX_D5571015B7942F03 (cour_id), INDEX IDX_D5571015846C8D18 (date_calendrier_id), PRIMARY KEY(cour_id, date_calendrier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date_calendrier (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, fk_date INT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, affiche INT NOT NULL, annule INT NOT NULL, UNIQUE INDEX UNIQ_B26681E989D9B62 (slug), INDEX IDX_B26681E26A0E944 (fk_date), UNIQUE INDEX UNIQ_B26681E3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, fk_utilisateur INT NOT NULL, fk_sortie INT DEFAULT NULL, fk_atelier INT DEFAULT NULL, nbPlace INT NOT NULL, dateCreation DATETIME NOT NULL, INDEX IDX_5E90F6D674EACF87 (fk_utilisateur), INDEX IDX_5E90F6D61C91BB62 (fk_sortie), INDEX IDX_5E90F6D61194250F (fk_atelier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, fk_type INT NOT NULL, nom VARCHAR(255) NOT NULL, route VARCHAR(255) DEFAULT NULL, slug VARCHAR(128) NOT NULL, ordre INT NOT NULL, UNIQUE INDEX UNIQ_8FA4097C989D9B62 (slug), INDEX IDX_8FA4097CE08917 (fk_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Rubrique_relations (rubrique_id INT NOT NULL, enfant_rubrique_id INT NOT NULL, INDEX IDX_143906753BD38833 (rubrique_id), INDEX IDX_14390675E44E8313 (enfant_rubrique_id), PRIMARY KEY(rubrique_id, enfant_rubrique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id INT AUTO_INCREMENT NOT NULL, fk_date INT NOT NULL, fk_date_limite INT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, affiche INT NOT NULL, annule INT NOT NULL, nb_place INT NOT NULL, reserveMembre INT NOT NULL, prix DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_3C3FD3F2989D9B62 (slug), INDEX IDX_3C3FD3F226A0E944 (fk_date), INDEX IDX_3C3FD3F22F551E3D (fk_date_limite), UNIQUE INDEX UNIQ_3C3FD3F23DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_rubrique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_cour (utilisateur_id INT NOT NULL, cour_id INT NOT NULL, INDEX IDX_6E9EFA75FB88E14F (utilisateur_id), INDEX IDX_6E9EFA75B7942F03 (cour_id), PRIMARY KEY(utilisateur_id, cour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_atelier (utilisateur_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_9BB0EFB1FB88E14F (utilisateur_id), INDEX IDX_9BB0EFB182E2CF35 (atelier_id), PRIMARY KEY(utilisateur_id, atelier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_evenement (utilisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_6B889D32FB88E14F (utilisateur_id), INDEX IDX_6B889D32FD02F13 (evenement_id), PRIMARY KEY(utilisateur_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_sortie (utilisateur_id INT NOT NULL, sortie_id INT NOT NULL, INDEX IDX_5D92E979FB88E14F (utilisateur_id), INDEX IDX_5D92E979CC72D953 (sortie_id), PRIMARY KEY(utilisateur_id, sortie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Utilisateur_relations (utilisateur_id INT NOT NULL, enfant_utilisateur_id INT NOT NULL, INDEX IDX_E30A6F8CFB88E14F (utilisateur_id), INDEX IDX_E30A6F8CAE8F9142 (enfant_utilisateur_id), PRIMARY KEY(utilisateur_id, enfant_utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB182326A0E944 FOREIGN KEY (fk_date) REFERENCES date_calendrier (id)');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB18232F551E3D FOREIGN KEY (fk_date_limite) REFERENCES date_calendrier (id)');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB18233DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F25F4D9D0 FOREIGN KEY (fk_auteur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003FBD8C4AA2 FOREIGN KEY (fk_rubrique) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F1194250F FOREIGN KEY (fk_atelier) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F1C91BB62 FOREIGN KEY (fk_sortie) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F6A7FBF8E FOREIGN KEY (fk_evenement) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964FE7CB980A FOREIGN KEY (fk_professeur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE cour_date_calendrier ADD CONSTRAINT FK_D5571015B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cour_date_calendrier ADD CONSTRAINT FK_D5571015846C8D18 FOREIGN KEY (date_calendrier_id) REFERENCES date_calendrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E26A0E944 FOREIGN KEY (fk_date) REFERENCES date_calendrier (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D674EACF87 FOREIGN KEY (fk_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D61C91BB62 FOREIGN KEY (fk_sortie) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D61194250F FOREIGN KEY (fk_atelier) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097CE08917 FOREIGN KEY (fk_type) REFERENCES type_rubrique (id)');
        $this->addSql('ALTER TABLE Rubrique_relations ADD CONSTRAINT FK_143906753BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE Rubrique_relations ADD CONSTRAINT FK_14390675E44E8313 FOREIGN KEY (enfant_rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F226A0E944 FOREIGN KEY (fk_date) REFERENCES date_calendrier (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F22F551E3D FOREIGN KEY (fk_date_limite) REFERENCES date_calendrier (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F23DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE utilisateur_cour ADD CONSTRAINT FK_6E9EFA75FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_cour ADD CONSTRAINT FK_6E9EFA75B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_atelier ADD CONSTRAINT FK_9BB0EFB1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_atelier ADD CONSTRAINT FK_9BB0EFB182E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_evenement ADD CONSTRAINT FK_6B889D32FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_evenement ADD CONSTRAINT FK_6B889D32FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_sortie ADD CONSTRAINT FK_5D92E979FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_sortie ADD CONSTRAINT FK_5D92E979CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Utilisateur_relations ADD CONSTRAINT FK_E30A6F8CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE Utilisateur_relations ADD CONSTRAINT FK_E30A6F8CAE8F9142 FOREIGN KEY (enfant_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD image_id INT DEFAULT NULL, ADD slug VARCHAR(128) NOT NULL, ADD acces_site INT NOT NULL, ADD locked INT NOT NULL, ADD est_professeur INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B33DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3989D9B62 ON utilisateur (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B33DA5256D ON utilisateur (image_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F1194250F');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D61194250F');
        $this->addSql('ALTER TABLE utilisateur_atelier DROP FOREIGN KEY FK_9BB0EFB182E2CF35');
        $this->addSql('ALTER TABLE cour_date_calendrier DROP FOREIGN KEY FK_D5571015B7942F03');
        $this->addSql('ALTER TABLE utilisateur_cour DROP FOREIGN KEY FK_6E9EFA75B7942F03');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB182326A0E944');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB18232F551E3D');
        $this->addSql('ALTER TABLE cour_date_calendrier DROP FOREIGN KEY FK_D5571015846C8D18');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E26A0E944');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F226A0E944');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F22F551E3D');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F6A7FBF8E');
        $this->addSql('ALTER TABLE utilisateur_evenement DROP FOREIGN KEY FK_6B889D32FD02F13');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB18233DA5256D');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E3DA5256D');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F23DA5256D');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B33DA5256D');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003FBD8C4AA2');
        $this->addSql('ALTER TABLE Rubrique_relations DROP FOREIGN KEY FK_143906753BD38833');
        $this->addSql('ALTER TABLE Rubrique_relations DROP FOREIGN KEY FK_14390675E44E8313');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F1C91BB62');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D61C91BB62');
        $this->addSql('ALTER TABLE utilisateur_sortie DROP FOREIGN KEY FK_5D92E979CC72D953');
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097CE08917');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE contenu');
        $this->addSql('DROP TABLE cour');
        $this->addSql('DROP TABLE cour_date_calendrier');
        $this->addSql('DROP TABLE date_calendrier');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE Rubrique_relations');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE type_rubrique');
        $this->addSql('DROP TABLE utilisateur_cour');
        $this->addSql('DROP TABLE utilisateur_atelier');
        $this->addSql('DROP TABLE utilisateur_evenement');
        $this->addSql('DROP TABLE utilisateur_sortie');
        $this->addSql('DROP TABLE Utilisateur_relations');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3989D9B62 ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B33DA5256D ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP image_id, DROP slug, DROP acces_site, DROP locked, DROP est_professeur');
    }
}
