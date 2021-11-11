<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210613233707 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_contacts (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, company_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, vcard VARCHAR(255) NOT NULL, business_card_face_one VARCHAR(255) DEFAULT NULL, business_card_face_two VARCHAR(255) DEFAULT NULL, INDEX IDX_2BD7001EE7A1254A (contact_id), INDEX IDX_2BD7001E979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts_languages (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, language VARCHAR(255) NOT NULL, display_order INT NOT NULL, level VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_A672B6E3E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_contacts ADD CONSTRAINT FK_2BD7001EE7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('ALTER TABLE company_contacts ADD CONSTRAINT FK_2BD7001E979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE contacts_languages ADD CONSTRAINT FK_A672B6E3E7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('ALTER TABLE emails ADD contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emails ADD CONSTRAINT FK_4C81E852E7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('CREATE INDEX IDX_4C81E852E7A1254A ON emails (contact_id)');
        $this->addSql('ALTER TABLE phones ADD contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phones ADD CONSTRAINT FK_E3282EF5E7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('CREATE INDEX IDX_E3282EF5E7A1254A ON phones (contact_id)');
        $this->addSql('ALTER TABLE private_notes ADD contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE private_notes ADD CONSTRAINT FK_2D52FA73E7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('CREATE INDEX IDX_2D52FA73E7A1254A ON private_notes (contact_id)');
        $this->addSql('ALTER TABLE social_media ADD contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social_media ADD CONSTRAINT FK_20BC159EE7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('CREATE INDEX IDX_20BC159EE7A1254A ON social_media (contact_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company_contacts');
        $this->addSql('DROP TABLE contacts_languages');
        $this->addSql('ALTER TABLE emails DROP FOREIGN KEY FK_4C81E852E7A1254A');
        $this->addSql('DROP INDEX IDX_4C81E852E7A1254A ON emails');
        $this->addSql('ALTER TABLE emails DROP contact_id');
        $this->addSql('ALTER TABLE phones DROP FOREIGN KEY FK_E3282EF5E7A1254A');
        $this->addSql('DROP INDEX IDX_E3282EF5E7A1254A ON phones');
        $this->addSql('ALTER TABLE phones DROP contact_id');
        $this->addSql('ALTER TABLE private_notes DROP FOREIGN KEY FK_2D52FA73E7A1254A');
        $this->addSql('DROP INDEX IDX_2D52FA73E7A1254A ON private_notes');
        $this->addSql('ALTER TABLE private_notes DROP contact_id');
        $this->addSql('ALTER TABLE social_media DROP FOREIGN KEY FK_20BC159EE7A1254A');
        $this->addSql('DROP INDEX IDX_20BC159EE7A1254A ON social_media');
        $this->addSql('ALTER TABLE social_media DROP contact_id');
    }
}
