<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616053215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bivouac_users (bivouac_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_D10920529EB7A99F (bivouac_id), INDEX IDX_D109205267B3B43D (users_id), PRIMARY KEY(bivouac_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bivouac_users ADD CONSTRAINT FK_D10920529EB7A99F FOREIGN KEY (bivouac_id) REFERENCES bivouac (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bivouac_users ADD CONSTRAINT FK_D109205267B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bivouac_users');
    }
}
