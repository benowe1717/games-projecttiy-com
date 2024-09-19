<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828150556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` ADD primary_job_id INT DEFAULT NULL, ADD secondary_job_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034F317F619 FOREIGN KEY (primary_job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034AF2D3011 FOREIGN KEY (secondary_job_id) REFERENCES job (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB034F317F619 ON `character` (primary_job_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB034AF2D3011 ON `character` (secondary_job_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034F317F619');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034AF2D3011');
        $this->addSql('DROP INDEX UNIQ_937AB034F317F619 ON `character`');
        $this->addSql('DROP INDEX UNIQ_937AB034AF2D3011 ON `character`');
        $this->addSql('ALTER TABLE `character` DROP primary_job_id, DROP secondary_job_id');
    }
}
