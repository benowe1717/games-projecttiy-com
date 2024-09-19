<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919205218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE milestone SET category = "level" WHERE id = 1');
        $this->addSql('UPDATE milestone SET category = "level" WHERE id = 2');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 3');
        $this->addSql('UPDATE milestone SET category = "level" WHERE id = 4');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 5');
        $this->addSql('UPDATE milestone SET category = "level" WHERE id = 6');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 7');
        $this->addSql('UPDATE milestone SET category = "level" WHERE id = 8');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 9');
        $this->addSql('UPDATE milestone SET category = "level" WHERE id = 10');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 11');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 12');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 13');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 14');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 15');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 16');
        $this->addSql('UPDATE milestone SET category = "level" WHERE id = 17');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 18');
        $this->addSql('UPDATE milestone SET category = "expedition" WHERE id = 19');

        $this->addSql('UPDATE job SET category = "primary" WHERE id = 1');
        $this->addSql('UPDATE job SET category = "primary" WHERE id = 2');
        $this->addSql('UPDATE job SET category = "secondary" WHERE id = 3');
        $this->addSql('UPDATE job SET category = "secondary" WHERE id = 4');
        $this->addSql('UPDATE job SET category = "secondary" WHERE id = 5');
        $this->addSql('UPDATE job SET category = "primary" WHERE id = 6');

        $this->addSql('INSERT IGNORE INTO user SET email = "benjamin@projecttiy.com", roles = "[\"ROLE_PLAYER\"]", password = "$2y$13$igTpWt6iCcbKVX2QbSbcge/3/SbjhH5egr7wSse2GLbcIKWOCD8xy"');
        $this->addSql('INSERT IGNORE INTO user SET email = "kevicott@gmail.com", roles = "[\"ROLE_PLAYER\"]", password = "$2y$13$6YFS3osIIBR9eMSHfvP5guckPVzgIIyfNB2bzjey.4uTuxQl9yG1C"');
        $this->addSql('INSERT IGNORE INTO user SET email = "ra84nc@gmail.com", roles = "[\"ROLE_PLAYER\"]", password = "$2y$13$2HkrhUSk1vAI2TtW8/1LIeDqzgUB/bRoYeNeHyjD6drLKCpZzqat2"');

        $this->addSql('UPDATE player SET user_id = 1 WHERE id = 1');
        $this->addSql('UPDATE player SET user_id = 2 WHERE id = 2');
        $this->addSql('UPDATE player SET user_id = 3 WHERE id = 3');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
