<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220107071306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maxwels_admin (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, granted_by_id INT NOT NULL, admin_key VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5AEC0A72A76ED395 (user_id), UNIQUE INDEX UNIQ_5AEC0A723151C11F (granted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maxwels_admin ADD CONSTRAINT FK_5AEC0A72A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE maxwels_admin ADD CONSTRAINT FK_5AEC0A723151C11F FOREIGN KEY (granted_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_relationship CHANGE is_friend is_friend TINYINT(1) NOT NULL, CHANGE is_blocked is_blocked TINYINT(1) NOT NULL, CHANGE priority priority INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE maxwels_admin');
        $this->addSql('ALTER TABLE request DROP INDEX UNIQ_3B978F9FDE12AB56, ADD INDEX IDX_3B978F9FDE12AB56 (created_by)');
        $this->addSql('ALTER TABLE user_relationship CHANGE is_friend is_friend TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_blocked is_blocked TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE priority priority INT DEFAULT 1 NOT NULL');
    }
}
