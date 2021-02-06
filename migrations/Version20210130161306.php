<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210130161306 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenants ADD referentiel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apprenants ADD CONSTRAINT FK_C71C2982805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('CREATE INDEX IDX_C71C2982805DB139 ON apprenants (referentiel_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenants DROP FOREIGN KEY FK_C71C2982805DB139');
        $this->addSql('DROP INDEX IDX_C71C2982805DB139 ON apprenants');
        $this->addSql('ALTER TABLE apprenants DROP referentiel_id');
    }
}
