<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210528230435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE companies ADD company_type_id INT DEFAULT NULL, ADD industry_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3AE51E9644 FOREIGN KEY (company_type_id) REFERENCES company_types (id)');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3A2B19A734 FOREIGN KEY (industry_id) REFERENCES industry_types (id)');
        $this->addSql('CREATE INDEX IDX_8244AA3AE51E9644 ON companies (company_type_id)');
        $this->addSql('CREATE INDEX IDX_8244AA3A2B19A734 ON companies (industry_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3AE51E9644');
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3A2B19A734');
        $this->addSql('DROP INDEX IDX_8244AA3AE51E9644 ON companies');
        $this->addSql('DROP INDEX IDX_8244AA3A2B19A734 ON companies');
        $this->addSql('ALTER TABLE companies DROP company_type_id, DROP industry_id');
    }
}
