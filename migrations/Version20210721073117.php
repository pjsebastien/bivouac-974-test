<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721073117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bivouac CHANGE content content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');       
        $this->addSql('ALTER TABLE categories ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tag ADD image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bivouac CHANGE content content VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE categories DROP image');
        $this->addSql('ALTER TABLE tag DROP image');
    }
}
