<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220119112951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_participant DROP logged_out_since, DROP logged_in_since');
        $this->addSql('ALTER TABLE user ADD logged_out_time DATETIME DEFAULT NULL, ADD logged_in_time DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_participant ADD logged_out_since DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD logged_in_since DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE `user` DROP logged_out_time, DROP logged_in_time');
    }
}
