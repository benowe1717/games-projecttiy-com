<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828025532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player_milestone (player_id INT NOT NULL, milestone_id INT NOT NULL, INDEX IDX_EFA0B6BB99E6F5DF (player_id), INDEX IDX_EFA0B6BB4B3E2EDA (milestone_id), PRIMARY KEY(player_id, milestone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player_milestone ADD CONSTRAINT FK_EFA0B6BB99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_milestone ADD CONSTRAINT FK_EFA0B6BB4B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player_milestone DROP FOREIGN KEY FK_EFA0B6BB99E6F5DF');
        $this->addSql('ALTER TABLE player_milestone DROP FOREIGN KEY FK_EFA0B6BB4B3E2EDA');
        $this->addSql('DROP TABLE player_milestone');
    }
}
