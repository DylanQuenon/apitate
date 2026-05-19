<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260519123055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE gallery_tags (gallery_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_FCA3BCAA4E7AF8F (gallery_id), INDEX IDX_FCA3BCAA8D7B4FB4 (tags_id), PRIMARY KEY (gallery_id, tags_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE gallery_tags ADD CONSTRAINT FK_FCA3BCAA4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_tags ADD CONSTRAINT FK_FCA3BCAA8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gallery_tags DROP FOREIGN KEY FK_FCA3BCAA4E7AF8F');
        $this->addSql('ALTER TABLE gallery_tags DROP FOREIGN KEY FK_FCA3BCAA8D7B4FB4');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE gallery_tags');
        $this->addSql('DROP TABLE media_object');
    }
}
