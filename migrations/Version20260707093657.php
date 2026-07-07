<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260707093657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE albums ADD cover_id INT NOT NULL, DROP cover');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474F922726E9 FOREIGN KEY (cover_id) REFERENCES media_object (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F4E2474F922726E9 ON albums (cover_id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE gallery_tags ADD CONSTRAINT FK_FCA3BCAA4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_tags ADD CONSTRAINT FK_FCA3BCAA8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE albums DROP FOREIGN KEY FK_F4E2474F922726E9');
        $this->addSql('DROP INDEX UNIQ_F4E2474F922726E9 ON albums');
        $this->addSql('ALTER TABLE albums ADD cover VARCHAR(255) NOT NULL, DROP cover_id');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A3DA5256D');
        $this->addSql('ALTER TABLE gallery_tags DROP FOREIGN KEY FK_FCA3BCAA4E7AF8F');
        $this->addSql('ALTER TABLE gallery_tags DROP FOREIGN KEY FK_FCA3BCAA8D7B4FB4');
    }
}
