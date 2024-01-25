<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124055838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_menu_page (page_menu_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_E7ABF9A136B70287 (page_menu_id), INDEX IDX_E7ABF9A1C4663E4 (page_id), PRIMARY KEY(page_menu_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_menu_page ADD CONSTRAINT FK_E7ABF9A136B70287 FOREIGN KEY (page_menu_id) REFERENCES page_menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_menu_page ADD CONSTRAINT FK_E7ABF9A1C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_menu_page DROP FOREIGN KEY FK_E7ABF9A136B70287');
        $this->addSql('ALTER TABLE page_menu_page DROP FOREIGN KEY FK_E7ABF9A1C4663E4');
        $this->addSql('DROP TABLE page_menu_page');
    }
}
