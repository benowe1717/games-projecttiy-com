<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828151133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attempt_milestone (attempt_id INT NOT NULL, milestone_id INT NOT NULL, INDEX IDX_70719CA9B191BE6B (attempt_id), INDEX IDX_70719CA94B3E2EDA (milestone_id), PRIMARY KEY(attempt_id, milestone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attempt_milestone ADD CONSTRAINT FK_70719CA9B191BE6B FOREIGN KEY (attempt_id) REFERENCES attempt (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attempt_milestone ADD CONSTRAINT FK_70719CA94B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attempt_milestone DROP FOREIGN KEY FK_70719CA9B191BE6B');
        $this->addSql('ALTER TABLE attempt_milestone DROP FOREIGN KEY FK_70719CA94B3E2EDA');
        $this->addSql('DROP TABLE attempt_milestone');
    }
}
