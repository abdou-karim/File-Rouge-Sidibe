<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203185053 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenants ADD promotion_id INT NOT NULL');
        $this->addSql('ALTER TABLE apprenants ADD CONSTRAINT FK_C71C2982139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_C71C2982139DF194 ON apprenants (promotion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenants DROP FOREIGN KEY FK_C71C2982139DF194');
        $this->addSql('DROP INDEX IDX_C71C2982139DF194 ON apprenants');
        $this->addSql('ALTER TABLE apprenants DROP promotion_id');
    }
}
