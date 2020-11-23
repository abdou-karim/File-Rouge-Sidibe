<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123231530 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, status VARCHAR(255) NOT NULL, type_de_groupe VARCHAR(255) NOT NULL, INDEX IDX_4B98C21139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_apprenants (groupe_id INT NOT NULL, apprenants_id INT NOT NULL, INDEX IDX_7FF1185E7A45358C (groupe_id), INDEX IDX_7FF1185ED4B7C9BD (apprenants_id), PRIMARY KEY(groupe_id, apprenants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_formateurs (groupe_id INT NOT NULL, formateurs_id INT NOT NULL, INDEX IDX_456DD4A87A45358C (groupe_id), INDEX IDX_456DD4A8FB0881C8 (formateurs_id), PRIMARY KEY(groupe_id, formateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, langue VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, date_fin_provisoire DATE NOT NULL, fabrique VARCHAR(255) NOT NULL, date_fin_reelle DATE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion_formateurs (promotion_id INT NOT NULL, formateurs_id INT NOT NULL, INDEX IDX_B82ECED0139DF194 (promotion_id), INDEX IDX_B82ECED0FB0881C8 (formateurs_id), PRIMARY KEY(promotion_id, formateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE groupe_apprenants ADD CONSTRAINT FK_7FF1185E7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenants ADD CONSTRAINT FK_7FF1185ED4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES apprenants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_formateurs ADD CONSTRAINT FK_456DD4A87A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_formateurs ADD CONSTRAINT FK_456DD4A8FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES formateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_formateurs ADD CONSTRAINT FK_B82ECED0139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_formateurs ADD CONSTRAINT FK_B82ECED0FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES formateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenants ADD CONSTRAINT FK_C71C29826409EF73 FOREIGN KEY (profil_sortie_id) REFERENCES profil_sortie (id)');
        $this->addSql('CREATE INDEX IDX_C71C29826409EF73 ON apprenants (profil_sortie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_apprenants DROP FOREIGN KEY FK_7FF1185E7A45358C');
        $this->addSql('ALTER TABLE groupe_formateurs DROP FOREIGN KEY FK_456DD4A87A45358C');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21139DF194');
        $this->addSql('ALTER TABLE promotion_formateurs DROP FOREIGN KEY FK_B82ECED0139DF194');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_apprenants');
        $this->addSql('DROP TABLE groupe_formateurs');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE promotion_formateurs');
        $this->addSql('ALTER TABLE apprenants DROP FOREIGN KEY FK_C71C29826409EF73');
        $this->addSql('DROP INDEX IDX_C71C29826409EF73 ON apprenants');
    }
}
