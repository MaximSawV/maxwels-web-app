<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version202201050001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_relationship RENAME COLUMN isFriend TO is_friend');
        $this->addSql('ALTER TABLE user_relationship RENAME COLUMN isBlocked TO is_blocked');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_relationship RENAME COLUMN is_friend TO isFriend');
        $this->addSql('ALTER TABLE user_relationship RENAME COLUMN is_blocked TO isBlocked');

    }
}
