<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112125549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_participant ADD in_chat_id INT NOT NULL');
        $this->addSql('ALTER TABLE chat_participant ADD CONSTRAINT FK_E8ED9C89512952CB FOREIGN KEY (in_chat_id) REFERENCES chat (id)');
        $this->addSql('CREATE INDEX IDX_E8ED9C89512952CB ON chat_participant (in_chat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_participant DROP FOREIGN KEY FK_E8ED9C89512952CB');
        $this->addSql('DROP INDEX IDX_E8ED9C89512952CB ON chat_participant');
        $this->addSql('ALTER TABLE chat_participant DROP in_chat_id');
    }
}
