<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260519144700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE gallery_media_object');
        $this->addSql('ALTER TABLE gallery ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_472B783A3DA5256D ON gallery (image_id)');
        $this->addSql('ALTER TABLE gallery_tags ADD CONSTRAINT FK_FCA3BCAA4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_tags ADD CONSTRAINT FK_FCA3BCAA8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gallery_media_object (gallery_id INT NOT NULL, media_object_id INT NOT NULL, INDEX IDX_88343BD24E7AF8F (gallery_id), INDEX IDX_88343BD264DE5A5 (media_object_id), PRIMARY KEY (gallery_id, media_object_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A3DA5256D');
        $this->addSql('DROP INDEX IDX_472B783A3DA5256D ON gallery');
        $this->addSql('ALTER TABLE gallery DROP image_id');
        $this->addSql('ALTER TABLE gallery_tags DROP FOREIGN KEY FK_FCA3BCAA4E7AF8F');
        $this->addSql('ALTER TABLE gallery_tags DROP FOREIGN KEY FK_FCA3BCAA8D7B4FB4');
    }
}
