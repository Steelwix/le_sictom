<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110160305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE carrier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE extraction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE frequentation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE material_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE number_plate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE carrier (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE extraction (id INT NOT NULL, landfill_id INT NOT NULL, material_id INT NOT NULL, carrier_id INT NOT NULL, number_plate_id INT NOT NULL, datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, number INT NOT NULL, size INT NOT NULL, destination VARCHAR(255) NOT NULL, is_emergency BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3ADCB5D6BCC3C7B2 ON extraction (landfill_id)');
        $this->addSql('CREATE INDEX IDX_3ADCB5D6E308AC6F ON extraction (material_id)');
        $this->addSql('CREATE INDEX IDX_3ADCB5D621DFC797 ON extraction (carrier_id)');
        $this->addSql('CREATE INDEX IDX_3ADCB5D65F741C74 ON extraction (number_plate_id)');
        $this->addSql('CREATE TABLE frequentation (id INT NOT NULL, landfill_id INT NOT NULL, day DATE NOT NULL, morning_count INT NOT NULL, afternoon_count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77787A32BCC3C7B2 ON frequentation (landfill_id)');
        $this->addSql('CREATE TABLE material (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE number_plate (id INT NOT NULL, carrier_id INT DEFAULT NULL, number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CAD7549321DFC797 ON number_plate (carrier_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, is_landfill BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE extraction ADD CONSTRAINT FK_3ADCB5D6BCC3C7B2 FOREIGN KEY (landfill_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE extraction ADD CONSTRAINT FK_3ADCB5D6E308AC6F FOREIGN KEY (material_id) REFERENCES material (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE extraction ADD CONSTRAINT FK_3ADCB5D621DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE extraction ADD CONSTRAINT FK_3ADCB5D65F741C74 FOREIGN KEY (number_plate_id) REFERENCES number_plate (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE frequentation ADD CONSTRAINT FK_77787A32BCC3C7B2 FOREIGN KEY (landfill_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE number_plate ADD CONSTRAINT FK_CAD7549321DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE carrier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE extraction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE frequentation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE material_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE number_plate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE extraction DROP CONSTRAINT FK_3ADCB5D6BCC3C7B2');
        $this->addSql('ALTER TABLE extraction DROP CONSTRAINT FK_3ADCB5D6E308AC6F');
        $this->addSql('ALTER TABLE extraction DROP CONSTRAINT FK_3ADCB5D621DFC797');
        $this->addSql('ALTER TABLE extraction DROP CONSTRAINT FK_3ADCB5D65F741C74');
        $this->addSql('ALTER TABLE frequentation DROP CONSTRAINT FK_77787A32BCC3C7B2');
        $this->addSql('ALTER TABLE number_plate DROP CONSTRAINT FK_CAD7549321DFC797');
        $this->addSql('DROP TABLE carrier');
        $this->addSql('DROP TABLE extraction');
        $this->addSql('DROP TABLE frequentation');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE number_plate');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
