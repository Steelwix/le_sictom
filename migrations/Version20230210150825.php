<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210150825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frequentation ADD landfill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE frequentation ADD CONSTRAINT FK_77787A32BCC3C7B2 FOREIGN KEY (landfill_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_77787A32BCC3C7B2 ON frequentation (landfill_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE frequentation DROP CONSTRAINT FK_77787A32BCC3C7B2');
        $this->addSql('DROP INDEX IDX_77787A32BCC3C7B2');
        $this->addSql('ALTER TABLE frequentation DROP landfill_id');
    }
}
