<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112125136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_participant DROP FOREIGN KEY chat_participant_chat');
        $this->addSql('DROP INDEX chat_participant_chat ON chat_participant');
        $this->addSql('ALTER TABLE chat_participant DROP in_chat');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_participant DROP FOREIGN KEY FK_E8ED9C891A9A7125');
        $this->addSql('DROP INDEX IDX_E8ED9C891A9A7125 ON chat_participant');
        $this->addSql('ALTER TABLE chat_participant ADD in_chat INT NOT NULL, DROP chat_id');
        $this->addSql('ALTER TABLE chat_participant ADD CONSTRAINT chat_participant_chat FOREIGN KEY (in_chat) REFERENCES chat (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX chat_participant_chat ON chat_participant (in_chat)');
    }
}
