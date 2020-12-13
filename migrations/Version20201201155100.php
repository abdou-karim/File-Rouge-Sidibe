<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201155100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD1805DB139 ON promotion (referentiel_id)');
        $this->addSql('ALTER TABLE referentiel CHANGE programme programme LONGBLOB NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1805DB139');
        $this->addSql('DROP INDEX IDX_C11D7DD1805DB139 ON promotion');
        $this->addSql('ALTER TABLE referentiel CHANGE programme programme VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
