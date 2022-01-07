<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220107132054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AABA0E79C3');
        $this->addSql('DROP INDEX UNIQ_659DF2AABA0E79C3 ON chat');
        $this->addSql('ALTER TABLE chat DROP last_message_id');
        $this->addSql('ALTER TABLE chat_participant DROP INDEX UNIQ_E8ED9C89A76ED395, ADD INDEX IDX_E8ED9C89A76ED395 (user_id)');
        $this->addSql('ALTER TABLE chat_participant ADD nickname VARCHAR(255) DEFAULT NULL');
        $this->addSql('Drop TABLE chat_participant_chat');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat ADD last_message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AABA0E79C3 FOREIGN KEY (last_message_id) REFERENCES chat_message (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_659DF2AABA0E79C3 ON chat (last_message_id)');
        $this->addSql('ALTER TABLE chat_participant DROP INDEX IDX_E8ED9C89A76ED395, ADD UNIQUE INDEX UNIQ_E8ED9C89A76ED395 (user_id)');
        $this->addSql('ALTER TABLE chat_participant DROP nickname');
    }
}
