<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618072545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region_bivouac (region_id INT NOT NULL, bivouac_id INT NOT NULL, INDEX IDX_5A1C9F2298260155 (region_id), INDEX IDX_5A1C9F229EB7A99F (bivouac_id), PRIMARY KEY(region_id, bivouac_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE region_bivouac ADD CONSTRAINT FK_5A1C9F2298260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE region_bivouac ADD CONSTRAINT FK_5A1C9F229EB7A99F FOREIGN KEY (bivouac_id) REFERENCES bivouac (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE region_bivouac DROP FOREIGN KEY FK_5A1C9F2298260155');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE region_bivouac');
    }
}
