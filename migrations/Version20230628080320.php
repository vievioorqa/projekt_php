<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230628080320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A6C60C3BD');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A6C60C3BD FOREIGN KEY (masterpiece_id) REFERENCES masterpieces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterpieces DROP comment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE masterpieces ADD comment LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A6C60C3BD');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A6C60C3BD FOREIGN KEY (masterpiece_id) REFERENCES masterpieces (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
