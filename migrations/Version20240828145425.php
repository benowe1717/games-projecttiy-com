<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828145425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attempt ADD character_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE attempt ADD CONSTRAINT FK_18EC026681877935 FOREIGN KEY (character_id_id) REFERENCES `character` (id)');
        $this->addSql('CREATE INDEX IDX_18EC026681877935 ON attempt (character_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attempt DROP FOREIGN KEY FK_18EC026681877935');
        $this->addSql('DROP INDEX IDX_18EC026681877935 ON attempt');
        $this->addSql('ALTER TABLE attempt DROP character_id_id');
    }
}
