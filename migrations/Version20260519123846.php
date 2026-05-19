<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260519123846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gallery_media_object (gallery_id INT NOT NULL, media_object_id INT NOT NULL, INDEX IDX_88343BD24E7AF8F (gallery_id), INDEX IDX_88343BD264DE5A5 (media_object_id), PRIMARY KEY (gallery_id, media_object_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE gallery_media_object ADD CONSTRAINT FK_88343BD24E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_media_object ADD CONSTRAINT FK_88343BD264DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_tags ADD CONSTRAINT FK_FCA3BCAA4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_tags ADD CONSTRAINT FK_FCA3BCAA8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gallery_media_object DROP FOREIGN KEY FK_88343BD24E7AF8F');
        $this->addSql('ALTER TABLE gallery_media_object DROP FOREIGN KEY FK_88343BD264DE5A5');
        $this->addSql('DROP TABLE gallery_media_object');
        $this->addSql('ALTER TABLE gallery_tags DROP FOREIGN KEY FK_FCA3BCAA4E7AF8F');
        $this->addSql('ALTER TABLE gallery_tags DROP FOREIGN KEY FK_FCA3BCAA8D7B4FB4');
    }
}
