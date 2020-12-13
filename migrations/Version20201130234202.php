<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201130234202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contexte LONGTEXT NOT NULL, date_poste DATE NOT NULL, date_limite DATE NOT NULL, liste_livrable LONGTEXT NOT NULL, description_rapide LONGTEXT NOT NULL, modalite_pedagogique LONGTEXT NOT NULL, crictere_performance LONGTEXT NOT NULL, modalite_evaluation LONGTEXT NOT NULL, image_exemplaire LONGBLOB NOT NULL, langue VARCHAR(255) NOT NULL, statut VARCHAR(50) NOT NULL, etat VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD1805DB139 ON promotion (referentiel_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE brief');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1805DB139');
        $this->addSql('DROP INDEX IDX_C11D7DD1805DB139 ON promotion');
    }
}
