<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120201754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_seo (id INT AUTO_INCREMENT NOT NULL, metat_title VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, indexation TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page ADD seo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62097E3DD86 FOREIGN KEY (seo_id) REFERENCES page_seo (id)');
        $this->addSql('CREATE INDEX IDX_140AB62097E3DD86 ON page (seo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62097E3DD86');
        $this->addSql('DROP TABLE page_seo');
        $this->addSql('DROP INDEX IDX_140AB62097E3DD86 ON page');
        $this->addSql('ALTER TABLE page DROP seo_id');
    }
}
