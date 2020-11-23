<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123150238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profil_sortie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenants ADD profil_sortie_id INT NOT NULL');
        $this->addSql('ALTER TABLE apprenants ADD CONSTRAINT FK_C71C29826409EF73 FOREIGN KEY (profil_sortie_id) REFERENCES profil_sortie (id)');
        $this->addSql('CREATE INDEX IDX_C71C29826409EF73 ON apprenants (profil_sortie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenants DROP FOREIGN KEY FK_C71C29826409EF73');
        $this->addSql('DROP TABLE profil_sortie');
        $this->addSql('DROP INDEX IDX_C71C29826409EF73 ON apprenants');
        $this->addSql('ALTER TABLE apprenants DROP profil_sortie_id');
    }
}
