<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119115341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenants (id INT NOT NULL, genre VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE community_manager (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateurs (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profils (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_75831F5EA4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profils_id INT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastename VARCHAR(255) NOT NULL, photo LONGBLOB NOT NULL, archivage TINYINT(1) NOT NULL, Profil VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649B9881AFB (profils_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenants ADD CONSTRAINT FK_C71C2982BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE community_manager ADD CONSTRAINT FK_DEE14CEABF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formateurs ADD CONSTRAINT FK_FD80E574BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B9881AFB FOREIGN KEY (profils_id) REFERENCES profils (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B9881AFB');
        $this->addSql('ALTER TABLE apprenants DROP FOREIGN KEY FK_C71C2982BF396750');
        $this->addSql('ALTER TABLE community_manager DROP FOREIGN KEY FK_DEE14CEABF396750');
        $this->addSql('ALTER TABLE formateurs DROP FOREIGN KEY FK_FD80E574BF396750');
        $this->addSql('DROP TABLE apprenants');
        $this->addSql('DROP TABLE community_manager');
        $this->addSql('DROP TABLE formateurs');
        $this->addSql('DROP TABLE profils');
        $this->addSql('DROP TABLE user');
    }
}
