<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210150727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frequentation DROP CONSTRAINT fk_77787a32bcc3c7b2');
        $this->addSql('DROP INDEX uniq_77787a32bcc3c7b2');
        $this->addSql('ALTER TABLE frequentation DROP landfill_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE frequentation ADD landfill_id INT NOT NULL');
        $this->addSql('ALTER TABLE frequentation ADD CONSTRAINT fk_77787a32bcc3c7b2 FOREIGN KEY (landfill_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_77787a32bcc3c7b2 ON frequentation (landfill_id)');
    }
}
