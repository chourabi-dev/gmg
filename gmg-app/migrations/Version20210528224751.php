<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210528224751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_accounts (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, bank_informations_id INT DEFAULT NULL, ordre INT NOT NULL, INDEX IDX_D25F8BC1979B1AD6 (company_id), INDEX IDX_D25F8BC16FC04F8E (bank_informations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_accounts ADD CONSTRAINT FK_D25F8BC1979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE company_accounts ADD CONSTRAINT FK_D25F8BC16FC04F8E FOREIGN KEY (bank_informations_id) REFERENCES bank_informations (id)');
        $this->addSql('ALTER TABLE emails ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emails ADD CONSTRAINT FK_4C81E852979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('CREATE INDEX IDX_4C81E852979B1AD6 ON emails (company_id)');
        $this->addSql('ALTER TABLE phones ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phones ADD CONSTRAINT FK_E3282EF5979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('CREATE INDEX IDX_E3282EF5979B1AD6 ON phones (company_id)');
        $this->addSql('ALTER TABLE private_notes ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE private_notes ADD CONSTRAINT FK_2D52FA73979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('CREATE INDEX IDX_2D52FA73979B1AD6 ON private_notes (company_id)');
        $this->addSql('ALTER TABLE social_media ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social_media ADD CONSTRAINT FK_20BC159E979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('CREATE INDEX IDX_20BC159E979B1AD6 ON social_media (company_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company_accounts');
        $this->addSql('ALTER TABLE emails DROP FOREIGN KEY FK_4C81E852979B1AD6');
        $this->addSql('DROP INDEX IDX_4C81E852979B1AD6 ON emails');
        $this->addSql('ALTER TABLE emails DROP company_id');
        $this->addSql('ALTER TABLE phones DROP FOREIGN KEY FK_E3282EF5979B1AD6');
        $this->addSql('DROP INDEX IDX_E3282EF5979B1AD6 ON phones');
        $this->addSql('ALTER TABLE phones DROP company_id');
        $this->addSql('ALTER TABLE private_notes DROP FOREIGN KEY FK_2D52FA73979B1AD6');
        $this->addSql('DROP INDEX IDX_2D52FA73979B1AD6 ON private_notes');
        $this->addSql('ALTER TABLE private_notes DROP company_id');
        $this->addSql('ALTER TABLE social_media DROP FOREIGN KEY FK_20BC159E979B1AD6');
        $this->addSql('DROP INDEX IDX_20BC159E979B1AD6 ON social_media');
        $this->addSql('ALTER TABLE social_media DROP company_id');
    }
}
