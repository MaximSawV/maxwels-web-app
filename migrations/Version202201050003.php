<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version202201050003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_relationship RENAME COLUMN refering_user TO refering_user_id');
        $this->addSql('ALTER TABLE user_relationship RENAME COLUMN referenced_user TO referenced_user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_relationship RENAME COLUMN refering_user_id TO refering_user');
        $this->addSql('ALTER TABLE user_relationship RENAME COLUMN referenced_user_id TO referenced_user');

    }
}
