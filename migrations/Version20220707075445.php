<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707075445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_blueline ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog_blueline ADD CONSTRAINT FK_35CA75BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_35CA75BCFB88E14F ON blog_blueline (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_blueline DROP FOREIGN KEY FK_35CA75BCFB88E14F');
        $this->addSql('DROP INDEX IDX_35CA75BCFB88E14F ON blog_blueline');
        $this->addSql('ALTER TABLE blog_blueline DROP utilisateur_id');
    }
}
