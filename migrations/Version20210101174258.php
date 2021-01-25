<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210101174258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenants (id INT NOT NULL, profil_sortie_id INT NOT NULL, promotion_id INT DEFAULT NULL, genre VARCHAR(30) NOT NULL, adresse LONGTEXT NOT NULL, telephone VARCHAR(50) NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_C71C29826409EF73 (profil_sortie_id), INDEX IDX_C71C2982139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contexte LONGTEXT NOT NULL, date_poste DATE NOT NULL, date_limite DATE NOT NULL, liste_livrable LONGTEXT NOT NULL, description_rapide LONGTEXT NOT NULL, modalite_pedagogique LONGTEXT NOT NULL, crictere_performance LONGTEXT NOT NULL, modalite_evaluation LONGTEXT NOT NULL, image_exemplaire LONGBLOB NOT NULL, langue VARCHAR(255) NOT NULL, statut VARCHAR(50) NOT NULL, etat VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE community_manager (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateurs (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, status VARCHAR(255) NOT NULL, type_de_groupe VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, INDEX IDX_4B98C21139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_apprenants (groupe_id INT NOT NULL, apprenants_id INT NOT NULL, INDEX IDX_7FF1185E7A45358C (groupe_id), INDEX IDX_7FF1185ED4B7C9BD (apprenants_id), PRIMARY KEY(groupe_id, apprenants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_formateurs (groupe_id INT NOT NULL, formateurs_id INT NOT NULL, INDEX IDX_456DD4A87A45358C (groupe_id), INDEX IDX_456DD4A8FB0881C8 (formateurs_id), PRIMARY KEY(groupe_id, formateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences_competences (groupe_competences_id INT NOT NULL, competences_id INT NOT NULL, INDEX IDX_FF48A1E1C1218EC1 (groupe_competences_id), INDEX IDX_FF48A1E1A660B158 (competences_id), PRIMARY KEY(groupe_competences_id, competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag_tag (groupe_tag_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C430CACFD1EC9F2B (groupe_tag_id), INDEX IDX_C430CACFBAD26311 (tag_id), PRIMARY KEY(groupe_tag_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, competence_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, crictere_devaluation VARCHAR(255) NOT NULL, groupe_daction VARCHAR(255) NOT NULL, INDEX IDX_4BDFF36B15761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_sortie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profils (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_75831F5EA4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, referentiel_id INT NOT NULL, langue VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, date_fin_provisoire DATE NOT NULL, fabrique VARCHAR(255) NOT NULL, date_fin_reelle DATE NOT NULL, status VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, INDEX IDX_C11D7DD1805DB139 (referentiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion_formateurs (promotion_id INT NOT NULL, formateurs_id INT NOT NULL, INDEX IDX_B82ECED0139DF194 (promotion_id), INDEX IDX_B82ECED0FB0881C8 (formateurs_id), PRIMARY KEY(promotion_id, formateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referentiel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, presentation VARCHAR(255) NOT NULL, crictere_admission VARCHAR(255) NOT NULL, crictere_evaluation LONGTEXT NOT NULL, programme LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referentiel_groupe_competences (referentiel_id INT NOT NULL, groupe_competences_id INT NOT NULL, INDEX IDX_E75B7F0A805DB139 (referentiel_id), INDEX IDX_E75B7F0AC1218EC1 (groupe_competences_id), PRIMARY KEY(referentiel_id, groupe_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, descriptif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_groupe_competences (tag_id INT NOT NULL, groupe_competences_id INT NOT NULL, INDEX IDX_32EEE3DBAD26311 (tag_id), INDEX IDX_32EEE3DC1218EC1 (groupe_competences_id), PRIMARY KEY(tag_id, groupe_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profils_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, fisrtname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, photo LONGBLOB DEFAULT NULL, archivage TINYINT(1) DEFAULT \'0\' NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_8D93D649B9881AFB (profils_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenants ADD CONSTRAINT FK_C71C29826409EF73 FOREIGN KEY (profil_sortie_id) REFERENCES profil_sortie (id)');
        $this->addSql('ALTER TABLE apprenants ADD CONSTRAINT FK_C71C2982139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE apprenants ADD CONSTRAINT FK_C71C2982BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE community_manager ADD CONSTRAINT FK_DEE14CEABF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formateurs ADD CONSTRAINT FK_FD80E574BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE groupe_apprenants ADD CONSTRAINT FK_7FF1185E7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenants ADD CONSTRAINT FK_7FF1185ED4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES apprenants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_formateurs ADD CONSTRAINT FK_456DD4A87A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_formateurs ADD CONSTRAINT FK_456DD4A8FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES formateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_competences ADD CONSTRAINT FK_FF48A1E1C1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_competences ADD CONSTRAINT FK_FF48A1E1A660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_tag_tag ADD CONSTRAINT FK_C430CACFD1EC9F2B FOREIGN KEY (groupe_tag_id) REFERENCES groupe_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_tag_tag ADD CONSTRAINT FK_C430CACFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B15761DAB FOREIGN KEY (competence_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE promotion_formateurs ADD CONSTRAINT FK_B82ECED0139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_formateurs ADD CONSTRAINT FK_B82ECED0FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES formateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referentiel_groupe_competences ADD CONSTRAINT FK_E75B7F0A805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referentiel_groupe_competences ADD CONSTRAINT FK_E75B7F0AC1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupe_competences ADD CONSTRAINT FK_32EEE3DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupe_competences ADD CONSTRAINT FK_32EEE3DC1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B9881AFB FOREIGN KEY (profils_id) REFERENCES profils (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_apprenants DROP FOREIGN KEY FK_7FF1185ED4B7C9BD');
        $this->addSql('ALTER TABLE groupe_competences_competences DROP FOREIGN KEY FK_FF48A1E1A660B158');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B15761DAB');
        $this->addSql('ALTER TABLE groupe_formateurs DROP FOREIGN KEY FK_456DD4A8FB0881C8');
        $this->addSql('ALTER TABLE promotion_formateurs DROP FOREIGN KEY FK_B82ECED0FB0881C8');
        $this->addSql('ALTER TABLE groupe_apprenants DROP FOREIGN KEY FK_7FF1185E7A45358C');
        $this->addSql('ALTER TABLE groupe_formateurs DROP FOREIGN KEY FK_456DD4A87A45358C');
        $this->addSql('ALTER TABLE groupe_competences_competences DROP FOREIGN KEY FK_FF48A1E1C1218EC1');
        $this->addSql('ALTER TABLE referentiel_groupe_competences DROP FOREIGN KEY FK_E75B7F0AC1218EC1');
        $this->addSql('ALTER TABLE tag_groupe_competences DROP FOREIGN KEY FK_32EEE3DC1218EC1');
        $this->addSql('ALTER TABLE groupe_tag_tag DROP FOREIGN KEY FK_C430CACFD1EC9F2B');
        $this->addSql('ALTER TABLE apprenants DROP FOREIGN KEY FK_C71C29826409EF73');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B9881AFB');
        $this->addSql('ALTER TABLE apprenants DROP FOREIGN KEY FK_C71C2982139DF194');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21139DF194');
        $this->addSql('ALTER TABLE promotion_formateurs DROP FOREIGN KEY FK_B82ECED0139DF194');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1805DB139');
        $this->addSql('ALTER TABLE referentiel_groupe_competences DROP FOREIGN KEY FK_E75B7F0A805DB139');
        $this->addSql('ALTER TABLE groupe_tag_tag DROP FOREIGN KEY FK_C430CACFBAD26311');
        $this->addSql('ALTER TABLE tag_groupe_competences DROP FOREIGN KEY FK_32EEE3DBAD26311');
        $this->addSql('ALTER TABLE apprenants DROP FOREIGN KEY FK_C71C2982BF396750');
        $this->addSql('ALTER TABLE community_manager DROP FOREIGN KEY FK_DEE14CEABF396750');
        $this->addSql('ALTER TABLE formateurs DROP FOREIGN KEY FK_FD80E574BF396750');
        $this->addSql('DROP TABLE apprenants');
        $this->addSql('DROP TABLE brief');
        $this->addSql('DROP TABLE community_manager');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE formateurs');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_apprenants');
        $this->addSql('DROP TABLE groupe_formateurs');
        $this->addSql('DROP TABLE groupe_competences');
        $this->addSql('DROP TABLE groupe_competences_competences');
        $this->addSql('DROP TABLE groupe_tag');
        $this->addSql('DROP TABLE groupe_tag_tag');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE profil_sortie');
        $this->addSql('DROP TABLE profils');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE promotion_formateurs');
        $this->addSql('DROP TABLE referentiel');
        $this->addSql('DROP TABLE referentiel_groupe_competences');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_groupe_competences');
        $this->addSql('DROP TABLE user');
    }
}
