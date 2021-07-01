<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618073336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_bivouac (tag_id INT NOT NULL, bivouac_id INT NOT NULL, INDEX IDX_733FC30FBAD26311 (tag_id), INDEX IDX_733FC30F9EB7A99F (bivouac_id), PRIMARY KEY(tag_id, bivouac_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_bivouac ADD CONSTRAINT FK_733FC30FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_bivouac ADD CONSTRAINT FK_733FC30F9EB7A99F FOREIGN KEY (bivouac_id) REFERENCES bivouac (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag_bivouac DROP FOREIGN KEY FK_733FC30FBAD26311');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_bivouac');
    }
}
